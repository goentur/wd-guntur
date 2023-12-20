@extends('auth.app')

@section('content')

<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label fw-bold">Nama</label>
        <input class="form-control form-control-lg @error('name') is-invalid @enderror" required type="name" id="name" name="name" value="{{ old('name') }}" placeholder="Masukan nama anda" autofocus />
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Email</label>
        <input class="form-control form-control-lg @error('email') is-invalid @enderror" required type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukan email anda" />
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Password</label>
        <input class="form-control form-control-lg @error('password') is-invalid @enderror" required type="password" id="password" name="password" placeholder="Masukan password anda" />
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Ulangi Password</label>
        <input class="form-control form-control-lg" required type="password" id="password" name="password_confirmation" placeholder="Masukan ulangi password anda" />
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Captcha</label>
        <div class="input-group">
            <div class="input-group-prepend">
                {!! captcha_img('flat') !!}
            </div>
            <input class="form-control form-control-lg @error('captcha') is-invalid @enderror" autocomplete="off" minlength="6" maxlength="6" required type="text" id="captcha" name="captcha" placeholder="Masukan captcha" />
            @error('captcha')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="text-center mt-3">
        <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-user"></i> Daftar</button>
        <a href="{{ route('login') }}" class="btn btn-lg btn-success"><i class="fa fa-sign-in-alt"></i> Login</a>
    </div>
</form>
@endsection