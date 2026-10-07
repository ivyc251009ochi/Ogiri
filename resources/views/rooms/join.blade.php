@extends('layouts.app')

@section('content')

<div class="container">

<h1>ルーム参加</h1>

<form action="{{ route('rooms.join') }}" method="POST">

@csrf

<div class="mb-3">

<label>参加コード</label>

<input
type="text"
name="room_code"
class="form-control">

</div>

<button class="btn btn-primary">

参加

</button>

</form>

</div>

@endsection