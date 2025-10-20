@extends('components.layouts.app')

@section('content')
<div class="p-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Card Header -->
            <div class="bg-blue-600 text-white p-6">
                <h4 class="text-2xl font-bold">
                    {{ isset($isClient) && $isClient ? 'Inquire About Property' : 'Create Transaction' }}
                </h4>
            </div>

            <!-- Card Body -->
            <div class="p-8">
                <form method="POST" action="{{ route('transactions.store') }}">
                    @csrf

                    @if(isset($isClient) && $isClient)
                        <!-- CLIENT INQUIRY FORM -->
                        
                        <!-- Property Summary -->
                        <div class="mb-8 pb-6 border-b-2 border-gray-200">
                            <h5 class="text-2xl font-bold text-gray-800 mb-2">{{ $property->title }}</h5>
                            <p class="text-3xl font-bold text-blue-600 mb-3">₱{{ number_format($property->price, 2) }}</p>
                            <div class="space-y-2 text-gray-600">
                                <p><strong>Type:</strong> {{ $property->property_type }}</p>
                                <p><strong>Size:</strong> {{ $property->size }} sqm</p>
                                <p><strong>Location:</strong> {{ $property->location }}</p>
                                @if($property->description)
                                    <p><strong>Description:</strong> {{ $property->description }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Your Information -->
                        <div class="mb-8">
                            <h6 class="text-lg font-bold text-gray-800 mb-4">Your Information</h6>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-2 text-gray-700">
                                <p><strong>Name:</strong> {{ $client->user->full_name ?? 'N/A' }}</p>
                                <p><strong>Email:</strong> {{ $client->user->email ?? 'N/A' }}</p>
                                <p><strong>Phone:</strong> {{ $client->phone ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <input type="hidden" name="property_id" value="{{ $property->property_id }}">
                        
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">Additional Message (optional)</label>
                            <textarea name="inquiry_details" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Tell us more about your interest in this property or any questions you have...">{{ old('inquiry_details') }}</textarea>
                            @error('inquiry_details')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex gap-3">
                            <button type="submit" class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition">
                                <i class="bi bi-check-circle"></i> Submit Inquiry
                            </button>
                            <a href="{{ route('properties.show', $property->property_id) }}" class="px-8 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 font-semibold transition">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>

                    @else
                        <!-- STAFF TRANSACTION FORM -->
                        
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">Client <span class="text-red-500">*</span></label>
                            <select name="client_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                <option value="">-- Select Client --</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->client_id }}" {{ old('client_id') == $client->client_id ? 'selected' : '' }}>
                                        {{ $client->user->full_name }} ({{ $client->user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">Property <span class="text-red-500">*</span></label>
                            <select name="property_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                <option value="">-- Select Property --</option>
                                @foreach ($properties as $prop)
                                    <option value="{{ $prop->property_id }}" {{ old('property_id') == $prop->property_id ? 'selected' : '' }}>
                                        {{ $prop->title }} - ₱{{ number_format($prop->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('property_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">Agent (optional)</label>
                            <input type="text" name="agent_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('agent_name') }}" placeholder="Assign an agent to this transaction">
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition">
                                <i class="bi bi-plus-circle"></i> Create Transaction
                            </button>
                            <a href="{{ route('transactions.index') }}" class="px-8 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 font-semibold transition">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mt-6 p-4 bg-red-50 border-l-4 border-red-600 rounded">
                            <p class="text-red-700 font-semibold mb-2">Error:</p>
                            <ul class="list-disc list-inside text-red-600 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection