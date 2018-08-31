<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'post_id',
        'message',
        'parent_id',
    ];

    protected $casts = [
        'post_id' => 'int',
        'parent_id' => 'int',
    ];
}
