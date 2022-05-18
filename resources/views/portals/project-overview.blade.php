@extends('layouts.portal')


@section('content')
<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Tổng quan về dự án {{$title}}</h4>
                    </div><!--end col-->
                </div><!--end row-->                                                              
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div><!--end row-->
    <!-- end page title end breadcrumb -->
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-3">
            <div class="card report-card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col">
                            <p class="text-dark mb-1 font-weight-semibold">Project ID</p>
                            <h3 class="m-0">{{$project->project_id}}</h3>
                            <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-checkbox-marked-circle-outline me-1"></i></span>Tạo ngày: {{$project->created_at}}</p>
                        </div>
                    </div>
                </div><!--end card-body--> 
            </div><!--end card--> 
        </div> <!--end col--> 
        <div class="col-md-6 col-lg-3">
            <div class="card report-card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">                                                
                        <div class="col">
                            <p class="text-dark mb-1 font-weight-semibold">Tasks</p>
                            <h3 class="m-0">{{count($tasks)}}</h3>
                            <p class="mb-0 text-truncate text-muted">Tổng số task trong dự án này</p>
                        </div>
                        <div class="col-auto align-self-center">
                            <div class="report-main-icon bg-light-alt">
                                <i data-feather="check-square" class="align-self-center text-muted icon-md"></i>  
                            </div>
                        </div> 
                    </div>
                </div><!--end card-body--> 
            </div><!--end card--> 
        </div> <!--end col-->                         
        <div class="col-md-6 col-lg-3">
            <div class="card report-card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col">  
                            <p class="text-dark mb-1 font-weight-semibold">Deadline</p>                                         
                            <h3 class="m-0">{{$project->deadline}}</h3>
                            <p class="mb-0 text-truncate text-muted">là deadline dành cho dự án này</p>
                        </div>
                    </div>
                </div><!--end card-body--> 
            </div><!--end card--> 
        </div> <!--end col--> 
        <div class="col-md-6 col-lg-3">
            <div class="card report-card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">                                                
                        <div class="col">
                            <p class="text-dark mb-1 font-weight-semibold">Thành viên</p>
                            <h3 class="m-0">{{count($users)}} người</h3>
                            <p class="mb-0 text-truncate text-muted">là số người đã tham gia vào dự án</p>
                        </div>
                    </div>
                </div><!--end card-body--> 
            </div><!--end card--> 
        </div> <!--end col-->                               
    </div><!--end row-->
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">Tham gia</h4>      
                            <p class="mb-0 text-truncate text-muted">Dành cho người mới</p>                
                        </div><!--end col-->
                    </div>  <!--end row-->                                  
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="text-center">
                        <div id="task_status">
                            <img src="https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl={{url('join/'.$project->project_id.'/'.$project->invite_code)}}">
                            <br>
                            <span>Sinh viên scan mã này để tham gia vào dự án</span>
                            <br>
                            <span>Hoặc</span>
                            <br>
                            <hr>
                            <span>Nhập thông tin sau để tham gia dự án</span>
                            <br>
                            <span>ID:</span> <strong>{{$project->project_id}}</strong>
                            <br>
                            <span>Invite Code:</span> <strong>{{$project->invite_code}}</strong>
                        </div>
                    </div>                                     
                </div><!--end card-body--> 
            </div><!--end card-->                             
        </div> <!--end col--> 
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">Thành viên dự án</h4>                      
                        </div><!--end col-->
                    </div>  <!--end row-->                                  
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="text">
                        <table id="users" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th><strong>STT</strong></th>
                                    <th><strong>Tên</strong></th>
                                    <th><strong>Email</strong></th>
                                    <th><strong>Ngày tham gia<strong></th>
                                    <th><strong>Phân quyền<strong></th>
                                    <th><strong>Done/Tasks</strong></th>
                                    <th><strong>Tuỳ chọn</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->no}}</td>
                                        <td>
                                            <img src="{{$user->avatar}}" alt="" class="rounded-circle thumb-xs">
                                            {{$user->fullname}}
                                        </td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->created_at}}</td>
                                        <td>
                                            @if($user->user_type_id == 3)
                                                Sinh viên
                                            @elseif($user->user_type_id == 2)
                                                Giảng viên
                                            @endif
                                        </td>
                                        <td>{{$user->completedTasks}}/{{$user->countTasks}}</td>
                                        <td>
                                            <a type="button" href="{{url('portal/user/'.$user->user_id)}}" class="btn btn-sm btn-primary m-1">Xem</a>
                                            <button type="button" onclick="deleteUser('{{$user->fullname}}', {{$user->user_id}}, {{$user->countTasks}})" class="btn btn-sm btn-danger m-1">Xoá</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>                                     
                </div><!--end card-body--> 
            </div><!--end card--> 
        </div> <!--end col-->  
    </div><!--end row-->
    <div class="row">                        
        <div class="col-12">
            <div class="card">  
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">Quản lý công việc</h4>                      
                        </div><!--end col-->
                        <div class="col-auto"> 
                            <a class=" btn btn-sm btn-soft-primary"  data-bs-toggle="modal" data-bs-target="#CreateTask" role="button"><i class="fas fa-plus me-2"></i>Tạo task mới</a>
                        </div><!--end col-->
                    </div>  <!--end row-->                                  
                </div><!--end card-header-->                                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="taskList">
                            <thead class="thead-light">
                                <tr>
                                    <th><strong>STT</strong></th>
                                    <th><strong>Task</strong></th>
                                    <th><strong>Người nhận</strong></th>
                                    <th><strong>Ngày tạo</strong></th>
                                    <th><strong>Start</strong></th>
                                    <th><strong>Deadline</strong></th>
                                    <th><strong>Cập nhật cuối</strong></th>
                                    <th><strong>Trạng thái</strong></th>
                                    <th><strong>Ghi chú</strong></th>
                                    <th><strong>Ưu tiên</strong></th>
                                    <th><strong>Điểm</strong></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                <tr>
                                    <td>{{$task->no}}</td>
                                    <td>{{$task->name}}</td>
                                    @if($task->user_id != null)
                                        <td>{{$task->handler}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>{{date('H:i - d/m/Y', strtotime($task->created_at))}}</td>
                                    <td>{{date('H:i - d/m/Y', strtotime($task->start))}}</td>
                                    <td>{{date('H:i - d/m/Y', strtotime($task->deadline))}}</td>
                                    <td>
                                        @if($task->updated_at == null)
                                        @else
                                            {{date('H:i - d/m/Y', strtotime($task->updated_at))}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($task->status == 0)
                                            @if(time() >= strtotime($task->start))
                                                @if(time() < strtotime($task->deadline))
                                                    <span class="badge badge-md badge-boxed  badge-soft-warning">Chưa hoàn thành</span>
                                                @else()
                                                    <span class="badge badge-md badge-boxed  badge-soft-danger">Chưa hoàn thành - Trễ</span>
                                                @endif
                                            @else
                                                <span class="badge badge-md badge-boxed  badge-soft-warning">Sắp tới</span>
                                            @endif
                                        @else
                                            @if($task->submited_time <= $task->deadline)
                                                <span class="badge badge-md badge-boxed  badge-soft-success">Hoàn thành - {{date('H:i - d/m/Y', strtotime($task->submited_time))}}</span>
                                            @else
                                                <span class="badge badge-md badge-boxed  badge-soft-warning">Hoàn thành trễ - {{date('H:i - d/m/Y', strtotime($task->submited_time))}}</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{$task->note}}</td>
                                    <td>
                                        @if($task->priority == 1)
                                            <span class="badge badge-md badge-boxed  badge-soft-danger">Cao</span>
                                        @elseif($task->priority == 2)
                                            <span class="badge badge-md badge-boxed  badge-soft-warning">Trung bình</span>
                                        @elseif($task->priority == 3)
                                            <span class="badge badge-md badge-boxed  badge-soft-primary">Không</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($task->status == 1)
                                            @if($task->score == null)
                                                Chờ đánh giá
                                            @elseif($task->score > 0)
                                                {{number_format($task->score, 0)}} x <i class="fa fas fa-star"></i>
                                            @else
                                                Không đạt
                                            @endif
                                        @else

                                        @endif
                                    </td>
                                    <td>
                                        @if($task->status == 0)
                                            <button type="button" class="btn btn-sm btn-primary m-1" data-bs-toggle="modal" data-bs-target="#editModal-{{$task->no}}">Sửa</button>
                                            <button type="button" class="btn btn-sm btn-danger m-1" onclick="taskDelete('{{$task->name}}', {{$task->task_id}})">Xoá</button>
                                        @else
                                            @if($task->score == null)
                                                <button type="button" class="btn btn-sm btn-success m-1" onclick="feedback1('{{$task->name}}', {{$task->task_id}}, '{{$task->report_link}}')">Đánh giá</button>
                                                <button type="button" class="btn btn-sm btn-warning text-light m-1" onclick="rollback('{{$task->name}}', {{$task->task_id}})">Rollback</button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>                                 
                    </div><!--end table-responsive--> 
                </div><!--end card-body-->                                                                                                        
            </div><!--end card-->
        </div><!--end col-->     
    </div><!--end row-->
    
    <div class="row">                        
        <div class="col-12">
            <div class="card">  
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">Quản lý tài nguyên</h4>                      
                        </div><!--end col-->
                        <div class="col-auto"> 
                            <a class=" btn btn-sm btn-soft-primary"  data-bs-toggle="modal" data-bs-target="#UploadFileForm" role="button"><i class="fas fa-plus me-2"></i>Thêm tài nguyên</a>
                        </div><!--end col-->
                    </div>  <!--end row-->                                  
                </div><!--end card-header-->                                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="fileList">
                            <thead class="thead-light">
                                <tr>
                                    <th><strong>STT</strong></th>
                                    <th><strong>Tên file</strong></th>
                                    <th><strong>Ngày tải lên</strong></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($files as $file)
                                <tr>
                                    <td>{{$file->no}}</td>
                                    <td>{{$file->path}}</td>
                                    <td>{{date('H:i - d/m/Y', strtotime($file->created_at))}}</td>
                                    <td>
                                        <a type="button" target="_blank" href="{{$file->directLink}}" class="btn btn-sm btn-primary">
                                            <i data-feather="download-cloud"></i>Tải về</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>                                 
                    </div><!--end table-responsive--> 
                </div><!--end card-body-->                                                                                                        
            </div><!--end card-->
        </div><!--end col-->     
    </div><!--end row-->
    <div class="modal fade" id="CreateTask" tabindex="-1" aria-labelledby="CreateTaskLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="CreateTask">Tạo task mới</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="example-password-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Task</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Nhập task" id="name" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Start</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="datetime-local" id="start">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Deadline</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="datetime-local" id="deadline">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Người nhận task</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="user_id">
                                <option value='0'>Sinh viên tự nhận task</option>
                                @foreach($users as $user)
                                    @if($user->user_type_id == 3)
                                        <option value='{{$user->user_id}}'>{{$user->fullname}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Ưu tiên</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="priority">
                                <option value="1">Cao</option>
                                <option value="2" selected>Trung bình</option>
                                <option value="3">Không</option>
                            </select>                        
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Note</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" type="text" id="note"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="createTask()">Thêm</button>
                    <button type="button" class="btn btn-soft-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!--- Modals --->

    @foreach ($tasks as $task)
    <div class="modal fade" id="editModal-{{$task->no}}" tabindex="-1" role="dialog" aria-labelledby="editModal-{{$task->no}}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title m-0 text-white" id="editModal-{{$task->no}}">Cập nhật thông tin task {{$task->name}}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!--end modal-header-->
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="example-password-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Task</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Nhập task" value="{{$task->name}}" id="newName-{{$task->task_id}}" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Start</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="datetime-local" id="newStart-{{$task->task_id}}" value="{{date('Y-m-d\TH:i:s', strtotime($task->start))}}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Deadline</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="datetime-local" id="newDeadline-{{$task->task_id}}" value="{{date('Y-m-d\TH:i:s', strtotime($task->deadline))}}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Người nhận task</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="newUser_id-{{$task->task_id}}">
                                <option value='0'>Không</option>
                                @foreach($users as $user)
                                    @if($user->user_type_id == 3)
                                        @if($task->user_id == $user->user_id)
                                            <option value='{{$user->user_id}}' selected>{{$user->fullname}}</option>
                                        @else
                                            <option value='{{$user->user_id}}'>{{$user->fullname}}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Ưu tiên</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="newPriority-{{$task->task_id}}">
                                @if($task->priority == 1)
                                    <option value="1" selected>Cao</option>
                                    <option value="2">Trung bình</option>
                                    <option value="3">Không</option>
                                @elseif($task->priority == 2)
                                    <option value="1">Cao</option>
                                    <option value="2" selected>Trung bình</option>
                                    <option value="3">Không</option>
                                @else    
                                    <option value="1">Cao</option>
                                    <option value="2">Trung bình</option>
                                    <option value="3" >Không</option>
                                @endif 
                            </select>                        
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-password-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Note</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" type="text" placeholder="Nhập ghi chú" id="newNote-{{$task->task_id}}" required>{{$task->note}}</textarea>
                        </div>
                    </div>
                </div>
                <!--end modal-body-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-soft-secondary btn-sm" onclick="taskUpdate({{$task->task_id}})">Cập nhật</button>
                    <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Đóng</button>
                </div>
                <!--end modal-footer-->
            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialog-->
    </div>
    @endforeach

    <div class="modal fade" id="UploadFileForm" tabindex="-1" aria-labelledby="UploadFileFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content" id="UploadFileFormPulse">
                <div class="modal-header">
                    <h6 class="modal-title" id="UploadFileForm">Thêm tài nguyên</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row d-none">
                        <label for="example-password-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Porject ID</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="number" value="{{$project->project_id}}" id="UploadProjectId" disabled>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-password-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Tài liệu đính kèm</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file" id="AttachFile" multiple/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="uploadFile()">Đính kèm</button>
                    <button type="button" class="btn btn-soft-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="FeedbackModal" tabindex="-1" aria-labelledby="FeedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="TaskTitle"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="h-100">
                        <h6>Tài liệu</h6>
                        <div class="embed-responsive embed-responsive-16by9 h-100">
                            <h6 class="title" id="dontAttack">Task này chưa có tài liệu</h6>
                            <iframe class="embed-responsive-item" id="src" scr=""></iframe>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="feedback">Đánh giá</button>
                    <button type="button" class="btn btn-warning text-light" id="rollback">Làm lại</button>
                    <button type="button" class="btn btn-soft-secondary" id="rollback" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Form đánh giá task -->
    <div class="modal fade" id="scoreFeedback" tabindex="-1" aria-labelledby="scoreFeedback" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="scoreFeedbackTitle">Đánh giá task</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="example-password-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Tên task</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="scoreTaskName" required="" disabled value="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Sao</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="number" placeholder="Nhập điểm bạn muốn chấm" id="score" min="1" max="5" required>
                            <small class="text-muted"><strong>Hướng dẫn:</strong>
                                <br>- Điểm 0: Không đạt
                                <br>- Từ 1-5: Đạt
                            </small>
                        </div>
                    </div>
                    <div class="mb-3 row d-none">
                        <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Task ID</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="number" placeholder="Nhập mã tham gia" id="scoreTaskId">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Nhận xét</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" type="text" placeholder="Nhập nhận xét của bạn cho task này" id="scoreComment"></textarea>
                            <small class="text-muted"><strong>Lưu ý: </strong>Bạn cần để lại nhận xét trong trường hợp task không đạt yêu cầu</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="feedbackConfirm()">Gửi nhận xét</button>
                    <button type="button" class="btn btn-soft-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End form đánh giá -->
@endsection

@section('scripts')

    <!-- Required datatable js -->
    <script src="{{asset('/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/plugins/datatables/dataTables.bootstrap5.min.js')}}"></script>
    <!-- Buttons examples -->
    <script src="{{asset('/plugins/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('/plugins/datatables/buttons.bootstrap5.min.js')}}"></script>
    <script src="{{asset('/plugins/datatables/jszip.min.js')}}"></script>
    <script src="{{asset('/plugins/datatables/pdfmake.min.js')}}"></script>
    <script src="{{asset('/plugins/datatables/vfs_fonts.js')}}"></script>
    <script src="{{asset('/plugins/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{asset('/plugins/datatables/buttons.print.min.js')}}"></script>
    <script src="{{asset('/plugins/datatables/buttons.colVis.min.js')}}"></script>
    <!-- Responsive examples -->
    <script src="{{asset('/plugins/datatables/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('/pages/jquery.datatable.init.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#users').DataTable( {
                "lengthMenu": [ 5, 10, 20, 25],
                "pageLength": 5
            } );
            $('#taskList').DataTable( {
            } );
            $('#fileList').DataTable( {
            } );
        });
    </script>
    <script>
        const createTask = () => {
            start = $('#start').val();
            deadline = $('#deadline').val();
            user_id = $('#user_id').val();
            priority = $('#priority').val();
            name = $('#name').val();
            note = $('#note').val();
            project_id = {{$project->project_id}};
            if(start && deadline && user_id && priority && name){
                $.ajax({
                    type: "POST",
                    url: "{{url('api/portal/create-task')}}",
                    data: {
                        start: Date.parse(start) / 1000,
                        deadline: Date.parse(deadline) / 1000,
                        user_id: user_id,
                        project_id: project_id,
                        name: name,
                        priority: priority,
                        note: note,
                    },
                    dataType: "JSON",
                }).done(function(res){
                    if(res.success == true){
                        Notiflix.Notify.success(res.msg);
                        setTimeout(function(){
                            window.location.reload();
                        }, 3000);
                    }else{
                        Notiflix.Notify.failure(res.msg);
                    }
                });
            }else{
                Notiflix.Notify.failure('Không để trống thông tin');
            }
        }
    </script>

    <script>
        const deleteUser = (fullname, user_id, tasks) => {
            project_id = {{$project->project_id}};
            if(user_id && project_id){
                Notiflix.Confirm.show(
                    'Xác nhận xoá thành viên',
                    'Việc này sẽ chuyển các '+tasks+' task của '+fullname+' sang trạng thái chờ người nhận.',
                    'Xác nhận',
                    'Huỷ',
                    function okCb(){
                        $.ajax({
                            type: "POST",
                            url: "{{url('api/portal/delete-user')}}",
                            data: {
                                user_id: user_id,
                                project_id: project_id,
                            },
                            dataType: "JSON",
                        }).done(function(res){
                            if(res.success == true){
                                Notiflix.Notify.success(res.msg);
                                setTimeout(function(){
                                    window.location.reload();
                                }, 3000);
                            }else{
                                Notiflix.Notify.failure(res.msg);
                            }
                        })
                    }
                )
            }else{
                Notiflix.Notify.failure('Không để trống dữ liệu');
            }
        }


        const feedback = (name, task_id) => {
            project_id = {{$project->project_id}};
            if(user_id && project_id){
                $('#scoreFeedback').modal('show');
                $('#scoreTaskName').val(name);
                $('#scoreTaskId').val(task_id);
                // Notiflix.Confirm.prompt(
                //     'Đánh giá',
                //     'Điểm của task '+name+' phải từ 0 - 5 sao. 0 sao tương đương với không đạt.',
                //     5,
                //     'Xác nhận',
                //     'Huỷ',
                //     (clientAnswer) => {
                //         $.ajax({
                //             type: "POST",
                //             url: "{{url('api/portal/feedback')}}",
                //             data: {
                //                 task_id: task_id,
                //                 project_id: project_id,
                //                 score: clientAnswer
                //             },
                //             dataType: "JSON",
                //         }).done(function(res){
                //             if(res.success == true){
                //                 Notiflix.Notify.success(res.msg);
                //                 setTimeout(function(){
                //                     window.location.reload();
                //                 }, 3000);
                //             }else{
                //                 Notiflix.Notify.failure(res.msg);
                //             }
                //         })
                //     },
                // )
            }else{
                Notiflix.Notify.failure('Không để trống dữ liệu');
            }
        }

        const feedbackConfirm = () => {
            var name = $('#scoreTaskName').val();
            var task_id = $('#scoreTaskId').val();
            var score = $('#score').val();
            var comment = $('#scoreComment').val();
            var isFalse = false;
            if(score == 0){
                if(!comment || comment == '' || comment == null){
                    Notiflix.Report.failure(
                        'Lỗi, bạn chưa để lại nhận xét',
                        'Trường hợp task được đánh giá là <strong>KHÔNG ĐẠT</strong>, bạn cần nhập lý do trong ô nhận xét',
                        'Đã hiểu.'
                        );
                    isFalse = true;
                }
            }else{
                if(!score || score < 1 || score > 5){
                    Notiflix.Report.failure(
                        'Điểm không hợp lệ',
                        'Bạn chưa nhập điểm hoặc điểm không hợp lệ. <br>Điểm 0 tương đương với KHÔNG ĐẠT, từ 1-5 tương đương với ĐẠT',
                        'Đã hiểu.'
                        );
                    isFalse = true;
                }
            }
            if(isFalse == false){
                $.ajax({
                    type: "POST",
                    url: "{{url('api/portal/feedback')}}",
                    data: {
                        task_id: task_id,
                        project_id: {{$project->project_id}},
                        score: score,
                        comment: comment
                    },
                    dataType: "JSON",
                }).done(function(res){
                    if(res.success == true){
                        Notiflix.Notify.success(res.msg);
                        setTimeout(function(){
                            window.location.reload();
                        }, 3000);
                    }else{
                        Notiflix.Notify.failure(res.msg);
                    }
                })
            }
        }


        const feedback1 = (name, task_id, report_link) => {
            $('#TaskTitle').text(name);
            if(report_link != ''){
                $('#dontAttack').addClass('d-none');
            }
            if(report_link){
                $('iframe[id="src"]').attr('src', report_link+'#toolbar=0&navpanes=0&scrollbar=0');
            }
            $('iframe[id="src"]').removeAttr( "hidden" );
            $('iframe[id="src"]').removeAttr( "style" );
            $('iframe[id="src"]').attr('style', 'height: 100%; width: 100%;');
            $('#FeedbackModal').modal('show');
            $('button[id="rollback"]').attr('onclick', 'rollback("'+name+'", '+task_id+')');
            $('button[id="feedback"]').attr('onclick', 'feedback("'+name+'", '+task_id+')');
        }

        const rollback = (name, task_id) => {
            project_id = {{$project->project_id}};
            if(user_id && project_id){
                Notiflix.Confirm.show(
                    'Rollback',
                    'Đặt lại trạng thái chưa thành công cho task '+name,
                    'Xác nhận',
                    'Huỷ',
                    function okCb(){
                        Notiflix.Block.pulse('body');
                        $.ajax({
                            type: "POST",
                            url: "{{url('api/portal/rollback')}}",
                            data: {
                                task_id: task_id,
                                project_id: project_id,
                            },
                            dataType: "JSON",
                        }).done(function(res){
                            Notiflix.Block.remove('body');
                            if(res.success == true){
                                Notiflix.Notify.success(res.msg);
                                setTimeout(function(){
                                    window.location.reload();
                                }, 3000);
                            }else{
                                Notiflix.Notify.failure(res.msg);
                            }
                        })
                    }
                )
            }else{
                Notiflix.Notify.failure('Không để trống dữ liệu');
            }
        }

        const taskDelete = (name, task_id) => {
            project_id = {{$project->project_id}};
            if(task_id && project_id){
                Notiflix.Confirm.show(
                    'Xoá task',
                    'Việc xoá task '+name+' sẽ không thể khôi phục',
                    'Xác nhận',
                    'Huỷ',
                    function okCb(){
                        $.ajax({
                            type: "POST",
                            url: "{{url('api/portal/task-delete')}}",
                            data: {
                                task_id: task_id,
                                project_id: project_id,
                            },
                            dataType: "JSON",
                        }).done(function(res){
                            if(res.success == true){
                                Notiflix.Notify.success(res.msg);
                                setTimeout(function(){
                                    window.location.reload();
                                }, 3000);
                            }else{
                                Notiflix.Notify.failure(res.msg);
                            }
                        })
                    }
                )
            }else{
                Notiflix.Notify.failure('Không để trống dữ liệu');
            }
        }

        const taskUpdate = (task_id) => {
            project_id = {{$project->project_id}};
            if(task_id && project_id){
                Notiflix.Confirm.show(
                    'Xác nhận cập nhật task',
                    'Việc này sẽ không thể hoàn tác',
                    'Xác nhận',
                    'Huỷ',
                    function okCb(){
                        $.ajax({
                            type: "POST",
                            url: "{{url('api/portal/task-update')}}",
                            data: {
                                task_id: task_id,
                                name: $('#newName-'+task_id).val(),
                                start: Date.parse($('#newStart-'+task_id).val())/1000,
                                deadline: Date.parse($('#newDeadline-'+task_id).val())/1000,
                                priority: $('#newPriority-'+task_id).val(),
                                user_id: $('#newUser_id-'+task_id).val(),
                                note: $('#newNote-'+task_id).val()
                            },
                            dataType: "JSON",
                        }).done(function(res){
                            if(res.success == true){
                                Notiflix.Notify.success(res.msg);
                                setTimeout(function(){
                                    window.location.reload();
                                }, 3000);
                            }else{
                                Notiflix.Notify.failure(res.msg);
                            }
                        })
                    }
                )
            }else{
                Notiflix.Notify.failure('Không để trống dữ liệu');
            }
        }

        let uploadFile = () => {
        //Lấy ra files
        var file_data = $('#AttachFile').prop('files')[0];
        var project_id = $('#UploadProjectId').val();
        //lấy ra kiểu file
        var form_data = new FormData();
        //thêm files vào trong form data
        form_data.append('file', file_data);
        form_data.append('project_id', project_id);
        Notiflix.Block.pulse('#UploadFileFormPulse');
        //sử dụng ajax post
        $.ajax({
            url: '{{url("api/portal/file-attack")}}', 
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            error:  function (response) {
                        Notiflix.Block.remove('#UploadFileFormPulse');
                        res = jQuery.parseJSON( response.responseText );
                        Notiflix.Notify.failure(res.message);
                    }
        }).done(function(res){
            Notiflix.Block.remove('#UploadFileFormPulse');
            if(res.success == true){
                Notiflix.Notify.success(res.msg);
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }else{
                Notiflix.Notify.failure(res.msg);
            }
        })
    }
    </script>
@endsection