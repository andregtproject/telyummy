@props(['status'])

@php
$statusConfig = [
    'menunggu' => [
        'bg' => 'bg-yellow-50',
        'border' => 'border-yellow-200',
        'icon_bg' => 'bg-yellow-100',
        'icon_color' => 'text-yellow-600',
        'title' => 'Menunggu Konfirmasi',
        'description' => 'Pesanan kamu sedang menunggu konfirmasi dari penjual.',
        'icon' => 'clock',
        'animate' => false,
    ],
    'diproses' => [
        'bg' => 'bg-blue-50',
        'border' => 'border-blue-200',
        'icon_bg' => 'bg-blue-100',
        'icon_color' => 'text-blue-600',
        'title' => 'Sedang Diproses',
        'description' => 'Pesanan kamu sedang diproses oleh penjual. Silakan tunggu.',
        'icon' => 'spinner',
        'animate' => true,
    ],
    'selesai' => [
        'bg' => 'bg-green-50',
        'border' => 'border-green-200',
        'icon_bg' => 'bg-green-100',
        'icon_color' => 'text-green-600',
        'title' => 'Pesanan Selesai',
        'description' => 'Pesanan telah selesai. Terima kasih telah berbelanja!',
        'icon' => 'check',
        'animate' => false,
    ],
    'batal' => [
        'bg' => 'bg-red-50',
        'border' => 'border-red-200',
        'icon_bg' => 'bg-red-100',
        'icon_color' => 'text-red-600',
        'title' => 'Pesanan Dibatalkan',
        'description' => 'Pesanan ini telah dibatalkan.',
        'icon' => 'x-mark',
        'animate' => false,
    ],
];
$config = $statusConfig[$status] ?? $statusConfig['menunggu'];
@endphp

<div class="{{ $config['bg'] }} {{ $config['border'] }} border rounded-lg p-4 mb-6">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-full {{ $config['icon_bg'] }} flex items-center justify-center flex-shrink-0">
            @if($config['icon'] === 'spinner')
                <svg class="w-6 h-6 {{ $config['icon_color'] }} animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            @elseif($config['icon'] === 'clock')
                <x-icons.clock class="w-6 h-6 {{ $config['icon_color'] }}" />
            @elseif($config['icon'] === 'check')
                <x-icons.check class="w-6 h-6 {{ $config['icon_color'] }}" />
            @elseif($config['icon'] === 'x-mark')
                <x-icons.x-mark class="w-6 h-6 {{ $config['icon_color'] }}" />
            @endif
        </div>
        <div class="flex-1">
            <p class="font-semibold {{ $config['icon_color'] }}">{{ $config['title'] }}</p>
            <p class="text-sm opacity-80 {{ $config['icon_color'] }}">{{ $config['description'] }}</p>
        </div>
    </div>
</div>
