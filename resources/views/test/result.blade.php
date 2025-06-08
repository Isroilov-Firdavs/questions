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
                        <h2>Test natijalari</h2>
                        <p>Test boshlanish vaqti: {{ $session->started_at }}</p>
                        <p>Test tugash vaqti: {{ $session->finished_at }}</p>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Savol</th>
                                    <th>Tanlangan javob</th>
                                    <th>To'g'ri javob</th>
                                    <th>Natija</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($answers as $answer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $answer->question->question }}</td>
                                    <td @if(!$answer->is_correct) style="color:red;" @else style="color:green;" @endif>
                                        {{ strtoupper($answer->selected_option) }}: {{ $answer->question->{'option_' . $answer->selected_option} }}
                                    </td>
                                    <td style="color:green;">
                                        {{ strtoupper($answer->question->correct_option) }}: {{ $answer->question->{'option_' . $answer->question->correct_option} }}
                                    </td>
                                    <td>
                                        @if($answer->is_correct)
                                            <span class="text-success">To'g'ri</span>
                                        @else
                                            <span class="text-danger">Noto'g'ri</span>
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
    </div>
</x-app-layout>
