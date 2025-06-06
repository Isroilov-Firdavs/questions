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
                    <div class="card">
                        <div class="card-header">
                            <h4>Savol: {{ $question->question }}</h4>
                        </div>
                        <div class="card-body">
                            @if($question->image)
                                <img src="{{ asset('storage/' . $question->image) }}" class="img-fluid mb-3" alt="Savol rasmi">
                            @endif

                            <p><strong>Variant A:</strong> {{ $question->option_a }}</p>
                            <p><strong>Variant B:</strong> {{ $question->option_b }}</p>
                            <p><strong>Variant C:</strong> {{ $question->option_c }}</p>
                            <p><strong>Variant D:</strong> {{ $question->option_d }}</p>
                            <p><strong>To‘g‘ri javob:</strong> {{ $question->correct_option }}</p>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('questions.index') }}" class="btn btn-secondary">Orqaga</a>
                            <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-primary">Tahrirlash</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
