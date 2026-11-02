@extends('backend.app')

@section('title', 'Song Details')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Qiz Details</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('qiz.index') }}">Qiz</a></li>
                <li class="breadcrumb-item active" aria-current="page">Qiz Details</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER END --}}

    @if($data->count() > 0)
        <div class="card box-shadow-5 mb-4">
            <div class="card-header border-bottom text-white bg-info-gradient">
                <h3 class="card-title text-white">Song: {{ $data[0]->song->title ?? 'N/A' }}</h3>
            </div>
        </div>

        @foreach($data as $key => $question)
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card box-shadow-5">
                        <div class="card-header border-bottom">
                            <h4 class="card-title">Question {{ $key + 1 }}</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered border-bottom">
                                <tbody>
                                <tr>
                                    <th style="width: 20%">Question:</th>
                                    <td>{{ $question->question ?? ' ' }}</td>
                                </tr>
                                <tr>
                                    <th>Answer Options:</th>
                                    <td>
                                        <div class="row">
                                            @foreach($question->quizOptions as $option)
                                                <div class="col-md-6 mb-2">
                                                    <div class="p-2 border">
                                                        <strong>({{ $option->option_label }})</strong> {{ $option->option_text }}
                                                        @if($option->is_correct)
                                                            <span class="badge bg-success float-end p-2">Correct</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-warning">No questions found for this song.</div>
    @endif
@endsection
