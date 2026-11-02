@extends('backend.app')

@section('title', 'Fun Fact List')

@section('content')
    <style>
        .note-editable {
            min-height: 100px !important;
            height: 100px !important;
        }
    </style>
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Fun Fact List</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fun Fact</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-bottom"
                     style="margin-bottom: 0; display: flex; justify-content: space-between;">
                    <h3 class="card-title">Fun Facts</h3>
                    <div>
                        <button type="button" class="btn btn-primary-gradient" data-bs-toggle="modal" data-bs-target="#createForm">
                            Create New
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom w-100" id="datatable">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">Language</th>
                                <th class="wd-15p border-bottom-0">Image</th>
                                <th class="wd-20p border-bottom-0">Title</th>
                                <th class="wd-45p border-bottom-0">Description</th>
                                <th class="wd-10p border-bottom-0">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Modal -->
        <div class="modal fade" id="createForm" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="createFunFactForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel">Create Fun Fact</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="create_language_id" class="form-label">Language <span class="text-danger">*</span></label>
                                <select class="form-select" id="create_language_id" name="language_id">
                                    <option value="">-- Select Language --</option>
                                    @foreach($languages as $language)
                                        <option value="{{ $language->id }}">{{ $language->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="create_error_language_id"></span>
                            </div>
                            <div class="mb-3">
                                <label for="create_title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="create_title" name="title" placeholder="Enter title">
                                <span class="text-danger" id="create_error_title"></span>
                            </div>
                            <div class="mb-3">
                                <label for="create_description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control summernote" id="create_description" name="description" rows="5" placeholder="Enter description"></textarea>
                                <span class="text-danger" id="create_error_description"></span>
                            </div>
                            <div class="mb-3">
                                <label for="create_image" class="form-label">Image</label>
                                <input type="file" class="form-control dropify" id="create_image" name="image" accept="image/*">
                                <span class="text-danger" id="create_error_image"></span>
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

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editFunFactForm">
                        @csrf
                        <input type="hidden" id="edit_id">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Fun Fact</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_language_id" class="form-label">Language <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_language_id" name="language_id">
                                    <option value="">Select Language</option>
                                    @foreach($languages as $language)
                                        <option value="{{ $language->id }}">{{ $language->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="edit_error_language_id"></span>
                            </div>
                            <div class="mb-3">
                                <label for="edit_title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_title" name="title" placeholder="Enter title">
                                <span class="text-danger" id="edit_error_title"></span>
                            </div>
                            <div class="mb-3">
                                <label for="edit_description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control summernote" id="edit_description" name="description" rows="5" placeholder="Enter description"></textarea>
                                <span class="text-danger" id="edit_error_description"></span>
                            </div>
                            <div class="mb-3">
                                <label for="edit_image" class="form-label">Image</label>
                                <input type="file" class="form-control dropify" id="edit_image" name="image" accept="image/*">
                                <span class="text-danger" id="edit_error_image"></span>
                                <div id="edit_image_preview" class="mt-2"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary-gradient" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary-gradient w-25">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Initialize Summernote
            $('.summernote').summernote({
                height: 200,
                tabsize: 2
            });

            // Initialize Dropify
            $('.dropify').dropify();

            if (!$.fn.DataTable.isDataTable('#datatable')) {
                $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('fun-fact.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'language', name: 'language'},
                        {data: 'image', name: 'image', orderable: false, searchable: false},
                        {data: 'title', name: 'title'},
                        {data: 'description', name: 'description'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                    language: {
                        processing: `<div class="text-center">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                          </div>
                            </div>`
                    }
                });
            }

            // Create Fun Fact
            $('#createFunFactForm').on('submit', function (e) {
                e.preventDefault();
                let $form = $(this);
                
                // Sync Summernote
                $('#create_description').val($('#create_description').summernote('code'));
                
                let formData = new FormData(this);

                // Clear previous errors
                $('#create_error_title').text('');
                $('#create_error_language_id').text('');
                $('#create_error_description').text('');
                $('#create_error_image').text('');

                axios.post("{{ route('fun-fact.store') }}", formData)
                    .then(function (response) {
                        if (response.data.success) {
                            $('#createForm').modal('hide');
                            $form[0].reset();
                            $('#create_description').summernote('code', ''); // Clear Summernote
                            
                            // Reset Dropify
                            let dropifyInstance = $('#create_image').data('dropify');
                            if (dropifyInstance) {
                                dropifyInstance.resetPreview();
                                dropifyInstance.clearElement();
                            }

                            $('#datatable').DataTable().ajax.reload();
                            toastr.success(response.data.message);
                        } else {
                            toastr.error(response.data.message);
                        }
                    })
                    .catch(function (error) {
                        if (error.response?.status === 422) {
                            $('#create_error_title').text(error.response.data.errors?.title?.[0]);
                            $('#create_error_language_id').text(error.response.data.errors?.language_id?.[0]);
                            $('#create_error_description').text(error.response.data.errors?.description?.[0]);
                            $('#create_error_image').text(error.response.data.errors?.image?.[0]);
                        } else {
                            toastr.error('Failed to create Fun Fact');
                        }
                    });
            });

            // Edit Fun Fact - Form Submit
            $('#editFunFactForm').on('submit', function (e) {
                e.preventDefault();
                let id = $('#edit_id').val();
                let url = "{{ route('fun-fact.update', ':id') }}";
                url = url.replace(':id', id);
                
                // Sync Summernote
                $('#edit_description').val($('#edit_description').summernote('code'));
                
                let formData = new FormData(this);
                formData.append('_method', 'PATCH');

                // Clear previous errors
                $('#edit_error_title').text('');
                $('#edit_error_description').text('');
                $('#edit_error_image').text('');

                axios.post(url, formData)
                    .then(function (response) {
                        if (response.data.success) {
                            $('#editModal').modal('hide');
                            $('#datatable').DataTable().ajax.reload();
                            toastr.success(response.data.message);
                        } else {
                            toastr.error(response.data.message);
                        }
                    })
                    .catch(function (error) {
                        if (error.response?.status === 422) {
                            $('#edit_error_title').text(error.response.data.errors?.title?.[0]);
                            $('#edit_error_description').text(error.response.data.errors?.description?.[0]);
                            $('#edit_error_image').text(error.response.data.errors?.image?.[0]);
                        } else {
                            toastr.error('Failed to update Fun Fact');
                        }
                    });
            });
        });

        // Open Edit Modal and Load Data
        function openEditModal(id) {
            let url = "{{ route('fun-fact.edit', ':id') }}";
            url = url.replace(':id', id);

            axios.get(url)
                .then(function (response) {
                    const data = response.data;
                    $('#edit_id').val(data.id);
                    $('#edit_title').val(data.title);
                    $('#edit_language_id').val(data.language_id);  // এটা add করুন
                    
                    // Load into Summernote
                    $('#edit_description').summernote('code', data.description);

                    // Dropify Preview
                    let dropifyElement = $('#edit_image').dropify();
                    let dropify = dropifyElement.data('dropify');
                    
                    if (data.image) {
                        let imageUrl = window.location.origin + '/storage/' + data.image;
                        dropify.resetPreview();
                        dropify.clearElement();
                        dropify.settings.defaultFile = imageUrl;
                        dropify.destroy();
                        dropify.init();
                    } else {
                        dropify.resetPreview();
                        dropify.clearElement();
                        dropify.settings.defaultFile = '';
                        dropify.destroy();
                        dropify.init();
                    }
                    
                    // Hide original preview div since dropify handles it
                    $('#edit_image_preview').hide();
                    
                    $('#editModal').modal('show');
                })
                .catch(function (error) {
                    toastr.error('Failed to load Fun Fact data');
                });
        }

        function showDeleteConfirm(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteItem(id);
                }
            });
        }

        function deleteItem(id) {
            let url = "{{ route('fun-fact.destroy', ':id') }}";
            url = url.replace(':id', id);
            
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#datatable').DataTable().ajax.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function () {
                    toastr.error("Something went wrong!");
                }
            });
        }
    </script>
@endpush
