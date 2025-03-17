@extends('admin-layouts.main')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Delivery Boys</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Delivery Boys</li>
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
                            <h3 class="card-title">List of Delivery Boys</h3>
                            <a href="{{ route('admin.delivery-boys.create') }}" class="btn btn-primary float-right">Add Delivery Boy</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Zip Code</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deliveryBoys as $key => $deliveryBoy)
                                        <tr id="delivery-row-{{ $deliveryBoy->id }}">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $deliveryBoy->zipCode->zip_code }}</td>
                                            <td>{{ $deliveryBoy->name }}</td>
                                            <td>{{ $deliveryBoy->address }}</td>
                                            <td>{{ $deliveryBoy->phone_number }}</td>
                                            <td>{{ $deliveryBoy->email }}</td>
                                            <td>
                                                <button class="btn btn-sm changeStatus {{ $deliveryBoy->status ? 'btn-success' : 'btn-danger' }}"
                                                    data-id="{{ $deliveryBoy->id }}">
                                                    {{ $deliveryBoy->status ? 'Active' : 'Inactive' }}
                                                </button>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.delivery-boys.show', $deliveryBoy->id) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('admin.delivery-boys.edit', $deliveryBoy->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                <button type="button" class="btn btn-sm btn-danger deleteDeliveryBoy" data-id="{{ $deliveryBoy->id }}"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {!! $deliveryBoys->appends($_GET)->links('pagination::bootstrap-4') !!}
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
            $(".changeStatus").click(function() {
                var deliveryBoyId = $(this).data("id");
                var button = $(this);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to change status!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Change it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('admin/delivery-boys') }}/" + deliveryBoyId + "/change-status",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    button.toggleClass('btn-success btn-danger');
                                    button.text(button.hasClass('btn-success') ? 'Active' : 'Inactive');
                                    Swal.fire('Updated!', response.message, 'success');
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            }
                        });
                    }
                });
            });

            $(".deleteDeliveryBoy").click(function() {
                var deliveryBoyId = $(this).data("id");

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
                            url: "{{ url('admin/delivery-boys') }}/" + deliveryBoyId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Deleted!', response.message, 'success');
                                    $("#delivery-row-" + deliveryBoyId).fadeOut(500);
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