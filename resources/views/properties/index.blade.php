@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between">
    <h3>Properties</h3>
    @if(auth()->user()->isRole('Sales Manager') || auth()->user()->isRole('Admin'))
        <a href="{{ route('properties.create') }}" class="btn btn-primary">Add Property</a>
    @endif
</div>

<table class="table mt-3">
    <thead><tr><th>Code</th><th>Title</th><th>Type</th><th>Location</th><th>Price</th><th>Status</th><th></th></tr></thead>
    <tbody>
        @foreach($properties as $p)
            <tr>
                <td>{{ $p->property_code }}</td>
                <td>{{ $p->title }}</td>
                <td>{{ $p->property_type }}</td>
                <td>{{ $p->location }}</td>
                <td>{{ $p->price }}</td>
                <td>{{ $p->status }}</td>
                <td><a href="{{ route('properties.show',$p->property_id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $properties->links() }}
@endsection
