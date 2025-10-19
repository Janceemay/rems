@extends('components.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header text-white text-center py-4 bg-gradient-custom">
                        <h4 class="mb-0">
                            <i class="fas fa-user-plus me-2"></i>CREATE NEW AGENT
                        </h4>
                    </div>

                    <div class="card-body p-4">
                        {{-- Display success or error messages --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <strong>Please fix the following errors:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        {{-- Form --}}
                        <form action="{{ route('agents.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf

                            <input type="hidden" name="manager_id" value="{{ Auth::user()->user_id }}">
                            <input type="hidden" name="role_id" value="{{ $role->role_id ?? 2 }}">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="full_name" class="form-control" id="full_name" value="{{ old('full_name') }}" placeholder="Full Name" required>
                                        <label for="full_name"><i class="fas fa-user me-1"></i>Full Name</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="Email" required>
                                        <label for="email"><i class="fas fa-envelope me-1"></i>Email</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="contact_number" class="form-control" id="contact_number" value="{{ old('contact_number') }}" placeholder="Contact Number">
                                        <label for="contact_number"><i class="fas fa-phone me-1"></i>Contact Number</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select name="gender" class="form-select" id="gender">
                                            <option value="">Select</option>
                                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        <label for="gender"><i class="fas fa-venus-mars me-1"></i>Gender</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="number" name="age" class="form-control" id="age" min="18" max="65" value="{{ old('age') }}" placeholder="Age">
                                        <label for="age"><i class="fas fa-birthday-cake me-1"></i>Age</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('dashboard.manager') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Create Agent
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- INLINE STYLE FIXES --}}
<style>
    body {
        background-color: #a7c5fc !important;
    }
    .bg-gradient-custom {
        background: linear-gradient(135deg, #163576ff 0%, #6fa9ff 100%) !important;
    }
    .card {
        background-color: #ffffff !important;
        border-radius: 1rem;
        border: none;
        transition: all 0.2s ease-in-out;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
    }
    .form-floating label {
        color: #4a4a4a;
    }
    .btn-primary {
        background-color: #4a73c9 !important;
        border: none !important;
    }
    .btn-primary:hover {
        background-color: #3b63b2 !important;
    }
    .btn-outline-secondary {
        border-color: #6b7b8c !important;
        color: #6b7b8c !important;
    }
    .btn-outline-secondary:hover {
        background-color: #6b7b8c !important;
        color: #fff !important;
    }
</style>

{{-- INLINE SCRIPT FIX --}}
<script>
    (function () {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
@endsection
