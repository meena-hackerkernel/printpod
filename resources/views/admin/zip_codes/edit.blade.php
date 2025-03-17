@extends('admin-layouts.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Zip Code</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Zip Code</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <form id="zipCodeEditForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="zip_id" value="{{ $zipCode->id }}">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <label for="zip_code">Zip Code</label>
                                        <input type="number" id="zip_code" name="zip_code" class="form-control"
                                            value="{{ $zipCode->zip_code }}" required>
                                    </div>
                                </div>
                                {{-- <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <label for="city">City</label>
                                        <input type="text" id="city" name="city" class="form-control"
                                            value="{{ $zipCode->city }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <label for="state">State</label>
                                        <input type="text" id="state" name="state" class="form-control"
                                            value="{{ $zipCode->state }}" required>
                                    </div>
                                </div> --}}
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
                updateZipCode();
            });

            function updateZipCode() {
                var zipId = $('#zip_id').val();
                var formData = {
                    zip_code: $('#zip_code').val(),
                    // city: $('#city').val(),
                    // state: $('#state').val(),
                    _method: 'PUT',
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    url: "{{ url('admin/zip-codes') }}/" + zipId,
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            }).then(() => {
                                window.location.href = "{{ route('admin.zip-codes.index') }}";
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
                                text: 'An error occurred while updating the ZIP Code.',
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
