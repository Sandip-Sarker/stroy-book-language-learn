@extends('backend.app')

@section('title', 'Faq Category Edit')

@section('content')

    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Faq Category Edit Form</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('faq.category.index')}}">Faq Category</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER END --}}

    <div class="row">
        <div class="col-lg-8 col-xl-8 col-md-8 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form method="post" action="{{ route('faq.category.update', $faqCategory->id) }}">
                        @csrf

                        {{-- Name --}}
                        <div class="form-group">
                            <label for="name" class="form-label">name:</label>
                            <input type="text" class="form-control
                                   @error('name') is-invalid
                                   @else
                                    {{ old('name') ? 'is-valid' : '' }}
                                   @enderror"
                                   name="name"  id="name"
                                   value="{{ old('name', $faqCategory->name) }}">
                            @error('question')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{ route('faq.category.index') }}" class="btn btn-danger me-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
