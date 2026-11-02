@extends('backend.app')

@section('title', 'Plan')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Plan List</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">Plan</li>
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
                                <th class="wd-15p border-bottom-0">Name</th>
                                <th class="wd-15p border-bottom-0">Price</th>
                                <th class="wd-15p border-bottom-0">Currency</th>
                                <th class="wd-15p border-bottom-0">Type</th>
                                <th class="wd-15p border-bottom-0">Interval</th>
                                <th class="wd-15p border-bottom-0">Paypal Product ID</th>
                                <th class="wd-15p border-bottom-0">Paypal Plan ID</th>
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
        <div class="modal fade" id="createForm" tabindex="-1" aria-labelledby="createPlanLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="createPlanForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createPlanLabel">Create Plan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="create_name" placeholder="Enter plan name">
                                <span class="text-danger" id="create_name_error"></span>
                            </div>

                            <!-- Price -->
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control" id="create_price" placeholder="Enter price">
                                <span class="text-danger" id="create_price_error"></span>
                            </div>


                            <!-- Type -->
                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <select class="form-select" id="create_type">
                                    <option value="">-- Select Type --</option>
                                    <option value="subscription">Subscription</option>
                                    <option value="one_time">One Time</option>
                                </select>
                                <span class="text-danger" id="create_type_error"></span>
                            </div>


                            <!-- Interval -->
                            <div class="mb-3">
                                <label class="form-label">Interval</label>
                                <select class="form-select" id="create_interval">
                                    <option value="">-- Select Interval --</option>
                                    <option value="MONTH">Monthly</option>
                                    <option value="YEAR">Yearly</option>
                                </select>
                                <span class="text-danger" id="create_interval_error"></span>
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
        <div class="modal fade" id="editPlanModal" tabindex="-1" aria-labelledby="editPlanLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editPlanForm">
                        @csrf
                        <input type="hidden" id="edit_id">

                        <div class="modal-header">
                            <h5 class="modal-title" id="editPlanLabel">Edit Artist</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="edit_name">
                                <span class="text-danger" id="edit_error_name"></span>
                            </div>

                            <!-- Price -->
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control" id="edit_price" placeholder="Enter price">
                                <span class="text-danger" id="create_price_error"></span>
                            </div>


                            <!-- Type -->
                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <select class="form-select" id="edit_type">
                                    <option value="">-- Select Type --</option>
                                    <option value="subscription">Subscription</option>
                                    <option value="one_time">One Time</option>
                                </select>
                                <span class="text-danger" id="create_type_error"></span>
                            </div>


                            <!-- Interval -->
                            <div class="mb-3">
                                <label class="form-label">Interval</label>
                                <select class="form-select" id="edit_interval">
                                    <option value="">-- Select Interval --</option>
                                    <option value="MONTH">Monthly</option>
                                    <option value="YEAR">Yearly</option>
                                </select>
                                <span class="text-danger" id="create_interval_error"></span>
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
                        url: "{{ route('plan.index') }}",
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
                            data: 'name',
                            name: 'name',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'price',
                            name: 'price',
                            orderable: true,
                            searchable: true
                        }, {
                            data: 'currency',
                            name: 'currency',
                            orderable: true,
                            searchable: true
                        }, {
                            data: 'type',
                            name: 'type',
                            orderable: true,
                            searchable: true
                        }, {
                            data: 'interval',
                            name: 'interval',
                            orderable: true,
                            searchable: true
                        }, {
                            data: 'paypal_product_id',
                            name: 'paypal_product_id',
                            orderable: true,
                            searchable: true
                        }, {
                            data: 'paypal_plan_id',
                            name: 'paypal_plan_id',
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
        $('#createPlanForm').on('submit', function (e) {
            e.preventDefault();

            let $form = $(this);
            let name = $('#create_name').val();
            let price = $('#create_price').val();
            let type = $('#create_type').val();
            let interval = $('#create_interval').val();

            // Clear previous errors
            $('#create_error_name').text('');
            $('#create_error_price').text('');
            $('#create_error_type').text('');
            $('#create_error_interval').text('');

            axios.post("{{ route('plan.store') }}", {name: name, price: price, type: type, interval: interval})
                .then(function (response) {
                    // Close modal using jQuery + Bootstrap 5
                    $('#createForm').modal('hide');

                    // Reset form
                    $form[0].reset();

                    // Reload DataTable
                    $('#datatable').DataTable().ajax.reload();

                    // Success toast
                    toastr.success('Plan created successfully');
                })
                .catch(function (error) {
                    if (error.response && error.response.status === 422 && error.response.data.errors.name) {
                        $('#create_error_name').text(error.response.data.errors.name[0]);
                    } else {
                        toastr.error('Failed to create Plan');
                    }
                });
        });


        {{-- Edit --}}
        function openEditModal(id) {
            let url = "{{ route('plan.edit', ':id') }}";
            url = url.replace(':id', id);

            axios.get(url)
                .then(response => {
                    const data = response.data;

                    // Fill inputs
                    $('#edit_id').val(data.id);
                    $('#edit_name').val(data.name);
                    $('#edit_price').val(data.price);
                    $('#edit_type').val(data.type);
                    $('#edit_interval').val(data.interval);

                    // Clear old errors
                    $('#edit_error_name').text('');
                    $('#create_price_error').text('');
                    $('#create_type_error').text('');
                    $('#create_interval_error').text('');

                    // Show modal
                    $('#editPlanModal').modal('show');
                })
                .catch(error => {
                    console.error(error);
                    toastr.error('Failed to load plan data');
                });
        }


          // update
        $('#editPlanForm').on('submit', function (e) {
            e.preventDefault();

            let id = $('#edit_id').val();
            let url = "{{ route('plan.update', ':id') }}";
            url = url.replace(':id', id);

            // Prepare payload
            let payload = {
                name: $('#edit_name').val(),
                price: $('#edit_price').val(),
                type: $('#edit_type').val(),
                interval: $('#edit_interval').val(),
                _token: '{{ csrf_token() }}'
            };

            axios.post(url, payload)
                .then(response => {
                    $('#editPlanModal').modal('hide'); // Correct modal ID
                    $('#datatable').DataTable().ajax.reload(null, false); // reload table without resetting pagination
                    toastr.success(response.data.message ?? 'Plan updated successfully');
                })
                .catch(error => {
                    if (error.response?.status === 422) {
                        // Validation errors
                        let errors = error.response.data.errors;

                        $('#edit_error_name').text(errors?.name?.[0] ?? '');
                        $('#create_price_error').text(errors?.price?.[0] ?? '');
                        $('#create_type_error').text(errors?.type?.[0] ?? '');
                        $('#create_interval_error').text(errors?.interval?.[0] ?? '');
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
            let url = '{{ route('plan.destroy', ':id') }}';
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
