@extends('layouts.user_type.guest')

@section('content')

<main class="main-content mt-0">
  <section>
    <div class="page-header min-vh-75">
      <div class="container">
        <div class="row">
          <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
            <div class="card card-plain mt-8">

              {{-- HEADER --}}
              <div class="card-header pb-0 text-left bg-transparent">
                <h4 class="font-weight-bolder text-info text-gradient">
                  {{ $organization->name }}
                </h4>
                <p class="mb-1 text-sm">
                  Tenant Login
                </p>
                <span class="badge bg-info mb-3">
                  {{ $organization->slug }}
                </span>
              </div>

              {{-- BODY --}}
              <div class="card-body">
                <form method="POST"
                      action="{{ route('organization.login.submit', $organization->slug) }}">
                  @csrf

                  {{-- hidden context --}}
                  <input type="hidden" name="organization_id" value="{{ $organization->id }}">
                  <input type="hidden" name="token" value="{{ $token }}">

                  {{-- Email --}}
                  <label>Email</label>
                  <div class="mb-3">
                    <input type="email"
                           class="form-control"
                           name="email"
                           placeholder="Email"
                           value="{{ old('email', $user->email ?? '') }}"
                           readonly>
                  </div>

                  {{-- Password --}}
                  <label>Password</label>
                  <div class="mb-3">
                    <input type="password"
                           class="form-control"
                           name="password"
                           placeholder="Password"
                           required>
                    @error('password')
                      <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                  </div>

                  {{-- Remember --}}
                  <div class="form-check form-switch">
                    <input class="form-check-input"
                           type="checkbox"
                           name="remember"
                           checked>
                    <label class="form-check-label">
                      Remember me
                    </label>
                  </div>

                  {{-- Submit --}}
                  <div class="text-center">
                    <button type="submit"
                            class="btn bg-gradient-info w-100 mt-4 mb-0">
                      Sign in to {{ $organization->name }}
                    </button>
                  </div>
                </form>
              </div>

              {{-- FOOTER --}}
              <div class="card-footer text-center pt-0 px-lg-2 px-1">
                <small class="text-muted">
                  This access is limited to
                  <b>{{ $organization->name }}</b>
                </small>
              </div>

            </div>
          </div>

          {{-- RIGHT IMAGE --}}
          <div class="col-md-6">
            <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
              <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                   style="background-image:url('{{ asset('assets/img/curved-images/curved6.jpg') }}')">
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
</main>

@endsection
