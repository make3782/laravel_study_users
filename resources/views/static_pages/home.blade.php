@extends('layouts.default')

@section('title', '首页')
@section('content')
	@if (Auth::check())
		<div class="row">
			<div class="col-md-8">
				<section class="status_form">
					@include('shared._status_form')
				</section>
				<h3>微博列表</h3>
				@include('shared._feed')
			</div>
			<aside class="col-md-4">
				<section class="user_info">
					@include('shared._user_info', ['user' => Auth::user()])
				</section>
			</aside>
		</div>
	@else
		<div class="jumbotron">
			<H1>Hello Laravel</h1>
			<P class="lead">
				你现在所看到的是 <a href="https://laravel-china.org/courses/laravel-essential-training-5.1">Laravel 入门教程</a> 的示例项目主页。
			</P>
			<P>
				一切，将从这里开始。
			</P>
			<P>
				<A class="btn btn-lg btn-success" href="#" role="button">现在注册</a>
			</P>
		</Div>
	@endif
@stop
