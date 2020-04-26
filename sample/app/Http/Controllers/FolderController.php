<?php

namespace App\Http\Controllers;


use App\Folder;
use App\Task;
use App\Http\Requests\CreateFolder;
use App\Http\Requests\EditFolder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function showCreateForm() {
        return view('folders/create');
    }

    public function create(CreateFolder $request) {
        $folder = new Folder();
        $folder->title = $request->title;
        Auth::user()->folders()->save($folder);

        return redirect()->route('tasks.index',[
            'id' => $folder->id,
        ]);
    }

    //フォルダ編集機能
    public function showEditForm(int $id) {
        $current_folder = Folder::find($id);
        $this->checkExistFolder($current_folder);
        $this->checkAuthority(Auth::user()->id, $current_folder->user_id);

        return view('folders/edit', [
            'folder' => $current_folder,
        ]);
    }

    public function edit(int $id, EditFolder $request) { 
        $folder = Folder::find($id);
        $this->checkExistFolder($folder);
        $this->checkAuthority(Auth::user()->id, $folder->user_id);

        $folder->title = $request->title;
        $folder->save();

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
        

    }

    //フォルダ削除機能
    public function delete(int $id) {
        $current_folder = Folder::find($id);

        $this->checkExistFolder($current_folder);
        $this->checkAuthority(Auth::user()->id, $current_folder->user_id);

        $this->deleteTasksByFolderId($id);
        $current_folder->delete();

        return redirect()->route('home');
        
    }

    //フォルダ削除前にタスクを削除
    private function deleteTasksByFolderId($id) {
        Task::where('folder_id', '=', $id)->delete();
    }

    //存在しないフォルダの場合
    private function checkExistFolder($current_folder) {
        if(is_null($current_folder)) {
            abort(404);
        }
    }

    //権限がない場合
    private function checkAuthority(int $user_id, int $folder_user_id) {
        if($user_id !== $folder_user_id) {
            abort(403);
        }
    }
}
