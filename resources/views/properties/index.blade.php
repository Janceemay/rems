@extends('components.layouts.app')

@section('content')

<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-3xl font-bold text-gray-800">Properties</h3>
            
            @auth
                @if(auth()->user()->isRole('Sales Manager') || auth()->user()->isRole('Admin'))
                    <a href="{{ route('properties.create') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition">
                        Add Property
                    </a>
                @endif
            @endauth
        </div>

        @if($properties->count() > 0)
            <!-- Card Grid View -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @foreach($properties as $property)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col">
                        <!-- Image -->
                       <img src="{{ asset($property->image_url) }}"
                            alt="Property Image"
                            class="w-full h-48 object-cover" />
                        
                        <!-- Card Body -->
                        <div class="p-5 flex flex-col flex-grow">
                            <h5 class="text-lg font-bold text-gray-800 mb-2">{{ $property->title }}</h5>
                            
                            <p class="text-xl font-bold text-blue-600 mb-3">₱{{ number_format($property->price, 2) }}</p>
                            
                            <p class="text-sm text-gray-600 mb-2">
                                <i class="bi bi-geo-alt"></i>
                                {{ Str::limit($property->location, 40) }}
                            </p>
                            
                            <p class="text-sm text-gray-500 mb-3">
                                {{ $property->property_type }} • {{ $property->size }} sqm
                            </p>
                            
                            @if($property->description)
                                <p class="text-sm text-gray-600 mb-4 flex-grow">
                                    {{ Str::limit($property->description, 60) }}
                                </p>
                            @endif
                            
                            <!-- Status and Button -->
                            <div class="mt-auto pt-4 border-t border-gray-200">
                                <div class="mb-3">
                                    <span class="inline-block px-3 py-1 rounded-lg text-sm font-semibold text-white
                                        {{ $property->status == 'Available' ? 'bg-green-600' : '' }}
                                        {{ $property->status == 'Reserved' ? 'bg-yellow-500' : '' }}
                                        {{ $property->status == 'Sold' ? 'bg-red-600' : '' }}">
                                        {{ $property->status }}
                                    </span>
                                </div>
                                <a href="{{ route('properties.show', $property->property_id) }}"
                                   class="w-full block text-center px-4 py-2 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 text-sm font-semibold transition">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $properties->links() }}
            </div>
        @else
            <div class="bg-blue-50 border-l-4 border-blue-600 p-4 rounded-lg">
                <p class="text-blue-800">
                    <i class="bi bi-info-circle"></i> No properties available at the moment.
                </p>
            </div>
        @endif
    </div>
</div>

@endsection
```