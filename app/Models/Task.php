<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    use HasFactory;
    public static function getMyTask($user_id, $project_id){
        $tasks = DB::table('tasks')
                    ->where('project_id', $project_id)
                    ->where('user_id', $user_id)
                    ->select('*')
                    ->get();
        for($i = 0; $i < count($tasks); $i++){
            $tasks[$i]->no = $i + 1;
        }
        return $tasks;
    }

}
