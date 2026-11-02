@extends('backend.app')

@section('title', 'Vocabulary List')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Vocabulary List</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">Vocabulary</li>
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
                                    <th class="wd-15p border-bottom-0">Song Title</th>
                                    <th class="wd-15p border-bottom-0">Word</th>
                                    <th class="wd-15p border-bottom-0">Meaning</th>
                                    <th class="wd-15p border-bottom-0">Example</th>
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

        <!-- Create Artist Modal -->
        <div class="modal fade" id="createForm" tabindex="-1" aria-labelledby="createVocabularyLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="createVocabularyForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createLanguageLabel">Create Vocabulary</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <!-- Song -->
                            <div class="form-group">
                                <label for="role" class="form-label">Song:
                                    <span class="text-danger">*</span>
                                </label>
                                <select
                                    class="form-control select2" name="song_id" id="song_id">
                                    <option value="">-- Select Song --</option>
                                    @foreach($songs as $song)
                                        <option value="{{ $song->id }}">{{ $song->title ?? '' }}</option>
                                    @endforeach
                                </select>
                                @error('song_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Word -->
                            <div>
                                <label class="form-label">Word:
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="word" placeholder="Enter word">
                                <span class="text-danger" id="word"></span>
                            </div>

                            <!-- Meaning -->
                            <div>
                                <label class="form-label">Meaning:
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="meaning" placeholder="Enter meaning">
                                <span class="text-danger" id="meaning"></span>
                            </div>

                            <!-- Example -->
                            <div>
                                <label class="form-label">Example:
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="example" placeholder="Enter Example">
                                <span class="text-danger" id="example"></span>
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

        <!-- Edit Artist Modal -->
        <div class="modal fade" id="editVocabularyModal" tabindex="-1" aria-labelledby="editVocabularyLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editVocabularyForm">
                        @csrf
                        <input type="hidden" id="edit_id">

                        <div class="modal-header">
                            <h5 class="modal-title" id="editVocabularyLabel">Edit Vocabulary</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Song -->
                            <div class="form-group">
                                <label for="role" class="form-label">Song:
                                    <span class="text-danger">*</span>
                                </label>
                                <select
                                    class="form-control select2" name="song_id" id="edit_song_id">
                                    <option value="">-- Select Song --</option>
                                    @foreach($songs as $song)
                                        <option value="{{ $song->id }}" >{{ $song->title ?? '' }}</option>
                                    @endforeach
                                </select>
                                @error('song_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Word -->
                            <div>
                                <label class="form-label">Word:
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="edit_word" placeholder="Enter Word">
                                <span class="text-danger" id="edit_word"></span>
                            </div>

                            <!-- Meaning -->
                            <div>
                                <label class="form-label">Meaning:
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="edit_meaning" placeholder="Enter meaning">
                                <span class="text-danger" id="edit_meaning"></span>
                            </div>

                            <!-- Example -->
                            <div>
                                <label class="form-label">Example:
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="edit_example" placeholder="Enter example">
                                <span class="text-danger" id="edit_example"></span>
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
        // get
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
                        url: "{{ route('vocabulary.index') }}",
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
                            data: 'song_title',
                            name: 'song_title',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'word',
                            name: 'word',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'meaning',
                            name: 'meaning',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'example',
                            name: 'example',
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
        $('#createVocabularyForm').on('submit', function(e) {
            e.preventDefault();

            let $form       = $(this);
            let song_id     = $('#song_id').val();
            let word        = $('#word').val();
            let meaning     = $('#meaning').val();
            let example     = $('#example').val();

            // Clear previous errors
            $('#create_error_name').text('');

            axios.post("{{ route('vocabulary.store') }}", { song_id:song_id, word:word, meaning:meaning, example:example})
                .then(function(response) {
                    // Close modal using jQuery + Bootstrap 5
                    $('#createForm').modal('hide');

                    // Reset form
                    $form[0].reset();

                    // Reload DataTable
                    $('#datatable').DataTable().ajax.reload();

                    // Success toast
                    toastr.success('Vocabulary created successfully');
                })
                .catch(function(error) {
                    if (error.response && error.response.status === 422 && error.response.data.errors.name) {
                        $('#create_error_name').text(error.response.data.errors.name[0]);
                    } else {
                        toastr.error('Failed to create Vocabulary');
                    }
                });
        });

        // Edit
        function openEditModal(id) {
            let url = "{{ route('vocabulary.edit', ':id') }}".replace(':id', id);

            axios.get(url)
                .then(response => {
                    const data = response.data;
                    $('#edit_id').val(data.id);
                    $('#edit_song_id').val(data.song_id).trigger('change');
                    $('#edit_word').val(data.word);
                    $('#edit_meaning').val(data.meaning);
                    $('#edit_example').val(data.example);

                    $('#editVocabularyModal').modal('show');
                })
                .catch(() => {
                    toastr.error('Failed to load Lyrics data');
                });
        }


        //update
        $('#editVocabularyForm').on('submit', function (e) {
            e.preventDefault();

            let id  = $('#edit_id').val();
            console.log(id)
            let url = "{{ route('vocabulary.update', ':id') }}".replace(':id', id);

            axios.post(url, {
                song_id: $('#edit_song_id').val(),
                word: $('#edit_word').val(),
                meaning: $('#edit_meaning').val(),
                example: $('#edit_example').val(),
            })
                .then(() => {
                    $('#editVocabularyModal').modal('hide');
                    $('#datatable').DataTable().ajax.reload(null, false);
                    toastr.success('Vocabulary updated successfully');
                })
                .catch(error => {
                    if (error.response?.status === 422) {
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
            let url = '{{ route('vocabulary.destroy', ':id') }}';
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
                url: "{{ route('vocabulary.bulkDelete') }}",
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
