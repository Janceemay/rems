<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>REMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
  <div class="container">
    <a class="navbar-brand" href="{{ route('dashboard') }}">REMS</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
            @auth
            <li class="nav-item"><a class="nav-link" href="{{ route('properties.index') }}">Properties</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('transactions.index') }}">Transactions</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('payments.index') }}">Payments</a></li>
            @endauth
        </ul>
        <ul class="navbar-nav">
            @auth
                <li class="nav-item"><span class="nav-link">{{ auth()->user()->full_name }}</span></li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-link nav-link">Logout</button>
                    </form>
                </li>
            @endauth
            @guest
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
            @endguest
        </ul>
    </div>
  </div>
</nav>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @yield('content')
</div>

</body>
</html>
