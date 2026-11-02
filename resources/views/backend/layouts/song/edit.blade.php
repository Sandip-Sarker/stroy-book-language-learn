@extends('backend.app')

@section('title', 'Song Edit')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Song Edit</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card box-shadow-5">
                <div class="card-header border-bottom bg-info-gradient">
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('song.update', $song->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                {{-- Language --}}
                                <div class="form-group">
                                    <label for="role" class="form-label">
                                        Language :
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control select2" name="language_id">
                                        <option value="">-- Select Language --</option>
                                        @foreach($languages as $language)
                                            <option value="{{ $language->id }}" {{ $song->language_id == $language->id ? 'Selected' : ''}}>{{ $language->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('language_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Artist --}}
                                <div class="form-group">
                                    <label for="role" class="form-label">
                                        Artist:
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control select2" name="artist_id">
                                        <option value="">-- Select Artist --</option>
                                        @foreach($artists as $artist)
                                            <option value="{{ $artist->id }}" {{ $song->artist_id == $artist->id ? 'Selected' : ''}}>{{ $artist->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('artist_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Title --}}
                                <div class="form-group">
                                    <label for="title" class="form-label">Title:
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="title"
                                           placeholder="Enter Song Title" id="title" value="{{ old('title', $song->title ?? '') }}">
                                    @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Image --}}
                                <div class="form-group">
                                    <label for="image" class="form-label">Image:
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" class="dropify" name="image" id="image" value="{{ old('image') }}" data-default-file="{{ url(Storage::url($song->image) ?? '') }}">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                {{-- Song Category --}}
                                <div class="form-group">
                                    <label for="role" class="form-label">Song Category:
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        class="form-control select2" name="song_category_id">
                                        <option value="">-- Select Song Category --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $song->song_category_id == $category->id ? 'Selected' : ''}}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('song_category_id ')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Difficult --}}
                                <div class="form-group">
                                    <label for="role" class="form-label">Difficult:</label>
                                    <select class="form-control select2" name="difficult">
                                        <option value="">-- Select Difficult --</option>
                                        <option value="Beginner" {{ $song->difficult == 'Beginner' ? 'Selected' : ''}}>Beginner</option>
                                        <option value="Intermediate" {{ $song->difficult == 'Intermediate' ? 'Selected' : ''}}>Intermediate</option>
                                        <option value="Advanced" {{ $song->difficult == 'Advanced' ? 'Selected' : ''}}>Advanced</option>
                                    </select>
                                </div>

                                {{-- Description --}}
                                <div class="form-group">
                                    <label for="short_description" class="form-label">Description:</label>
                                    <input type="text" class="form-control @error('short_description') is-invalid @enderror"
                                           name="short_description"
                                           placeholder="Enter short description" id="title" value="{{ old('short_description', $song->short_description) }}">
                                </div>


                                {{-- Audio --}}
                                <div class="form-group">
                                    <label for="audio" class="form-label">Audio:
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" class="dropify @error('audio') is-invalid @enderror"
                                           name="audio"
                                           placeholder="audio" id="audio" value="{{ old('audio') }}" data-default-file="{{ url(Storage::url($song->audio) ?? '') }}">
                                    @error('audio')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    @if (!empty($song->audio))
                                        <audio controls style="width:100%; margin-top:10px;">
                                            <source src="{{ url(Storage::url($song->audio)) }}" type="audio/mpeg">
                                            Your browser does not support the audio tag.
                                        </audio>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="form-group">
                            <button class="btn btn-primary-gradient" type="submit">Submit</button>
                            <a href="{{ route('user.index') }}" class="btn btn-danger-gradient me-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
