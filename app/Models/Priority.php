<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;

    protected $guarded = 'id';

    protected $fillable = [
        'priority_name',
        'priority_desc',
        'status'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'priority_task', 'priority_id', 'task_id');
    }
}
