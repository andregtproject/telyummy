<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Riwayat Pesanan') }}
            </h2>
            <a href="{{ route('seller.orders.incoming') }}"
               class="text-sm text-gray-500 hover:text-red-600 transition">
                ← Pesanan Masuk
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Stats Summary --}}
            @php
                $selesaiCount = $orders->where('status', 'selesai')->count();
                $batalCount = $orders->where('status', 'batal')->count();
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                            <x-icons.check class="w-5 h-5 text-green-600" />
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-green-700">{{ $selesaiCount }}</p>
                            <p class="text-sm text-green-600">Pesanan Selesai</p>
                        </div>
                    </div>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                            <x-icons.x-mark class="w-5 h-5 text-red-600" />
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-red-700">{{ $batalCount }}</p>
                            <p class="text-sm text-red-600">Pesanan Dibatalkan</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Orders List --}}
            @if($orders->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pelanggan
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Items
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900">#{{ $order->id }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            @foreach($order->orderItems->take(2) as $item)
                                                <span class="block">{{ $item->quantity }}x {{ $item->menuItem->name ?? 'N/A' }}</span>
                                            @endforeach
                                            @if($order->orderItems->count() > 2)
                                                <span class="text-gray-500">+{{ $order->orderItems->count() - 2 }} lainnya</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-bold text-gray-900">{{ $order->formatted_total_price }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-order-status-badge :status="$order->status" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $order->created_at->format('d M Y') }}
                                        <span class="block text-xs">{{ $order->created_at->format('H:i') }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('seller.orders.show', $order) }}"
                                           class="text-red-600 hover:text-red-900">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <x-order-empty-state
                        icon="clock"
                        title="Belum ada riwayat pesanan"
                        description="Pesanan yang telah selesai atau dibatalkan akan muncul di sini."
                    />
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
