@props(['status'])

@php
$statusConfig = [
    'menunggu' => [
        'bg' => 'bg-yellow-100',
        'text' => 'text-yellow-800',
        'label' => 'Menunggu Konfirmasi',
        'icon' => 'clock',
    ],
    'diproses' => [
        'bg' => 'bg-blue-100',
        'text' => 'text-blue-800',
        'label' => 'Sedang Diproses',
        'icon' => 'clock',
    ],
    'selesai' => [
        'bg' => 'bg-green-100',
        'text' => 'text-green-800',
        'label' => 'Selesai',
        'icon' => 'check',
    ],
    'batal' => [
        'bg' => 'bg-red-100',
        'text' => 'text-red-800',
        'label' => 'Dibatalkan',
        'icon' => 'x-mark',
    ],
];

$config = $statusConfig[$status] ?? $statusConfig['menunggu'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$config['bg']} {$config['text']}"]) }}>
    @if($config['icon'] === 'clock')
        <x-icons.clock class="w-3 h-3 mr-1" />
    @elseif($config['icon'] === 'check')
        <x-icons.check class="w-3 h-3 mr-1" />
    @elseif($config['icon'] === 'x-mark')
        <x-icons.x-mark class="w-3 h-3 mr-1" />
    @endif
    {{ $config['label'] }}
</span>
