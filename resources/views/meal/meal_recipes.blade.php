@extends("base")

@section('title', 'Recettes d\'un plat')

@section('content')
<div class="container">
    <h1 class="text-center text-muted mb-3 mt-5">Plat {{$name_meal}}</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse ($recipes as $recipe)
        <div class="col">
            <div id ="recipe-card" class="card">
                <a href="{{ route('app_recipe', $recipe['id_recipe']) }}" style="text-decoration:none;">
                    <img src="{{asset('assets/img/recipe/' . $recipe['picture_recipe'])}}" class="card-img-top cover rounded" alt="">
                </a>
                <div class="card-header text-center bg-light">
                    <h3 class="card-title">
                        <a href="{{ route('app_recipe', $recipe['id_recipe']) }}" style="text-decoration:none;">{{$recipe['name_recipe']}}</a>
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-center fw-bold">
                        @if ($loop->iteration == 1)
                            Entrée
                        @elseif ($loop->iteration == 2)
                            Plat Principal
                        @elseif ($loop->iteration == 3)
                            Dessert
                        @endif
                    </p>
                    <p class="card-text">Catégories:
                        @foreach ($recipe['categories'] as $index => $category)
                            <span><a href="{{route('app_recipes_of_category', $category->id)}}">{{$category->name_category_recipe}}</a></span>
                            @if (!$loop->last)
                            ,
                            @else
                            .
                            @endif
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
        @empty
        <div>Aucune recette dans ce plat.</div>
        @endforelse

    </div>
    @if(Auth::check() && Auth::user()->id === $meal_owner)
        <div class="d-flex justify-content-between my-3">
            <a href="{{route('app_old_meal', $id_meal)}}" class="btn btn-primary me-2 btn-block" id="btn-modifier">Modifier</a>
            <button class="btn btn-danger btn-block" id="btn-delete">Supprimer</button>
        </div>
    @endif
    <div class="popup-delete col-md-12" id="popup-delete">
        <div class="popup">
            <h4 class="message-delete mb-3">Voulez vous supprimer ce plat ?</h4>
            <div class="col d-flex justify-content-center">
                <a class="btn btn-outline-danger col-md-5 me-2" id="yes-delete" href="{{route('app_delete_meal', $id_meal)}}" role="button">Oui</a>
                <button id="no-delete" class="btn btn-outline-success col-md-5">Non</button>
            </div>
        </div>
    </div>
</div>
@endsection
