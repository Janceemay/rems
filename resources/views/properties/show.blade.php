@extends('components.layouts.app')

@section('content')
<h3>{{ $property->title ?? $property->property_code }}</h3>
<p>Type: {{ $property->property_type }}</p>
<p>Location: {{ $property->location }}</p>
<p>Size: {{ $property->size }}</p>
<p>Price: {{ $property->price }}</p>
<p>Status: {{ $property->status }}</p>
@if($property->image_url)
    <img src="{{ $property->image_url }}" style="max-width:300px;">
@endif
@if($property->floor_plan)
    <p><a href="{{ $property->floor_plan }}" class="btn btn-sm btn-outline-secondary">Download Floor Plan</a></p>
@endif
@endsection
