<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class Controller extends BaseController
{ 
    protected $me;
    public function __construct(){
        if(session('user_id')){
            $this->me = DB::table('users')
            ->where('user_id', session('user_id'))
            ->select()
            ->first();
        }else{
            $this->me = null;
        }
    }
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
