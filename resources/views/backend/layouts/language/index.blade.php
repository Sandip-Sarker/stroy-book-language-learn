@extends('backend.app')

@section('title', 'Language List')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Language List</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">Language</li>
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
                    <div>
                        <button type="button" class="btn btn-danger-gradient" id="deleteALL">Bulk Delete</button>
                        <button type="button" class="btn btn-primary-gradient" data-bs-toggle="modal" data-bs-target="#createForm">
                            Create
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom w-100" id="datatable">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">Name</th>
                                    <th class="wd-15p border-bottom-0">Image</th>
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

        <!-- Create Language Modal -->
        <div class="modal fade" id="createForm" tabindex="-1" aria-labelledby="createLanguageLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="createLanguageForm" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createLanguageLabel">Create Language</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="create_name" placeholder="Enter language name">
                                <span class="text-danger" id="create_error_name"></span>
                            </div>

                            {{-- Image --}}
                            <div class="mb-3">
                                <label for="image" class="form-label">Image:
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="file" class="dropify" name="image" id="create_image">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary-gradient" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary-gradient w-25">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Language Modal -->
        <div class="modal fade" id="editLanguageModal" tabindex="-1" aria-labelledby="editLanguageLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editLanguageForm">
                        @csrf
                        <input type="hidden" id="edit_id">

                        <div class="modal-header">
                            <h5 class="modal-title" id="editLanguageLabel">Edit Language</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="edit_name">
                                <span class="text-danger" id="edit_error_name"></span>
                            </div>

                            {{-- Image --}}
                            <div class="mb-3">
                                <label for="image" class="form-label">Image:</label>
                                <input type="file" class="dropify" name="image" id="edit_image">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary-gradient w-25">Update</button>
                            <button type="button" class="btn btn-secondary-gradient" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
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
                        url: "{{ route('language.index') }}",
                        type: "GET",
                    },

                    columns: [{
                            data: 'checkbox',
                            name: 'checkbox',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
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
        $('#createLanguageForm').on('submit', function (e) {
            e.preventDefault();

            let $form = $(this);

            let formData = new FormData();
            formData.append('name', $('#create_name').val());

            // image file
            if ($('#create_image')[0].files.length > 0) {
                formData.append('image', $('#create_image')[0].files[0]);
            }

            // CSRF token
            formData.append('_token', '{{ csrf_token() }}');

            // Clear previous errors
            $('#create_error_name').text('');

            axios.post("{{ route('language.store') }}", formData)
                .then(function (response) {
                    $('#createForm').modal('hide');

                    $form[0].reset();
                    
                    // Clear Dropify properly
                    let dropifyInstance = $('#create_image').data('dropify');
                    if(dropifyInstance) {
                        dropifyInstance.resetPreview();
                        dropifyInstance.clearElement();
                    }

                    $('#datatable').DataTable().ajax.reload(null, false);

                    toastr.success(response.data.message ?? 'Language created successfully');
                })
                .catch(function (error) {
                    console.log(error.response); // DEBUG

                    if (error.response?.status === 422) {
                        $('#create_error_name').text(error.response.data.errors?.name?.[0]);
                    } else {
                        toastr.error('Failed to create language');
                    }
                });

        });



        // Edit
        function openEditModal(id) {
            let url = "{{ route('language.edit', ':id') }}";
            url = url.replace(':id', id);

            axios.get(url)
                .then(response => {
                    const data = response.data;
                    document.getElementById('edit_id').value = data.id;
                    document.getElementById('edit_name').value = data.name;

                    // Image
                    let dropifyElement = $('#edit_image').dropify();
                    let dropify = dropifyElement.data('dropify');
                    
                    if (data.image) {
                        dropify.resetPreview();
                        dropify.clearElement();
                        dropify.settings.defaultFile = data.image;
                        dropify.destroy();
                        dropify.init();
                    } else {
                        dropify.resetPreview();
                        dropify.clearElement();
                        dropify.settings.defaultFile = '';
                        dropify.destroy();
                        dropify.init();
                    }

                    $('#editLanguageModal').modal('show');
                })
                .catch(error => {
                    console.error(error);
                    toastr.error('Failed to load language data');
                });
        }

        //update
        $('#editLanguageForm').on('submit', function (e) {
            e.preventDefault();

            let id = $('#edit_id').val();
            let url = "{{ route('language.update', ':id') }}";
            url = url.replace(':id', id);

            let formData = new FormData();
            formData.append('name', $('#edit_name').val());
            
            if ($('#edit_image')[0].files.length > 0) {
                formData.append('image', $('#edit_image')[0].files[0]);
            }

            formData.append('_method', 'PUT'); // Simulate PUT for Laravel

            axios.post(url, formData)
                .then(response => {
                    $('#editLanguageModal').modal('hide');
                    $('#datatable').DataTable().ajax.reload(null, false);
                    toastr.success('Language updated successfully');
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        toastr.error(error.response.data.message);
                    } else {
                        toastr.error('Update failed');
                    }
                });
        });


        // delete Confirm
        function showDeleteConfirm(id) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to delete this record?',
                text: 'If you delete this, it will be gone forever.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteItem(id);
                }
            });
        }

        // Delete Button
        function deleteItem(id) {
            let url = '{{ route('language.destroy', ':id') }}';
            let csrfToken = '{{ csrf_token() }}';
            $.ajax({
                type: "DELETE",
                url: url.replace(':id', id),
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(resp) {
                    $('#datatable').DataTable().ajax.reload();
                    if (resp['t-success']) {
                        toastr.success(resp.message);
                    } else {
                        toastr.error(resp.message);
                    }
                },
                error: function(error) {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        }
    </script>

    {{-- Multiple Delete --}}
    <script>
        $(document).on('click', '#deleteALL', function() {
            let selectedIds = [];

            $('.user-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire('No selection', 'Please select at least one song.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: 'Selected songs will be deleted permanently!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkDelete(selectedIds);
                }
            });
        });

        function bulkDelete(ids) {
            $.ajax({
                url: "{{ route('language.bulkDelete') }}",
                type: "POST",
                data: {
                    ids: ids,
                    _token: "{{ csrf_token() }}"
                },
                success: function(resp) {
                    $('#datatable').DataTable().ajax.reload();
                    toastr.success(resp.message);
                },
                error: function() {
                    toastr.error('Something went wrong.');
                }
            });
        }
    </script>
@endpush
