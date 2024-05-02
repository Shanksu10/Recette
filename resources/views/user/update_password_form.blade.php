@extends('base')

@section('title', 'Mettre à jour votre mot de passe')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <h1 class="text-center text-muted mb-3 mt-5">Changer le mot de passe</h1>
                <form method="POST" action="{{ route('app_update_password') }}" class="row g-3" id="form-modif">
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
                    <div class="col-md-12">
                        <label for="current_password" class="form-label">Ancien mot de passe</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" value="" autofocus>
                        @error ('current_password')
                            <small class="text-danger fw-bold" id="error-register-current-password">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="" required autofocus>
                        @error ('password')
                            <small class="text-danger fw-bold" id="error-register-password">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="password_confirmation" class="form-label">Confirmation du mot de passe</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" value="" required autofocus>
                        @error ('password_confirmation')
                            <small class="text-danger fw-bold" id="error-register-password-confirmation">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="d-grid gap-2 mb-3">
                        <button class="btn btn-primary" type="submit" id="modif-user-info">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

