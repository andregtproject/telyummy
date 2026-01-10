<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Dashboard Kantin') }}
        </h2>
    </x-slot>

    {{-- Load Library Chart --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    {{-- Informasi Kantin & Toggle Buka/Tutup --}}
    @include('dashboards.partials.canteen-info')

    {{-- Card Statistik (Pendapatan, Order, Rating) --}}
    @include('dashboards.partials.stats-cards')

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        {{-- Antrian Pesanan --}}
        @include('dashboards.partials.orders-queue')

        {{-- Grafik Analitik Penjualan --}}
        @include('dashboards.partials.sales-chart')
    </div>

    {{-- Scripts Javascript --}}
    @include('dashboards.partials.scripts')

</x-app-layout>