@php
    $isActive = Route::has($route) && request()->routeIs($route);
@endphp

<a href="{{ Route::has($route) ? route($route) : '#' }}"
   class="flex items-center gap-3 rounded-xl transition group hover:bg-sky-300/50">
    <div class="p-3">
        @if ($isActive)
            <i class="fi fi-sr-{{ $icon }} text-2xl text-[#2a47ff]"></i>
        @else
            <i class="fi fi-br-{{ $icon }} text-2xl text-[#2a47ff] group-hover:text-[#2a47ff]/50"></i>
        @endif
    </div>
    <span x-show="!collapsed" class="font-medium text-md text-[#2a47ff] group-hover:text-[#2a47ff]/50 pr-3">
        {{ $label }}
    </span>
</a>
