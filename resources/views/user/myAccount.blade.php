@extends('base')

@section('title', 'Mon compte')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <h1 class="text-center text-muted mb-3 mt-5">Informations personnels</h1>
                <form method="POST" action="{{route('app_modificating_account')}}" class="row g-3" id="form-modif" enctype="multipart/form-data">
                    @csrf <!-- Important -->
                    @if($errors->any())
                        <div class="alert alert-danger text-center" role="alert">
                            Mise à jour échouée !
                        </div>
                    @endif
                    @if (session('success'))
                    <div class="alert alert-success text-center" role="alert">
                        {{session('success')}}
                    </div>
                    @endif
                    <div class="col-md-6">
                        <label for="firstNameModif" class="form-label">Prénom</label>
                        <input type="text" class="form-control @error('firstNameModif') is-invalid @enderror" id="firstNameModif" name="firstNameModif" value="{{$user->first_name}}" required autocomplete="firstNameModif" autofocus>
                        @error ('firstNameModif')
                            <small class="text-danger fw-bold" id="error-register-firstNameModif">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="lastNameModif" class="form-label">Nom</label>
                        <input type="text" class="form-control @error('lastNameModif') is-invalid @enderror" id="lastNameModif" name="lastNameModif" value="{{$user->last_name}}" required autocomplete="lastNameModif" autofocus>
                        @error ('lastNameModif')
                            <small class="text-danger fw-bold" id="error-register-lastNameModif">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="emailModif" class="form-label">Email</label>
                        <input type="emailModif" class="form-control" id="emailModif" name="emailModif" value="{{$user->email}}" disabled>
                        @error ('emailModif')
                            <small class="text-danger fw-bold" id="error-register-emailModif">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="birthdayModif">Date de naissance</label>
                            <input type="date" class="form-control" id="birthdayModif" name="birthdayModif" value="{{ $user->birthday }}"
                                aria-describedby="birthdayModif_feedback"
                                class="form-control @error('birthdayModif') is-invalid @enderror" required>
                            @error('birthdayModif')
                            <small class="text-danger fw-bold" id="error-register-birthdayModif">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="pictureModif" class="form-label">Photo de profile: <small>{{$user->picture}}</small></label>
                            <input class="form-control" type="file" id="pictureModif-user" name="pictureModif">
                            @error('pictureModif')
                            <small class="text-danger fw-bold" id="error-pictureModif-user">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit" id="modif-user-info">Modifier</button>
                    </div>
                    <div class="d-grid gap-2">
                        <a class="btn btn-primary" href="{{ route('app_update_password_form') }}" role="button" id="register-user">Changer le mot de passe</a>
                    </div>
                    <div class="d-grid gap-2 mb-3">
                        <a class="btn btn-danger" href="{{ route('app_delete_account_form') }}" role="button" id="register-user">Supprimer mon compte</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

