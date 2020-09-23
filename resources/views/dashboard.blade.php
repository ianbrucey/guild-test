<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('How may we help you today?') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg text-center">
                @if (session('success'))
                    <div class="bg-indigo-900 text-center py-4 lg:px-4">
                        <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
                            <span class="flex rounded-full bg-green-500 uppercase px-2 py-1 text-xs font-bold mr-3">Success!</span>
                            <span class="font-semibold mr-2 text-left flex-auto">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                <livewire:dash-welcome />
            </div>
        </div>
    </div>
</x-app-layout>
