@extends('backend.app')

@section('title', 'Create Lyrics')

@section('content')

    <div class="page-header">
        <div>
            <h1 class="page-title">Lyrics Create for: {{ $song->title }}</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('lyrics.update', $song->id) }}" id="lyrics-form">
        @csrf
        <input type="hidden" name="song_id" value="{{ $song->id }}">

        <div id="lyrics-wrapper"></div>

        <div class="d-flex justify-content-between mt-4 mb-5">
            <button type="button" id="add-lyrics" class="btn btn-info text-white">
                <i class="fa fa-plus-circle"></i> Add Lyrics
            </button>

            <button type="submit" class="btn btn-success" id="submitBtn">
                <i class="fa fa-save"></i> Save Lyrics
            </button>
        </div>
    </form>

    {{-- -------------------- DATA SOURCE -------------------- --}}
    <script>
        const existingLyrics = @json(old('lyrics') ?? $lyrics);
    </script>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* Hide Hour in Flatpickr */
        .flatpickr-calendar.noCalendar .numInputWrapper:nth-child(1),
        .flatpickr-calendar.noCalendar .flatpickr-time-separator:nth-child(2) {
            display: none !important;
        }
        .flatpickr-calendar.noCalendar {
            width: 120px !important;
        }

        /* Targeted Input Responsiveness for Mobile */
        @media (max-width: 575.98px) {
            .form-control {
                font-size: 14px !important; /* Slightly smaller for more text visibility */
                padding: 0.5rem 0.75rem;
                height: auto;
            }
            .lyrics-card label {
                font-size: 0.8rem;
                font-weight: 500;
                margin-bottom: 0.2rem;
            }
            .mb-2 {
                margin-bottom: 0.5rem !important;
            }
            .page-title {
                font-size: 1.1rem;
            }
            .card-body {
                padding: 0.8rem !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Helper functions
        function formatTime(seconds) {
            if (seconds === null || seconds === undefined || seconds === '') return '';
            const sec = parseFloat(seconds);
            if (isNaN(sec)) return '';
            const m = Math.floor(sec / 60);
            const s = Math.floor(sec % 60);
            return (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
        }

        function parseTime(timeStr) {
            if (!timeStr) return 0;
            // Handle both MM:SS and seconds
            if (timeStr.includes(':')) {
                const parts = timeStr.split(':');
                if (parts.length === 2) {
                    return (parseInt(parts[0], 10) * 60) + parseInt(parts[1], 10);
                } else if (parts.length === 3) {
                    // In case flatpickr returns H:M:S
                    return (parseInt(parts[0], 10) * 3600) + (parseInt(parts[1], 10) * 60) + parseInt(parts[2], 10);
                }
            }
            return parseFloat(timeStr) || 0;
        }

        function initTimePicker(element) {
            $(element).find('.timepicker').flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "i:S", // i for minutes (00-59), S for seconds (00-59)
                time_24hr: true,
                enableSeconds: true,
                onChange: function() {
                    window.dispatchEvent(new Event('time-changed'));
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {

            const wrapper = document.getElementById('lyrics-wrapper');
            const addBtn  = document.getElementById('add-lyrics');
            const submitBtn = document.getElementById('submitBtn');

            let count = 0;

            function addLyrics(data = {}) {
                const index = count++;

                const html = `
        <div class="card mb-4 lyrics-card" id="lyrics-${index}">
            <div class="card-header d-flex justify-content-between">
                <h5><span class="number">${index + 1}.</span> Lyrics</h5>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeLyrics(${index})">
                    Remove
                </button>
            </div>

            <div class="card-body">
                <input type="hidden" name="lyrics[${index}][id]" value="${data.id ?? ''}">

                <div class="mb-2">
                    <label>Lyrics Translation</label>
                    <input type="text"
                        name="lyrics[${index}][eng_lang]"
                        value="${data.eng_lang ?? ''}"
                        class="form-control" placeholder="Enter english language title"
                        required>
                </div>

                <div class="mb-2">
                    <label>Active Lyrics</label>
                    <input type="text"
                        name="lyrics[${index}][other_lang]"
                        value="${data.other_lang ?? ''}"
                        class="form-control" placeholder="Enter other language title"
                        required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label>Start Time (MM:SS)</label>
                        <input type="text"
                            name="lyrics[${index}][start_time]"
                            value="${formatTime(data.start_time)}"
                            class="form-control start-time timepicker" placeholder="00:00"
                            required>
                        <small class="text-danger error-start"></small>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label>End Time (MM:SS)</label>
                        <input type="text"
                            name="lyrics[${index}][end_time]"
                            value="${formatTime(data.end_time)}"
                            class="form-control end-time timepicker" placeholder="00:00"
                            required>
                        <small class="text-danger error-end"></small>
                    </div>
                </div>
            </div>
        </div>`;

                wrapper.insertAdjacentHTML('beforeend', html);

                // Init timepicker for the new element
                const newCard = document.getElementById(`lyrics-${index}`);
                initTimePicker(newCard);

                validateAll();
            }

            window.removeLyrics = function (index) {
                const card = document.getElementById(`lyrics-${index}`);
                if (wrapper.children.length > 1) {
                    card.remove();
                    updateNumbers();
                    validateAll();
                } else {
                    alert('At least one lyrics is required.');
                }
            }

            function updateNumbers() {
                document.querySelectorAll('.lyrics-card').forEach((card, i) => {
                    card.querySelector('.number').textContent = (i + 1) + '.';
                });
            }

            // ---------------- VALIDATION ----------------

            function validateAll() {
                let valid = true;
                let prevEnd = null;

                document.querySelectorAll('.lyrics-card').forEach(card => {
                    const startInput = card.querySelector('.start-time');
                    const endInput   = card.querySelector('.end-time');
                    const errStart   = card.querySelector('.error-start');
                    const errEnd     = card.querySelector('.error-end');

                    errStart.textContent = '';
                    errEnd.textContent   = '';

                    const start = parseTime(startInput.value);
                    const end   = parseTime(endInput.value);

                    if (startInput.value && endInput.value) {
                        if (start >= end) {
                            errEnd.textContent = 'End time must be greater than start time';
                            valid = false;
                        }
                    }

                    if (prevEnd !== null && start < prevEnd) {
                        errStart.textContent = 'Start time must be ≥ ' + formatTime(prevEnd);
                        valid = false;
                    }

                    if (endInput.value) prevEnd = end;
                });

                submitBtn.disabled = !valid;
            }

            // Watch for input changes
            document.addEventListener('input', function (e) {
                if (e.target.classList.contains('timepicker')) {
                    validateAll();
                }
            });
            window.addEventListener('time-changed', validateAll);

            document.getElementById('lyrics-form').addEventListener('submit', function (e) {
                validateAll();
                if (submitBtn.disabled) {
                    e.preventDefault();
                    toastr.error('Fix time errors before submit.');
                    return;
                }

                // Convert visuals back to seconds for backend
                document.querySelectorAll('.lyrics-card').forEach(card => {
                    const si = card.querySelector('.start-time');
                    const ei = card.querySelector('.end-time');
                    si.value = parseTime(si.value);
                    ei.value = parseTime(ei.value);
                });
            });

            // -------------- INIT ----------------

            if (existingLyrics.length > 0) {
                existingLyrics.forEach(l => addLyrics(l));
            } else {
                addLyrics();
            }

            addBtn.addEventListener('click', () => addLyrics());

        });
    </script>
@endpush
