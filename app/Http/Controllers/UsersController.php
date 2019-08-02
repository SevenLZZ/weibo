<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UsersController extends Controller
{
    public function create(){

    	return view('users.create');
    }

	/**
	*
	Laravel 会自动解析定义在控制器方法（变量名匹配路由片段）中的 Eloquent 模型类型声明。在上面代码中，由于 show() 方法传参时声明了类型 —— Eloquent 模型 User，对应的变量名 $user 会匹配路由片段中的 {user}，这样，Laravel 会自动注入与请求 URI 中传入的 ID 对应的用户模型实例。

	此功能称为 『隐性路由模型绑定』，是『约定优于配置』设计范式的体现，同时满足以下两种情况，此功能即会自动启用：

	**/
    //users/1 满足条件，直接查找id为1的数据
 	public function show(User $user)
    {

        return view('users.show', compact('user'));
    }

     public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        
        $user = User::create([
        	'name'=>$request->name,
        	'email'=>$request->email,
        	'password'=>bcrypt($request->password)
        ]);
        Auth::login($user);          
		session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show',$user);	

    }
}
