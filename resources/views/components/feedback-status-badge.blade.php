@props([
    'status' => 'menunggu'
])

@php
    $statusConfig = [
        'menunggu' => [
            'label' => 'Menunggu',
            'bg' => 'bg-yellow-100',
            'text' => 'text-yellow-800',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
        ],
        'dibaca' => [
            'label' => 'Dibaca',
            'bg' => 'bg-blue-100',
            'text' => 'text-blue-800',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>',
        ],
        'ditanggapi' => [
            'label' => 'Ditanggapi',
            'bg' => 'bg-green-100',
            'text' => 'text-green-800',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
        ],
    ];
    
    $config = $statusConfig[$status] ?? $statusConfig['menunggu'];
@endphp

<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }}">
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        {!! $config['icon'] !!}
    </svg>
    {{ $config['label'] }}
</span>
