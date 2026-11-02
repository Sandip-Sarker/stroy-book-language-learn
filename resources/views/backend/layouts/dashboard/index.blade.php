@extends('backend.app')

@section('title', 'Dashboard')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    @php
        $totalUser          = \App\Models\User::all()->count();
        $totalLanguage      = \App\Models\Language::all()->count();
        $totalArtist        = \App\Models\Artist::all()->count();
        $totalCategory      = \App\Models\SongCategory::all()->count();
        $totalSong          = \App\Models\Song::all()->count();
        $totalLyrics        = \App\Models\Lyrics::all()->count();
        $totalVocabulary    = \App\Models\Vocabulary::all()->count();
        $totalQiz           = \App\Models\QuizQuestion::all()->count();
    @endphp

    <div class="row">

        {{-- Total User --}}
        <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
            <a href="{{ route('user.index') }}" class="card-link">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2 fw-semibold">{{ $totalUser }}</h3>
                                <p class="text-muted fs-13 mb-0">Total User</p>
                            </div>
                            <div class="col col-auto top-icn dash">
                                <div class="counter-icon  dash ms-auto box-shadow-primary">
                                    <i class="fa fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Total Language --}}
        <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
            <a href="{{ route('language.index') }}" class="card-link">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2 fw-semibold">{{ $totalLanguage }}</h3>
                                <p class="text-muted fs-13 mb-0">Total Language</p>
                            </div>
                            <div class="col col-auto top-icn dash">
                                <div class="counter-icon  dash ms-auto box-shadow-primary">
                                    <i class="fa fa-language"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Total Artist --}}
        <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
            <a href="{{ route('artist.index') }}" class="card-link">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2 fw-semibold">{{ $totalArtist }}</h3>
                                <p class="text-muted fs-13 mb-0">Total Artist</p>
                            </div>
                            <div class="col col-auto top-icn dash">
                                <div class="counter-icon  dash ms-auto box-shadow-primary">
                                    <i class="fa fa-user-secret"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Total Category --}}
        <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
            <a href="{{ route('song.category.index') }}" class="card-link">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2 fw-semibold">{{ $totalCategory }}</h3>
                                <p class="text-muted fs-13 mb-0">Total Category</p>
                            </div>
                            <div class="col col-auto top-icn dash">
                                <div class="counter-icon  dash ms-auto box-shadow-primary">
                                    <i class="fa fa-bars"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Total Song --}}
        <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
            <a href="{{ route('song.category.index') }}" class="card-link">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2 fw-semibold">{{ $totalSong }}</h3>
                                <p class="text-muted fs-13 mb-0">Total Song</p>
                            </div>
                            <div class="col col-auto top-icn dash">
                                <div class="counter-icon  dash ms-auto box-shadow-primary">
                                    <i class="fa fa-headphones"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Total Lyrics --}}
        <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
            <a href="" class="card-link">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2 fw-semibold">{{ $totalLyrics }}</h3>
                                <p class="text-muted fs-13 mb-0">Total Lyrics</p>
                            </div>
                            <div class="col col-auto top-icn dash">
                                <div class="counter-icon  dash ms-auto box-shadow-primary">
                                    <i class="fa fa-music"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Total Vocabulary --}}
        <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
            <a href="" class="card-link">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2 fw-semibold">{{ $totalVocabulary }}</h3>
                                <p class="text-muted fs-13 mb-0">Total Vocabulary</p>
                            </div>
                            <div class="col col-auto top-icn dash">
                                <div class="counter-icon  dash ms-auto box-shadow-primary">
                                    <i class="fa fa-book"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Total Quiz --}}
        <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
            <a href="" class="card-link">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2 fw-semibold">{{ $totalQiz }}</h3>
                                <p class="text-muted fs-13 mb-0">Total Quiz</p>
                            </div>
                            <div class="col col-auto top-icn dash">
                                <div class="counter-icon  dash ms-auto box-shadow-primary">
                                    <i class="fa fa-quora"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
@endsection
