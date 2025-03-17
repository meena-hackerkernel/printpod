@extends('admin-layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Vendor</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Vendor</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <form id="vendorEditForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="vendor_id" value="{{ $vendor->id }}">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            value="{{ $vendor->name }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            value="{{ $vendor->email }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <label for="phone_number">phone_number</label>
                                        <input type="number" id="phone_number" name="phone_number" class="form-control"
                                            value="{{ $vendor->phone_number }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <label for="address">Address</label>
                                        <input type="text" id="address" name="address" class="form-control"
                                            value="{{ $vendor->address }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <label for="zip_code">Zip Code</label>
                                        <select id="zip_code" name="zip_code" class="form-control" required>
                                            @foreach($zipCodes as $zip)
                                                <option value="{{ $zip->id }}" 
                                                    {{ $vendor->zip_code_id == $zip->id ? 'selected' : '' }}>
                                                    {{ $zip->zip_code }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <label for="status">Status</label>
                                        <select id="status" name="status" class="form-control">
                                            <option value="1" {{ $vendor->status ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ !$vendor->status ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <button type="button" class="btn btn-primary" id="updateButton">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#updateButton').click(function() {
                updateVendor();
            });

            function updateVendor() {
                var vendorId = $('#vendor_id').val();
                var formData = {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    phone_number: $('#phone_number').val(),
                    address: $('#address').val(),
                    zip_code_id: $('#zip_code').val(),
                    status: $('#status').val(),
                    _method: 'PUT',
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    url: "{{ url('admin/vendors') }}/" + vendorId,
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            }).then(() => {
                                window.location.href = "{{ route('admin.vendors.index') }}";
                            });
                        } else {
                            showErrorMessages(response.errors);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            showErrorMessages(xhr.responseJSON.errors);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while updating the vendor.',
                            });
                        }
                    }
                });
            }

            function showErrorMessages(errors) {
                var errorList = '';
                $.each(errors, function(key, value) {
                    errorList += '<li>' + value[0] + '</li>';
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Errors',
                    html: '<ul>' + errorList + '</ul>',
                });
            }
        });
    </script>
@endsection
