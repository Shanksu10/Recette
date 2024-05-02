@extends('base')

@section('title', 'Nouveau mot de passe')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <h1 class="text-center text-muted mb-3 mt-5">Changer le mot de passe</h1>
                <form method="POST" action="{{ route('password.update') }}" class="row g-3" id="form-modif">
                    @csrf <!-- Important -->
                    @if($errors->any())
                        <div class="alert alert-danger text-center" role="alert">
                            Modification échouée !
                        </div>
                    @endif
                    @if (session('success'))
                    <div class="alert alert-success text-center" role="alert">
                        {{session('success')}}
                    </div>
                    @endif
                    <input type="hidden" name="token" value="{{ request()->token }}">
                    <div class="col-md-12">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <small class="text-danger fw-bold" id="error-new-email" role="alert">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="" required autofocus>
                        @error ('password')
                            <small class="text-danger fw-bold" id="error-new-password">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="password_confirmation" class="form-label">Confirmation du mot de passe</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" value="" required autofocus>
                        @error ('password_confirmation')
                            <small class="text-danger fw-bold" id="error-new-password-confirmation">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="d-grid gap-2 mb-3">
                        <button class="btn btn-primary" type="submit" id="new-password-btn">Récupérer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

