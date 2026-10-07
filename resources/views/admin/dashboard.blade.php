@extends('layouts.app')

@section('content')

<div class="container">

    <h1>管理者ダッシュボード</h1>

    <div class="row">

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>ユーザー数</h5>
                    <h2>{{ $userCount }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>お題数</h5>
                    <h2>{{ $topicCount }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>回答数</h5>
                    <h2>{{ $answerCount }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>通報数</h5>
                    <h2>{{ $reportCount }}</h2>
                </div>
            </div>
        </div>

    </div>

    <hr>

    <a href="{{ route('admin.users') }}" class="btn btn-primary">
        ユーザー管理
    </a>

    <a href="{{ route('admin.reports') }}" class="btn btn-danger">
        通報一覧
    </a>

</div>

@endsection