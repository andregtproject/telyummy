<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Filter Tabs --}}
            @include('orders.partials.filter-tabs', [
                'currentStatus' => request('status'),
                'route' => 'orders.index'
            ])

            {{-- Orders List --}}
            @if($orders->count() > 0)
                <div class="space-y-4">
                    @foreach($orders as $order)
                        @include('orders.partials.order-card', ['order' => $order])
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <x-order-empty-state
                        icon="cart"
                        :title="__('Belum Ada Pesanan')"
                        :description="request('status') 
                            ? __('Tidak ada pesanan dengan status ini.') 
                            : __('Kamu belum memiliki pesanan. Yuk pesan sekarang!')"
                        :actionUrl="route('dashboard')"
                        :actionLabel="__('Lihat Kantin')"
                    />
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
