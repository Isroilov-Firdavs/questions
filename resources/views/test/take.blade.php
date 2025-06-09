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
                        <h2 class="mb-6 text-2xl font-bold">Testni yeching</h2>
                        <form id="test-form">
                            @csrf
                            <input type="hidden" id="session_id" value="{{ $session->id }}">
                            {{-- <input type="text" id="session_id" value="{{ $session->id }}"> --}}

                            @foreach($questions as $q)
                            <div class="question mb-6 p-4 border rounded" data-question-id="{{ $q->id }}">
                                <p class="mb-2"><strong>{{ $loop->iteration }}. {{ $q->question }}</strong></p>
                                @if($q->image)
                                <img src="{{ asset('storage/' . $q->image) }}" alt="question image" style="max-width:200px; margin-bottom: 10px;">
                                @endif
                                <div class="options space-y-2">
                                    @foreach(['a', 'b', 'c', 'd'] as $opt)
                                    @php
                                        $optionText = $q->{'option_' . $opt};
                                    @endphp
                                    <div>
                                        <input type="radio"
                                               name="question_{{ $q->id }}"
                                               id="q{{ $q->id }}_{{ $opt }}"
                                               value="{{ $opt }}">
                                        <label for="q{{ $q->id }}_{{ $opt }}">{{ strtoupper($opt) }}: {{ $optionText }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach

                            <button type="button" id="finish-test" class="btn btn-success px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">
                                Testni yakunlash
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .question {
            border: 1px solid #e2e8f0; /* Gray border */
            border-radius: 0.375rem; /* Rounded corners */
            padding: 1rem; /* Padding inside the question box */
            margin-bottom: 1.5rem; /* Space between questions */
        }
        .options input[type="radio"] {
            margin-right: 0.5rem; /* Space between radio button and label */
        }
        .options label {
            cursor: pointer; /* Change cursor to pointer for labels */
        }
        .options label:hover {
            color: #2b6cb0; /* Change color on hover */
        }
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            font-weight: 600;
            text-align: center;
            color: #fff;
            background-color: #4a5568; /* Gray background */
            border-radius: 0.375rem; /* Rounded corners */
            transition: background-color 0.2s ease-in-out;
        }
        .btn:hover {
            background-color: #2d3748; /* Darker gray on hover */
        }
    </style>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            const sessionId = $('#session_id').val();
            const token = $('input[name="_token"]').val();
            const answerUrl = `{{ url('dashboard/test') }}/${sessionId}/answer`;
            const finishUrl = `{{ url('dashboard/test') }}/${sessionId}/finish`;

            // Har bir radio uchun listener
            $('input[type=radio]').on('change', function() {
                const questionDiv = $(this).closest('.question');
                const questionId = questionDiv.data('question-id');
                const selectedOption = $(this).val();

                $.ajax({
                    url: answerUrl,
                    method: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    data: JSON.stringify({
                        question_id: questionId,
                        selected_option: selectedOption,
                    }),
                    success: function(data) {
                        if (data.success) {
                            // Disable barcha radio buttonlar
                            questionDiv.find('input[type=radio]').prop('disabled', true);

                            // To'g'ri va noto'g'ri variantlarni ranglash
                            const correctOpt = data.correct_option;
                            questionDiv.find('input[type=radio]').each(function() {
                                const label = questionDiv.find(`label[for="${$(this).attr('id')}"]`);
                                if ($(this).val() === correctOpt) {
                                    label.css({'color': 'green', 'font-weight': 'bold'});
                                }
                                if ($(this).is(':checked') && !data.is_correct) {
                                    label.css({'color': 'red', 'font-weight': 'bold'});
                                }
                            });
                        } else {
                            alert('Javob saqlashda xatolik yuz berdi');
                        }
                    },
                    error: function() {
                        alert('Javob saqlashda xatolik yuz berdi');
                    }
                });
            });

            $('#finish-test').on('click', function() {
                $.ajax({
                    url: finishUrl,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    success: function(res) {
                        if (res.redirect_url) {
                            window.location.href = res.redirect_url;
                        } else {
                            alert('Testni yakunlashda xatolik yuz berdi');
                        }
                    },
                    error: function() {
                        alert('Testni yakunlashda xatolik yuz berdi');
                    }
                });
            });

        });
    </script>


</x-app-layout>
