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
                    <h1>Test Natijasi</h1>
                        <p><strong>Foydalanuvchi:</strong> {{ $testSession->user->name }}</p>
                        <p><strong>Natija:</strong> {{ $correctCount }} / {{ $answers->count() }} to‘g‘ri javob</p>
                        <p><strong>Test yakunlangan vaqti:</strong> {{ $testSession->finished_at->format('d-m-Y H:i:s') }}</p>

                        <hr>

                        <h3>Javoblar tafsiloti:</h3>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Savol</th>
                                    <th>Foydalanuvchi javobi</th>
                                    <th>To‘g‘ri javob</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($answers as $answer)
                                <tr>
                                    <td>{{ $answer->question->question }}</td>
                                    <td>{{ $answer->selected_option }}</td>
                                    <td>{{ strtoupper($answer->question->correct_option) }}</td>
                                    <td>
                                        @if($answer->is_correct)
                                            <span class="text-success">To‘g‘ri</span>
                                        @else
                                            <span class="text-danger">Noto‘g‘ri</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
