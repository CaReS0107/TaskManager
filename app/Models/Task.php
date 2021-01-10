<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = 'id';

    protected $fillable = [
        'task_name',
        'task_desc',
        'status',
        'deadline',
        'task_created_at',
        'task_started_at',
        'user_id'
    ];
    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function comments(){
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function priorities()
    {
        return $this->belongsToMany(Priority::class, 'priority_task', 'task_id', 'priority_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_task', 'task_id', 'project_id');
    }




}
