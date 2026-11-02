@extends('backend.app')

@section('title', 'Plan Feature')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Plan Feature List</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">Plan Feature</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row row-sm">
        {{-- List Feature --}}
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-bottom"
                     style="margin-bottom: 0; display: flex; justify-content: space-between;">
                    <h3 class="card-title"></h3>
                    <div>
                        <button type="button" class="btn btn-primary-gradient" data-bs-toggle="modal"
                                data-bs-target="#createForm">
                            Create
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom w-100" id="datatable">
                            <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">Plan Name</th>
                                <th class="wd-15p border-bottom-0">Plan Price</th>
                                <th class="wd-15p border-bottom-0">Feature</th>
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

        <!-- Create Plan Modal -->
        <div class="modal fade" id="createForm" tabindex="-1" aria-labelledby="createPlanFeatureLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="createPlanFeatureForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createPlanLabel">Create Feature</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Plan -->
                            <div class="mb-3">
                                <label class="form-label">Plan</label>
                                <select class="form-select" id="create_plan_id">
                                    <option value="">-- Select Plan --</option>
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="create_plan_id_error"></span>
                            </div>

                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="create_feature"
                                       placeholder="Enter plan name">
                                <span class="text-danger" id="create_name_error"></span>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary-gradient" data-bs-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-primary-gradient w-25">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Plan Modal -->
        <div class="modal fade" id="editPlanFeatureModal" tabindex="-1" aria-labelledby="editPlanFeatureLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editPlanFeatureForm">
                        @csrf
                        <input type="hidden" id="edit_id">

                        <div class="modal-header">
                            <h5 class="modal-title" id="editPlanLabel">Edit Feature</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <!-- Plan -->
                            <div class="mb-3">
                                <label class="form-label">Plan</label>
                                <select class="form-select" id="edit_plan_id">
                                    <option value="">-- Select Plan --</option>
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="create_plan_id_error"></span>
                            </div>

                            <!-- Title -->
                            <div class="mb-3">
                                <label class="form-label">Feature Title</label>
                                <input type="text" class="form-control" id="edit_feature">
                                <span class="text-danger" id="edit_error_feature"></span>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary-gradient w-25">Update</button>
                            <button type="button" class="btn btn-secondary-gradient" data-bs-dismiss="modal">Close
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        {{-- List --}}
        $(document).ready(function () {

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
                        url: "{{ route('plan.feature.index') }}",
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
                            data: 'plan_name',
                            name: 'plan_name',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'plan_price',
                            name: 'plan_price',
                            orderable: true,
                            searchable: true
                        }, {
                            data: 'feature',
                            name: 'feature',
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

        {{-- Create--}}
        $('#createPlanFeatureForm').on('submit', function (e) {
            e.preventDefault();

            let $form = $(this);
            let feature = $('#create_feature').val();
            let planId = $('#create_plan_id').val();

            // Clear previous errors
            $('#create_error_feature').text('');

            axios.post("{{ route('plan.feature.store') }}", {feature: feature, plan_id:planId})
                .then(function (response) {
                    // Close modal using jQuery + Bootstrap 5
                    $('#createForm').modal('hide');

                    // Reset form
                    $form[0].reset();

                    // Reload DataTable
                    $('#datatable').DataTable().ajax.reload();

                    // Success toast
                    toastr.success('Feature created successfully');
                })
                .catch(function (error) {
                    if (error.response && error.response.status === 422 && error.response.data.errors.name) {
                        $('#create_error_feature').text(error.response.data.errors.feature[0]);
                    } else {
                        toastr.error('Failed to create Plan');
                    }
                });
        });


        {{-- Edit --}}
        function openEditModal(id) {
            let url = "{{ route('plan.feature.edit', ':id') }}";
            url = url.replace(':id', id);

            axios.get(url)
                .then(response => {
                    const data = response.data;

                    console.log('Plan ID from API:', data.plan_id);

                    // Set hidden id
                    $('#edit_id').val(data.id);

                    // IMPORTANT: convert to string
                    $('#edit_plan_id')
                        .val(String(data.plan_id))
                        .prop('selected', true);

                    // Set feature
                    $('#edit_feature').val(data.feature);

                    // Clear errors
                    $('#edit_error_feature').text('');
                    $('#create_plan_id_error').text('');

                    // Show modal
                    $('#editPlanFeatureModal').modal('show');
                })
                .catch(error => {
                    console.error(error);
                    toastr.error('Failed to load feature data');
                });
        }

        {{--  update--}}
        $('#editPlanFeatureForm').on('submit', function (e) {
            e.preventDefault();

            let id = $('#edit_id').val();
            let url = "{{ route('plan.feature.update', ':id') }}".replace(':id', id);

            let payload = {
                plan_id: $('#edit_plan_id').val(),
                feature: $('#edit_feature').val(),
                _token: '{{ csrf_token() }}',
                _method: 'POST' // IMPORTANT
            };

            axios.post(url, payload)
                .then(response => {
                    $('#editPlanFeatureModal').modal('hide');
                    $('#datatable').DataTable().ajax.reload(null, false);
                    toastr.success(response.data.message);
                })
                .catch(error => {
                    if (error.response?.status === 422) {
                        let errors = error.response.data.errors;

                        $('#edit_error_feature').text(errors?.feature?.[0] ?? '');
                        $('#edit_plan_id_error').text(errors?.plan_id?.[0] ?? '');
                    } else {
                        toastr.error('Update failed');
                    }
                });
        });

        {{-- Delete Confirm--}}
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

        {{-- Delete Button--}}
        function deleteItem(id) {
            let url = '{{ route('plan.feature.destroy', ':id') }}';
            let csrfToken = '{{ csrf_token() }}';
            $.ajax({
                type: "DELETE",
                url: url.replace(':id', id),
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function (resp) {
                    $('#datatable').DataTable().ajax.reload();
                    if (resp['t-success']) {
                        toastr.success(resp.message);
                    } else {
                        toastr.error(resp.message);
                    }
                },
                error: function (error) {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        }
    </script>
@endpush
