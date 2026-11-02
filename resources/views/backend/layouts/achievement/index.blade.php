@extends('backend.app')

@section('title', 'Achievement List')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Achievement List</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">Achievement</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row row-sm">
        {{-- List Achievement --}}
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
                                    <th class="wd-15p border-bottom-0">Title</th>
                                    <th class="wd-15p border-bottom-0">Image</th>
                                    {{-- <th class="wd-15p border-bottom-0">Quiz Number</th> --}}
                                    <th class="wd-15p border-bottom-0">XP Number</th>
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

        <!-- Create Achievement Modal -->
        <div class="modal fade" id="createForm" tabindex="-1" aria-labelledby="createAchievementLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="createAchievementForm" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createAchievementLabel">Create Achievement</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" id="create_title" placeholder="Enter achievement title">
                                <span class="text-danger" id="create_error_title"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" class="form-control dropify" name="image" id="create_image">
                                <span class="text-danger" id="create_error_image"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">XP Number</label>
                                <input type="number" class="form-control" name="xp_num" id="create_xp_num" placeholder="Enter xp number">
                                <span class="text-danger" id="create_error_xp_num"></span>
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

        <!-- Edit Achievement Modal -->
        <div class="modal fade" id="editAchievementModal" tabindex="-1" aria-labelledby="editAchievementLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editAchievementForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit_id">

                        <div class="modal-header">
                            <h5 class="modal-title" id="editAchievementLabel">Edit Achievement</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" id="edit_title">
                                <span class="text-danger" id="edit_error_title"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" class="form-control dropify" name="image" id="edit_image">
                                <span class="text-danger" id="edit_error_image"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">XP Number</label>
                                <input type="number" class="form-control" name="xp_num" id="edit_xp_num">
                                <span class="text-danger" id="edit_error_xp_num"></span>
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
            $('.dropify').dropify();

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
                        url: "{{ route('achievement.index') }}",
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
                            data: 'title',
                            name: 'title',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'image',
                            name: 'image',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'xp_num',
                            name: 'xp_num',
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
        $('#createAchievementForm').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            // Clear previous errors
            $('#createAchievementForm').find('.text-danger').text('');

            axios.post("{{ route('achievement.store') }}", formData)
                .then(function(response) {
                    $('#createForm').modal('hide');
                    $('#createAchievementForm')[0].reset();

                    // Reset Dropify
                    let dropifyInstance = $('#create_image').data('dropify');
                    if(dropifyInstance) {
                        dropifyInstance.resetPreview();
                        dropifyInstance.clearElement();
                    }

                    $('#datatable').DataTable().ajax.reload();
                    toastr.success('Achievement created successfully');
                })
                .catch(function(error) {
                    if (error.response && error.response.status === 422) {
                        let errors = error.response.data.errors;
                        $.each(errors, function(key, value) {
                            $(`#create_error_${key}`).text(value[0]);
                        });
                    } else {
                        toastr.error('Failed to create achievement');
                    }
                });
        });


        // Edit
        function openEditModal(id) {
            let url = "{{ route('achievement.edit', ':id') }}";
            url = url.replace(':id', id);

            axios.get(url)
                .then(response => {
                    const data = response.data;
                    $('#edit_id').val(data.id);
                    $('#edit_title').val(data.title);
                    $('#edit_xp_num').val(data.xp_num);

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

                    $('#editAchievementModal').modal('show');
                })
                .catch(error => {
                    console.error(error);
                    toastr.error('Failed to load achievement data');
                });
        }

        //update
        $('#editAchievementForm').on('submit', function (e) {
            e.preventDefault();

            let id = $('#edit_id').val();
            let url = "{{ route('achievement.update', ':id') }}";
            url = url.replace(':id', id);

            let formData = new FormData(this);
            formData.append('_method', 'PUT');

            axios.post(url, formData)
                .then(response => {
                    $('#editAchievementModal').modal('hide');
                    $('#datatable').DataTable().ajax.reload();
                    toastr.success('Achievement updated successfully');
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                         let errors = error.response.data.errors;
                        $.each(errors, function(key, value) {
                            $(`#edit_error_${key}`).text(value[0]);
                        });
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
            let url = '{{ route('achievement.destroy', ':id') }}';
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


        $(document).on('click', '#deleteALL', function() {
            let selectedIds = [];

            $('.user-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire('No selection', 'Please select at least one data.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: 'Selected data will be deleted permanently!',
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
                url: "{{ route('achievement.bulkDelete') }}",
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
