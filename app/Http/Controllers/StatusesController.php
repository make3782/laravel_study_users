<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Status;

class StatusesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * 发表内容
     *
     */
    public function store(Request $request) {

        $this->validate($request, [
            'content' => 'required|max:140'
        ]);
        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);
        session()->flash('success', '微博已成功发布');
        return redirect()->back();
    }


    /**
     * 删除微博
     *
     */
    public function destroy(Status $status) {
        //  中间件权限检查
        $this->authorize('destroy', $status);

        $status->delete();
        session()->flash('success', '微博已被成功删除');
        return redirect()->back();
    }
}
