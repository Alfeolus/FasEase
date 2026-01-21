@extends('layouts.user_type.auth')

@section('content')

  <section class="min-vh-100 mb-8">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 mx-3 border-radius-lg" style="background-image: url('{{ asset('assets/img/curved-images/bg-2.png') }}');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10">
        <div class="col-xl-7 col-lg-7 col-md-9 mx-auto">
          <div class="card z-index-0">
            <div class="card-header text-center pt-4">
              <h5>Edit existing organization</h5>
            </div>
            <div class="card-body">
              <form role="form text-left" method="POST" action="{{ route('organization-management-update', $data->slug) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                  <label for="name" class="form-label">Organization Name</label>
                  <input type="text" class="form-control" placeholder="Organization Name" name="name" id="name" aria-label="Name" aria-describedby="name" value="{{ old('name', $data->name) }}">
                  @error('name')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="slug" class="form-label">Organization Slug</label>
                  <input disabled type="text" class="form-control" placeholder="Organization Slug" name="slug" id="slug" aria-label="Slug" aria-describedby="slug" value="{{ old('slug', $data->slug) }}">
                  @error('slug')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="email" class="form-label">Organization Email</label>
                  <input type="email" class="form-control" placeholder="Organization Email" name="email" id="email" aria-label="Organization Email" aria-describedby="email" value="{{ old('email', $data->email) }}">
                  @error('email')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="phone" class="form-label">Organization Phone</label>
                  <input type="number" class="form-control" placeholder="Organization Phone" name="phone" id="phone" aria-label="Organization Phone" aria-describedby="phone" value="{{ old('phone', $data->phone) }}">
                  @error('phone')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="location" class="form-label">Organization Location</label>
                  <input type="text" class="form-control" placeholder="Organization Location" name="location" id="location" aria-label="Organization Location" aria-describedby="location" value="{{ old('location', $data->location) }}">
                  @error('location')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="image" class="form-label">Organization Image</label>
                  <input type="file" class="form-control" name="image" id="image" aria-label="Image">
                  @error('image')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>
                
                <div class="text-center">
                  <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Save Changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection

