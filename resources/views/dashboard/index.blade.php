@extends('layouts.app')

@section('content')
<h2>Dashboard</h2>
<div class="row">
    <div class="col-md-4"><div class="card"><div class="card-body"><h5>Total Properties</h5><p>{{ $totalProperties }}</p></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body"><h5>Available</h5><p>{{ $available }}</p></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body"><h5>Sold</h5><p>{{ $sold }}</p></div></div></div>
</div>

<h4 class="mt-4">Recent Transactions</h4>
<table class="table">
    <thead><tr><th>ID</th><th>Client</th><th>Property</th><th>Agent</th><th>Status</th></tr></thead>
    <tbody>
        @foreach($recentTransactions as $t)
            <tr>
                <td>{{ $t->transaction_id }}</td>
                <td>{{ $t->client->user->full_name }}</td>
                <td>{{ $t->property->title ?? $t->property->property_code }}</td>
                <td>{{ $t->agent->full_name }}</td>
                <td>{{ $t->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
ss