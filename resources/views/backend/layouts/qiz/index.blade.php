@extends('backend.app')

@section('title', 'QIZ List')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">QIZ List</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">QIZ</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row row-sm">
        {{-- List Language --}}
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-bottom"
                     style="margin-bottom: 0; display: flex; justify-content: space-between;">
                    <h3 class="card-title"></h3>
{{--                    <div>--}}
{{--                        <a href="{{route('qiz.create')}}" class="btn btn-primary-gradient">--}}
{{--                            Create--}}
{{--                        </a>--}}
{{--                    </div>--}}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom w-100" id="datatable">
                            <thead>
                            <tr>
{{--                                <th><input type="checkbox" id="selectAll"></th>--}}
                                <th class="wd-15p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">Song Title</th>
                                <th class="wd-15p border-bottom-0">Song Image</th>
                                <th class="wd-15p border-bottom-0">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- dynamic data --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            });
            if (!$.fn.DataTable.isDataTable('#datatable')) {
                let dTable = $('#datatable').DataTable({
                    order: [],
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    processing: true,
                    responsive: true,
                    serverSide: true,

                    language: {
                        processing: `<div class="text-center">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                          </div>
                            </div>`
                    },

                    scroller: {
                        loadingIndicator: false
                    },
                    pagingType: "full_numbers",
                    dom: "<'row justify-content-between table-topbar'<'col-md-2 col-sm-4 px-0'l><'col-md-2 col-sm-4 px-0'f>>tipr",
                    ajax: {
                        url: "{{ route('qiz.index') }}",
                        type: "GET",
                    },

                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'title',
                            name: 'title',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'image',
                            name: 'image',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                });

                dTable.buttons().container().appendTo('#file_exports');
                new DataTable('#example', {
                    responsive: true
                });
            }
        });


        // Create
        $('#createLanguageForm').on('submit', function(e) {
            e.preventDefault();

            let $form = $(this);
            let name = $('#create_name').val();

            // Clear previous errors
            $('#create_error_name').text('');

            axios.post("{{ route('artist.store') }}", { name: name })
                .then(function(response) {
                    // Close modal using jQuery + Bootstrap 5
                    $('#createForm').modal('hide');

                    // Reset form
                    $form[0].reset();

                    // Reload DataTable
                    $('#datatable').DataTable().ajax.reload();

                    // Success toast
                    toastr.success('Artist created successfully');
                })
                .catch(function(error) {
                    if (error.response && error.response.status === 422 && error.response.data.errors.name) {
                        $('#create_error_name').text(error.response.data.errors.name[0]);
                    } else {
                        toastr.error('Failed to create artist');
                    }
                });
        });


        // Edit
        function openEditModal(id) {
            let url = "{{ route('artist.edit', ':id') }}";
            url = url.replace(':id', id);

            axios.get(url)
                .then(response => {
                    const data = response.data;
                    console.log(data);
                    document.getElementById('edit_id').value = data.id;
                    document.getElementById('edit_name').value = data.name;

                    $('#editLanguageModal').modal('show');
                })
                .catch(error => {
                    console.error(error);
                    toastr.error('Failed to load artist data');
                });
        }

        //update
        $('#editLanguageForm').on('submit', function (e) {
            e.preventDefault();

            let id = $('#edit_id').val();
            let url = "{{ route('artist.update', ':id') }}";
            url = url.replace(':id', id);

            axios.put(url, {
                name: $('#edit_name').val()
            })
                .then(response => {
                    $('#editLanguageModal').modal('hide');
                    $('#datatable').DataTable().ajax.reload();
                    toastr.success('Artist updated successfully');
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        toastr.error(error.response.data.message);
                    } else {
                        toastr.error('Update failed');
                    }
                });
        });
    </script>

@endpush
