@extends('layouts.portal')


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Quản lý</h4>
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
                            <h4 class="card-title">Danh sách giảng viên trên hệ thống</h4>                      
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
                            <th><strong>Họ tên</strong></th>
                            <th><strong>Ngày tham gia</strong></th>
                            <th><strong>Email</strong></th>
                            <th><strong>Số dự án tham gia</strong></th>
                            <th><strong>Tuỳ chọn</strong></th>
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
                    url: '../api/portal/mentors',
                    dataSrc: 'data'
                },
                "columns":[
                    {data: 'user_id'},
                    {data: 'fullname'},
                    {data: 'created_at'},
                    {data: 'email'},
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
        let addNewMentor = () => {
            var email = $('#mentorEmail').val();
            if(email){
                Notiflix.Block.pulse('#pulseModalNewMentor');
                $.ajax({
                    url: '../api/portal/new-mentor',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        email: email,
                    }
                }).done(function(res){
                    Notiflix.Block.remove('#pulseModalNewMentor');
                    $(".modal:visible").modal('toggle');
                    if(res.success == true) {
                        fetchData();
                        Notiflix.Report.success(
                            'Thành công',
                            res.msg,
                            'Đóng',
                            );
                        
                    }else{
                        Notiflix.Notify.failure(res.msg);
                    }
                })
            }else{
                Notiflix.Notify.failure('Bạn chưa nhập email');
            }
        }
    </script>
@endsection