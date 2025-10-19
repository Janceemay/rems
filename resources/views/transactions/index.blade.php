@extends('components.layouts.app')

@section('content')
<div class="d-flex justify-content-between">
    <h3>Transactions</h3>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary">New Transaction</a>
</div>

<table class="table mt-3">
    <thead><tr><th>ID</th><th>Client</th><th>Property</th><th>Agent</th><th>Status</th><th></th></tr></thead>
    <tbody>
        @foreach($transactions as $t)
            <tr>
                <td>{{ $t->transaction_id }}</td>
                <td>{{ $t->client->user->full_name }}</td>
                <td>{{ $t->property->title ?? $t->property->property_code }}</td>
                <td>{{ $t->agent->full_name }}</td>
                <td>{{ $t->status }}</td>
                <td><a href="{{ route('transactions.show',$t->transaction_id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $transactions->links() }}
@endsection
