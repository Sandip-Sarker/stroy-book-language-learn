@extends('backend.app')

@section('title', 'Song Details')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Song Details</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('song.index') }}">Song</a></li>
                <li class="breadcrumb-item active" aria-current="page">Song Details</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER END --}}

    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-5">
                <div class="card-header border-bottom text-white bg-info-gradient">
                </div>
                <div class="card-body">
                    <table class="table table-bordered border-bottom">
                        <tbody>

                        <tr>
                            <th>Title</th>
                            <td>{{ $song->title ?? ' ' }}</td>
                        </tr>
                        <tr>
                            <th>Artist</th>
                            <td>{{ $song->artist->name ?? ' ' }}</td>
                        </tr>
                        <tr>
                            <th>Language</th>
                            <td>{{ $song->language->name ?? ' ' }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>{{ $song->category->name ?? ' ' }}</td>
                        </tr>
                        <tr>
                            <th>Difficult</th>
                            <td>
                                @if ($song->difficult == "Beginner")
                                    <span class="badge bg-info-gradient">{{ $song->difficult ?? '' }}</span>
                                @elseif($song->difficult == "Intermediate")
                                    <span class="badge bg-primary-gradient">{{ $song->difficult ?? '' }}</span>
                                @else
                                    <span class="badge bg-success-gradient">{{ $song->difficult ?? '' }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <td>
                                @if ($song->image)
                                    <img src="{{ url(Storage::url($song->image)) }}" alt="Thumbnail"
                                         style="max-width: 100px; max-height: 100px;">
                                @else
                                    No Thumbnail Available
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Audio File</th>
                            <td>
                                @if ($song->audio)
                                    <audio controls>
                                        <source src="{{ url(Storage::url($song->audio)) }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                @else
                                    No Audio File Available
                                @endif
                            </td>
                        <tr>
                            <th>Short Description</th>
                            <td>{{ $song->short_description ?? ' ' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if ($song->status)
                                    <span class="badge bg-success-gradient">Active</span>
                                @else
                                    <span class="badge bg-danger-gradient">Inactive</span>
                                @endif
                            </td>
                        <tr>
                            <th>Created At</th>
                            <td>
                                @if ($song->created_at)
                                    {{ $song->created_at->diffForHumans() }}
                                @else
                                    &nbsp;
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>
                                @if ($song->updated_at)
                                    {{ $song->updated_at->diffForHumans() }}
                                @else
                                    &nbsp;
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
