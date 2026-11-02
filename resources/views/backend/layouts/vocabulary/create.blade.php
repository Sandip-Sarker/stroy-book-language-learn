@extends('backend.app')

@section('title', 'Create Vocabulary')

@section('content')

    <div class="page-header">
        <div>
            <h1 class="page-title">Vocabulary Create for: {{ $song->title }}</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('vocabulary.create.update', $song->id) }}" id="vocabulary-form">
        @csrf
        <input type="hidden" name="song_id" value="{{ $song->id }}">

        <div id="vocabulary-wrapper"></div>

        <div class="d-flex justify-content-between mt-4 mb-5">
            <button type="button" id="add-vocabulary" class="btn btn-info text-white">
                <i class="fa fa-plus-circle"></i> Add Vocabulary
            </button>

            <button type="submit" class="btn btn-success" id="submitBtn">
                <i class="fa fa-save"></i> Save Vocabulary
            </button>
        </div>
    </form>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const wrapper = document.getElementById('vocabulary-wrapper');
            const addBtn = document.getElementById('add-vocabulary');
            const submitBtn = document.getElementById('submitBtn');

            // Data passed from controller
            const existingVocabularies = @json($vocabularies ?? []); // Default to empty array if undefined

            let count = 0;

            function addVocabulary(data = {}) {
                const index = count++;
                const isExisting = data.id ? true : false;
                const hiddenIdInput = isExisting ? `<input type="hidden" name="vocabularies[${index}][id]" value="${data.id}">` : '';

                const html = `
        <div class="card mb-4 vocabulary-card" id="vocab-${index}">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Vocabulary <span class="number"></span></h4>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeVocabulary(${index})">
                    <i class="fa fa-trash"></i> Remove
                </button>
            </div>
            <div class="card-body">
                ${hiddenIdInput}
                
                <!-- Word -->
                <div class="mb-3">
                    <label class="form-label">Word:
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" name="vocabularies[${index}][word]" value="${data.word || ''}" placeholder="Enter word" required>
                </div>

                <!-- Meaning -->
                <div class="mb-3">
                    <label class="form-label">Meaning:
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" name="vocabularies[${index}][meaning]" value="${data.meaning || ''}" placeholder="Enter meaning" required>
                </div>

                <!-- Example -->
                <div class="mb-3">
                    <label class="form-label">Example:
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" name="vocabularies[${index}][example]" value="${data.example || ''}" placeholder="Enter Example" required>
                </div>
            </div>
        </div>`;

                wrapper.insertAdjacentHTML('beforeend', html);
                updateNumbers();
            }

            window.removeVocabulary = function (index) {
                const card = document.getElementById(`vocab-${index}`);
                // Optional: Check if at least one remains, or allow empty. 
                // User asked for "add button remove section button", usually implies at least one, but let's allow flexibility or warn.
                if (document.querySelectorAll('.vocabulary-card').length > 1) {
                    card.remove();
                    updateNumbers();
                } else {
                    alert('At least one vocabulary item is required.');
                }
            }

            function updateNumbers() {
                document.querySelectorAll('.vocabulary-card').forEach((card, i) => {
                    card.querySelector('.number').textContent = (i + 1);
                });
            }

            // -------------- INIT ----------------

            if (existingVocabularies.length > 0) {
                existingVocabularies.forEach(v => addVocabulary(v));
            } else {
                addVocabulary(); // Add one empty by default
            }

            addBtn.addEventListener('click', () => addVocabulary());

        });
    </script>
@endpush
