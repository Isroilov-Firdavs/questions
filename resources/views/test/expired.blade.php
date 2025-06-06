<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container mt-5">
                        <h2>Test vaqti tugadi!</h2>
                        <p>Test uchun ajratilgan vaqt tugadi, endi javoblarni kiritish mumkin emas.</p>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Bosh sahifaga qaytish</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
