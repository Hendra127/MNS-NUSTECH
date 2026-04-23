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

        $todos = Todo::where(function($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->orWhereHas('sharedUsers', function($q) use ($userId) {
                      $q->where('users.id', $userId);
                  });
        })->where('is_done', false)->latest()->get();

        $dones = Todo::where(function($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->orWhereHas('sharedUsers', function($q) use ($userId) {
                      $q->where('users.id', $userId);
                  });
        })->where('is_done', true)->latest()->get();

        $users = \App\Models\User::where('id', '!=', auth()->id())->get();

        return view('todolist', compact('todos', 'dones', 'users'));
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
        $todo = clone $this->findTodoWithAccess($id);
        $newStatus = !$todo->is_done;
        $todo->update(['is_done' => $newStatus]);
        
        $this->notifyOwnerIfShared($todo, $newStatus ? 'menyelesaikan' : 'mengembalikan ke status Ongoing');

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
        $todo = $this->findTodoWithAccess($id);
        $todo->update([
            'content' => $request->content
        ]);
        
        $this->notifyOwnerIfShared($todo, 'mengubah detail');

        return response()->json(['success' => true]);
    }

    // Menghapus catatan secara permanen
    public function destroy($id)
    {
        $todo = $this->findTodoWithAccess($id);
        $title = $todo->title;
        $todo->delete();

        $this->notifyOwnerIfShared($todo, 'menghapus');

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
        $todo = $this->findTodoWithAccess($id);
        $checklists = $todo->checklists ?? [];
        
        $checklists[] = [
            'id' => uniqid(),
            'text' => $request->text,
            'completed' => false
        ];

        $todo->update(['checklists' => $checklists]);
        
        $this->notifyOwnerIfShared($todo, 'menambah subtask baru');

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
        $todo = $this->findTodoWithAccess($id);
        $checklists = $todo->checklists;

        foreach ($checklists as &$item) {
            if ($item['id'] == $request->subtask_id) {
                $item['completed'] = !$item['completed'];
            }
        }

        $todo->update(['checklists' => $checklists]);
        $this->notifyOwnerIfShared($todo, 'mengubah status subtask');
        return response()->json(['success' => true]);
    }
    // Update Judul Project
    public function updateTitle(Request $request, $id) {
        $todo = $this->findTodoWithAccess($id);
        $oldTitle = $todo->title;
        $todo->update(['title' => $request->title]);

        $this->notifyOwnerIfShared($todo, 'mengubah judul');

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
        $todo = $this->findTodoWithAccess($id);
        $checklists = $todo->checklists;

        foreach ($checklists as &$item) {
            if ($item['id'] == $request->subtask_id) {
                $item['text'] = $request->text;
            }
        }

        $todo->update(['checklists' => $checklists]);
        $this->notifyOwnerIfShared($todo, 'mengubah teks subtask');
        return response()->json(['success' => true]);
    }

    // Menghapus sub-item
    public function deleteSubTask(Request $request, $id) {
        $todo = $this->findTodoWithAccess($id);
        
        if (!$todo->checklists) {
            return response()->json(['success' => true]);
        }

        $checklists = collect($todo->checklists)->filter(function ($item) use ($request) {
            return $item['id'] != $request->subtask_id;
        })->values()->all();

        $todo->update(['checklists' => $checklists]);
        
        $this->notifyOwnerIfShared($todo, 'menghapus subtask');
        
        ActivityLog::record([
            'action' => 'delete',
            'module' => 'To Do List',
            'description' => 'Menghapus sub-task dari project ' . $todo->title,
            'record_id' => $todo->id,
            'record_label' => $todo->title,
        ]);

        return response()->json(['success' => true]);
    }

    // Share To Do
    public function share(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        if (auth()->user()->role !== 'superadmin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $userIds = $request->user_ids ?? [];
        $todo->sharedUsers()->sync($userIds);

        $customMessage = $request->message;
        $usersToNotify = \App\Models\User::whereIn('id', $userIds)->get();
        foreach ($usersToNotify as $user) {
            $user->notify(new \App\Notifications\TaskSharedNotification($todo, $customMessage));
        }

        return response()->json(['success' => true]);
    }

    public function checkNotifications()
    {
        $user = auth()->user();
        $notifications = $user->unreadNotifications;
        $user->unreadNotifications->markAsRead();
        return response()->json(['notifications' => $notifications]);
    }

    private function findTodoWithAccess($id)
    {
        $userId = auth()->id();
        return Todo::where(function($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->orWhereHas('sharedUsers', function($q) use ($userId) {
                      $q->where('users.id', $userId);
                  });
        })->findOrFail($id);
    }

    private function notifyOwnerIfShared($todo, $actionDescription)
    {
        if (auth()->id() !== $todo->user_id) {
            $owner = \App\Models\User::find($todo->user_id);
            if ($owner) {
                $owner->notify(new \App\Notifications\TaskUpdatedNotification($todo, $actionDescription, auth()->user()->name));
            }
        }
    }
}