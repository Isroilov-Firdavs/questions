<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Savollar ro‘yxati') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Savollar</h4>
                        <a href="{{ route('questions.create') }}" class="btn btn-success">+ Yangi savol</a>
                    </div>

                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Savol matni</th>
                                <th>Javoblar (A, B, C, D)</th>
                                <th>Amallar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($questions as $index => $q)
                                <tr>
                                    <td>{{ $questions->firstItem() + $index }}</td>
                                    <td>{{ Str::limit($q->question, 80) }}</td>
                                    <td>
                                        @php
                                            // Har bir javobni tekshirish va to'g'ri javobni rang bilan ajratish
                                            $options = ['A' => $q->option_a, 'B' => $q->option_b, 'C' => $q->option_c, 'D' => $q->option_d];
                                        @endphp

                                        <ul class="list-unstyled mb-0">
                                            @foreach ($options as $key => $answer)
                                                <li>
                                                    <span class="fw-bold">{{ $key }}.</span>
                                                    <span @class([
                                                        'text-success' => $key === strtoupper($q->correct_option),
                                                        'text-dark' => $key !== strtoupper($q->correct_option)
                                                    ])>
                                                        {{ $answer }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <a href="{{ route('questions.show', $q->id) }}" class="btn btn-sm btn-info">Ko‘rish</a>
                                        <a href="{{ route('questions.edit', $q->id) }}" class="btn btn-sm btn-warning">Tahrirlash</a>
                                        <form action="{{ route('questions.destroy', $q->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Ishonchingiz komilmi?')" class="btn btn-sm btn-danger">
                                                O‘chirish
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Hech qanday savol topilmadi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
