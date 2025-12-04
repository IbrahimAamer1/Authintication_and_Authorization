
@section('title')
    front reset password page
@endsection
@section('logo')
    front
@endsection
<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('assets-front') }}/"
  data-template="vertical-menu-template-free"
>
    @include('front.partials.AuthHead')
  <body>
   <!-- Content -->

   <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
          <!-- Forgot Password -->
          <div class="card">
            <div class="card-body">
                @include('front.partials.AuthLogo')
              <h4 class="mb-2">Reset Password</h4>
              <p class="mb-4">Enter your new password</p>


              <x-auth-session-status class="mb-4" :status="session('status')" />
              <form id="formAuthentication" class="mb-3" action="{{ route('password.store') }}" method="POST">
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                @csrf
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input
                    type="email " 
                    class="form-control"
                    id="email"
                    name="email" 
                    placeholder="Enter your email"
                    autofocus 
                    value="{{ old('email', $request->email) }}" readonly
                  />
                  <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <!-- Password -->
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                  <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <!-- Confirm Password -->
                <div class="mb-3">
                  <label for="password_confirmation" class="form-label">Confirm Password</label>
                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                  <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <button type="submit" class="btn btn-primary d-grid w-100">Reset Password</button>
              </form>
              
            </div>
          </div>
          <!-- /Forgot Password -->
        </div>
      </div>
    </div>

    <!-- / Content -->

   

    @include('front.partials.AuthScripts')
  </body>
</html>
