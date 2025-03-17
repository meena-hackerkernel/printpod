@extends('admin-layouts.main')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Delivery Boy</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.delivery-boys.index') }}">Delivery Boys</a></li>
                        <li class="breadcrumb-item active">Add</li>
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
                            <h3 class="card-title">Add New Delivery Boy</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.delivery-boys.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name"  value="{{ old('name') }}"  
                                      class="form-control @error('name') is-invalid @enderror">

                                      @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email"  value="{{ old('email') }}"  class="form-control @error('email') is-invalid @enderror">
                               
                                    @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" name="phone_number" value="{{ old('phone_number') }}" class="form-control @error('phone_number') is-invalid @enderror">
                               
                                    @error('phone_number')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" value="{{ old('address') }}"  class="form-control @error('address') is-invalid @enderror"></textarea>
                              
                                    @error('address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="zip_code_id">Zip Code</label>
                                    <select name="zip_code_id" class="form-control @error('zip_code_id') is-invalid @enderror">
                                        <option value="">Select Zip Code</option>
                                        @foreach ($zipCodes as $zipCode)
                                            <option value="{{ $zipCode->id }}" {{ old('zip_code_id') == $zipCode->id ? 'selected' : '' }}>
                                            {{ $zipCode->zip_code }}
                                        </option>
                                        @endforeach
                                    </select>

                                    @error('zip_code_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{ route('admin.delivery-boys.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
