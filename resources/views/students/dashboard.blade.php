@extends('layouts.student')


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Dự án của tôi</h4>
                        <p class="text-muted mb-0">Bạn có {{count($projects)}} dự án.</p>
                    </div><!--end col--> 
                </div><!--end row-->                                                              
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <div class="row">
        @foreach($projects as $item)
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">{{$item->name}}</h4> 
                            <p class="text-muted mb-0">Deadline dự án: {{$item->deadline}}</p>                  
                        </div><!--end col-->                                                                            
                    </div>  <!--end row-->                                  
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col">
                            <div class="media">         
                                <a class="" href="#">
                                    <img src="{{$item->avatar}}" alt="user" class="rounded-circle thumb-lg">
                                </a>                                   
                                <div class="media-body align-self-center ms-2">
                                    <p class="font-14 font-weight-semibold mb-0">Giảng viên: {{$item->owner}}</p>
                                    <p class="mb-0 font-12 text-muted">Email: {{$item->email}}</p>
                                </div>
                            </div><!--end media-->
                        </div><!--end col-->
                        <div class="col-auto align-self-center">
                            <div class="button-items"> 
                                <a href="{{url('project/'.$item->project_id)}}"type="button" class="btn btn-outline-primary">Chi tiết</a>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->                                    
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
        @endforeach
    </div>

</div>
@endsection
