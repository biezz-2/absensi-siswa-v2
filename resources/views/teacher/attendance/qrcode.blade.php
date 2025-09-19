<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scan QR Code for Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center">
                    <h3 class="text-lg font-semibold mb-4">Scan this QR Code to mark your attendance</h3>
                    <div class="flex justify-center">
                        <img src="{{ $qrCode }}" alt="Attendance QR Code">
                    </div>
                    <p class="mt-4 text-gray-600">This QR code is valid for 5 minutes.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
