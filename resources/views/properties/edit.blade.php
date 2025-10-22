@extends('components.layouts.app')

@section('content')
<div class="p-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-3xl border-2 border-gray-300 shadow-sm overflow-hidden">

            {{-- Card Header --}}
            <div class="bg-[#2a47ff] text-white p-6 rounded-t-3xl">
                <h4 class="text-2xl font-bold">Edit Property</h4>
            </div>

            {{-- Card Body --}}
            <div class="p-8">
                @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-600 rounded-xl">
                    <p class="text-red-700 font-semibold mb-2">Please fix the following:</p>
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

                    {{-- Property Code --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Property Code</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-gray-100 cursor-not-allowed" value="{{ $property->property_code }}" disabled>
                        <small class="text-gray-500">Property code cannot be changed</small>
                    </div>

                    {{-- Developer --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Developer <span class="text-red-500">*</span></label>
                        <select name="developer_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2a47ff] focus:border-transparent" required>
                            <option value="">-- Select Developer --</option>
                            @foreach ($developers as $developer)
                            <option value="{{ $developer->developer_id }}" {{ old('developer_id', $property->developer_id) == $developer->developer_id ? 'selected' : '' }}>
                                {{ $developer->developer_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('developer_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Type --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Type <span class="text-red-500">*</span></label>
                        <select name="property_type" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2a47ff] focus:border-transparent" required>
                            @foreach(['Condominium','House','Lot','Apartment','Townhouse'] as $type)
                            <option value="{{ $type }}" {{ old('property_type', $property->property_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('property_type') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Title --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Title <span class="text-red-500">*</span></label>
                        <input name="title" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2a47ff] focus:border-transparent @error('title') border-red-500 @enderror" value="{{ old('title', $property->title) }}" required>
                        @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Location --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Location <span class="text-red-500">*</span></label>
                        <textarea name="location" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2a47ff] focus:border-transparent @error('location') border-red-500 @enderror" rows="2" required>{{ old('location', $property->location) }}</textarea>
                        @error('location') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Description</label>
                        <textarea name="description" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2a47ff] focus:border-transparent @error('description') border-red-500 @enderror" rows="3">{{ old('description', $property->description) }}</textarea>
                        @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Size & Price --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Size (sqm)</label>
                            <input name="size" type="number" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2a47ff] focus:border-transparent @error('size') border-red-500 @enderror" value="{{ old('size', $property->size) }}">
                            @error('size') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Price <span class="text-red-500">*</span></label>
                            <input name="price" type="number" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2a47ff] focus:border-transparent @error('price') border-red-500 @enderror" value="{{ old('price', $property->price) }}" required>
                            @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Status <span class="text-red-500">*</span></label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2a47ff] focus:border-transparent" required>
                            @foreach(['Available','Reserved','Sold'] as $status)
                            <option value="{{ $status }}" {{ old('status', $property->status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Current Image --}}
                    @if($property->image_url)
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Current Image</label>
                        <img src="{{ asset($property->image_url) }}" class="border border-gray-300 rounded-xl max-w-xs mb-3">
                    </div>
                    @endif

                    {{-- New Image --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">New Image (optional)</label>
                        <input type="file" name="image" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2a47ff] focus:border-transparent @error('image') border-red-500 @enderror" accept="image/*">
                        <small class="text-gray-500">Supported formats: JPG, PNG, WEBP</small>
                        @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Floor Plan --}}
                    @if($property->floor_plan)
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Current Floor Plan</label>
                        <a href="{{ $property->floor_plan }}" target="_blank" class="inline-block px-4 py-2 bg-gray-500 text-white rounded-full hover:bg-gray-600 transition">
                            <i class="bi bi-download"></i> View Current Floor Plan
                        </a>
                    </div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex gap-4 pt-2">
                        <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-full hover:bg-green-700 font-semibold transition">
                            <i class="bi bi-check-circle"></i> Update Property
                        </button>
                        <a href="{{ route('properties.index') }}" class="px-6 py-3 bg-gray-500 text-white rounded-full hover:bg-gray-600 font-semibold transition">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
