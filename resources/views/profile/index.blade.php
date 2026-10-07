@extends('layouts.app')

@section('content')

<div class="container">

<h1>マイページ</h1>

<p>

名前：
{{ Auth::user()->name }}

</p>

<p>

メールアドレス：
{{ Auth::user()->email }}

</p>

<a
href="{{ route('profile.edit') }}"
class="btn btn-warning">

プロフィール編集

</a>

</div>

@endsection