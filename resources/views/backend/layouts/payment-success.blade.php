
@extends('backend.app')

@section('title', 'Payment Success')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Payment Success</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Payment Success</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payment Success</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER END --}}

    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-5">
                <div class="card-body">
                   <h2 class="text-success">Payment Successfully</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
