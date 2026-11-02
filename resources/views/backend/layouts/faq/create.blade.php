@extends('backend.app')

@section('title', 'Faq Create')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Faq Create Form</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('page.setting')}}">Faq</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER END --}}

    <div class="row">
        <div class="col-lg-8 col-xl-8 col-md-8 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form method="post" action="{{ route('faq.store') }}">
                        @csrf

                        {{-- Question --}}
                        <div class="form-group">
                            <label for="question" class="form-label">Question:</label>
                            <input type="text" class="form-control
                                   @error('question') is-invalid
                                   @else
                                    {{ old('question') ? 'is-valid' : '' }}
                                   @enderror"
                                   name="question" placeholder="Enter question?" id="question"
                                   value="{{ old('question') }}">
                            @error('question')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        {{-- Answer --}}
                        <div class="form-group">
                            <label for="answer" class="form-label">Answer:</label>
                            <textarea name="answer" id="answer" class="form-control
                                    @error('answer') is-invalid
                                    @else
                                        {{ old('answer') ? 'is-valid' : '' }}
                                    @enderror"
                                      placeholder="Enter Answer...">{{ old('answer') }}</textarea>
                            @error('answer')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <a href="{{ route('faq.index') }}" class="btn btn-danger me-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
