@extends('base')

@section('title', 'Suppression de votre compte')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <h1 class="text-center text-muted mb-3 mt-5">Supprimer mon compte</h1>
                <form method="POST" action="{{ route('app_delete_account') }}" class="row g-3" id="form-modif">
                    @csrf <!-- Important -->
                    @if($errors->any())
                        <div class="alert alert-danger text-center" role="alert">
                            Nous n'avons pas pu supprimer votre compte !
                        </div>
                    @endif
                    <div class="col-md-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="" autofocus>
                        @error ('email')
                            <small class="text-danger fw-bold" id="error-register-current-password">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="" required autofocus>
                        @error ('password')
                            <small class="text-danger fw-bold" id="error-register-password">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="d-grid gap-2 mb-3">
                        <button class="btn btn-danger" type="submit" id="modif-user-info">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

