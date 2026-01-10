@props([
    'currentStatus' => null,
    'route' => 'orders.index',
])

@php
$filters = [
    null => 'Semua',
    'active' => 'Aktif',
    'selesai' => 'Selesai',
    'batal' => 'Dibatalkan',
];
@endphp

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-4">
        <div class="flex gap-2 flex-wrap">
            @foreach($filters as $status => $label)
                <a href="{{ route($route, $status ? ['status' => $status] : []) }}"
                   class="px-4 py-2 rounded-full text-sm font-medium {{ $currentStatus === $status ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-red-100 hover:text-red-600' }} transition">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
</div>
