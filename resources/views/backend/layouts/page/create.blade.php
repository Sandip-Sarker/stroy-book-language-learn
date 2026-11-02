@extends('backend.app')

@section('title', 'Page Create')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Page Create Form</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('page.setting')}}">Page</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER END --}}

    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form method="post" action="{{ route('page.setting.store') }}">
                        @csrf
                       <div class="row">
                           <div class="col-md-6">
                               {{-- Name --}}
                               <div class="form-group">
                                   <label for="page_title" class="form-label">Title:</label>
                                   <input type="text" class="form-control @error('page_title') is-invalid @enderror"
                                          name="page_title" placeholder="Title" id="page_title" value="{{ old('page_title') }}">
                                   @error('page_title')
                                   <span class="text-danger">{{ $message }}</span>
                                   @enderror
                               </div>
                           </div>

                           <div class="col-md-6">
{{--                                Slug --}}
                               <div class="form-group">
                                   <label for="page_slug" class="form-label">Slug:</label>
                                   <input type="text" class="form-control @error('page_slug') is-invalid @enderror"
                                          name="page_slug" placeholder="slug" id="page_slug" value="{{ old('page_slug') }}">
                                   @error('page_slug')
                                   <span class="text-danger">{{ $message }}</span>
                                   @enderror
                               </div>
                           </div>
                       </div>

                        {{-- Content --}}
                        <div class="form-group">
                            <label for="content" class="form-label">Content:</label>
                            <textarea class="form-control" name="page_content" id="summernote">{{ old('page_content') }}</textarea>
                        </div>

                        {{-- Submit --}}
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <a href="{{ route('page.setting') }}" class="btn btn-danger me-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
