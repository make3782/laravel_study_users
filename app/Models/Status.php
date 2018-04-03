<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    protected $fillable = ['content'];

    /**
     * 多对一的从属关系:用户
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
