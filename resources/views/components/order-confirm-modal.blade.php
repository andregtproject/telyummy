@props([
    'name' => 'confirm',
    'title' => 'Konfirmasi',
    'message' => 'Apakah Anda yakin?',
    'confirmLabel' => 'Ya',
    'cancelLabel' => 'Batal',
    'confirmColor' => 'red', // red, green, blue
    'action' => null,
    'method' => 'POST',
])

@php
$colorClasses = [
    'red' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
    'green' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500',
    'blue' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
];
$buttonClass = $colorClasses[$confirmColor] ?? $colorClasses['red'];
@endphp

<div
    x-data="{ open: false }"
    x-on:open-modal-{{ $name }}.window="open = true"
    x-on:close-modal-{{ $name }}.window="open = false"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
>
    {{-- Backdrop --}}
    <div 
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        @click="open = false"
    ></div>

    {{-- Modal Panel --}}
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
        >
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-{{ $confirmColor }}-100 sm:mx-0 sm:h-10 sm:w-10">
                        @if($confirmColor === 'red')
                            <x-icons.x-mark class="h-6 w-6 text-red-600" />
                        @elseif($confirmColor === 'green')
                            <x-icons.check class="h-6 w-6 text-green-600" />
                        @else
                            <x-icons.clock class="h-6 w-6 text-blue-600" />
                        @endif
                    </div>
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
                            {{ $title }}
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                {{ $message }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                @if($action)
                    <form action="{{ $action }}" method="POST" class="inline">
                        @csrf
                        @if($method !== 'POST')
                            @method($method)
                        @endif
                        <button
                            type="submit"
                            class="inline-flex w-full justify-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:w-auto {{ $buttonClass }}"
                        >
                            {{ $confirmLabel }}
                        </button>
                    </form>
                @else
                    <button
                        type="button"
                        x-on:click="$dispatch('confirm-{{ $name }}')"
                        class="inline-flex w-full justify-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:w-auto {{ $buttonClass }}"
                    >
                        {{ $confirmLabel }}
                    </button>
                @endif
                <button
                    type="button"
                    @click="open = false"
                    class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                >
                    {{ $cancelLabel }}
                </button>
            </div>
        </div>
    </div>
</div>
