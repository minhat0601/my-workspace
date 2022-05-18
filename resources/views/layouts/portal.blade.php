
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{$title}} - My Workspace - Portal</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        {{-- <link rel="shortcut icon" href="{{asset('favicon.ico')}}"> --}}

        <!-- jvectormap -->
        <link href="{{asset('/plugins//jvectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet">

        <!-- App css -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('css/metisMenu.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/plugins//daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/css/app.min.css')}}" rel="stylesheet" type="text/css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>        
        <script src="{{asset('/js/notiflix-aio.js')}}"></script>
        <link href="{{asset('/dropify/css/dropify.min.css')}}">
        <script src="{{asset('/dropify/js/dropify.js')}}"></script>
    </head>
    <body class="">
        <!-- Left Sidenav -->
        <div class="left-sidenav">
            <!-- LOGO -->
            <div class="brand">
                <a href="{{url('/')}}" class="logo">
                    <span>
                        <img src="{{asset('/images/logo.png')}}" alt="logo-large" class="logo-sm" style="height: 50px !important;">
                    </span>
                    <span>
                        <img src="{{asset('/images/logo.png')}}" alt="logo-large" class="logo-lg logo-light">
                    </span>
                </a>
            </div>
            <!--end logo-->
            <div class="menu-content h-100" data-simplebar>
                <ul class="metismenu left-sidenav-menu">
                    <li class="menu-label mt-0">Dự án</li>
                    <li>
                        <a href="{{url('/')}}"> <i data-feather="home" class="align-self-center menu-icon"></i><span>Trang chủ</span><span class="menu-arrow"></span></a>
            
                    </li>
    
                    <li>
                        <a href="{{route('portal.projectManager')}}"><i data-feather="grid" class="align-self-center menu-icon"></i><span>Quản lý dự án</span></a>
                    </li> 

                    <hr class="hr-dashed hr-menu">
                    <li class="menu-label my-2">Người dùng</li>
                    <li>
                        <a data-bs-toggle="modal" data-bs-target="#userSearch" role="button"> <i data-feather="search" class="align-self-center menu-icon"></i><span>Tìm kiếm người dùng</span><span class="menu-arrow"></span></a>
                    </li>
                    <li>
                        <a href="{{route('portal.studentManager')}}"> <i data-feather="users" class="align-self-center menu-icon"></i><span>Quản lý sinh viên</span><span class="menu-arrow"></span></a>
                    </li>
                    <li>
                        <a href="{{route('portal.mentorManager')}}"> <i data-feather="user" class="align-self-center menu-icon"></i><span>Quản lý giảng viên</span><span class="menu-arrow"></span></a>
                    </li>
                    <li>
                        <a href="{{route('portal.adminManager')}}"> <i data-feather="user-check" class="align-self-center menu-icon"></i><span>Quản lý quản trị viên</span><span class="menu-arrow"></span></a>
                    </li>
    
                <div class="update-msg text-center">
                    <a href="javascript: void(0);" class="float-end close-btn text-muted" data-dismiss="update-msg" aria-label="Close" aria-hidden="true">
                        <i class="mdi mdi-close"></i>
                    </a>
                    <h5 class="mt-3">My Workspace</h5>
                    <p class="mb-3">Chào mừng bạn đến với My Workspace</p>
                    <a href="javascript: void(0);" class="btn btn-outline-warning btn-sm">Xem hướng dẫn</a>
                </div>
            </div>
        </div>
        <!-- end left-sidenav-->
        

        <div class="page-wrapper">
            <!-- Top Bar Start -->
            <div class="topbar">            
                <!-- Navbar -->
                <nav class="navbar-custom">    
                    <ul class="list-unstyled topbar-nav float-end mb-0">  
                        <li class="dropdown hide-phone">
                            <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-bs-toggle="dropdown" href="#" role="button"
                                aria-haspopup="false" aria-expanded="false">
                                <i data-feather="search" class="topbar-icon"></i>
                            </a>
                            
                            <div class="dropdown-menu dropdown-menu-end dropdown-lg p-0">
                                <!-- Top Search Bar -->
                                <div class="app-search-topbar">
                                    <form action="#" method="get">
                                        <input type="search" name="search" class="from-control top-search mb-0" placeholder="Type text...">
                                        <button type="submit"><i class="ti-search"></i></button>
                                    </form>
                                </div>
                            </div>
                        </li>                      

                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-bs-toggle="dropdown" href="#" role="button"
                                aria-haspopup="false" aria-expanded="false">
                                <i data-feather="bell" class="align-self-center topbar-icon"></i>
                                <span class="badge bg-danger rounded-pill noti-icon-badge">2</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0">
                            
                                <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                                    Thông báo <span class="badge bg-primary rounded-pill">2</span>
                                </h6> 
                                <div class="notification-menu" data-simplebar>
                                    <!-- item-->
                                    <a href="#" class="dropdown-item py-3">
                                        <small class="float-end text-muted ps-2">2 min ago</small>
                                        <div class="media">
                                            <div class="avatar-md bg-soft-primary">
                                                <i data-feather="shopping-cart" class="align-self-center icon-xs"></i>
                                            </div>
                                            <div class="media-body align-self-center ms-2 text-truncate">
                                                <h6 class="my-0 fw-normal text-dark">Your order is placed</h6>
                                                <small class="text-muted mb-0">Dummy text of the printing and industry.</small>
                                            </div><!--end media-body-->
                                        </div><!--end media-->
                                    </a><!--end-item-->
                                    <!-- item-->
                                    <a href="#" class="dropdown-item py-3">
                                        <small class="float-end text-muted ps-2">10 min ago</small>
                                        <div class="media">
                                            <div class="avatar-md bg-soft-primary">
                                                <img src="{{asset('/images/users/user-4.jpg')}}" alt="" class="thumb-sm rounded-circle">
                                            </div>
                                            <div class="media-body align-self-center ms-2 text-truncate">
                                                <h6 class="my-0 fw-normal text-dark">Meeting with designers</h6>
                                                <small class="text-muted mb-0">It is a long established fact that a reader.</small>
                                            </div><!--end media-body-->
                                        </div><!--end media-->
                                    </a><!--end-item-->
                                    <!-- item-->
                                    <a href="#" class="dropdown-item py-3">
                                        <small class="float-end text-muted ps-2">40 min ago</small>
                                        <div class="media">
                                            <div class="avatar-md bg-soft-primary">                                                    
                                                <i data-feather="users" class="align-self-center icon-xs"></i>
                                            </div>
                                            <div class="media-body align-self-center ms-2 text-truncate">
                                                <h6 class="my-0 fw-normal text-dark">UX 3 Task complete.</h6>
                                                <small class="text-muted mb-0">Dummy text of the printing.</small>
                                            </div><!--end media-body-->
                                        </div><!--end media-->
                                    </a><!--end-item-->
                                    <!-- item-->
                                    <a href="#" class="dropdown-item py-3">
                                        <small class="float-end text-muted ps-2">1 hr ago</small>
                                        <div class="media">
                                            <div class="avatar-md bg-soft-primary">
                                                <img src="{{asset('/images/users/user-5.jpg')}}" alt="" class="thumb-sm rounded-circle">
                                            </div>
                                            <div class="media-body align-self-center ms-2 text-truncate">
                                                <h6 class="my-0 fw-normal text-dark">Your order is placed</h6>
                                                <small class="text-muted mb-0">It is a long established fact that a reader.</small>
                                            </div><!--end media-body-->
                                        </div><!--end media-->
                                    </a><!--end-item-->
                                    <!-- item-->
                                    <a href="#" class="dropdown-item py-3">
                                        <small class="float-end text-muted ps-2">2 hrs ago</small>
                                        <div class="media">
                                            <div class="avatar-md bg-soft-primary">
                                                <i data-feather="check-circle" class="align-self-center icon-xs"></i>
                                            </div>
                                            <div class="media-body align-self-center ms-2 text-truncate">
                                                <h6 class="my-0 fw-normal text-dark">Payment Successfull</h6>
                                                <small class="text-muted mb-0">Dummy text of the printing.</small>
                                            </div><!--end media-body-->
                                        </div><!--end media-->
                                    </a><!--end-item-->
                                </div>
                                <!-- All-->
                                <a href="javascript:void(0);" class="dropdown-item text-center text-primary">
                                    Xem tất cả <i class="fi-arrow-right"></i>
                                </a>
                            </div>
                        </li>

                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-bs-toggle="dropdown" href="#" role="button"
                                aria-haspopup="false" aria-expanded="false">
                                <span class="ms-1 nav-user-name hidden-sm">{{session('fullname')}}</span>
                                <img src="{{session('avatar')}}" alt="" class="rounded-circle thumb-xs" />                                 
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="/dashboard/myaccount"><i data-feather="user" class="align-self-center icon-xs icon-dual me-1"></i> Thông tin của tôi</a>
                                <a class="dropdown-item" href="#"><i data-feather="settings" class="align-self-center icon-xs icon-dual me-1"></i> Cài đặt</a>
                                <div class="dropdown-divider mb-0"></div>
                                <a class="dropdown-item" href="{{route('logout')}}"><i data-feather="power" class="align-self-center icon-xs icon-dual me-1"></i> Đăng xuất</a>
                            </div>
                        </li>
                    </ul><!--end topbar-nav-->
        
                    <ul class="list-unstyled topbar-nav mb-0">                        
                        <li>
                            <button class="nav-link button-menu-mobile">
                                <i data-feather="menu" class="align-self-center topbar-icon"></i>
                            </button>
                        </li> 
                        <li class="creat-btn">
                            <div class="nav-link">
                            <a class=" btn btn-sm btn-soft-primary"  data-bs-toggle="modal" data-bs-target="#CreateNewProject" role="button"><i class="fas fa-plus me-2"></i>Tạo dự án mới</a>
                        </li>                           
                    </ul>
                </nav>
                <!-- end navbar-->
            </div>
            <!-- Top Bar End -->

            <!-- Page Content-->
            <div class="page-content">
                @yield('content')
                <footer class="footer text-center text-sm-start">
                    &copy; <script>
                        document.write(new Date().getFullYear())
                    </script> My Workspace <span class="text-muted d-none d-sm-inline-block float-end">Crafted with <i
                            class="mdi mdi-heart text-danger"></i> by Mannatthemes</span>
                </footer><!--end footer-->
            </div>
            <!-- end page content -->
        </div>
        <!-- end page-wrapper -->
        <div class="modal fade" id="CreateNewProject" tabindex="-1" aria-labelledby="CreateNewProjectLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen-sm-down">
                <div class="modal-content" id="pulseModalCreateProject">
                    <div class="modal-header">
                        <h6 class="modal-title" id="CreateNewProject">Tạo dự án mới</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="example-password-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Tên dự án (*)</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Nhập tên dự án" id="name" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Invite Code (*)</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Nhập Invite Code cho dự án này" id="invite_code">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Mô tả (*)</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" type="text" placeholder="Nhập mô tả cho dự án này" id="desc"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Ngày chạy (*)</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="datetime-local" id="start">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Deadline Dự án (*)</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="datetime-local" id="deadline">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-number-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Giáo viên phụ trách</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="user_id">
                                    <option value='0'>Không</option>
                                    @foreach($mentors as $user)
                                        @if($user->user_id != session('user_id'))
                                            <option value='{{$user->user_id}}'>{{$user->fullname}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" onclick="createProject()">Tạo dự án</button>
                        <button type="button" class="btn btn-soft-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="userSearch" tabindex="-1" aria-labelledby="userSearchLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen-sm-down">
                <div class="modal-content" id="pulseModalUserSearch">
                    <div class="modal-header">
                        <h6 class="modal-title" id="userSearch">Tìm kiếm người dùng</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="example-password-input" class="col-sm-2 form-label align-self-center mb-lg-0 text-end">Email (*)</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="email" placeholder="Nhập email người dùng" id="emailUser" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" onclick="userSearch()">Tìm kiếm</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
        const createProject = () =>{
            let name = $("#name").val();
            let invite_code = $("#invite_code").val();
            let about = $("#desc").val();
            let deadline = $("#deadline").val();
            let user_id = $("#user_id").val();
            let start = $("#start").val();
            if(name && deadline){
                Notiflix.Block.pulse('#pulseModalCreateProject');
                $.ajax({
                    url: '{{route('portal.newProject')}}',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        name: name,
                        about: about,
                        invite_code: invite_code,
                        deadline: Date.parse(deadline) / 1000,
                        user_id: user_id,
                        start: Date.parse(start) / 1000,
                    }
                }).done(function(response){
                    Notiflix.Block.remove('#pulseModalCreateProject');
                    $(".modal:visible").modal('toggle');
                    if(response.success == true){
                        Notiflix.Notify.success(response.msg);
                    }else{
                        Notiflix.Notify.failure(response.msg);
                    }
                })
            }else{
                Notiflix.Notify.failure('Tên dự án là bắt buộc');
            }
        }
        const userSearch = () =>{
            let email = $("#emailUser").val();
            if(email){
                Notiflix.Block.pulse('#pulseModalUserSearch');
                $.ajax({
                    url: '{{route('portal.searchUser')}}',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        email: email,
                    }
                }).done(function(res){
                    Notiflix.Block.remove('#pulseModalUserSearch');
                    $(".modal:visible").modal('toggle');
                    if(res.success == true){
                        Notiflix.Confirm.show(
                            res.msg,
                            'Nhấn tiếp tục để xem chi tiết',
                            'Tiếp tục',
                            'Huỷ',
                            function ok(){
                                window.location.href = res.redirect;
                            }
                        );
                    }else{
                        Notiflix.Notify.failure(res.msg);
                    }
                })
            }else{
                Notiflix.Notify.failure('Không để trống email');
            }
        }
        </script>


        <!-- jQuery  -->
        <script src="{{asset('/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('/js/metismenu.min.js')}}"></script>
        <script src="{{asset('/js/waves.js')}}"></script>
        <script src="{{asset('/js/feather.min.js')}}"></script>
        <script src="{{asset('/js/simplebar.min.js')}}"></script>
        <script src="{{asset('/js/moment.js')}}"></script>
        <script src="{{asset('/plugins/daterangepicker/daterangepicker.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('/js/app.js')}}"></script>
        @yield('scripts')

    </body>


</html>