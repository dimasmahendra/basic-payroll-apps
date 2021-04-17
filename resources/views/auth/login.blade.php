@extends('layouts.auth')

@section('body')

@if ($errors->has('all'))
    <div class="alert alert-danger">
        <strong>{{ $errors->first('all') }}</strong>
    </div>
@endif

<form class="form-horizontal auth-form my-4" action="" method="POST">
    @csrf
    <div class="form-group">
        <label for="email">Email</label>
        <div class="input-group mb-3">
        <input type="text" class="form-control" name="email" id="email" placeholder="Masukkan email" value="{{ old('email') }}" autofocus />
        </div>
        @if ($errors->has('email'))
            <span class="text-danger">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
  </div>
  <div class="form-group">
        <label for="userpassword">Password</label>
        <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" id="userpassword" placeholder="Masukkan password" />
        </div>
        @if ($errors->has('password'))
            <span class="text-danger">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
  </div>
  <div class="form-group mb-0 mt-2 row">
      <div class="col-12">
          <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Masuk<i class="fas fa-sign-in-alt ml-1"></i></button>
      </div>
      <div class="col-12 mt-5 text-center">
          <span>Belum punya akun?</span>
          <a href="{{ route('register') }}" class="text-blue">Daftar di sini!</a>
      </div>
  </div>
</form>
@endsection
