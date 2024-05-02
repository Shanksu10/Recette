@extends('base')

@section('title', 'S\'enregistrer')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <h1 class="text-center text-muted mb-3 mt-5">S'enregistrer</h1>
                <p class="text-center text-muted mb-5">Créer un compte si vous ne possèdez aucun</p>

                <form method="POST" action="{{ route('register') }}" class="row g-3" id="form-register" enctype="multipart/form-data">
                    @csrf <!-- Important -->
                    @if($errors->any())
                        <div class="alert alert-danger text-center">
                            Enregistrement échoué.
                        </div>
                    @endif
                    <div class="col-md-6">
                        <label for="firstName" class="form-label">Prénom</label>
                        <input type="text" class="form-control @error('firstName') is-invalid @enderror" id="firstName" name="firstName" value="{{old('firstName')}}" required autocomplete="firstName" autofocus>
                        @error ('firstName')
                            <small class="text-danger fw-bold" id="error-register-firstName">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="lastName" class="form-label">Nom</label>
                        <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName" name="lastName" value="{{old('lastName')}}" required autocomplete="lastName">
                        @error ('lastName')
                            <small class="text-danger fw-bold" id="error-register-lastName">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}" required autocomplete="email">
                        @error ('email')
                            <small class="text-danger fw-bold" id="error-register-email">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{old('password')}}" required autocomplete="password">
                        @error ('password')
                            <small class="text-danger fw-bold" id="error-register-password">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirmation mot de passe</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" value="{{old('password_confirmation')}}" required>
                        @error ('password_confirmation')
                            <small class="text-danger fw-bold" id="error-register-password-confirmation">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="birthday">Date de naissance</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') }}"
                                aria-describedby="birthday_feedback"
                                class="form-control @error('birthday') is-invalid @enderror" required>
                            @error('birthday')
                            <small class="text-danger fw-bold" id="error-register-birthday">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="picture" class="form-label">Choisissez votre photo de profile</label>
                            <input class="form-control" type="file" id="picture-user" name="picture">
                            @error('picture')
                            <small class="text-danger fw-bold" id="error-register-picture">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input @error('agreeTerms') is-invalid @enderror" type="checkbox" name="agreeTerms" id="agreeTerms">
                            <label class="form-check-label" for="agreeTerms">Accepter les conditions</label><br>
                            @error('agreeTerms')
                            {{$message}}
                            <small class="text-danger fw-bold" id="error-register-agreeTerms">il faut accepter les conditions</small>
                            @enderror
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit" id="register-user">S'enregistrer</button>
                    </div>
                    <p class="text-center text-muted mt-5">
                        Avez-vous déjà un compte ? <a href="{{ route('login')}}">connectez-vous.</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection

