<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        // 加入中间件:除了新建相关,其他如编辑等需要有登录态
        $this->middleware('auth', ['except' => ['show', 'create', 'store', 'index']]);
        $this->middleware('guest', ['only' => ['create']]);
    }

    /**
     * 用户列表页显示
     *
     */
    public function index()
    {
        // $users = User::all();
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }
    //创建用户页面显示
    public function create ()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * 创建用户操作
     * @param Request $request 请求的数据
     *
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:10',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success', '欢迎,您将在这里开启一段新的历程');
        return redirect()->route('users.show', compact('user'));
    }

    /**
     * 编辑用户信息页面显示
     */
    public function edit(User $user)
    {
        $this->authorize('checkIsSelf', $user);
        return view('users.edit', compact('user'));
    }

    /**
     * 资料编辑提交
     *
     */
    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100|min:1',
            'password' => 'nullable|confirmed|max:10|min:6',
        ]);
        $this->authorize('checkIsSelf', $user);
        $data = [];
        $data['name'] = $request->name;

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功');
        return redirect()->route('users.show', $user->id);
    }

    /**
     * 删除用户操作
     *
     */
    public function destroy(User $user) {
        $this->authorize('checkIsAdmin', $user);
        $user->delete();
        session()->flash('success', '已成功删除用户,用户ID:' . $user->id);
        return back();
    }

}
