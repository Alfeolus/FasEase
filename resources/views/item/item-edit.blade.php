@extends('layouts.user_type.auth')

@section('content')

  <section class="min-vh-100 mb-8">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 mx-3 border-radius-lg" style="background-image: url('{{ asset('assets/img/curved-images/curved14.jpg') }}');">
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
              <h5>Edit existing item</h5>
            </div>
            <div class="card-body">
              <form role="form text-left" method="POST" action="{{ route('org.item-management-update', $data->slug) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                  <label for="name" class="form-label">Item Name</label>
                  <input type="text" class="form-control" placeholder="Item Name" name="name" id="name" aria-label="Name" aria-describedby="name" value="{{ old('name', $data->name) }}">
                  @error('name')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Item Description</label>
                    <textarea class="form-control" 
                              placeholder="Item Description (max 1000 characters)" 
                              name="description" 
                              id="description" 
                              rows="4">{{ old('description', $data->description) }}</textarea>

                    @error('description')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- <div class="mb-3">
                  <label for="quantity" class="form-label">Item Quantity</label>
                  <input type="number" class="form-control" placeholder="Item Quantity" name="quantity" id="quantity" aria-label="Quantity" aria-describedby="quantity" value="{{ old('quantity', $data->quantity) }}">
                  @error('quantity')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div> --}}

                <div class="mb-3">
                  <label for="max_book_duration" class="form-label">Max Book Duration (hours)</label>
                  <input type="number" class="form-control" placeholder="Max Book Duration (hours)" name="max_book_duration" id="max_book_duration" aria-label="Max Book Duration" aria-describedby="max_book_duration" value="{{ old('max_book_duration', $data->max_book_duration) }}">
                  @error('max_book_duration')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="opening_time" class="form-label">Opening Time</label>
                        <input type="time"
                              class="form-control"
                              name="opening_time"
                              id="opening_time"
                              value="{{ old('opening_time', $data->opening_time) }}">

                        @error('opening_time')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="closing_time" class="form-label">Closing Time</label>
                        <input type="time"
                              class="form-control"
                              name="closing_time"
                              id="closing_time"
                              value="{{ old('closing_time', $data->closing_time) }}">

                        @error('closing_time')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                  <label class="form-label d-block">Status</label>
                  
                  <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="is_active" id="active" value="1"
                          {{ old('is_active', $data->is_active ?? '') == '1' ? 'checked' : '' }}>
                      <label class="form-check-label" for="active">Available</label>
                  </div>

                  <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="is_active" id="nonactive" value="0"
                          {{ old('is_active', $data->is_active ?? '') == '0' ? 'checked' : '' }}>
                      <label class="form-check-label" for="nonactive">Unavailable</label>
                  </div>


                  @error('is_active')
                      <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="category" class="form-label">Category</label>
                  <select class="form-control" name="category_id" id="category_id" aria-label="Category" aria-describedby="category_id">
                    <option value="" disabled selected>Select Category</option>
                    @forelse($categories as $category)
                      <option value="{{ $category->id }}" {{ old('category_id', $data->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @empty
                      <option value="">No data</option>
                    @endforelse
                  </select>
                </div>

                <div class="mb-3">
                  <label for="image" class="form-label">Item Image</label>
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

