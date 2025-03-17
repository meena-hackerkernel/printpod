@extends('admin-layouts.main')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Delivery Boy</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.delivery-boys.index') }}">Delivery Boys</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Update Delivery Boy</h3>
                        </div>
                        <div class="card-body">
                            <form id="updateDeliveryBoyForm" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="zip_code_id">Zip Code</label>
                                    <select name="zip_code_id" id="zip_code_id" class="form-control">
                                        @foreach ($zipCodes as $zipCode)
                                            <option value="{{ $zipCode->id }}"
                                                {{ $deliveryBoy->zip_code_id == $zipCode->id ? 'selected' : '' }}>
                                                {{ $zipCode->zip_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ $deliveryBoy->name }}">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        value="{{ $deliveryBoy->email }}">
                                </div>

                                <div class="form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" name="phone_number" class="form-control" id="phone_number"
                                        value="{{ $deliveryBoy->phone_number }}">
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control" required>{{ $deliveryBoy->address }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ $deliveryBoy->status ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$deliveryBoy->status ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('admin.delivery-boys.index') }}" class="btn btn-secondary">Cancel</a>
                            </form>
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
            $("#updateDeliveryBoyForm").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                var updateUrl = "{{ route('admin.delivery-boys.update', $deliveryBoy->id) }}";

                $.ajax({
                    url: updateUrl,
                    type: "PUT",
                    data: formData,
                    success: function(response) {
                        Swal.fire('Success!', response.message, 'success')
                            .then(() => window.location.href = "{{ route('admin.delivery-boys.index') }}");
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
                    }
                });
            });
        });
    </script>
@endsection
