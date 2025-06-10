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
                        <h1 class="mb-4">Foydalanuvchilarning test natijalari</h1>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Foydalanuvchi</th>
                                    <th>Boshlanish</th>
                                    <th>Tugash</th>
                                    <th>To‘g‘ri javoblar</th>
                                    <th>Jami savollar</th>
                                    <th>Foiz (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($results as $result)
                                    <tr>
                                        <td>{{ $result->id ?? 'No name' }}</td>
                                        <td>{{ $result->user->name ?? 'No name' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($result->started_at)->timezone('Asia/Tashkent')->format('d.m.Y H:i:s') ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($result->finished_at)->timezone('Asia/Tashkent')->format('d.m.Y H:i:s') ?? 'Test yakunlanmagan' }}</td>
                                        <td>{{ $result->correct_answers_count }}</td>
                                        <td>{{ $result->total_answers_count }}</td>
                                        <td>
                                            @if($result->total_answers_count > 0)
                                                {{ round(($result->correct_answers_count / $result->total_answers_count) * 100, 2) }}%
                                            @else
                                                0%
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6">Natijalar topilmadi</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $results->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
