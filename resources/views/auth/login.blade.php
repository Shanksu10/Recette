@extends('base')

@section('title', 'Se connecter')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <h1 class="text-center text-muted mb-3 mt-5">Se connecter</h1>
                <p class="text-center text-muted mb-5">Vos recettes vous attends</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf <!-- Obligatoir pour protéger le formulaire -->
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @error('email')
                        <div class="alert alert-danger text-center" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                    @error('password')
                        <div class="alert alert-danger text-center" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                        <div>
                            <label class="mb-2" for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control mb-3 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>
                        <div>
                            <label class="mb-2" for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control mb-3 @error('password') is-invalid @enderror" required autocomplete="current-password">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="remember" name="remember" {{ old('remember') ? 'checked' : ""}}>
                                    <label class="form-check-label" for="remember">Rester connecter</label>
                                  </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Se connecter</button>
                        </div>
                        <p class="text-center text-muted mt-5">
                            Pas encore enregistrer ? <a href="{{route("register")}}">Créer un compte.</a>
                        </p>
                </form>
            </div>
        </div>
    </div>
@endsection

