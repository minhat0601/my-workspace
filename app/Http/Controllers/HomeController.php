<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{   
    protected $res = [
        "success" => false,
        "msg" => "Có lỗi trong quá trình xử lý"
    ];
    public function index(){
        if($this->me != null){
            if($this->me->user_type_id == 1){
                return redirect()->route('portal.dashboard');
            }elseif($this->me->user_type_id == 2){
                return redirect()->route('teach.dashboard');
            }elseif($this->me->user_type_id == 3){
                return redirect()->route('student.dashboard');
            }
        }
    }
    public function loginView(Request $request, $msg = null){
        if($request->session()->has('user_id')){
            return redirect()->route('/');
        }else{
            return view('login', compact('msg'));
        }
    }
    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        if($email == null || $email == '' || $password == null || $password == ''){
            $this->res['msg'] = 'Vui lòng không để trống dữ liệu';
        }else{
            if (Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])) {
                $this->res['msg'] = 'Đăng nhập thành công';
                $this->res['success'] = true;
                $this->res['user_id'] = Auth::user()->user_id;
                $this->res['fullname'] = Auth::user()->fullname;
                $this->res['logged'] = Auth::getName();
                // $request->session()->put('user_id', Auth::user()->user_id);
                session(['user_id' => Auth::user()->user_id]);
                session(['fullname'=> Auth::user()->fullname]);
                session(['avatar'=> Auth::user()->avatar]);
            }else{
                $this->res['msg'] = 'Email hoặc mật khẩu không đúng';
                // $this->res['pass'] = bcrypt($password);
            }
        }
        return response($this->res);
    }

    public function error(){
        return view('404');
    }
}
