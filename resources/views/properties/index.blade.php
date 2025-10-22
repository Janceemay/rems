@extends('components.layouts.app')

@section('title', 'Properties')

@section('content')

{{-- Main Content --}}
<main class="flex-1 p-8">
    <div class="max-w-7xl mx-auto space-y-8">

        {{-- Header Actions --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            @auth
            @if(auth()->user()->isRole('Sales Manager') || auth()->user()->isRole('Admin'))
            <a href="{{ route('properties.create') }}" class="bg-[#2a47ff] text-white px-6 py-3 rounded-full font-semibold hover:bg-[#2a47ff]/80 transition">
                + Add Property
            </a>
            @endif
            @endauth
        </div>

        {{-- Property Grid --}}
        @if($properties->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($properties as $property)
            <div class="bg-white rounded-3xl border-2 border-gray-300 shadow-sm hover:shadow-md transition flex flex-col overflow-hidden">
                <img src="{{ asset($property->image_url) }}" alt="Property Image" class="w-full h-48 object-cover border-b border-gray-300" />

                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-bold text-[#2a47ff] mb-1">{{ $property->title }}</h3>
                    <p class="text-2xl font-bold text-gray-800 mb-2">₱{{ number_format($property->price, 2) }}</p>

                    <p class="text-sm text-gray-600 mb-1">
                        <i class="fa-solid fa-location-dot mr-1 text-[#2a47ff]"></i>
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

                        <a href="{{ route('properties.show', $property->property_id) }}"
                           class="mt-3 block text-center px-4 py-2 border-2 border-[#2a47ff] text-[#2a47ff] rounded-full hover:bg-[#2a47ff]/10 text-sm font-semibold transition">
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
        <div class="bg-white border-2 border-gray-300 p-6 rounded-3xl text-center">
            <p class="text-gray-600 text-lg">
                <i class="fa-solid fa-circle-info mr-2 text-[#2a47ff]"></i>
                No properties available at the moment.
            </p>
        </div>
        @endif

    </div>
</main>
@endsection
