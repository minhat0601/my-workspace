<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function googleredirect(Request $request){
        if(session('user_id')){
            return redirect()->route('/');
        }
        return Socialite::driver('google')->redirect();
    }

    public function handleCallback(Request $request){
        if(session('user_id')){
            return redirect()->route('/');
        }
        $user = Socialite::driver('google')->user();
        if(http_response_code() == 500){
            return redirect()->route('error');
        }
        if(strpos($user->email, '@fpt.edu.vn') === false){
            return redirect('/auth/login/error');
        }

        $userData = DB::table('users')
                        ->where('email', $user->email)
                        ->first();
        
        if(!$userData){
            DB::table('users')
                ->insert([
                    [
                        'email' => $user->email,
                        'google_id' => $user->id,
                        'fullname' => $user->name,
                        'avatar' => $user->avatar,
                        'user_id' => null,
                        'active' => 1,
                        'user_type_id' => 3,
                        'created_at' => date('Y-m-d H:i:s', time()),
                        'password' => 0
                    ]
                ]);
                $afterInsert = DB::table('users')
                                ->where('email', $user->email)
                                ->first();
                $request->session()->put('user_id', $afterInsert->user_id);
                session(['fullname'=> $afterInsert->fullname]);
                session(['avatar'=> $afterInsert->avatar]);
                return redirect()->route('/');
        }else{
            DB::table('users')
                ->where('user_id', $userData->user_id)
                ->update(
                    [
                        'google_id' => $user->id,
                        'avatar' => $user->avatar,
                        'fullname' => $user->name,
                    ]
                );
            $request->session()->put('user_id', $userData->user_id);
            session(['fullname' => $user->name]);
            session(['avatar'=> $user->avatar]);
            return redirect()->route('/');
        }
    }

    public function logout(){
        session()->flush();
        return redirect()->route('/');
    }
}
