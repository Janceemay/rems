@php
    use Illuminate\Support\Facades\Route;

    $role = strtolower(Auth::user()->role->role_name);
@endphp

<nav class="px-2 space-y-2 mt-4">
    {{-- Shared Navigation --}}
    <x-sidebar.link route="home" icon="home" label="Home" />
    <x-sidebar.link route="dashboard" icon="dashboard" label="Dashboard" />
    <x-sidebar.link route="properties.index" icon="apartment" label="Properties" />
    <x-sidebar.link route="profile" icon="user" label="Profile" />

    {{-- Agent Navigation --}}
    @if ($role === 'agent')
        {{-- Add more agent-specific links here --}}
    @endif

    {{-- Sales Manager Navigation --}}
    @if ($role === 'sales manager')
        <x-sidebar.link route="team.index" icon="users" label="Team" />
        <x-sidebar.link route="reports.index" icon="file-chart" label="Reports" />
    @endif

    {{-- Admin Navigation --}}
    @if ($role === 'admin')
        <x-sidebar.link route="users.index" icon="users-alt" label="Users" />
    @endif

    {{-- Logout --}}
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="flex items-center gap-3 rounded-xl transition group hover:bg-sky-300/50 w-full text-left mt-4">
            <div class="p-3">
                <i class="fi fi-br-exit text-2xl text-[#2a47ff] group-hover:text-[#2a47ff]/50"></i>
            </div>
            <span x-show="!collapsed" class="font-medium text-md text-[#2a47ff] group-hover:text-[#2a47ff]/50 pr-3">
                Logout
            </span>
        </button>
    </form>
</nav>
