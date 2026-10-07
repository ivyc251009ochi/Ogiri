@extends('layouts.app')

@section('content')

<h1>ルーム作成</h1>

<form action="{{ route('rooms.store') }}" method="POST">


@csrf

<p>

ルーム名

</p>

<input
type="text"
name="name"
style="width:100%;padding:10px;">

<br><br>

<button>

作成

</button>

</form>

@endsection