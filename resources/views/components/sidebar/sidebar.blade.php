@php
$role = strtolower(Auth::user()->role->role_name);
@endphp

<nav class="px-2 space-y-2 mt-4">
    {{-- Agent Navigation --}}
    @if ($role === 'agent')
    <x-sidebar.link route="dashboard.agent" icon="dashboard" label="Dashboard" />
    <x-sidebar.link route="profiles.agent" icon="user" label="Profile" />
    <x-sidebar.link route="properties.index" icon="home" label="Housing" />
    @endif

    {{-- Manager Navigation --}}
    @if ($role === 'sales manager')
    <x-sidebar.link route="dashboard.manager" icon="chart-line" label="Overview" />
    <x-sidebar.link route="team.index" icon="users" label="Team" />
    <x-sidebar.link route="reports.index" icon="file-chart" label="Reports" />
    @endif

    {{-- Admin Navigation --}}
    @if ($role === 'admin')
    <x-sidebar.link route="dashboard.admin" icon="settings" label="Admin Panel" />
    <x-sidebar.link route="users.index" icon="users-alt" label="Users" />
    @endif

    {{-- Common Navigation --}}
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
