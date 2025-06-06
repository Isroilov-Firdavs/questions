<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Question') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('questions.create') }}" class="btn btn-success mb-3">+ Yangi savol</a>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Savol</th>
                                    <th>To‘g‘ri javob</th>
                                    <th>Amallar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $q)
                                <tr>
                                    <td>{{ Str::limit($q->question, 50) }}</td>
                                    <td>{{ strtoupper($q->correct_option) }}</td>
                                    <td>
                                        <a href="{{ route('questions.edit', $q->id) }}" class="btn btn-warning btn-sm">Tahrirlash</a>
                                        <a href="{{ route('questions.show', $q->id) }}" class="btn btn-info btn-sm">Ko'rish</a>
                                        <form action="{{ route('questions.destroy', $q->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button onclick="return confirm('Ishonchingiz komilmi?')" class="btn btn-danger btn-sm">O‘chirish</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $questions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
