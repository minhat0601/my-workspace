@extends('layouts.student')


@section('content')
<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Chọn niên khoá học</h4>
                    </div><!--end col-->
                </div><!--end row-->                                                              
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div><!--end row-->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Danh sách niên khoá học</h4>
                    <p class="text-muted mb-0">
                        Sinh viên vui lòng chọn đúng niên khoá của mình để tiếp tục sử dụng hệ thống. Mỗi sinh viên chỉ được chọn tối đa <span class="text-danger">một niên khoá</span> trong danh sách bên dưới.
                    </p>
                </div>
                <!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th><strong>STT<strong></th>
                                    <th><strong>Tên khoá</strong></th>
                                    <th><strong>Bắt đầu</strong></th>
                                    <th><strong>Kết thúc</strong></th>
                                    <th><strong>Tuỳ chọn</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($semesters as $item)
                                <tr>
                                    <td>{{$item->no}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->start}}</td>
                                    <td>{{$item->end}}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="semesterChoice({{$item->semester_id}},'{{$item->name}}')">
                                                Chọn niên khoá
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!-- end col -->
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
            }
        })
    } );


    let semesterChoice = (semester_id, semester_name) => {
        Notiflix.Confirm.show(
            'Xác nhận',
            'Niên khoá của bạn là '+semester_name+'?',
            'Xác nhận',
            'Huỷ',
            function okCb(){
                $.ajax({
                    url: '/api/student/semester-choice',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        semester_id: semester_id,
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
</script>
@endsection
