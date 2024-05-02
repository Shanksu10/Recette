@extends("base")

@section('title', 'Plat ajouté avec succès')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="alert alert-success text-center">
                Le plat a été ajouté avec succès !
            </div>
            <div class="text-center">
                <a href="{{ route('app_meal_create') }}" class="btn btn-primary mr-3">Ajouter un nouveau plat</a>
                <a href="{{ route('app_dashboard') }}" class="btn btn-primary">Afficher mon carnet personnalisé</a>
            </div>
        </div>
    </div>
</div>
@endsection
