@extends('components.layouts.app')

@section('title', 'Properties')

@section('content')

{{-- Main Content --}}
<main class="flex-1 p-8">
    <div class="max-w-7xl mx-auto space-y-8">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            @auth
            @if(auth()->user()->isRole('Sales Manager') || auth()->user()->isRole('Admin'))
            <a href="{{ route('properties.create') }}" class="bg-blue-600 text-black px-6 py-2 rounded-lg hover:bg-blue-700 font-semibold transition">
                Add Property
            </a>
            @endif
            @endauth
        </div>

        {{-- Property Grid --}}
        @if($properties->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($properties as $property)
            <div class="bg-blue-100 rounded-xl shadow hover:shadow-lg transition flex flex-col overflow-hidden">
                <img src="{{ asset($property->image_url) }}" alt="Property Image" class="w-full h-48 object-cover" />

                <div class="p-5 flex flex-col flex-grow">
                    <h3 class="text-lg font-bold mb-1">{{ $property->title }}</h3>
                    <p class="text-xl font-bold text-blue-600 mb-2">₱{{ number_format($property->price, 2) }}</p>

                    <p class="text-sm text-gray-600 mb-1">
                        <i class="fa-solid fa-location-dot mr-1"></i>
                        {{ Str::limit($property->location, 40) }}
                    </p>

                    <p class="text-sm text-gray-500 mb-2">
                        {{ $property->property_type }} • {{ $property->size }} sqm
                    </p>

                    @if($property->description)
                    <p class="text-sm text-gray-600 mb-4 flex-grow">
                        {{ Str::limit($property->description, 60) }}
                    </p>
                    @endif

                    {{-- Status + Button --}}
                    <div class="mt-auto pt-4 border-t border-gray-300">
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold text-white
                    {{ $property->status == 'Available' ? 'bg-green-600' : '' }}
                    {{ $property->status == 'Reserved' ? 'bg-yellow-500' : '' }}
                    {{ $property->status == 'Sold' ? 'bg-red-600' : '' }}">
                            {{ $property->status }}
                        </span>

                        <a href="{{ route('properties.show', $property->property_id) }}" class="mt-3 block text-center px-4 py-2 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 text-sm font-semibold transition">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="flex justify-center pt-6">
            {{ $properties->links() }}
        </div>
        @else
        <div class="bg-blue-50 border-l-4 border-blue-600 p-4 rounded-lg">
            <p class="text-blue-800">
                <i class="fa-solid fa-circle-info mr-1"></i> No properties available at the moment.
            </p>
        </div>
        @endif

    </div>
</main>
</div>
@endsection
