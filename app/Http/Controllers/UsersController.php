<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        // 加入中间件:除了新建相关,其他如编辑等需要有登录态
        $this->middleware('auth', ['except' => ['show', 'create', 'store', 'index', 'confirmEmail']]);
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
        $this->sendEmail($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收');
        return redirect('/');
    }

    protected function sendEmail(User $user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'aufree@yousails.com';
        $name = 'wzx-测试';
        $to = $user->email;
        $subject = "感谢注册 Sample 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
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

    /**
     * 用户邮件激活请求
     *
     * @param string $token 邮件激活token
     *
     */
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '您已成功激活邮件');
        return redirect()->route('users.show', $user->id);
    }
}
