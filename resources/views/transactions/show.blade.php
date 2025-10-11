@extends('layouts.app')

@section('content')
<h3>Transaction #{{ $transaction->transaction_id }}</h3>
<p>Client: {{ $transaction->client->user->full_name }}</p>
<p>Property: {{ $transaction->property->title }}</p>
<p>Agent: {{ $transaction->agent->full_name }}</p>
<p>Status: {{ $transaction->status }}</p>

@if(auth()->user()->isRole('Sales Manager') && $transaction->status !== 'Approved')
    <form method="POST" action="{{ route('transactions.approve',$transaction->transaction_id) }}">
        @csrf
        <button class="btn btn-success">Approve</button>
    </form>
@endif

@if((auth()->user()->isRole('Agent') || auth()->user()->isRole('Sales Manager')) && $transaction->status !== 'Cancelled')
    <form method="POST" action="{{ route('transactions.cancel',$transaction->transaction_id) }}" class="mt-2">
        @csrf
        <div class="mb-2"><input name="reason" class="form-control" placeholder="Cancellation reason" required></div>
        <button class="btn btn-danger">Cancel</button>
    </form>
@endif

<h4 class="mt-4">Payments</h4>
<table class="table">
    <thead><tr><th>Due Date</th><th>Amount Due</th><th>Amount Paid</th><th>Status</th></tr></thead>
    <tbody>
        @foreach($transaction->payments as $p)
            <tr>
                <td>{{ $p->due_date }}</td>
                <td>{{ $p->amount_due }}</td>
                <td>{{ $p->amount_paid }}</td>
                <td>{{ $p->payment_status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
