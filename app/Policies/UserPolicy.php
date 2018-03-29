<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 检查当前查看用户是否登录用户:权限检查
     *
     * @param User $currentUser 当前登录用户
     * @param User $user 要查看或者操作的用户
     * @return bool 是否允许
     */
    public function checkIsSelf(User $currentUser, User $user)
    {
        return $currentUser->id == $user->id;
    }

    /**
     * 检查当前用户是否是管理员
     *
     */
    public function checkIsAdmin(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id != $user->id;
    }
}
