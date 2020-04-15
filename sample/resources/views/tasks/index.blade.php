@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-4">
                <nav class="panel panel-default">
                    <div class="panel-heading">フォルダ</div>
                    <div class="panel-body">
                        <a href="{{route('folders.create')}}" class="btn btn-default btn-block">
                            フォルダを追加する
                        </a>
                    </div>
                    <div class="list-group">
                        @foreach($folders as $folder)
                            <a href="{{route('tasks.index',['id' => $folder->id])}}" class="list-group-item {{$current_folder_id === $folder->id ? 'active' : ''}}">
                            {{$folder->title}}
                            </a>
                        @endforeach    
                    </div>
                </nav>
            </div>
            <div class="column col-md-8">
                <!-- ここにタスク表示 -->
                <div class="panel panel-default">
                    <div class="panel-heading">タスク</div>
                    <div class="panel-body">
                        <div class="text-right">
                            <a href="{{ route('tasks.create', ['id' => $current_folder_id]) }}" class="btn btn-default btn-block">タスクを追加する</a>
                        </div>
                    </div>
                    <table class="table" style="table-layout:fixed;">
                        <thead>
                        <tr>
                            <th style="width:50%;">タイトル</th>
                            <th style="width:10%;">状態</th>
                            <th style="width:20%;">期限</th>
                            <th style="width:10%;"></th>
                            <th style="width:10%;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td>{{$task->title}}</td>
                                <td><span class="label {{$task->status_class}}">{{ $task->status_label }}</span></td>
                                <td>{{$task->formatted_due_date}}</td>
                                <td style="text-align: right;"><button class="btn btn-primary"><a href="{{ route('tasks.edit', ['id' => $task->folder_id, 'task_id' => $task->id] )}}" style="color: white;">編集</a></button></td>
                                <td style="text-align: right;">
                                  <form action="{{ route('tasks.delete', ['id' => $task->folder_id, 'task_id' => $task->id] )}}" method="post" name="deleteTask">
                                  @csrf
                                    <button type="submit" class="btn btn-primary" id="delete" onclick='return confirm("本当に削除しますか？")'>削除</button>
                                    <!-- <a href="javascript: deleteTask.submit">削除</a> -->
                                  </form>
                                </td>
                            </tr>
                        @endforeach    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
