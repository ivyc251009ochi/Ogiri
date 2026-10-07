@extends('layouts.app')

@section('content')

<h1>人気ランキング</h1>

@foreach($topics as $topic)

<div class="topic-card">

<h2>

{{ $loop->iteration }}位

{{ $topic->title }}

</h2>

<p>

回答数

{{ $topic->answers_count }}

件

</p>

</div>

@endforeach

@endsection