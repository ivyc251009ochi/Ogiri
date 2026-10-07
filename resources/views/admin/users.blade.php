@extends('layouts.app')

@section('content')

<div class="container">

<h1>ユーザー管理</h1>

<table class="table table-bordered">

<thead>

<tr>

<th>ID</th>

<th>名前</th>

<th>メール</th>

<th>状態</th>

<th>操作</th>

</tr>

</thead>

<tbody>

@foreach($users as $user)

<tr>

<td>{{ $user->id }}</td>

<td>{{ $user->name }}</td>

<td>{{ $user->email }}</td>

<td>{{ $user->status }}</td>

<td>

@if($user->status == 'active')

<form action="{{ route('admin.suspend',$user->id) }}" method="POST">

@csrf

<button class="btn btn-danger btn-sm">

利用停止

</button>

</form>

@else

<form action="{{ route('admin.activate',$user->id) }}" method="POST">

@csrf

<button class="btn btn-success btn-sm">

停止解除

</button>

</form>

@endif

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection