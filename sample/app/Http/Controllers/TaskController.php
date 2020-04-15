<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use App\Folder;
use App\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(int $id) {
        $current_folder = Folder::find($id);
        
        $this->checkExistFolder($current_folder);
        $this->checkAuthority(Auth::user()->id, $current_folder->user_id);

        $folders = Auth::user()->folders()->get();

        $tasks = $current_folder->tasks()->get();

        return view('tasks/index',[
            'folders' => $folders,
            'current_folder_id' => $current_folder->id,
            'tasks' => $tasks,
        ]);
    }

    public function showCreateForm(int $id) {
        $current_folder = Folder::find($id);
        
        $this->checkExistFolder($current_folder);
        $this->checkAuthority(Auth::user()->id, $current_folder->user_id);

        return view('tasks/create', [
            'folder_id' => $id,
        ]);
    }

    public function create(int $id, CreateTask $request) {
        $current_folder = Folder::find($id);
     
        $this->checkExistFolder($current_folder);
        $this->checkAuthority(Auth::user()->id, $current_folder->user_id);

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $current_folder->tasks()->save($task);

        return redirect()->route('tasks.index',[
            'id' => $current_folder->id,
        ]);
    }

    public function showEditForm(int $id, int $task_id) {
        $current_folder = Folder::find($id);
        $task = Task::find($task_id);

        $this->checkExistFolder($current_folder);
        $this->checkExistTask($task);
        $this->checkAuthority(Auth::user()->id, $current_folder->user_id);
        $this->checkRelation($current_folder->id, $task->folder_id);
        
        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    public function edit(int $id, int $task_id, EditTask $request) {
        $current_folder = Folder::find($id);
        $task = Task::find($task_id);
        
        $this->checkExistFolder($current_folder);
        $this->checkExistTask($task);
        $this->checkAuthority(Auth::user()->id, $current_folder->user_id);
        $this->checkRelation($current_folder->id, $task->folder_id);

        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }


    //存在しないフォルダの場合
    private function checkExistFolder($current_folder) {
        if(is_null($current_folder)) {
            abort(404);
        }
    }

    //存在しないタスクの場合
    private function checkExistTask($task) {
        if(is_null($task)) {
            abort(404);
        }
    }

    //権限がない場合
    private function checkAuthority(int $user_id, int $folder_user_id) {
        if($user_id !== $folder_user_id) {
            abort(403);
        }
    }

    //フォルダとタスクにリレーションがない場合
    private function checkRelation(int $folder_id, int $task_folder_id) {
        if($folder_id !== $task_folder_id) {
            abort(404);
        }
    }


    //タスク削除機能
    public function delete(int $id, int $task_id) {
        $current_folder = Folder::find($id);
        $task = Task::find($task_id);

        $this->checkExistFolder($current_folder);
        $this->checkExistTask($task);
        $this->checkAuthority(Auth::user()->id, $current_folder->user_id);
        $this->checkRelation($current_folder->id, $task->folder_id);
        
        $task->delete();

        return redirect()->route('tasks.index',[
            'id' => $current_folder->id,
        ]);
    }

}
