@props(['route', 'icon', 'label'])

@php
    $isActive = request()->routeIs($route) || request()->routeIs(str_replace('.index', '.*', $route));
@endphp

<a href="{{ route($route) }}"
   class="flex items-center px-4 py-2.5 rounded-lg transition duration-200
          hover:bg-gray-700 hover:text-white
          {{ $isActive ? 'bg-blue-600 text-white' : '' }}">
    <i class="{{ $icon }} w-6 mr-2"></i>
    <span>{{ $label }}</span>
</a>
