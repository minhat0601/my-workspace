@extends('layouts.student')


@section('content')
<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Tổng quan về dự án {{$project->name}}</h4>
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
                            <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-checkbox-marked-circle-outline me-1"></i></span>Giảng viên: {{$project->owner}}</p>
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
                            <p class="mb-0 text-truncate text-muted">Số task của bạn trong dự án này</p>
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
                            <p class="text-dark mb-1 font-weight-semibold">Deadline dự án</p>                                         
                            <h3 class="m-0">{{date('H:i - d/m/Y', (strtotime($project->deadline)))}}</h3>
                            <p class="mb-0 text-truncate text-muted"><span class="text-muted">{{date('d/m/Y', (strtotime($project->start_time)))}}</span> - 
                                <span class="text-muted">{{date('d/m/Y', (strtotime($project->deadline)))}}</span></p>
                        </div>
                        <div class="col-auto align-self-center">
                            <div class="report-main-icon bg-light-alt">
                                <i data-feather="clock" class="align-self-center text-muted icon-md"></i>  
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
                            <p class="text-dark mb-1 font-weight-semibold">Thành viên</p>
                            <h3 class="m-0">{{number_format(count($enrolleds))}} người</h3>
                            <p class="mb-0 text-truncate text-muted">là số người đã tham gia vào dự án</p>
                        </div>
                    </div>
                </div><!--end card-body--> 
            </div><!--end card--> 
        </div> <!--end col-->                               
    </div><!--end row-->
    @if(count($taskForTake) > 0)
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">Task hiện tại bạn có thể nhận thêm</h4>                      
                        </div><!--end col-->
                    </div>  <!--end row-->                                  
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="text">
                        <table id="myTask" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th><strong>STT</strong></th>
                                    <th><strong>Task</strong></th>
                                    <th><strong>Ngày tạo</strong></th>
                                    <th><strong>Bắt đầu</strong></th>
                                    <th><strong>Deadline<strong></th>
                                    <th><strong>Ưu tiên</strong></th>
                                    <th><strong>Tuỳ chọn</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($taskForTake as $item)
                                <tr>
                                    <td>{{$item->no}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{date('H:i - d/m/Y', strtotime($item->created_at))}}</td>
                                    <td>{{date('H:i - d/m/Y', strtotime($item->start))}}</td>
                                    <td>{{date('H:i - d/m/Y', strtotime($item->deadline))}}</td>
                                    <td>
                                        @if($item->priority == 1)
                                            <span class="badge badge-md badge-boxed  badge-soft-danger">Cao</span>
                                        @elseif($item->priority == 2)
                                            <span class="badge badge-md badge-boxed  badge-soft-warning">Trung bình</span>
                                        @elseif($item->priority == 3)
                                            <span class="badge badge-md badge-boxed  badge-soft-primary">Không</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($item->status == 0)
                                            <button type="button" onclick="takeIt({{$item->task_id}}, {{$item->project_id}}, '{{$item->name}}')" class="btn btn-sm btn-primary">Nhận task này</button>
                                        @endif
                                    </td>
                                </tr>

                                @endforeach
                                {{-- @dd($tasks) --}}
                            </tbody>
                        </table>
                    </div>                                     
                </div><!--end card-body--> 
            </div><!--end card--> 
        </div> <!--end col-->  
    </div><!--end row-->
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">Task của bạn</h4>                      
                        </div><!--end col-->
                    </div>  <!--end row-->                                  
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="text">
                        <table id="myTask" class="table table-hover mb-0" style="border-collapse: collapse; border-spacing: 0; width: 100%; ">
                            <thead>
                                <tr>
                                    <th><strong>STT</strong></th>
                                    <th><strong>Task</strong></th>
                                    <th><strong>Ngày nhận</strong></th>
                                    <th><strong>Bắt đầu</strong></th>
                                    <th><strong>Deadline<strong></th>
                                    <th><strong>Cập nhật cuối<strong></th>   
                                    <th><strong>Ưu tiên</strong></th>
                                    <th><strong>Trạng thái</strong></th>
                                    <th><strong>Ghi chú</strong></th>
                                    <th><strong>Điểm đánh giá</strong></th>
                                    <th><strong>Báo cáo</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $item)
                                <tr>
                                    <td>{{$item->no}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{date('H:i - d/m/Y', strtotime($item->created_at))}}</td>
                                    <td>{{date('H:i - d/m/Y', strtotime($item->start))}}</td>
                                    <td>{{date('H:i - d/m/Y', strtotime($item->deadline))}}</td>    
                                    <td>
                                        @if($item->updated_at == null)
                                        @else
                                            {{date('H:i - d/m/Y', strtotime($item->updated_at))}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->priority == 1)
                                            <span class="badge badge-md badge-boxed  badge-soft-danger">Cao</span>
                                        @elseif($item->priority == 2)
                                            <span class="badge badge-md badge-boxed  badge-soft-warning">Trung bình</span>
                                        @elseif($item->priority == 3)
                                            <span class="badge badge-md badge-boxed  badge-soft-primary">Không</span>
                                        @endif
                                    </td>
                                    <td>                                        
                                        @if($item->status == 0)
                                            @if(time() >= strtotime($item->start))
                                                @if(time() < strtotime($item->deadline))
                                                    <span class="badge badge-md badge-boxed  badge-soft-warning">Chưa hoàn thành</span>
                                                @else()
                                                    <span class="badge badge-md badge-boxed  badge-soft-danger">Chưa hoàn thành - Trễ</span>
                                                @endif
                                            @else
                                                <span class="badge badge-md badge-boxed  badge-soft-warning">Sắp tới</span>
                                            @endif
                                        @else
                                            @if($item->submited_time <= $item->deadline)
                                                <span class="badge badge-md badge-boxed  badge-soft-success">Hoàn thành - {{date('H:i - d/m/Y', strtotime($item->submited_time))}}</span>
                                            @else
                                                <span class="badge badge-md badge-boxed  badge-soft-warning">Hoàn thành trễ - {{date('H:i - d/m/Y', strtotime($item->submited_time))}}</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{$item->note}}</td>
                                    <td>
                                        @if($item->score != null)
                                            @if($item->score > 0)
                                                {{number_format($item->score, 0)}} x <i class="fa fas fa-star"></i>
                                            @elseif($item->score <= 0)
                                                Không đạt
                                            @endif 
                                        @endif
                                    </td>
                                    <td>
                                        @if(time() >= strtotime($item->start))
                                            @if($item->status == 0 )
                                                <button type="button" onclick="openFormUpload({{$item->task_id}}, {{$item->project_id}}, '{{$item->name}}')" class="btn btn-sm btn-primary">Done</button>
                                            @else()
                                                <button type="button" onclick="openAttackFile('{{$item->report_link}}')" class="btn btn-sm btn-primary">File đã nộp</button>
                                            @endif
                                        @else
                                            @if($item->status == 0 )
                                                <button type="button" disabled onclick="openFormUpload({{$item->task_id}}, {{$item->project_id}}, '{{$item->name}}')" class="btn btn-sm btn-primary btn-soft-primary">Done</button>
                                            @else
                                                <button type="button" onclick="openAttackFile('{{$item->report_link}}')" class="btn btn-sm btn-primary">File đã nộp</button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>

                                @endforeach
                                {{-- @dd($tasks) --}}
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
                            <h4 class="card-title">Tài nguyên dự án</h4>                      
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

    <div class="modal fade" id="ConfirmDone" tabindex="-1" aria-labelledby="ConfirmDoneLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content" id="ConfirmDoneForm">
                <div class="modal-header">
                    <h6 class="modal-title" id="ConfirmDone">Xác nhận hoàn thành task</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="example-password-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Task</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Nhập task" id="ConfirmName" disabled>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="example-password-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Tài liệu đính kèm (PDF)</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file" placeholder="Nhập task" id="ConfimFile" multiple/>
                        </div>
                    </div>
                    <div class="mb-3 row d-none">
                        <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">ID Task</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="number" id="ConfirmTaskId">
                        </div>
                    </div>
                    <div class="mb-3 row d-none">
                        <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">File ID</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="number" id="ConfirmFileID">
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


</div>
<!-- Required datatable js -->
<script src="../../public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../public/plugins/datatables/dataTables.bootstrap5.min.js"></script>
<!-- Buttons examples -->
<script src="../../public/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="../../public/plugins/datatables/buttons.bootstrap5.min.js"></script>
<script src="../../public/plugins/datatables/jszip.min.js"></script>
<script src="../../public/plugins/datatables/pdfmake.min.js"></script>
<script src="../../public/plugins/datatables/vfs_fonts.js"></script>
<script src="../../public/plugins/datatables/buttons.html5.min.js"></script>
<script src="../../public/plugins/datatables/buttons.print.min.js"></script>
<script src="../../public/plugins/datatables/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="../../public/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="../../public/plugins/datatables/responsive.bootstrap4.min.js"></script>
<script src="../../public/pages/jquery.datatable.init.js"></script>
<script>
    $(document).ready( function () {
        $('#myTask').DataTable({
            "language": {
                "sProcessing":    "Đang xử lý",
                "sLengthMenu":    "Xem _MENU_ tasks",
                "sZeroRecords":   "Không tìm thấy yêu cầu bạn nhập",
                "sEmptyTable":    "Bạn chưa nhận được task nào",
                "sInfo":          "Đang xem từ _START_ - _END_ trên tổng _TOTAL_ tasks",
                "sInfoEmpty":     "Đang xem từ _START_ - _END_ trên tổng _TOTAL_ tasks",
                "sInfoFiltered":  "(tìm trong _MAX_ tasks)",
                "sSearch":        "Tìm kiếm:",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Đang xử lý...",
                "oPaginate": {
                    "sFirst":    "Đầu tiên",
                    "sLast":    "Trang cuối",
                    "sNext":    "Trước",
                    "sPrevious": "Sau"
                }
            }, 
            responsive: true,
        });
        $('#fileList').DataTable({});
    } );

    let openFormUpload = (taskId, projectId, name, file_id) => {
        $('#ConfirmName').val(name);
        $('#ConfirmTaskId').val(taskId);
        $('#ConfirmDone').modal('show');
    }
    let makeDone = (taskId, file_id) => {

        Notiflix.Confirm.show(
            'Xác nhận đã hoàn thành công việc',
            'Tôi xác nhận đã hoàn thành. Việc này sẽ không thể hoàn tác.',
            'Xác nhận',
            'Huỷ',
            function okCb(){
                $.ajax({
                    url: '/api/project/task/make-done',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        task_id: taskId,
                        file_id: file_id,
                    }
                }).done(function(response){
                    if(response.success == true){
                        Notiflix.Notify.success(response.msg);
                        setTimeout(function(){
                            window.location.reload();
                        }, 3000);
                    }else{
                        Notiflix.Notify.failure(response.msg);
                    }
                })
            }
        );
    }

    let uploadFile = () => {
        //Lấy ra files
        var file_data = $('#ConfimFile').prop('files')[0];
        var task_id = $('#ConfirmTaskId').val();
        //lấy ra kiểu file
        var form_data = new FormData();
        //thêm files vào trong form data
        form_data.append('file', file_data);
        form_data.append('task_id', task_id);
        Notiflix.Block.pulse('#ConfirmDoneForm');
        //sử dụng ajax post
        $.ajax({
            url: '{{url("api/student/file-attack")}}', 
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            error:  function (response) {
                        Notiflix.Block.remove('#ConfirmDoneForm');
                        res = jQuery.parseJSON( response.responseText );
                        Notiflix.Notify.failure(res.message);
                    }
        }).done(function(res){
            Notiflix.Block.remove('#ConfirmDoneForm');
            if(res.success == true){
                Notiflix.Notify.success(res.msg);
                makeDone(task_id, res.file_id);
            }else{
                Notiflix.Notify.failure(res.msg);
            }
        })
    }

    let takeIt = (taskId, projectId, name) => {
        Notiflix.Confirm.show(
            'Xác nhận',
            'Bạn sẽ nhận task <b>' +name+'</b>. Việc này sẽ không thể hoàn tác.',
            'Xác nhận',
            'Huỷ',
            function okCb(){
                $.ajax({
                    url: '/api/project/task/take-it',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        task_id: taskId,
                        project_id: projectId
                    }
                }).done(function(response){
                    if(response.success == true){
                        Notiflix.Notify.success(response.msg);
                        setTimeout(function(){
                            window.location.reload();
                        }, 3000);
                    }else{
                        Notiflix.Notify.failure(response.msg);
                    }
                })
            })
    }

    const openAttackFile = (report_link) =>{
        if(report_link == ''){
            Notiflix.Report.failure(
                'Task này bạn nộp tài liệu',
                'Task '+name+' chưa nộp tài liệu nào.',
                'Ok',
                );
        }else{
            window.open(report_link, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400");
        }
    }
</script>
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
            $('#taskList').DataTable( {
                responsive: true
            } );
        });
    </script>
@endsection
