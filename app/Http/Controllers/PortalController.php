<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class PortalController extends Controller
{
    protected $array = [
        "success" => false,
        "msg" => "Có lỗi trong quá trình xử lý"
    ];
    protected $mentors; // Mentor list

    public function __construct(){
        $users = DB::table('users')
                ->where('user_type_id', 2)
                ->get();
        $this->mentors = $users;
    }
    public function index(){
        $title = 'Trang chủ';
        $enrolled = DB::table('enrolled')
                    ->where('user_id', session('user_id'))
                    ->select('*')
                    ->get();
        $projects = [];
        $mentors = $this->mentors;
        for($i = 0; $i < $enrolled->count(); $i++) {
            $data = DB::table('projects')
                    ->join('users', 'users.user_id', 'projects.user_id')
                    ->where('project_id', $enrolled[$i]->project_id)
                    ->select('projects.*', 'users.fullname as owner', 'users.email', 'users.avatar as avatar')
                    ->first();
            $projects[$i] = $data;
        }
        for($i = 0; $i < count($projects); $i++) {
            $projects[$i]->deadline = date('H:i - d/m/y', strtotime($projects[$i]->deadline));
        }
        return view('portals.projectList',compact('title', 'projects', 'mentors'));
    }
    public function getProjectList(){
        $projects = DB::table('projects')
                        ->select()
                        ->get();
        for($i=0;$i<count($projects);$i++){
            $projects[$i]->unix_deadline = strtotime($projects[$i]->deadline);
            $projects[$i]->unix_start_time = strtotime($projects[$i]->start_time);
            $projects[$i]->created_at = date('H:i - d/m/Y', strtotime($projects[$i]->created_at));
            $projects[$i]->deadline = date('H:i - d/m/Y', strtotime($projects[$i]->deadline));
            $projects[$i]->start_time = date('H:i - d/m/Y', strtotime($projects[$i]->start_time));
            $projects[$i]->count = DB::table('enrolled')->where('project_id', $projects[$i]->project_id)->count();
        }
        return DataTables::of($projects)                
            ->addColumn('action', function($project){
            return '<a type="button" href="/portal/project/'.$project->project_id.'" class="btn btn-sm btn-primary m-1">Xem</a>
            <button type="button" onclick="openUpdateForm(`'.$project->project_id.'`, `'.$project->name.'`, `'.$project->unix_start_time.'`, `'.$project->unix_deadline.'`)" class="btn btn-sm btn-warning m-1 text-white">Sửa</button>
            <a type="button" href="/portal/project/'.$project->project_id.'" class="btn btn-sm btn-danger m-1">Xoá</a>';
            })->make(true);;    
    }

    public function projectCreate(Request $request){
        $name = $request->input('name');
        $deadline = $request->input('deadline');
        $about = $request->input('about');
        $invite_code = $request->input('invite_code');
        $user_id = $request->input('user_id');
        $start = $request->input('start');
        if($user_id == 0){
            $user_id = null;
        }
        if($name && $deadline && $invite_code){
            $project_id = DB::table('projects')
                        ->insertGetId([
                            'project_id' => null,
                            'name' => $name,
                            'start_time' => date('Y-m-d H:i:s', $start),
                            'deadline' => date('Y-m-d H:i:s', $deadline),
                            'created_at' => date('Y-m-d H:i:s', time()),
                            'user_id' => null,
                            'invite_code' => $invite_code,
                            'about' => $about,
                            'user_id' => $user_id,                    
                        ]);
            if($user_id != null){
                DB::table('enrolled')
                    ->insert([
                        'enrolled_id' => null,
                        'created_at' => date('Y-m-d H:i:s', time()),
                        'user_id' => $user_id,
                        'project_id' => $project_id,
                        'status' => 1
                    ]);
            }
            $this->array['msg'] = 'Thêm thành công';
            $this->array['success'] = true;
        }else{
            $this->array['msg'] = 'Không để trống dữ liệu';
        }
        return response($this->array);
    }


    function studentManagerAction(){
        $students = DB::table('users')
                    ->where('user_type_id', 3)
                    ->select()
                    ->get();
        for($i=0;$i<count($students);$i++){
            $students[$i]->created_at = date('H:i - d/m/Y', strtotime($students[$i]->created_at));
            if($students[$i]->major_id){
                $students[$i]->major = DB::table('majors')->where('major_id', $students[$i]->major_id)->first()->name;
            }else{
                $students[$i]->major = '';
            }
            if($students[$i]->semester_id){
                $students[$i]->semester = DB::table('semesters')->where('semester_id', $students[$i]->semester_id)->first()->name;
            }else{
                $students[$i]->semester = '';
            }
            $students[$i]->count = DB::table('enrolled')->where('user_id', $students[$i]->user_id)->count();
            if($students[$i]->password){
                unset($students[$i]->password);
            }
        }
        return DataTables::of($students)                
            ->addColumn('action', function($student){
            return '<a type="button" href="/portal/user/'.$student->user_id.'" class="btn btn-sm btn-primary m-3">Chi tiết</a>';
            })->make(true);    
    }

    function studentManager(){
        $title = 'Quản lý sinh viên';
        $mentors = $this->mentors;
        return view('portals.studentList', compact('title', 'mentors'));
    }

    function studentView($id){
        $mentors = $this->mentors;
        $user = DB::table('users')
                ->where('user_id', $id)
                ->first();
        if($user){
            $semesters = DB::table('semesters')
                        ->get();
            $majors = DB::table('majors')
                        ->get();
            $enrolled = DB::table('enrolled')
                        ->where('user_id', $id)
                        ->get();
            $user_types = DB::table('user_types')->get();
            $projects = [];
            if(count($enrolled) > 0){
                for($i = 0; $i <count($enrolled); $i++){
                    $project = DB::table('projects')
                                ->where('project_id', $enrolled[$i]->project_id)
                                ->first();
                    $project->no = $i+1;
                    if($project){
                        // $project->tasks = DB::table('tasks')->where('project_id', $project->project_id)->where('user_id', $id)->get();
                        // $project->done = 0;
                        // for($i = 0; $i < count($project->tasks); $i++){
                        //     if($project->tasks[$i]->status == 1){
                        //         $project->done++;
                        //     }
                        // }
                        array_push($projects, $project);
                    }
                }
            }
            $title = $user->fullname;
            return view('portals.user', compact('title','user', 'semesters', 'majors', 'projects', 'mentors', 'user_types'));
            // return dd($user, $user_types);
        }else{
            return redirect()->route('error');
        }
    }
    function mentorManager(){
        $title = 'Quản lý giảng viên';
        $mentors = $this->mentors;
        return view('portals.mentorList', compact('title', 'mentors'));
    }

    function mentorManagerAction(){
        $mentors = DB::table('users')
                    ->where('user_type_id', 2)
                    ->select()
                    ->get();
        for($i=0;$i<count($mentors);$i++){
            $mentors[$i]->created_at = date('H:i - d/m/Y', strtotime($mentors[$i]->created_at));
            $mentors[$i]->count = DB::table('enrolled')->where('user_id', $mentors[$i]->user_id)->count();
            if($mentors[$i]->password){
                unset($mentors[$i]->password);
            }
        }
        return DataTables::of($mentors)                
            ->addColumn('action', function($mentor){
            return '<a type="button" href="/portal/user/'.$mentor->user_id.'" class="btn btn-sm btn-primary m-1">Xem</a><button type="button"  onclick="edit('.$mentor->user_id.')" class="btn btn-sm btn-warning m-1">Sửa</button><button type="button"  onclick="delete('.$mentor->user_id.')" class="btn btn-sm btn-danger m-1">Xoá</button>';
            })->make(true);    
    }   
    
    
    function newMentor(Request $request){
        $email = $request->input('email');
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $user = DB::table('users')
                    ->where('email', $email)
                    ->first();
            if($user){
                DB::table('users')
                    ->where('email', $email)
                    ->update([
                        'user_type_id' => 2,
                        'updated_at' => date('Y-m-d H:i:s', time()),
                    ]);
                $this->array['msg'] = 'Cập nhật thành công cho tài khoản '.$user->fullname;
                $this->array['success'] = true;
            }else{
                DB::table('users')
                    ->where('email', $email)
                    ->insert([
                        'user_id' => null,
                        'user_type_id' => 1,
                        'fullname' => 'GV chưa đăng nhập',
                        'email' => $email,
                        'password' => 0,
                        'status' => 1,
                        'active' => 1,
                        'user_type_id' => 2,
                        'created_at' => date('Y-m-d H:i:s', time()),
                    ]);
                $this->array['success'] = true;
                $this->array['msg'] = 'GV đã được thêm thành công. GV cần đăng nhập bằng tài khoản Gmail để cập nhật các thông tin khác và tiếp tục sử dụng';
            }
        }else{
            $this->array['msg'] = 'Email không đúng định dạng';
        }
        return response($this->array);
    }


    function userSearchByEmail(Request $request){
        $email = $request->input('email');
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $user = DB::table('users')
                    ->where('email', $email)
                    ->first();
            if($user){
                $this->array['msg'] = 'Tìm thành công';
                $this->array['success'] = true;
                $this->array['redirect'] = url('/portal/user').'/'.$user->user_id;
            }else{
                $this->array['msg'] = 'Không tìm thấy người dùng này';
            }
        }else{
            $this->array['msg'] = 'Email không hợp lệ';
        }
        return response($this->array);
    }


    function adminManager(){
        $title = 'Quản lý quản trị viên';
        $mentors = $this->mentors;
        return view('portals.adminList', compact('title', 'mentors'));
    }


    function newAdmin(Request $request){
        $email = $request->input('email');
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $user = DB::table('users')
                    ->where('email', $email)
                    ->first();
            if($user){
                DB::table('users')
                    ->where('email', $email)
                    ->update([
                        'user_type_id' => 1,
                        'updated_at' => date('Y-m-d H:i:s', time()),
                    ]);
                $this->array['msg'] = 'Cập nhật thành công cho tài khoản '.$user->fullname;
                $this->array['success'] = true;
            }else{
                DB::table('users')
                    ->where('email', $email)
                    ->insert([
                        'user_id' => null,
                        'user_type_id' => 1,
                        'fullname' => 'Admin chưa đăng nhập',
                        'email' => $email,
                        'password' => 0,
                        'status' => 1,
                        'active' => 1,
                        'user_type_id' => 1,
                        'created_at' => date('Y-m-d H:i:s', time()),
                    ]);
                $this->array['success'] = true;
                $this->array['msg'] = 'Admin đã được thêm thành công. Admin này cần đăng nhập bằng tài khoản Gmail để cập nhật các thông tin khác và tiếp tục sử dụng';
            }
        }else{
            $this->array['msg'] = 'Email không đúng định dạng';
        }
        return response($this->array);
    }

    function adminManagerAction(){
        $admins = DB::table('users')
                    ->where('user_type_id', 1)
                    ->select()
                    ->get();
        for($i=0;$i<count($admins);$i++){
            $admins[$i]->created_at = date('H:i - d/m/Y', strtotime($admins[$i]->created_at));
            if($admins[$i]->password){
                unset($admins[$i]->password);
            }
        }
        return DataTables::of($admins)                
            ->addColumn('action', function($admin){
            return '<a type="button" href="/portal/user/'.$admin->user_id.'" class="btn btn-sm btn-primary m-1">Chi tiết</a>';
            })->make(true);    
    }   


    function projectManager(){
        $title = 'Quản lý dự án';
        $mentors = $this->mentors;
        return view('portals.projectList', compact('title', 'mentors'));
    }
    

    function projectManagerAction(){
        $projects = DB::table('projects')
                    ->orderBy('project_id', 'DESC')
                    ->get();
        for($i=0;$i<count($projects);$i++){
            $projects[$i]->unix_deadline = strtotime($projects[$i]->deadline);
            $projects[$i]->unix_start_time = strtotime($projects[$i]->start_time);
            $projects[$i]->created_at = date('H:i - d/m/Y', strtotime($projects[$i]->created_at));
            $projects[$i]->deadline = date('H:i - d/m/Y', strtotime($projects[$i]->deadline));
            $projects[$i]->start_time = date('H:i - d/m/Y', strtotime($projects[$i]->start_time));
            $projects[$i]->count = DB::table('enrolled')->where('project_id', $projects[$i]->project_id)->count();
        }
        return DataTables::of($projects)
        ->addColumn('action', function($project){
            return '<a type="button" href="/portal/project/'.$project->project_id.'" class="btn btn-sm btn-primary m-1">Xem</a>
            <button type="button" onclick="openUpdateForm(`'.$project->project_id.'`, `'.$project->name.'`,`'.$project->invite_code.'`, `'.$project->about.'`, `'.date('Y-m-d\TH:i:s', $project->unix_start_time).'`, `'.date('Y-m-d\TH:i:s', $project->unix_deadline).'`)" class="btn btn-sm btn-warning m-1 text-white">Sửa</button>
            <button type="button" onclick="projectDelete('.$project->project_id.')" class="btn btn-sm btn-danger m-1">Xoá</button>';
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
            $mentors = $this->mentors;
            return view('portals.project-overview', compact('title', 'project', 'tasks', 'mentors', 'users','files'));
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
        $note = $request->input('comment');
        if(is_numeric($score)){
            if(0 <= $score && $score <= 5){
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
                                'score' => $score,
                                'note' => $note,
                                'updated_at' => date('Y-m-d H:i:s', time()),
                            ]);
                        $this->array['msg'] = 'Đánh giá thành công';
                        $this->array['success'] = true;
                    }else{
                        $this->array['msg'] = 'Dữ liệu không tồn tại hoặc task đã chấm điểm rồi';
                    }
                }
            }else{
                $this->array['msg'] = 'Range điểm từ 0 - 5 sao';
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


    public function accountUpdate(Request $request){
        $this->array['msg'] = $request->validate([
            'fullname' => 'required|string|min: 3| max: 50'
        ]);
        $fullname = $request->input('fullname');
        $user_type_id = $request->input('user_type_id');
        $major_id = $request->input('major_id');
        $semester_id = $request->input('semester_id');
        $user_id = $request->input('user_id');
        $isFalse = false;

        $user = DB::table('users')->where('user_id', $user_id)->first();
        if($user_id == session('user_id')){
            $this->array['msg'] = 'Không thể tự cập nhật chính mình';
            return response($this->array);
            exit();
        }
        if(!$user){
            $this->array['msg'] = 'Người dùng không tồn tại';
        }
        if(!$fullname){
            $isFalse = true;
        }

        if($isFalse == false){
            DB::table('users')
                ->where('user_id', $user_id)
                ->update([
                    'user_type_id' => $user_type_id,
                    'fullname' => $fullname,
                    'major_id' => $major_id,
                    'semester_id' => $semester_id,
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ]);
            $this->array['msg'] = 'Cập nhật thành công cho tài khoản '.$fullname;
            $this->array['success'] = true;        
        }

        return response($this->array);
    }


    public function projectUpdate(Request $request){
        $project_id = $request->input('project_id');
        $name = $request->input('name');
        $invite_code = $request->input('invite_code');
        $start = $request->input('start');
        $deadline = $request->input('deadline');
        $about = $request->input('about');
        if($project_id && $name && $deadline){
            $project = DB::table('projects')
                    ->where('project_id', $project_id)
                    ->first();
            if($project){
                DB::table('projects')
                    ->where('project_id', $project_id)
                    ->update([
                        'name' => $name,
                        'invite_code' => $invite_code,
                        'start_time' => date('Y-m-d H:i:s', $start),
                        'deadline' => date('Y-m-d H:i:s', $deadline),
                        'about' => $about,
                    ]);
                $this->array['msg'] = 'Cập nhật thành công';
                $this->array['success'] = true;
            }else{
                $this->array['msg'] = 'Dữ liệu không tồn tại';
            }
        }else{
            $this->array['msg'] = 'Lỗi dữ liệu';
        }
        return response($this->array);
    }

    public function projectDelete($id){
        $project = DB::table('projects')->where('project_id', $id)->first();
        if($project){
            $task_id_list = DB::table('tasks')->where('project_id', $id)->get();
                foreach($task_id_list as $item){
                    DB::table('task_files')->where('task_id', $item->task_id)->delete();
                }
            DB::table('project_files')->where('project_id', $id)->delete();
            DB::table('tasks')->where('project_id', $id)->delete();
            DB::table('enrolled')->where('project_id', $id)->delete();
            DB::table('projects')->where('project_id', $id)->delete();
            $this->array['msg'] = 'Xoá thành công';
            $this->array['success'] = true;
        }else{
            $this->array['msg'] = 'Dự án không tồn tại';
        }
        return response($this->array);
    }


}
