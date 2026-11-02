@extends('backend.app')

@section('title', 'Create Quiz')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">QIZ List</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </div>
    </div>

    <form method="POST" action="{{ route('qiz.store') }}" id="quiz-form">
        @csrf

        <div class="row justify-content-center">
            <div class="col-lg-12">

                {{-- Quiz Info Card (Optional: You could add Quiz Title/Description inputs here if needed in future) --}}

                <div id="questions-wrapper">
                    {{-- Questions will be injected here --}}
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between align-items-center mt-4 mb-5">
                    <button type="button" id="add-question" class="btn btn-info text-white  px-4 py-2 rounded-pill">
                        <i class="fa fa-plus-circle me-1"></i> Add New Question
                    </button>

                    <button type="submit" class="btn btn-success-gradient px-5 py-2 rounded-pill">
                        <i class="fa fa-save me-1"></i> Save Quiz
                    </button>
                </div>

            </div>
        </div>
    </form>

    {{-- Hidden Template for JavaScript --}}
    <template id="question-template">
        <div class="card shadow-sm border-0 mb-4 question-card animate__animated animate__fadeInUp">
            <div class="card-header bg-white border-bottom-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title  mb-0">Question <span class="question-number">1</span></h5>
                <button type="button" class="btn btn-outline-danger btn-sm p-1 px-2 rounded-circle remove-question" title="Remove Question">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
            <div class="card-body bg-light-soft">
                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Question Text <span class="text-danger">*</span></label>
                    <input type="text"
                           class="form-control border-0 question-input"
                           placeholder="e.g. What is the capital of France?"
                           required>
                </div>

                <div class="row g-3 options-container">
                    {{-- Options will be generated here --}}
                </div>
            </div>
        </div>
    </template>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const wrapper = document.getElementById('questions-wrapper');
            const addBtn = document.getElementById('add-question');

            let questionCount = 0;

            // Function to add a new question
            function addQuestion() {
                const index = questionCount++;
                const template = `
            <div class="card shadow-sm border-0 mb-4 question-card" id="question-${index}">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-bold text-primary mb-0">
                        <span class="">${index + 1}.</span> Question
                    </h5>
                    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 remove-question" onclick="removeQuestion(${index})">
                        <i class="fa fa-trash me-1"></i> Remove
                    </button>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label">Write your question here</label>
                        <input type="text"
                               name="questions[${index}][question]"
                               class="form-control"
                               placeholder="Enter question"
                               required>
                    </div>

                    <label class="form-label mb-2">Answer Options</label>
                    <div class="row g-3">
                        ${['A', 'B', 'C', 'D'].map(opt => `
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold text-dark border-end-0" style="width: 45px; justify-content: center;">${opt}</span>
                                    <input type="text"
                                           name="questions[${index}][options][${opt}]"
                                           class="form-control"
                                           placeholder="Option ${opt}"
                                           required>
                                    <div class="input-group-text bg-white border-start-0">
                                        <input class="form-check-input mt-0"
                                               type="radio"
                                               name="questions[${index}][correct]"
                                               value="${opt}"
                                               required
                                               title="Mark as correct answer">
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            </div>
        `;

                wrapper.insertAdjacentHTML('beforeend', template);
                updateQuestionNumbers();
            }

            // Function to remove a question
            window.removeQuestion = function(index) {
                const element = document.getElementById(`question-${index}`);
                if(element) {
                    const allQuestions = wrapper.querySelectorAll('.question-card');
                    if(allQuestions.length > 1) {
                        element.remove();
                        updateQuestionNumbers();
                    } else {
                        alert("You must have at least one question.");
                    }
                }
            }

            // Update numbers and remove button visibility
            function updateQuestionNumbers() {
                const questions = wrapper.querySelectorAll('.question-card');
                questions.forEach((card, i) => {
                    // Update badge number
                    const badge = card.querySelector('.card-title .badge');
                    if(badge) badge.textContent = i + 1;

                    // Hide remove button for first question, show for others
                    const removeBtn = card.querySelector('.remove-question');
                    if(removeBtn) {
                        removeBtn.style.display = i === 0 ? 'none' : 'inline-block';
                    }
                });
            }

            // Add initial question
            addQuestion();

            // Add more question button
            addBtn.addEventListener('click', addQuestion);
        });
    </script>

@endsection
