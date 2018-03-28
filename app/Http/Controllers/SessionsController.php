<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Auth;

class SessionsController extends Controller
{
    /**
     * 注册用户页面
     *
     */
    public function create()
    {
        return view('sessions.create');
    }

    /**
     * 用户登录操作
     *
     * @param Request $request 请求
     * @return route 操作完毕后的路由
     */
    public function store(Request $request)
    {
        $cert = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:2'
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember'))) {
            // 登录成功
            session()->flash('success', '欢迎回来!' . Auth::user()->name);
            return redirect()->route('users.show', [Auth::user()]);
        } else {
            // 登录失败
            session()->flash('danger', '很抱歉,您的邮箱和密码不匹配');
            return redirect()->back();
        }
        return;
    }

    public function destory()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出');
        return redirect()->route('login');
    }


}
