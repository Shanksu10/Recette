@extends('base')

@section('title', 'Mot de passe oublié')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <h1 class="text-center text-muted mb-3 mt-5">Mot de passe oublié</h1>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf <!-- Obligatoir pour protéger le formulaire -->
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @error('email')
                        <div class="alert alert-danger text-center" role="alert">
                            {{ $message }}
                        </div>
                    @enderror

                        <div>
                            <label class="mb-2" for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control mb-3 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Envoyer le mot de passe</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

