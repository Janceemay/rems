@extends('components.layouts.app')

@section('content')
<h3>Create Property</h3>
<form method="POST" action="{{ route('properties.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>Property Code (optional)</label>
        <input name="property_code" class="form-control">
    </div>
    <div class="mb-3">
        <label>Type</label>
        <select name="property_type" class="form-control">
            <option>Condominium</option>
            <option>House</option>
            <option>Lot</option>
            <option>Apartment</option>
            <option>Townhouse</option>
        </select>
    </div>
    <div class="mb-3"><label>Title</label><input name="title" class="form-control"></div>
    <div class="mb-3"><label>Location</label><textarea name="location" class="form-control"></textarea></div>
    <div class="mb-3"><label>Size (sqm)</label><input name="size" class="form-control"></div>
    <div class="mb-3"><label>Price</label><input name="price" class="form-control"></div>
    <div class="mb-3"><label>Image</label><input type="file" name="image" class="form-control"></div>
    <div class="mb-3"><label>Floor plan (pdf/jpg/png)</label><input type="file" name="floor_plan" class="form-control"></div>
    <button class="btn btn-success">Create</button>
</form>
@endsection
