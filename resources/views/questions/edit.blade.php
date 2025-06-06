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
                    <form action="{{ route('questions.update', $question->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Savol matni -->
                        <div class="mb-3">
                            <label class="form-label">Savol matni</label>
                            <input type="text" name="question" class="form-control" value="{{ $question->question }}" required>
                        </div>

                        <!-- Rasm -->
                        <div class="mb-3">
                            <label class="form-label">Rasm (ixtiyoriy)</label><br>
                            @if($question->image)
                                <img src="{{ asset('storage/' . $question->image) }}" alt="rasm" width="200" class="mb-2"><br>
                            @endif
                            <input type="file" name="image" class="form-control">
                        </div>

                        <!-- Variantlar -->
                        <div class="row">
                            <div class="col">
                                <input type="text" name="option_a" class="form-control" value="{{ $question->option_a }}" placeholder="A varianti" required>
                            </div>
                            <div class="col">
                                <input type="text" name="option_b" class="form-control" value="{{ $question->option_b }}" placeholder="B varianti" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <input type="text" name="option_c" class="form-control" value="{{ $question->option_c }}" placeholder="C varianti" required>
                            </div>
                            <div class="col">
                                <input type="text" name="option_d" class="form-control" value="{{ $question->option_d }}" placeholder="D varianti" required>
                            </div>
                        </div>

                        <!-- To‘g‘ri javob -->
                        <!-- To‘g‘ri javob -->
                        <!-- To‘g‘ri javob -->
                        <div class="mt-3">
                            <label for="correct_option" class="form-label">To‘g‘ri javob</label>
                            <select name="correct_option" class="form-select" required>
                                <option value="" disabled {{ old('correct_option', $question->correct_option ?? '') == '' ? 'selected' : '' }}>Tanlang</option>
                                <option value="A" {{ old('correct_option', $question->correct_option ?? '') == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('correct_option', $question->correct_option ?? '') == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ old('correct_option', $question->correct_option ?? '') == 'C' ? 'selected' : '' }}>C</option>
                                <option value="D" {{ old('correct_option', $question->correct_option ?? '') == 'D' ? 'selected' : '' }}>D</option>
                            </select>
                        </div>



                        <button type="submit" class="btn btn-success mt-3">Saqlash</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
