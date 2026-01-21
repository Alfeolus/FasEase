@extends('layouts.user_type.guest')

@section('content')

<main class="main-content mt-0">
  <section>
    <div class="page-header min-vh-75">
      <div class="container">
        <div class="row">
          <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
            <div class="card card-plain mt-8">

              <div class="card-header pb-0 text-left bg-transparent">
                <h1 class="font-weight-bolder text-info text-gradient">
                  {{ $organization->name }}
                </h1>
                <p class="mb-1 text-sm">
                  Please sign in with your authorized account to securely access
                  the system and continue your activities.
                </p>
              </div>

              <div class="card-body">
                <form method="POST"
                      action="{{ route('organization.login.submit') }}">
                  @csrf

                  <input type="hidden" name="organization_id" value="{{ $organization->id }}">
                  <input type="hidden" name="token" value="{{ $token }}">

                  <label>Email</label>
                  <div class="mb-3">
                    <input type="email"
                           class="form-control"
                           name="email"
                           placeholder="Email">
                    @error('email')
                        <span class="text-danger text-xs mt-1 d-block">{{ $message }}</span>
                    @enderror
                  </div>

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

                  <div class="form-check form-switch">
                    <input class="form-check-input"
                           type="checkbox"
                           name="remember"
                           checked>
                    <label class="form-check-label">
                      Remember me
                    </label>
                  </div>

                  <div class="text-center">
                    <button type="submit"
                            class="btn bg-gradient-info w-100 mt-4 mb-0">
                      Sign in to {{ $organization->name }}
                    </button>
                  </div>
                </form>

                <div class="position-relative text-center my-4">
                    <p class="text-sm font-weight-bold mb-2 text-secondary text-border d-inline z-index-2 bg-white px-3">
                      OR
                    </p>
                  </div>
                  
                  <a href="{{ route('organization.google.login', $organization->token) }}" class="btn btn-white border w-100 mb-0">
                    <span class="me-2">
                        <svg width="18px" height="18px" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Artboard" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="google-icon" transform="translate(3.000000, 2.000000)" fill-rule="nonzero">
                                    <path d="M57.8123233,30.1515267 C57.8123233,27.7263183 57.6155321,25.9565533 57.1896408,24.1212666 L29.4960833,24.1212666 L29.4960833,35.0674653 L45.7515771,35.0674653 C45.4239683,37.7877475 43.6542033,41.8844383 39.7213169,44.6372555 L39.6661883,45.0037254 L48.4223791,51.7870338 L49.0290201,51.8475849 C54.6004021,46.7020943 57.8123233,39.1313952 57.8123233,30.1515267" id="Path" fill="#4285F4"></path>
                                    <path d="M29.4960833,58.9921667 C37.4599129,58.9921667 44.1456164,56.3701671 49.0290201,51.8475849 L39.7213169,44.6372555 C37.2305867,46.3742596 33.887622,47.5868638 29.4960833,47.5868638 C21.6960582,47.5868638 15.0758763,42.4415991 12.7159637,35.3297782 L12.3700541,35.3591501 L3.26524241,42.4054492 L3.14617358,42.736447 C7.9965904,52.3717589 17.959737,58.9921667 29.4960833,58.9921667" id="Path" fill="#34A853"></path>
                                    <path d="M12.7159637,35.3297782 C12.0932812,33.4944915 11.7329116,31.5279353 11.7329116,29.4960833 C11.7329116,27.4640054 12.0932812,25.4976752 12.6832029,23.6623884 L12.6667095,23.2715173 L3.44779955,16.1120237 L3.14617358,16.2554937 C1.14708246,20.2539019 0,24.7439491 0,29.4960833 C0,34.2482175 1.14708246,38.7380388 3.14617358,42.736447 L12.7159637,35.3297782" id="Path" fill="#FBBC05"></path>
                                    <path d="M29.4960833,11.4050769 C35.0347044,11.4050769 38.7707997,13.7975244 40.9011602,15.7968415 L49.2255853,7.66898166 C44.1130815,2.91684746 37.4599129,0 29.4960833,0 C17.959737,0 7.9965904,6.62018183 3.14617358,16.2554937 L12.6832029,23.6623884 C15.0758763,16.5505675 21.6960582,11.4050769 29.4960833,11.4050769" id="Path" fill="#EB4335"></path>
                                </g>
                            </g>
                        </svg>
                    </span>
                    Sign in with Google
                  </a>
              </div>

              <div class="card-footer text-center pt-0 px-lg-2 px-1">
                <small class="text-muted">Forgot you password? Reset you password 
                  <a href="/login/forgot-password" class="text-info text-gradient font-weight-bold">here</a>
                </small>
                  <p class="mb-4 text-sm mx-auto">
                    Don't have an account?
                    <a href="{{ route('organization.register-index', $token) }}" class="text-info text-gradient font-weight-bold">Sign up</a>
                  </p>
              </div>

            </div>
          </div>

          <div class="col-md-6">
            <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
              <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                   style="background-image:url('{{ asset('assets/img/curved-images/bg-2.png') }}')">
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
</main>

@endsection
