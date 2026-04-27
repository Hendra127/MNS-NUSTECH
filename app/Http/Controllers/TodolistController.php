<?php

namespace App\Http\Controllers;

use App\Models\Todo;

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
        })->where('is_done', false)->orderBy('is_urgent', 'desc')->orderBy('is_pinned', 'desc')->latest()->get();

        $dones = Todo::where(function($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->orWhereHas('sharedUsers', function($q) use ($userId) {
                      $q->where('users.id', $userId);
                  });
        })->where('is_done', true)->orderBy('is_urgent', 'desc')->orderBy('is_pinned', 'desc')->latest()->get();

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



        return response()->json(['success' => true]);
    }

    public function togglePin($id)
    {
        $todo = $this->findTodoWithAccess($id);
        $todo->update(['is_pinned' => !$todo->is_pinned]);
        
        return response()->json(['success' => true, 'is_pinned' => $todo->is_pinned]);
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



        return response()->json(['success' => true, 'checklists' => $checklists]);
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

    // Update Komentar Sub-task
    public function updateCommentSubTask(Request $request, $id) {
        $todo = $this->findTodoWithAccess($id);
        $checklists = $todo->checklists;

        foreach ($checklists as &$item) {
            if ($item['id'] == $request->subtask_id) {
                $item['comment'] = $request->comment;
            }
        }

        $todo->update(['checklists' => $checklists]);
        $this->notifyOwnerIfShared($todo, 'memberikan komentar pada subtask');
        return response()->json(['success' => true]);
    }

    public function toggleUrgent($id)
    {
        $todo = $this->findTodoWithAccess($id);
        $todo->update(['is_urgent' => !$todo->is_urgent]);
        
        return response()->json(['success' => true, 'is_urgent' => $todo->is_urgent]);
    }

    // Toggle Urgency Sub-task
    public function toggleSubTaskUrgent(Request $request, $id) {
        $todo = $this->findTodoWithAccess($id);
        $checklists = $todo->checklists;

        foreach ($checklists as &$item) {
            if ($item['id'] == $request->subtask_id) {
                $item['is_urgent'] = !($item['is_urgent'] ?? false);
            }
        }

        $todo->update(['checklists' => $checklists]);
        $this->notifyOwnerIfShared($todo, 'mengubah prioritas subtask');
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
        $todo = Todo::findOrFail($id);
        
        // Jika pemilik, berikan akses
        if ($todo->user_id == $userId) {
            return $todo;
        }
        
        // Jika dibagikan ke user ini, berikan akses
        $isShared = \DB::table('todo_user')
            ->where('todo_id', $id)
            ->where('user_id', $userId)
            ->exists();

        if ($isShared) {
            return $todo;
        }

        abort(403, 'Unauthorized access to this To Do List.');
    }

    private function notifyOwnerIfShared($todo, $actionDescription)
    {
        try {
            if (auth()->id() !== $todo->user_id) {
                $owner = \App\Models\User::find($todo->user_id);
                if ($owner) {
                    $owner->notify(new \App\Notifications\TaskUpdatedNotification($todo, $actionDescription, auth()->user()->name));
                }
            }
        } catch (\Exception $e) {
            \Log::error('Notification Error: ' . $e->getMessage());
        }
    }
}