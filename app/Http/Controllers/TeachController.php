<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;


class TeachController extends Controller
{   
    protected $array = [
        "success" => false,
        "msg" => "Có lỗi trong quá trình xử lý"
    ];
    public function index(){
        $title = 'Trang chủ';
        return view('teachs.dashboard', compact('title'));
    }

    public function getProjectList(){
        $enrolled = DB::table('enrolled')
                    ->where('user_id', session('user_id'))
                    ->get();
        $projects = [];
        if($enrolled){
            for($i = 0; $i < count($enrolled); $i++){
                $data = DB::table('projects')
                ->where('project_id', $enrolled[$i]->project_id)
                ->first();
                if($data){
                    array_push($projects, $data);
                }
            }
            for($i=0;$i<count($projects);$i++){
            $projects[$i]->created_at = date('H:i - d/m/Y', strtotime($projects[$i]->created_at));
            $projects[$i]->deadline = date('H:i - d/m/Y', strtotime($projects[$i]->deadline));
            $projects[$i]->start_time = date('H:i - d/m/Y', strtotime($projects[$i]->start_time));
            $projects[$i]->count = DB::table('enrolled')->where('project_id', $projects[$i]->project_id)->count();
            }
        }

        return DataTables::of($projects)
                ->addColumn('action', function($project){
                    return '<a type="button" href="/teach/project/'.$project->project_id.'" class="btn btn-sm btn-primary m-1">Xem</a>';
                })->make(true);
    }

    public function projectOverView($project_id){
        $project = DB::table('projects')
                    ->where('project_id', $project_id)
                    ->first(); 
        if($project){
            $title = $project->name;
            $project->start_time = date('H:i - d/m/Y', strtotime($project->start_time));
            $project->deadline = date('H:i - d/m/Y', strtotime($project->deadline));
            $tasks = DB::table('tasks')
                        ->where('project_id', $project_id)
                        ->get();
                       
            $users = DB::table('enrolled')
                        ->where('project_id', $project_id)
                        ->join('users', 'users.user_id', 'enrolled.user_id')
                        ->select('users.fullname', 'users.user_id', 'users.email', 'enrolled.created_at', 'enrolled.status', 'users.user_type_id', 'users.avatar')
                        ->get();
            for($i = 0; $i < count($users); $i++){
                $users[$i]->no = $i + 1;
                $users[$i]->created_at = date('H:i - d/m/Y', strtotime($users[$i]->created_at));
                $users[$i]->completedTasks = 0;
                $users[$i]->countTasks = 0;
                for($n = 0; $n < count($tasks); $n++){
                    if($users[$i]->user_id == $tasks[$n]->user_id){
                        if($tasks[$n]->status == 1){
                            $users[$i]->completedTasks++;
                        }
                        $users[$i]->countTasks++;
                    }
                }
            }
            for($i = 0; $i < count($tasks); $i++){
                $tasks[$i]->no = $i + 1;
                // $tasks[$i]->created_at = date('H:i - d/m/Y', strtotime($tasks[$i]->created_at));
                // $tasks[$i]->deadline = date('H:i - d/m/Y', strtotime($tasks[$i]->deadline));
                // $tasks[$i]->start = date('H:i - d/m/Y', strtotime($tasks[$i]->start));
            }
            for($i = 0; $i < count($tasks); $i++){
                if($tasks[$i]->user_id != null){
                    for($j = 0; $j < count($users); $j++){
                        if($users[$j]->user_id == $tasks[$i]->user_id){
                            $tasks[$i]->handler = $users[$j]->fullname;
                        }
                    }
                }
            }
            $files = DB::table('project_files')
                    ->where('project_id', $project_id)
                    ->get();
            for($i = 0; $i < count($files); $i++){
                $files[$i]->directLink = url('resources/'.$files[$i]->path);
                $files[$i]->no = $i + 1;
            }
            for($i = 0; $i < count($tasks); $i++){
                if($tasks[$i]->status == 1){
                    $report_file =  DB::table('task_files')
                                                ->where('task_id', $tasks[$i]->task_id)
                                                ->where('user_id', $tasks[$i]->user_id)
                                                ->orderby('file_id', 'DESC')
                                                ->first();
                    if($report_file){
                        $tasks[$i]->report_link = url('/student-files/'.$report_file->path);
                    }else{
                        $tasks[$i]->report_link = null;
                    }
                }
            }
            return view('teachs.project-overview', compact('title', 'project', 'tasks', 'users','files'));
        }else{
            return redirect()->route('error');
        }
    }

    public function createTask(Request $request){
        $name = $request->input('name');
        $project_id = $request->input('project_id');
        $user_id = $request->input('user_id');
        $start = $request->input('start');
        $deadline = $request->input('deadline');
        $priority = $request->input('priority');
        $note = $request->input('note');
        $enrolled = DB::table('enrolled')
                    ->where('project_id', $project_id)
                    ->where('user_id', $user_id)
                    ->first();
        if($name && $project_id && $start && $deadline && $priority){
            if(($start - time()) > (-1*24*3600)){
                if($start <= $deadline){
                    if($user_id != session('user_id')){
                        if($user_id == 0){
                            DB::table('tasks')
                                ->insert([
                                    'task_id' => null,
                                    'created_at' => date('Y-m-d H:i:s', time()),
                                    'start' => date('Y-m-d H:i:s', $start),
                                    'deadline' => date('Y-m-d H:i:s', $deadline),
                                    'project_id' => $project_id,
                                    'priority' => $priority,
                                    'user_id' => null,
                                    'score' => null,
                                    'status' => 0,
                                    'name' => $name,
                                    'note' =>$note,
                                ]);
                                $this->array['msg'] = 'Thêm thành công';
                                $this->array['success'] = true;
                            }else{
                                if($enrolled){
                                    $user = DB::table('users')
                                            ->where('user_id', $user_id)
                                            ->first();
                                    if($user->user_type_id == 3){
                                        DB::table('tasks')
                                        ->insert([
                                            'task_id' => null,
                                            'created_at' => date('Y-m-d H:i:s', time()),
                                            'start' => date('Y-m-d H:i:s', $start),
                                            'deadline' => date('Y-m-d H:i:s', $deadline),
                                            'project_id' => $project_id,
                                            'priority' => $priority,
                                            'user_id' => $user_id,
                                            'score' => null,
                                            'status' => 0,
                                            'name' => $name
                                        ]);
                                        $this->array['msg'] = 'Thêm thành công';
                                        $this->array['success'] = true;
                                    }else{
                                        $this->array['msg'] = 'Không thể phân cho giảng viên';
                                    }
                                }else{
                                    $this->array['msg'] = 'Người dùng hoặc dự án không tồn tại';
                                }
                            }
                        }else{
                            $this->array['msg'] = 'Giảng viên không thể tự nhận việc';
                        }
                }else{
                    $this->array['msg'] = 'Deadline không được trước thời gian bắt đầu';
                }
            }else{
                $this->array['msg'] = 'Thời gian bắt đầu không thể quá 1 ngày so với hiện tại';
                $this->array['data'] = $start - time();
                $this->array['now'] = time();
                $this->array['start'] = (int) $start;
            }
        }else{
            $this->array['msg'] = 'Không để trống dữ liệu';
        }
        return response($this->array);
    }


    public function deleteUser(Request $request){
        $user_id = $request->input('user_id');
        $project_id = $request->input('project_id');
        if($project_id && $user_id){
            $enrolled = DB::table('enrolled')
                        ->where('user_id', $user_id)
                        ->where('project_id',$project_id)
                        ->first();
            if($user_id != session('user_id')){
                if($enrolled){
                    DB::table('tasks')
                        ->where('user_id', $user_id)
                        ->where('project_id', $project_id)
                        ->update([
                            'user_id' => null,
                        ]);
                    DB::table('enrolled')
                        ->where('user_id', $user_id)
                        ->where('project_id', $project_id)
                        ->delete();   
                    $this->array['msg'] = 'Xoá thành công';
                    $this->array['success'] = true;

                }else{
                    $this->array['msg'] = 'Người dùng này chưa tham gia';
                }
            }else{
                $this->array['msg'] = 'Lỗi';
            }
        }
        return response($this->array);
    }
    public function feedback(Request $request){
        $score = $request->input('score');
        $task_id = $request->input('task_id');
        $project_id = $request->input('project_id');
        if(is_numeric($score)){
            if(0 <= $score && $score <= 10){
                if($project_id && $task_id){
                    $task = DB::table('tasks')
                                ->where('task_id', $task_id)
                                ->where('project_id',$project_id)
                                ->first();
                    if($task){
                        if($score == 0){
                            $score = -1;
                        }
                        DB::table('tasks')
                            ->where('task_id', $task_id)
                            ->where('project_id',$project_id)
                            ->update([
                                'score' => $score
                            ]);
                        $this->array['msg'] = 'Thành công';
                        $this->array['success'] = true;
                    }else{
                        $this->array['msg'] = 'Dữ liệu không tồn tại hoặc đã chấm điểm rồi';
                    }
                }
            }else{
                $this->array['msg'] = 'Range đánh giá từ 5 - 10 sao';
            }
        }else{
            $this->array['msg'] = 'Vui lòng chỉ nhập số';
        }
        return response($this->array);
    }

    public function rollback(Request $request){
        $task_id = $request->input('task_id');
        $project_id = $request->input('project_id');
        if($project_id && $task_id){
            $task = DB::table('tasks')
                        ->where('task_id', $task_id)
                        ->where('project_id',$project_id)
                        ->first();
            if($task){
                DB::table('tasks')
                    ->where('task_id', $task_id)
                    ->where('project_id', $project_id)
                    ->update([
                        'status' => 0,
                        'updated_at' => date('Y-m-d H:i:s', time()),
                        'note' => 'Task cần làm lại'
                    ]);
                $this->array['msg'] = 'Đặt lại thành công';
                $this->array['success'] = true;

            }else{
                $this->array['msg'] = 'Dữ liệu không tồn tại';
            }
        }
        return response($this->array);
    }


    public function taskDelete(Request $request){
        $task_id = $request->input('task_id');
        $project_id = $request->input('project_id');
        if($task_id && $project_id){
            $task = DB::table('tasks')
                    ->where('task_id', $task_id)
                    ->where('project_id', $project_id)
                    ->first();
            if($task){
                if($task->status == 0){
                    DB::table('task_files')
                        ->where('task_id', $task_id)
                        ->delete();
                    DB::table('tasks')
                        ->where('task_id', $task_id)
                        ->delete();
                    $this->array['msg'] = 'Xoá thành công';
                    $this->array['success'] = true;
                }else{
                    $this->array['msg'] = 'Không thể xoá task đã làm rồi';
                }
            }else{
                $this->array['msg'] = 'Dữ liệu không tồn tại';
            }
        }else{
            $this->array['msg'] = 'Lỗi dữ liệu';
        }
        return response($this->array);
    }

    public function taskUpdate(Request $request){
        $task_id = $request->input('task_id');
        $user_id = $request->input('user_id');
        $priority = $request->input('priority');
        $start = $request->input('start');
        $deadline = $request->input('deadline');
        $name = $request->input('name');
        $note = $request->input('note');
        if($user_id == 0){
            $user_id = null;
        }
        if($task_id && $priority && $start && $deadline && $name){
            $task = DB::table('tasks')
                    ->where('task_id', $task_id)
                    ->first();
            if($task){
                if($task->status == 0){
                    if($start < $deadline){
                        DB::table('tasks')
                            ->where('task_id', $task_id)
                            ->update([
                                'user_id' => $user_id,
                                'priority' => $priority,
                                'name' => $name,
                                'start' => date('Y-m-d H:i:s', $start),
                                'deadline' => date('Y-m-d H:i:s', $deadline),
                                'updated_at' => date('Y-m-d H:i:s', time()),
                                'note' => $note
                            ]);
                        $this->array['msg'] = 'Cập nhật thành công';
                        $this->array['success'] = true;
                    }else{
                        $this->array['msg'] = 'Deadline không được lớn hơn thời gian bắt đầu làm';
                    }
                }else{
                    $this->array['msg'] = 'Không thể cập nhật task đã làm rồi';
                }
            }else{
                $this->array['msg'] = 'Dữ liệu không tồn tại';
            }
        }else{
            $this->array['msg'] = 'Lỗi dữ liệu';
        }
        return response($this->array);
    }

    public function browseView(){
        $title = 'Tham gia dự án mới';
        return view('teachs.projectList', compact('title'));
    }
    public function browse(){
        $enrolled = DB::table('enrolled')
                    ->where('user_id', session('user_id'))
                    ->get();
        $exceptList = [];
        for($i = 0; $i < count($enrolled); $i++){
            array_push($exceptList, $enrolled[$i]->project_id);
        }
        $projects = DB::table('projects')
                    ->whereNotIn('project_id', $exceptList)
                    ->get();

        for($i=0;$i<count($projects);$i++){
            $projects[$i]->created_at = date('H:i - d/m/Y', strtotime($projects[$i]->created_at));
            $projects[$i]->deadline = date('H:i - d/m/Y', strtotime($projects[$i]->deadline));
            $projects[$i]->start_time = date('H:i - d/m/Y', strtotime($projects[$i]->start_time));
            $projects[$i]->count = DB::table('enrolled')->where('project_id', $projects[$i]->project_id)->count();
        }

        return DataTables::of($projects)
                ->addColumn('action', function($project){
                    return '<a type="button" onclick="join('.$project->project_id.',`'.$project->invite_code.'`)" class="btn btn-sm btn-primary m-1">Tham gia</a>';
                })->make(true);
    }
    public function getProjectJoinView(Request $request){
        $project_id = $request->input('project_id');
        $invite_code = $request->input('invite_code');
        if($project_id && $invite_code){
            $project = DB::table('projects')
                        ->where('project_id', $project_id)
                        ->where('invite_code', $invite_code)
                        ->first();
            if($project){
                $check = DB::table('enrolled')
                        ->where('project_id', $project_id)
                        ->where('user_id', session('user_id'))
                        ->first();
                if(!$check){
                    DB::table('enrolled')
                        ->insert([
                            'enrolled_id' => null,
                            'user_id' => session('user_id'),
                            'project_id' => $project_id,
                            'status' => 1,
                            'created_at' => date('Y-m-d H:i:s', time())
                        ]);
                        $this->array['msg'] = 'Tham gia thành công';
                        $this->array['success'] = true;
                        $this->array['redirect'] = url('teach/project').'/'.$project_id;
                }else{
                    $this->array['msg'] = 'Bạn đã tham gia dự án này rồi';
                }
            }else{
                $this->array['msg'] = 'Không tìm thấy dự án này. Vui lòng kiểm tra lại thông tin';
            }
        }
        return response($this->array);
    }
    public function fileAttack(Request $request){
        $this->array['msg'] = $request->validate([
            'file' => 'required|mimes:png,jpg,jpeg,docs,pdf,docs,docx,excel,zip,rar|max:16000'
        ]);
        $project_id = $request->input('project_id');
        $file = $request->file('file');
        if($request->hasFile('file') && $project_id){
            $filename = rand().'_'.$file->getClientOriginalName();
            $file->move('resources/', $filename);
            $file_id = DB::table('project_files')
                    ->insertGetId([
                        'file_id' => null,
                        'project_id' => $project_id,
                        'path' => $filename,
                        'created_at' => date('Y-m-d H:i:s', time()),
                        'user_id' => session('user_id')
                    ]);
            $this->array['msg'] = 'Đính kèm thành công';
            $this->array['success'] = true;
            $this->array['file_id'] = $file_id;
        }else{
            $this->array['msg'] = 'Vui lòng đính kèm file';
        }
        return response($this->array);
    }
}
