<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot()
    {
        parent::boot();

        // 事件监听
        // 监听模型在创建前,生成token
        static::creating(function($user) {
            $user->activation_token = str_random(30);
        });
    }

    /**
     * 生成头像
     *
     */
    public function genavatar($size = 100)
    {
        return 'https://lccdn.phphub.org/uploads/avatars/6932_1508394867.jpg?imageView2/1/w/100/h/100';
        // return 'https://b-ssl.duitang.com/uploads/item/201504/04/20150404H3338_N8Wir.jpeg';
    }

    /**
     * 一对多的关系:微博正文
     */
    public function statuses() {
        return $this->hasMany(Status::class);
    }

    /**
     * 获取用户发表的微博
     */
    public function feed() {
        return $this->statuses()->orderBy('created_at', 'desc');
    }
}

