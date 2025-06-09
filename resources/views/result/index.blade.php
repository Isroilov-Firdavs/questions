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
                    <div class="container">
                        @if(session('info'))
                            <div class="alert alert-info">{{ session('info') }}</div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <form action="{{ route('test.start') }}" method="GET">
                            <button type="submit" class="btn btn-primary">Testni boshlash</button>
                        </form>
                        <h2>Mening test natijalarim</h2>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Test ID</th>
                                    <th>Boshlanish vaqti</th>
                                    <th>Tugash vaqti</th>
                                    <th>To'g'ri javoblar soni</th>
                                    <th>Jami savollar</th>
                                    <th>Foiz</th> <!-- Yangi ustun -->
                                    <th>Natijani ko'rish</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sessions as $session)
                                @php
                                    $totalQuestions = $session->userAnswers()->count();
                                    $correctAnswers = $session->correct_count ?? 0;
                                    $percentage = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;
                                @endphp
                                <tr>
                                    <td>{{ $session->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($session->started_at)->timezone('Asia/Tashkent')->format('d.m.Y H:i:s') }}</td>
                                    <td>
                                        {{ $session->finished_at
                                            ? \Carbon\Carbon::parse($session->finished_at)->timezone('Asia/Tashkent')->format('d.m.Y H:i:s')
                                            : 'Test yakunlanmagan' }}
                                    </td>
                                    <td>{{ $correctAnswers }}</td>
                                    <td>{{ $totalQuestions }}</td>
                                    <td>{{ $percentage }}%</td> <!-- Foiz chiqarish -->
                                    <td>
                                        <a href="{{ route('test.result', $session->id) }}" class="btn btn-primary btn-sm">Ko'rish</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
