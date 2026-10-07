@extends('layouts.app')

@section('content')

<div class="container">

<h1>通報一覧</h1>

<table class="table table-bordered">

<thead>

<tr>

<th>ID</th>
<th>通報者</th>
<th>対象ユーザー</th>
<th>理由</th>
<th>状態</th>

</tr>

</thead>

<tbody>

@forelse($reports as $report)

<tr>

<td>{{ $report->id }}</td>

<td>{{ $report->reporter->name }}</td>

<td>{{ $report->reportedUser->name }}</td>

<td>{{ $report->reason }}</td>

<td>{{ $report->status }}</td>

</tr>

@empty

<tr>

<td colspan="5">

通報はありません。

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@endsection