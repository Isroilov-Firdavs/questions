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
                        <h2>Testni yeching (1 soat davomida)</h2>

                        <div id="timer" style="font-size: 24px; font-weight: bold; margin-bottom: 20px;">60:00</div>

                        <form id="testForm" method="POST" action="{{ route('test.submit') }}">
                            @foreach($questions as $index => $question)
                                <div class="card mb-3 p-3 question-block" data-question-id="{{ $question->id }}">
                                    <p><strong>{{ $index + 1 }}. {{ $question->question }}</strong></p>

                                    @if($question->image)
                                        <img src="{{ asset('storage/' . $question->image) }}" alt="Savol rasmi" style="max-width: 300px; margin-bottom: 10px;">
                                    @endif

                                    @php
                                        $options = ['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d];
                                    @endphp

                                    @foreach($options as $key => $value)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="answer_{{ $question->id }}"
                                                id="q{{ $question->id }}_{{ $key }}"
                                                value="{{ $key }}"
                                                data-correct="{{ $question->correct_option }}"
                                                onchange="submitAnswer(this)" >
                                            <label class="form-check-label" for="q{{ $question->id }}_{{ $key }}">
                                                {{ $key }}. {{ $value }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                            <!-- Yuborish tugmasi shu yerda -->
                            {{-- <button type="button" id="submitTestBtn" class="btn btn-primary mt-3">Yuborish</button> --}}
                        </form>
                        <style>
                            .correct {
                                background-color: #d4edda !important; /* yashil */
                            }
                            .wrong {
                                background-color: #f8d7da !important; /* qizil */
                            }
                        </style>
                        <script>
                            let totalTime = 3600;
                            const timerEl = document.getElementById('timer');

                            let interval = setInterval(() => {
                                if (totalTime <= 0) {
                                    clearInterval(interval);
                                    disableAll();
                                    alert('Vaqt tugadi! Test tugadi.');
                                    return;
                                }
                                totalTime--;

                                let minutes = Math.floor(totalTime / 60);
                                let seconds = totalTime % 60;

                                timerEl.textContent = `${minutes.toString().padStart(2,'0')}:${seconds.toString().padStart(2,'0')}`;
                            }, 1000);

                            function disableAll() {
                                document.querySelectorAll('input[type=radio]').forEach(radio => radio.disabled = true);
                            }

                            function submitAnswer(el) {
                                let questionId = el.name.replace('answer_', '');
                                let selectedOption = el.value;

                                fetch("{{ route('test.answer') }}", {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        question_id: questionId,
                                        selected_option: selectedOption
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        let questionBlock = el.closest('.question-block');
                                        let radios = questionBlock.querySelectorAll('input[type=radio]');

                                        radios.forEach(radio => {
                                            radio.disabled = true;
                                            if (radio.value === data.correct_option.toUpperCase()) {
                                                radio.parentElement.classList.add('correct');
                                            }
                                        });

                                        if (!data.is_correct) {
                                            el.parentElement.classList.add('wrong');
                                        }
                                    } else {
                                        alert('Javob saqlanmadi.');
                                    }
                                })
                                .catch(() => alert('Server bilan bog‘lanishda xatolik yuz berdi'));
                            }
                        </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
