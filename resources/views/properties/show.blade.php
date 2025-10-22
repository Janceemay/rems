@extends('components.layouts.app')

@section('content')
<div class="p-8" x-data="{ showAgentModal: false }">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Property Header Card --}}
            <div class="bg-white rounded-3xl border-2 border-gray-300 shadow-sm overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-3">{{ $property->title }}</h2>
                            <span class="inline-block px-4 py-2 rounded-full font-semibold text-white
                                {{ $property->status == 'available' ? 'bg-green-600' : '' }}
                                {{ $property->status == 'reserved' ? 'bg-yellow-500' : '' }}
                                {{ $property->status == 'sold' ? 'bg-red-600' : '' }}">
                                {{ ucfirst($property->status) }}
                            </span>
                        </div>
                        @auth
                        @if(auth()->user()->isRole('Sales Manager') || auth()->user()->isRole('Admin'))
                        <a href="{{ route('properties.edit', $property->property_id) }}" class="px-6 py-2 bg-yellow-500 text-white rounded-full hover:bg-yellow-600 font-semibold transition">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        @endif
                        @endauth
                    </div>

                    <img src="{{ $property->image_url }}" alt="{{ $property->title }}" class="w-full h-96 object-cover rounded-xl border border-gray-300 mb-6">

                    @if($property->description)
                    <div>
                        <h5 class="text-xl font-bold text-gray-800 mb-3">Description</h5>
                        <p class="text-gray-600 leading-relaxed">{{ $property->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl border-2 border-gray-300 shadow-sm sticky top-8 overflow-hidden">
                <div class="p-8">
                    <h3 class="text-3xl font-bold text-[#2a47ff] mb-6">₱{{ number_format($property->price, 2) }}</h3>

                    <div class="mb-6">
                        <h6 class="text-gray-700 font-bold mb-4">Property Details</h6>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex justify-between"><strong>Code:</strong><span>{{ $property->property_code }}</span></li>
                            <li class="flex justify-between"><strong>Type:</strong><span>{{ $property->property_type }}</span></li>
                            <li class="flex justify-between"><strong>Size:</strong><span>{{ $property->size }} sqm</span></li>
                            <li><strong class="block mb-1">Location:</strong><span class="text-gray-600">{{ $property->location }}</span></li>
                        </ul>
                    </div>

                    <hr class="my-4">

                    {{-- Inquiry Button --}}
                    @auth
                    @if(auth()->user()->isRole('Client') || auth()->user()->isRole('Agent'))
                    @if($property->isAvailable())
                    <a href="{{ route('transactions.create', ['property_id' => $property->property_id]) }}" class="w-full block text-center px-4 py-3 bg-[#2a47ff] text-white rounded-full hover:bg-[#2a47ff]/80 font-semibold transition mb-3">
                        <i class="bi bi-cart-plus"></i> Inquire About This Property
                    </a>
                    @else
                    <button class="w-full px-4 py-3 bg-gray-400 text-white rounded-full cursor-not-allowed mb-3" disabled>
                        Property Not Available
                    </button>
                    @endif
                    @endif
                    @else
                    <a href="{{ route('login') }}" class="w-full block text-center px-4 py-3 bg-[#2a47ff] text-white rounded-full hover:bg-[#2a47ff]/80 font-semibold transition mb-3">
                        <i class="bi bi-box-arrow-in-right"></i> Login to Inquire
                    </a>
                    @endauth

                    {{-- Manage Agents Button --}}
                    @if(auth()->user()->isRole('Sales Manager'))
                    <button @click="showAgentModal = true" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition mb-3">
                        <i class="bi bi-person-lines-fill mr-2"></i> Manage Agents
                    </button>
                    @endif

                    {{-- Assigned Agents List --}}
                    @if($property->assignedAgents->count())
                    <div class="mt-6">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Assigned Agents</h4>
                        <ul class="space-y-1 text-sm text-gray-600">
                            @foreach($property->assignedAgents as $agent)
                            <li>• {{ $agent->full_name }} ({{ $agent->email }})</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- Back Link --}}
                    <a href="{{ route('properties.index') }}" class="w-full block text-center px-4 py-3 border-2 border-gray-400 text-gray-600 rounded-full hover:bg-gray-50 font-semibold transition mt-6">
                        <i class="bi bi-arrow-left"></i> Back to Properties
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Agent Modal --}}
    <div x-show="showAgentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away="showAgentModal = false" class="bg-white rounded-xl shadow-lg w-full max-w-xl p-6 space-y-6">

            <h2 class="text-xl font-bold text-gray-800">Manage Assigned Agents</h2>

            {{-- Add Agent --}}
            <form method="POST" action="{{ route('properties.assignAgent', $property->property_id) }}" class="space-y-4">
                @csrf
                <label for="agent_id" class="block text-sm font-medium text-gray-700">Add Agent</label>
                <select name="agent_id" id="agent_id" class="w-full px-4 py-2 border rounded-lg">
                    @foreach($agents as $agent)
                    @if(!$property->assignedAgents->contains('user_id', $agent->user_id))
                    <option value="{{ $agent->user_id }}">{{ $agent->full_name }}</option>
                    @endif
                    @endforeach
                </select>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Add Agent
                </button>
            </form>

            {{-- Remove Agent --}}
            <div class="space-y-2">
                <h4 class="text-sm font-semibold text-gray-700">Remove Assigned Agent</h4>
                @foreach($property->assignedAgents as $agent)
                <form method="POST" action="{{ route('properties.removeAgent', [$property->property_id, $agent->user_id]) }}" class="flex items-center justify-between">
                    @csrf @method('DELETE')
                    <span class="text-sm text-gray-600">{{ $agent->full_name }}</span>
                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Remove</button>
                </form>
                @endforeach
            </div>

            <div class="pt-4">
                <button @click="showAgentModal = false" class="w-full bg-gray-300 text-gray-800 py-2 rounded-lg hover:bg-gray-400">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
