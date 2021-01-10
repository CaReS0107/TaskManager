<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = 'id';

    protected $fillable = [
        'comment',
        'user_id',
    ];
    protected $hidden = [
        'user_id',
        'id',
        'commentable_type',
        'commentable_id'
    ];

    public function commentable(){
        return $this->morphTo();
    }
    public function users(){
        return $this->belongsTo(User::class);
    }

}
