@extends('components.layouts.app')

@section('content')
<div class="p-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Card Header -->
            <div class="bg-blue-600 text-white p-6">
                <h4 class="text-2xl font-bold">Create New Property</h4>
            </div>

            <!-- Card Body -->
            <div class="p-8">
                <form method="POST" action="{{ route('properties.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Property Code (Auto-generated)</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" value="eg. PROP-1" disabled>
                        <small class="text-gray-500">Will be automatically assigned after creation</small>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Developer <span class="text-red-500">*</span></label>
                        <select name="developer_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="">-- Select Developer --</option>
                            @foreach ($developers as $developer)
                                <option value="{{ $developer->developer_id }}" {{ old('developer_id') == $developer->developer_id ? 'selected' : '' }}>
                                    {{ $developer->developer_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Type <span class="text-red-500">*</span></label>
                        <select name="property_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="">-- Select Type --</option>
                            <option value="Condominium" {{ old('property_type') == 'Condominium' ? 'selected' : '' }}>Condominium</option>
                            <option value="House" {{ old('property_type') == 'House' ? 'selected' : '' }}>House</option>
                            <option value="Lot" {{ old('property_type') == 'Lot' ? 'selected' : '' }}>Lot</option>
                            <option value="Apartment" {{ old('property_type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                            <option value="Townhouse" {{ old('property_type') == 'Townhouse' ? 'selected' : '' }}>Townhouse</option>
                        </select>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Title <span class="text-red-500">*</span></label>
                        <input name="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('title') }}" required placeholder="e.g., Modern 2BR Condo in Makati">
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Location <span class="text-red-500">*</span></label>
                        <textarea name="location" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="2" required placeholder="Full address including city/province">{{ old('location') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Description</label>
                        <textarea name="description" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="4" placeholder="Detailed description of the property...">{{ old('description') }}</textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Size (sqm) <span class="text-red-500">*</span></label>
                            <input name="size" type="number" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('size') }}" required placeholder="e.g., 45.5">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Price <span class="text-red-500">*</span></label>
                            <input name="price" type="number" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('price') }}" required placeholder="e.g., 5000000">
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Property Image <span class="text-red-500">*</span></label>
                        <input type="file" name="image_url" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" accept="image/*" required>
                        <small class="text-gray-500">Supported formats: JPG, PNG, WEBP</small>
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition">
                            <i class="bi bi-plus-circle"></i> Create Property
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