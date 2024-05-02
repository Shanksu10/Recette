@extends("base")

@section('title', 'Recette ajouter avec succès')

@section('content')
<div class="container">
        <div class="row mb-3">
            <div class="col-md-6 mx-auto ">
                 <p class="text-center text-muted mb-3">La recette a été ajoutée avec succès !</p>
                <div class="row">
                    <div class="col-md-6 mb-3">
                         <p><a href="{{route('app_add_new_recipe')}}">Ajouter une nouvelle recette?</a></p>
                    </div>
                    <div class="col-md-6 mb-3">
                         <p><a href="{{ route('app_user_recipes', Auth::user()->id) }}">Mon carnet des recettes?</a></p>
                    </div>

                </div>
            </div>
        </div>
 </div>


@endsection
