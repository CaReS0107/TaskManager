<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 * @package App\Models
 */
class Project extends Model
{
    use HasFactory;

    protected $guarded = 'id';

    protected $fillable = [
        'project_name',
        'project_desc',
        'status',
        'user_id'

    ];

    protected $hidden = [

        'created_at',
        'updated_at',

    ];
    public function users(){
        return $this->belongsToMany(User::class,'project_user', 'project_id', 'user_id');
    }

    public function tasks(){
        return $this->belongsToMany(Task::class,'project_task','project_id','task_id');
    }
    public function comments(){
        return $this->morphMany(Comment::class, 'commentable');
    }

}
