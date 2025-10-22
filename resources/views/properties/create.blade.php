@extends('components.layouts.app')

@section('content')
<div class="p-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-3xl border-2 border-gray-300 shadow-sm overflow-hidden">

            {{-- Card Header --}}
            <div class="bg-[#2a47ff] text-white p-6 rounded-t-3xl">
                <h4 class="text-2xl font-bold">Create New Property</h4>
            </div>

            {{-- Card Body --}}
            <div class="p-8">
                <form method="POST" action="{{ route('properties.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Property Code --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Property Code (Auto-generated)</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-gray-100 cursor-not-allowed" value="eg. PROP-1" disabled>
                        <small class="text-gray-500">Will be automatically assigned after creation</small>
                    </div>

                    {{-- Developer --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Developer <span class="text-red-500">*</span></label>
                        <select name="developer_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2a47ff] focus:border-transparent" required>
                            <option value="">-- Select Developer --</option>
                            @foreach ($developers as $developer)
                                <option value="{{ $developer->developer_id }}" {{ old('developer_id') == $developer->developer_id ? 'selected' : '' }}>
                                    {{ $developer->developer_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Type --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Type <span class="text-red-500">*</span></label>
                        <select name="property_type" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2a47ff] focus:border-transparent" required>
                            <option value="">-- Select Type --</option>
                            @foreach(['Condominium','House','Lot','Apartment','Townhouse'] as $type)
                                <option value="{{ $type }}" {{ old('property_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Title --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Title <span class="text-red-500">*</span></label>
                        <input name="title" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2a47ff] focus:border-transparent" value="{{ old('title') }}" required placeholder="e.g., Modern 2BR Condo in Makati">
                    </div>

                    {{-- Location --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Location <span class="text-red-500">*</span></label>
                        <textarea name="location" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2a47ff] focus:border-transparent" rows="2" required placeholder="Full address including city/province">{{ old('location') }}</textarea>
                    </div>

                    {{-- Description --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Description</label>
                        <textarea name="description" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2a47ff] focus:border-transparent" rows="4" placeholder="Detailed description of the property...">{{ old('description') }}</textarea>
                    </div>

                    {{-- Size & Price --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Size (sqm) <span class="text-red-500">*</span></label>
                            <input name="size" type="number" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2a47ff] focus:border-transparent" value="{{ old('size') }}" required placeholder="e.g., 45.5">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Price <span class="text-red-500">*</span></label>
                            <input name="price" type="number" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2a47ff] focus:border-transparent" value="{{ old('price') }}" required placeholder="e.g., 5000000">
                        </div>
                    </div>

                    {{-- Image --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Property Image <span class="text-red-500">*</span></label>
                        <input type="file" name="image_url" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2a47ff] focus:border-transparent" accept="image/*" required>
                        <small class="text-gray-500">Supported formats: JPG, PNG, WEBP</small>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-4 pt-2">
                        <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-full hover:bg-green-700 font-semibold transition">
                            <i class="bi bi-plus-circle"></i> Create Property
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