<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Project extends Model
{
    use HasFactory;

    public static function getProjectById($project_id){
        $data = DB::table('projects')
                ->where('project_id', $project_id)
                ->join('users', 'users.user_id', 'projects.user_id')
                ->select('projects.*', 'users.fullname as owner')
                ->first();
        return $data;
    }
}
