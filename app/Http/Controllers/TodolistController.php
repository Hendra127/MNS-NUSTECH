<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    public function index()
    {
        // Ambil data milik user yang sedang login saja
        $userId = auth()->id();

        $todos = Todo::where('user_id', $userId)
                     ->where('is_done', false)
                     ->latest()
                     ->get();

        $dones = Todo::where('user_id', $userId)
                     ->where('is_done', true)
                     ->latest()
                     ->get();

        return view('todolist', compact('todos', 'dones'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo = Todo::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'is_done' => false,
            'type' => 'note'
        ]);

        ActivityLog::record([
            'action' => 'create',
            'module' => 'To Do List',
            'description' => 'Membuat project baru: ' . $request->title,
            'record_id' => $todo->id,
            'record_label' => $request->title,
        ]);

        return response()->json([
            'success' => true,
            'data' => $todo
        ]);
    }

    public function toggle($id)
    {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);
        $newStatus = !$todo->is_done;
        $todo->update(['is_done' => $newStatus]);

        ActivityLog::record([
            'action' => 'update',
            'module' => 'To Do List',
            'description' => $newStatus ? 'Menyelesaikan project: ' . $todo->title : 'Mengembalikan project ke Ongoing: ' . $todo->title,
            'record_id' => $todo->id,
            'record_label' => $todo->title,
            'field_changed' => 'is_done',
            'old_value' => !$newStatus ? 'Completed' : 'Ongoing',
            'new_value' => $newStatus ? 'Completed' : 'Ongoing',
        ]);

        return response()->json(['success' => true]);
    }
    // Mengupdate isi konten/detail catatan
    public function update(Request $request, $id)
    {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);
        $todo->update([
            'content' => $request->content
        ]);

        return response()->json(['success' => true]);
    }

    // Menghapus catatan secara permanen
    public function destroy($id)
    {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);
        $title = $todo->title;
        $todo->delete();

        ActivityLog::record([
            'action' => 'delete',
            'module' => 'To Do List',
            'description' => 'Menghapus project: ' . $title,
            'record_id' => $id,
            'record_label' => $title,
        ]);

        return response()->json(['success' => true]);
    }
    // Menambah sub-item ke dalam checklist
    public function addSubTask(Request $request, $id) {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);
        $checklists = $todo->checklists ?? [];
        
        $checklists[] = [
            'id' => uniqid(),
            'text' => $request->text,
            'completed' => false
        ];

        $todo->update(['checklists' => $checklists]);

        ActivityLog::record([
            'action' => 'create',
            'module' => 'To Do List',
            'description' => 'Menambah sub-task "' . $request->text . '" pada project ' . $todo->title,
            'record_id' => $todo->id,
            'record_label' => $todo->title,
        ]);

        return back();
    }

    // Menandai sub-item selesai/belum
    public function toggleSubTask(Request $request, $id) {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);
        $checklists = $todo->checklists;

        foreach ($checklists as &$item) {
            if ($item['id'] == $request->subtask_id) {
                $item['completed'] = !$item['completed'];
            }
        }

        $todo->update(['checklists' => $checklists]);
        return response()->json(['success' => true]);
    }
    // Update Judul Project
    public function updateTitle(Request $request, $id) {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);
        $oldTitle = $todo->title;
        $todo->update(['title' => $request->title]);

        ActivityLog::record([
            'action' => 'update',
            'module' => 'To Do List',
            'description' => 'Mengubah judul project',
            'record_id' => $todo->id,
            'record_label' => $request->title,
            'field_changed' => 'title',
            'old_value' => $oldTitle,
            'new_value' => $request->title,
        ]);

        return response()->json(['success' => true]);
    }

    // Update Teks Sub-task/Checklist
    public function updateSubTask(Request $request, $id) {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);
        $checklists = $todo->checklists;

        foreach ($checklists as &$item) {
            if ($item['id'] == $request->subtask_id) {
                $item['text'] = $request->text;
            }
        }

        $todo->update(['checklists' => $checklists]);
        return response()->json(['success' => true]);
    }

    // Menghapus sub-item
    public function deleteSubTask(Request $request, $id) {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);
        
        if (!$todo->checklists) {
            return response()->json(['success' => true]);
        }

        $checklists = collect($todo->checklists)->filter(function ($item) use ($request) {
            return $item['id'] != $request->subtask_id;
        })->values()->all();

        $todo->update(['checklists' => $checklists]);
        
        ActivityLog::record([
            'action' => 'delete',
            'module' => 'To Do List',
            'description' => 'Menghapus sub-task dari project ' . $todo->title,
            'record_id' => $todo->id,
            'record_label' => $todo->title,
        ]);

        return response()->json(['success' => true]);
    }
}