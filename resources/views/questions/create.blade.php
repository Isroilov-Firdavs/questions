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
                    <form action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Savol matni</label>
                            <textarea name="question" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Rasm (ixtiyoriy)</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        @foreach(['a','b','c','d'] as $opt)
                        <div class="mb-3">
                            <label>Variant {{ strtoupper($opt) }}</label>
                            <input type="text" name="option_{{ $opt }}" class="form-control" required>
                        </div>
                        @endforeach
                        <div class="mb-3">
                            <label>To‘g‘ri javob</label>
                            <select name="correct_option" class="form-control" required>
                                <option value="">Tanlang</option>
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                                <option value="d">D</option>
                            </select>
                        </div>
                        <button class="btn btn-primary">Saqlash</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
