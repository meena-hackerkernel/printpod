@extends('admin-layouts.main')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Vendors</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Vendors</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Vendors</h3>
                            <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary float-right">Add Vendor</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Zip Code</th>
                                        <th>Vendor Name</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vendors as $key => $vendor)
                                        <tr id="vendor-row-{{ $vendor->id }}">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $vendor->zipCode->zip_code }}</td>
                                            <td>{{ $vendor->name }}</td>
                                            <td>{{ $vendor->address }}</td>
                                            <td>{{ $vendor->phone_number }}</td>
                                            <td>{{ $vendor->email }}</td>
                                            <td>
                                                <button class="btn btn-sm statusToggle"
                                                    data-id="{{ $vendor->id }}"
                                                    data-status="{{ $vendor->status }}">
                                                    {!! $vendor->status
                                                        ? '<span class="badge badge-success">Active</span>'
                                                        : '<span class="badge badge-danger">Inactive</span>' !!}
                                                </button>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.vendors.show', $vendor->id) }}"
                                                    class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('admin.vendors.edit', $vendor->id) }}"
                                                    class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                <button type="button" class="btn btn-sm btn-danger deleteVendor"
                                                    data-id="{{ $vendor->id }}"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {!! $vendors->appends($_GET)->links('pagination::bootstrap-4') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Change Vendor Status via AJAX
            $(".statusToggle").click(function() {
                var vendorId = $(this).data("id");
                var button = $(this);

                $.ajax({
                    url: "{{ route('admin.vendors.status', '') }}/" + vendorId,
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Updated!', response.message, 'success');

                            // Toggle status button dynamically
                            if (button.data("status") == 1) {
                                button.html('<span class="badge badge-danger">Inactive</span>');
                                button.data("status", 0);
                            } else {
                                button.html('<span class="badge badge-success">Active</span>');
                                button.data("status", 1);
                            }
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    }
                });
            });

            // Delete Vendor via AJAX
            $(".deleteVendor").click(function() {
                var vendorId = $(this).data("id");

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
                        $.ajax({
                            url: "{{ url('admin/vendors') }}/" + vendorId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Deleted!', response.message, 'success');
                                    $("#vendor-row-" + vendorId).fadeOut(500);
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
