<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    protected $array = [
        "success" => false,
        "msg" => "Có lỗi trong quá trình xử lý"
    ];
    public function index(){
        $title = 'Trang chủ';
        $enrolled = DB::table('enrolled')
                    ->where('user_id', session('user_id'))
                    ->select('*')
                    ->get();
        $projects = [];
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
        return view('students.dashboard',compact('title', 'projects'));
    }
    public function projectOverview($id){
        $enrolled = DB::table('enrolled')
                    ->where('user_id', session('user_id'))
                    ->where('project_id', $id)
                    ->select('*')
                    ->first();
        if($enrolled){
            $enrolleds = DB::table('enrolled')
                        ->where('project_id', $id)
                        ->get();
            $project = DB::table('projects')
                        ->where('project_id', $id)
                        ->join('users', 'users.user_id', 'projects.user_id')
                        ->select('projects.*', 'users.fullname as owner')
                        ->first();
            $tasks = DB::table('tasks')
                        ->where('project_id', $id)
                        ->where('user_id', session('user_id'))
                        ->select('*')
                        ->get();
            $taskForTake = DB::table('tasks')
                            ->where('project_id', $id)
                            ->where('user_id', null)
                            ->where('status', 0)
                            ->get();
            $title = $project->name;
            for($i = 0; $i < count($tasks); $i++){
                $tasks[$i]->no = $i + 1;
                // $tasks[$i]->deadline = date('H:i - d/m/y', strtotime($tasks[$i]->deadline));
                // $tasks[$i]->created_at = date('H:i - d/m/y', strtotime($tasks[$i]->created_at));
                // $tasks[$i]->start = date('H:i - d/m/y', strtotime($tasks[$i]->start));
            }
            for($i = 0; $i < count($taskForTake); $i++){
                $taskForTake[$i]->no = $i + 1;
                // $tasks[$i]->deadline = date('H:i - d/m/y', strtotime($tasks[$i]->deadline));
                // $tasks[$i]->created_at = date('H:i - d/m/y', strtotime($tasks[$i]->created_at));
                // $tasks[$i]->start = date('H:i - d/m/y', strtotime($tasks[$i]->start));
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
            $files = DB::table('project_files')
                    ->where('project_id', $id)
                    ->get();
            for($i = 0; $i < count($files); $i++){
                    $files[$i]->directLink = url('resources/'.$files[$i]->path);
                    $files[$i]->no = $i + 1;
            }
            return view('students.project-overview', compact('title', 'project', 'tasks', 'enrolleds', 'taskForTake', 'files'));
        }else{
            return redirect()->route('error');
        }
    }


    public function makeDone(Request $request){
        $file_id = $request->input('file_id');
        $task_id = $request->input('task_id');  
        $task = DB::table('tasks')
                ->where('task_id', $task_id)
                ->where('user_id', session('user_id'))
                ->select()
                ->first();
        if($task){
            if(time() >= strtotime($task->start)){
                $file = DB::table('task_files')
                        ->where('task_id', $task_id)
                        ->where('user_id', session('user_id'))
                        ->where('file_id', $file_id)
                        ->first();
                if($file){
                    DB::table('tasks')
                    ->where('task_id', $task_id)
                    ->where('user_id', session('user_id'))
                    ->update(
                        [
                            'status' => 1,
                            'submited_time' => date('Y-m-d H:i:s', time())
                        ]
                    );
                $this->array['msg'] = "Báo cáo thành công";
                $this->array['success'] = true;
                }
            }else{
                $this->array['msg'] = 'Task này chưa tới ngày làm';
            }
        }else{
            $this->array['msg'] = 'Dữ liệu không tồn tại';
        }
        return response($this->array);
    }


    public function majorChoiceView(){
        $user = DB::table('users')
                ->where('user_id', session('user_id'))
                ->first();
        if($user->major_id == null){        
            $majors = DB::table('majors')
                        ->select()
                        ->get();
            for($i = 0; $i <count($majors); $i++){
                $majors[$i]->no = $i + 1;
            }
            $title = 'Cập nhật thông tin';
            return view('students.major-choice', compact('majors', 'title'));
        }else{
            return redirect()->route('/');
        }
    }

    public function majorChoice(Request $request){
        $major_id = $request->input('major_id');
        $check = DB::table('majors')
                ->where('major_id', $major_id)
                ->get()
                ->first();
        if($check){
            $user = DB::table('users')
                    ->where('user_id', session('user_id'))
                    ->select()
                    ->first();
            if($user->major_id == null){
                DB::table('users')
                ->where('user_id', session('user_id'))
                ->update([
                    'major_id' => $major_id
                ]);
                $this->array['msg'] = 'Chọn chuyên ngành thành công';
                $this->array['success'] = true;
            }else{
                $this->array['msg'] = 'Bạn đã chọn một chuyên ngành khác.';
            }
        }else{
            $this->array['msg'] = 'Chuyên ngành không tồn tại.';
        }
        return response($this->array);
    }


    public function semesterChoiceView(){
        $user = DB::table('users')
                ->where('user_id', session('user_id'))
                ->first();
        if($user->semester_id == null){        
            $semesters = DB::table('semesters')
                        ->select()
                        ->get();
            for($i = 0; $i <count($semesters); $i++){
                $semesters[$i]->no = $i + 1;
            }
            $title = 'Cập nhật thông tin';
            return view('students.semester-choice', compact('semesters', 'title'));
        }else{
            return redirect()->route('/');
        }
    }
    public function semesterChoice(Request $request){
        $semester_id = $request->input('semester_id');
        $check = DB::table('semesters')
                ->where('semester_id', $semester_id)
                ->get()
                ->first();
        if($check){
            $user = DB::table('users')
                    ->where('user_id', session('user_id'))
                    ->select()
                    ->first();
            if($user->semester_id == null){
                DB::table('users')
                ->where('user_id', session('user_id'))
                ->update([
                    'semester_id' => $semester_id
                ]);
                $this->array['msg'] = 'Chọn niên khoá thành công';
                $this->array['success'] = true;
            }else{
                $this->array['msg'] = 'Bạn đã chọn một khoá khác.';
            }
        }else{
            $this->array['msg'] = 'Niên khoá không tồn tại.';
        }
        return response($this->array);
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
                        $this->array['redirect'] = url('project').'/'.$project_id;
                }else{
                    $this->array['msg'] = 'Bạn đã tham gia dự án này rồi';
                }
            }else{
                $this->array['msg'] = 'Không tìm thấy dự án này. Vui lòng kiểm tra lại thông tin';
            }
        }
        return response($this->array);
    }


    public function takeIt(Request $request){
        $project_id = $request->input('project_id');
        $task_id = $request->input('task_id');
        if($task_id && $project_id){
            $task = DB::table('tasks')
                    ->where('project_id', $project_id)
                    ->where('task_id', $task_id)
                    ->where('user_id', null)
                    ->first();
            if($task){
                DB::table('tasks')
                    ->where('task_id', $task_id)
                    ->update([
                        'user_id' => session('user_id'),
                        'note' => 'Pick up',
                        'updated_at' => date('Y-m-d H:i:s', time())
                    ]);
                    $this->array['msg'] = 'Nhận task thành công';
                    $this->array['success'] = true;
            }else{
                $this->array['msg'] = 'Task này hiện đã có người nhận';
                $this->array['reload'] = true;
            }
        }else{
            $this->array['msg'] = 'Lỗi';
        }
        return response($this->array);
    }

    public function fileAttack(Request $request){
        $this->array['msg'] = $request->validate([
            'file' => 'required|mimes:pdf|max:16000'
        ]);
        $task_id = $request->input('task_id');
        $file = $request->file('file');
        if($request->hasFile('file') && $task_id){
            $filename = rand().'_'.$file->getClientOriginalName();
            $file->move('student-files/', $filename);
            $file_id = DB::table('task_files')
                    ->insertGetId([
                        'file_id' => null,
                        'task_id' => $task_id,
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
    public function browseView(){
        $title = 'Tham gia dự án mới';
        return view('students.projectList', compact('title'));
    }

    public function joining($project_id, $invite_code){
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
                        return redirect(url('project/'.$project->project_id));
                }else{
                    return redirect(url('project/'.$project->project_id));
                }
            }else{
                return redirect()->route('error');
            }
        }
    }
}
