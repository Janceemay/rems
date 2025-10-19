@extends('components.layouts.app')

@section('content')
<div class="row justify-content-end">
    <div class="col-md-6">
        <h3>Register</h3>
        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="mb-3"><label>Full name</label><input name="full_name" class="form-control" required></div>
            <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
            <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
            <div class="mb-3"><label>Confirm Password</label><input type="password" name="password_confirmation" class="form-control" required></div>
            <div class="mb-3"><label>Role</label>
                <select name="role_id" class="form-control">
                    @foreach($roles as $role)
                        <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-success">Register</button>
        </form>
    </div>
</div>
@endsection
