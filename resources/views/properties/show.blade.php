@extends('components.layouts.app')

@section('content')
<div class="p-8">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Property Header Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-3">{{ $property->title }}</h2>
                            <span class="inline-block px-4 py-2 rounded-lg font-semibold text-white
                                {{ $property->status == 'available' ? 'bg-green-600' : '' }}
                                {{ $property->status == 'reserved' ? 'bg-yellow-500' : '' }}
                                {{ $property->status == 'sold' ? 'bg-red-600' : '' }}">
                                {{ ucfirst($property->status) }}
                            </span>
                        </div>
                        @auth
                            @if(auth()->user()->isRole('Sales Manager') || auth()->user()->isRole('Admin'))
                                <a href="{{ route('properties.edit', $property->property_id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 font-semibold transition">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            @endif
                        @endauth
                    </div>

                    @if($property->image_url)
                        <img src="{{ $property->image_url }}" 
                             alt="{{ $property->title }}" 
                             class="w-full h-96 object-cover rounded-lg mb-6">
                    @else
                        <img src="{{ asset('default-house.jpg') }}" 
                             alt="Default Property" 
                             class="w-full h-96 object-cover rounded-lg mb-6">
                    @endif

                    @if($property->description)
                        <div>
                            <h5 class="text-xl font-bold text-gray-800 mb-3">Description</h5>
                            <p class="text-gray-600">{{ $property->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

        <!-- Sidebar Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden sticky top-8">
                <div class="p-8">
                    <h3 class="text-3xl font-bold text-blue-600 mb-6">₱{{ number_format($property->price, 2) }}</h3>
                    
                    <div class="mb-6">
                        <h6 class="text-gray-700 font-bold mb-4">Property Details</h6>
                        <ul class="space-y-3 text-sm text-gray-700">
                            @if($property->property_code)
                                <li class="flex justify-between">
                                    <strong>Code:</strong> 
                                    <span>{{ $property->property_code }}</span>
                                </li>
                            @endif
                            <li class="flex justify-between">
                                <strong>Type:</strong> 
                                <span>{{ $property->property_type }}</span>
                            </li>
                            <li class="flex justify-between">
                                <strong>Size:</strong> 
                                <span>{{ $property->size }} sqm</span>
                            </li>
                            <li>
                                <strong class="block mb-1">Location:</strong>
                                <span class="text-gray-600">{{ $property->location }}</span>
                            </li>
                        </ul>
                    </div>

                    <hr class="my-4">

                    @auth
                        @if(auth()->user()->isRole('Client') || auth()->user()->isRole('Agent'))
                            @if($property->status == 'available')
                                <a href="{{ route('transactions.create', ['property_id' => $property->property_id]) }}" 
                                   class="w-full block text-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition mb-3">
                                    <i class="bi bi-cart-plus"></i> Inquire About This Property
                                </a>
                            @else
                                <button class="w-full px-4 py-3 bg-gray-400 text-white rounded-lg cursor-not-allowed mb-3" disabled>
                                    Property Not Available
                                </button>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="w-full block text-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition mb-3">
                            <i class="bi bi-box-arrow-in-right"></i> Login to Inquire
                        </a>
                    @endauth

                    <a href="{{ route('properties.index') }}" class="w-full block text-center px-4 py-3 border-2 border-gray-400 text-gray-600 rounded-lg hover:bg-gray-50 font-semibold transition">
                        <i class="bi bi-arrow-left"></i> Back to Properties
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection