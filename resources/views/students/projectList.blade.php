@extends('layouts.student')


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Tham gia dự án mới</h4>
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
                    url: '../api/student/browse',
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

        const join = (project_id,invite_code) =>{
            if(project_id && invite_code){
                $.ajax({
                    url: '/api/student/join',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        project_id: project_id,
                        invite_code: invite_code
                    }
                }).done(function(response){
                    if(response.success == true){
                        Notiflix.Notify.success(response.msg);
                        setTimeout(function(){
                            window.location.replace(response.redirect);
                        },3000)
                    }else{
                        Notiflix.Notify.failure(response.msg);
                    }
                })
            }else{
                Notiflix.Notify.failure('Vui lòng không để trống thông tin');
            }
        }
    </script>
@endsection