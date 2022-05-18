@extends('layouts.portal')


@section('content')
<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Chi tiết người dùng</h4>
                    </div><!--end col-->
                </div><!--end row-->                                                              
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div><!--end row-->
    <!-- end page title end breadcrumb -->
    <div class="pb-4">
        <ul class="nav-border nav nav-pills mb-0" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="settings_detail_tab" data-bs-toggle="pill" href="#Profile_Settings">Thông tin</a>
            </li>
        </ul>        
    </div><!--end card-body-->
    <div class="row">
        <div class="col-12">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade active show" id="Profile_Settings" role="tabpanel" aria-labelledby="settings_detail_tab">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">                      
                                            <h4 class="card-title">Thông tin cá nhân</h4>                      
                                        </div><!--end col-->                                                       
                                    </div>  <!--end row-->                                  
                                </div><!--end card-header-->
                                <div class="card-body">                       
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center">Họ tên</label>
                                        <div class="col-lg-9 col-xl-8">
                                            <span class="form-control">{{$user->fullname}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center">Email</label>
                                        <div class="col-lg-9 col-xl-8">
                                            <span class="form-control">{{$user->email}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center">Chuyên ngành</label>
                                        <div class="col-lg-9 col-xl-8">
                                            <select class="form-select">
                                                @foreach($majors as $item)
                                                    @if($item->major_id == $user->major_id)
                                                        <option value="{{$item->major_id}}" selected>{{$item->name}}</option>
                                                    @else()
                                                       <option value="{{$item->major_id}}">{{$item->name}}</option>
                                                    @endif
                                                @endforeach()
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center">Khoá</label>
                                        <div class="col-lg-9 col-xl-8">
                                            <select class="form-select">
                                                @foreach($semesters as $item)
                                                    @if($item->semester_id == $user->semester_id)
                                                        <option value="{{$item->semester_id}}" selected>{{$item->name}}</option>
                                                    @else()
                                                       <option value="{{$item->semester_id}}">{{$item->name}}</option>
                                                    @endif
                                                @endforeach()
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-9 col-xl-8 offset-lg-3">
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Cập nhật</button>
                                        </div>
                                    </div>                                                    
                                </div>                                            
                            </div>
                        </div> <!--end col--> 
                        <div class="col-lg-6 col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Dự án đã tham gia</h4>
                                </div><!--end card-header-->
                                <div class="card-body"> 
                                    <table id="projects" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th><strong>STT</strong></th>
                                                <th><strong>Tên dự án</strong></th>
                                                <th><strong>Ngày tham gia<strong></th>
                                                <th><strong>Done/Tasks</strong></th>
                                                <th><strong>Tuỳ chọn</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($projects as $item)
                                                <tr>
                                                    <td>{{$item->no}}</td>
                                                    <td>{{$item->name}}</td>
                                                    <td>{{$item->created_at}}</td>
                                                    <td>{{$item->done}}/{{$item->tasks->count()}}</td>
                                                    <td>
                                                        <button type="button" onclick="deleteUser('{{$user->fullname}}', {{$user->user_id}}, {{$item->tasks->count()}})" class="btn btn-sm btn-danger">Xoá</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div><!--end card-body-->
                            </div><!--end card-->
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Other Settings</h4>
                                </div><!--end card-header-->
                                <div class="card-body"> 

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="Email_Notifications" checked="">
                                        <label class="form-check-label" for="Email_Notifications">
                                            Email Notifications
                                        </label>
                                        <span class="form-text text-muted font-12 mt-0">Do you need them?</span>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="API_Access">
                                        <label class="form-check-label" for="API_Access">
                                            API Access
                                        </label>
                                        <span class="form-text text-muted font-12 mt-0">Enable/Disable access</span>
                                    </div>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div> <!-- end col -->                                                                              
                    </div><!--end row-->
                </div><!--end tab-pane-->
            </div><!--end tab-content-->
        </div><!--end col-->
    </div><!--end row-->

</div>
@endsection

@section('scripts')


@endsection