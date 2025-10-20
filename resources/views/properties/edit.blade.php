@extends('components.layouts.app')

@section('content')
<div class="p-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Card Header -->
            <div class="bg-blue-600 text-white p-6">
                <h4 class="text-2xl font-bold">Edit Property</h4>
            </div>

            <!-- Card Body -->
            <div class="p-8">
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-600 rounded">
                        <p class="text-red-700 font-semibold mb-2">Errors:</p>
                        <ul class="list-disc list-inside text-red-600 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('properties.update', $property->property_id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Property Code</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" value="{{ $property->property_code }}" disabled>
                        <small class="text-gray-500">Property code cannot be changed</small>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Developer <span class="text-red-500">*</span></label>
                        <select name="developer_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="">-- Select Developer --</option>
                            @foreach ($developers as $developer)
                                <option value="{{ $developer->developer_id }}" {{ old('developer_id', $property->developer_id) == $developer->developer_id ? 'selected' : '' }}>
                                    {{ $developer->developer_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('developer_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Type <span class="text-red-500">*</span></label>
                        <select name="property_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="Condominium" {{ old('property_type', $property->property_type) == 'Condominium' ? 'selected' : '' }}>Condominium</option>
                            <option value="House" {{ old('property_type', $property->property_type) == 'House' ? 'selected' : '' }}>House</option>
                            <option value="Lot" {{ old('property_type', $property->property_type) == 'Lot' ? 'selected' : '' }}>Lot</option>
                            <option value="Apartment" {{ old('property_type', $property->property_type) == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                            <option value="Townhouse" {{ old('property_type', $property->property_type) == 'Townhouse' ? 'selected' : '' }}>Townhouse</option>
                        </select>
                        @error('property_type')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Title <span class="text-red-500">*</span></label>
                        <input name="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror" value="{{ old('title', $property->title) }}" required>
                        @error('title')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Location <span class="text-red-500">*</span></label>
                        <textarea name="location" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('location') border-red-500 @enderror" rows="2" required>{{ old('location', $property->location) }}</textarea>
                        @error('location')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Description</label>
                        <textarea name="description" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror" rows="3">{{ old('description', $property->description) }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Size (sqm)</label>
                            <input name="size" type="number" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('size') border-red-500 @enderror" value="{{ old('size', $property->size) }}">
                            @error('size')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Price <span class="text-red-500">*</span></label>
                            <input name="price" type="number" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror" value="{{ old('price', $property->price) }}" required>
                            @error('price')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Status <span class="text-red-500">*</span></label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="Available" {{ old('status', $property->status) == 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="Reserved" {{ old('status', $property->status) == 'Reserved' ? 'selected' : '' }}>Reserved</option>
                            <option value="Sold" {{ old('status', $property->status) == 'Sold' ? 'selected' : '' }}>Sold</option>
                        </select>
                        @error('status')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    @if(asset($property->image_url))
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">Current Image</label>
                            <img src="{{ asset($property->image_url) }}" style="max-width: 200px; height: auto;" class="border border-gray-300 rounded-lg mb-3">
                        </div>
                    @endif
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">New Image (leave empty to keep current)</label>
                        <input type="file" name="image" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror" accept="image/*">
                        <small class="text-gray-500">Supported formats: JPG, PNG, WEBP</small>
                        @error('image')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    @if($property->floor_plan)
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">Current Floor Plan</label>
                            <a href="{{ $property->floor_plan }}" target="_blank" class="inline-block px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                                <i class="bi bi-download"></i> View Current Floor Plan
                            </a>
                        </div>
                    @endif
                    
                    <div class="flex gap-3">
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition">
                            <i class="bi bi-check-circle"></i> Update Property
                        </button>
                        <a href="{{ route('properties.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 font-semibold transition">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection