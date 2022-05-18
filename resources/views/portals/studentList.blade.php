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
                    <h4 class="card-title">Danh sách sinh viên trên hệ thống</h4>
                </div><!--end card-header-->
                <div class="card-body">
                    <table id="projects" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th><strong>ID</strong></th>
                            <th><strong>Họ tên</strong></th>
                            <th><strong>Ngày tham gia</strong></th>
                            <th><strong>Email</strong></th>
                            <th><strong>Chuyên ngành</strong></th>
                            <th><strong>Khoá học</strong></th>
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
            $('#projects').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax":{ 
                    type: 'POST',
                    url: '../api/portal/students',
                    dataSrc: 'data'
                },
                "columns":[
                    {data: 'user_id'},
                    {data: 'fullname'},
                    {data: 'created_at'},
                    {data: 'email'},
                    {data: 'major'},
                    {data: 'semester'},
                    {data: 'count'},
                    {data: 'action'},
                ],
                columnDefs: [{
                    "defaultContent": "",
                    "targets": "_all"
                }],
            } );
        });
    </script>
@endsection