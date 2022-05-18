@extends('layouts.portal')


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Quản lý dự án</h4>
                    </div><!--end col-->
                </div><!--end row-->                                                              
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div><!--end row-->
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">Danh sách dự án trên hệ thống</h4>                      
                        </div><!--end col-->
                        <div class="col-auto"> 
                            <a class=" btn btn-sm btn-soft-primary" data-bs-toggle="modal" data-bs-target="#newMentor" role="button"><i class="fas fa-plus me-2"></i>Thêm giảng viên mới</a>
                        </div><!--end col-->
                    </div>                </div><!--end card-header-->
                <div class="card-body">
                    <table id="projects" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th><strong>ID</strong></th>
                            <th><strong>Tên dự án</strong></th>
                            <th><strong>Ngày tạo</strong></th>
                            <th><strong>Start</strong></th>
                            <th><strong>Deadline</strong></th>
                            <th><strong>Mã tham gia</strong></th>
                            <th><strong>Lượng thành viên</strong></th>
                            <th><strong></strong></th>
                        </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>

<div class="modal fade" id="newMentor" tabindex="-1" aria-labelledby="newMentorLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content" id="pulseModalNewMentor">
            <div class="modal-header">
                <h6 class="modal-title" id="newMentor">Thêm giảng viên</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Email GV(*)</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="email" id="mentorEmail" placeholder="Nhập email giảng viên">
                        <small class="text-muted ms-2">Email có hoặc chưa tồn tại trên hệ thống đều có thể được cấp quyền</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" onclick="addNewMentor()">Cấp quyền</button>
                <button type="button" class="btn btn-soft-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade show" id="UpdateProject" tabindex="-1" aria-labelledby="UpdateProjectLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content" id="pulseModalUpdateProject">
            <div class="modal-header">
                <h6 class="modal-title" id="UpdateProject">Cập nhật dự án</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 row d-none">
                    <label for="example-password-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">ID (*)</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" placeholder="Nhập tên dự án" id="update_project_id" required="">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="example-password-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Tên dự án (*)</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" placeholder="Nhập tên dự án" id="update_name" required="">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Invite Code (*)</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" placeholder="Nhập Invite Code cho dự án này" id="update_invite_code">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Mô tả (*)</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" type="text" placeholder="Nhập mô tả cho dự án này" id="update_desc"></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Ngày chạy (*)</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="datetime-local" id="update_start">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Deadline Dự án (*)</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="datetime-local" id="update_deadline">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" onclick="updateProjectRequest()">Cập nhật</button>
                <button type="button" class="btn btn-soft-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
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
        const fetchData = () => {
            $('#projects').DataTable( {
                "processing": true,
                "retrieve": true,
                "serverSide": true,
                "ajax":{ 
                    type: 'POST',
                    url: '../api/portal/all-projects',
                    dataSrc: 'data'
                },
                "columns":[
                    {data: 'project_id'},
                    {data: 'name'},
                    {data: 'created_at'},
                    {data: 'start_time'},
                    {data: 'deadline'},
                    {data: 'invite_code'},
                    {data: 'count'},
                    {data: 'action'},

                ],
                columnDefs: [{
                    "defaultContent": "",
                    "targets": "_all"
                }],
            } );
        }
        $(document).ready(function() {
            fetchData();
        });
        const openUpdateForm = (project_id, name, invite_code, about, start_time, deadline) =>{
            $('#update_project_id').val(project_id);
            $('#update_name').val(name);
            $('#update_desc').text(about);
            $('#update_invite_code').val(invite_code);
            $('#update_start').val(start_time);
            $('#update_deadline').val(deadline);
            $('#UpdateProject').modal('show');
        }

        const updateProjectRequest = () => {
            Notiflix.Confirm.show(
                    'Xác nhận cập nhật dự án',
                    'Việc này sẽ không thể hoàn tác',
                    'Xác nhận',
                    'Huỷ',
                    function okCb(){
                        $.ajax({
                            type: "POST",
                            url: "{{url('api/portal/project-update')}}",
                            data: {
                                project_id: $('#update_project_id').val(),
                                name: $('#update_name').val(),
                                start: Date.parse($('#update_start').val())/1000,
                                deadline: Date.parse($('#update_deadline').val())/1000,
                                about: $('#update_desc').val(),
                                invite_code: $('#update_invite_code').val()
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
        }
        const projectDelete = (id) => {
            Notiflix.Confirm.show(
                    'Xác nhận xoá dự án',
                    'Việc này sẽ không thể hoàn tác',
                    'Xác nhận',
                    'Huỷ',
                    function okCb(){
                        $.ajax({
                            type: "GET",
                            url: "{{url('api/portal/project-delete')}}/"+id,
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
                );
        }
    </script>


@endsection