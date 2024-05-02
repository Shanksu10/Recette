@extends('base')

@section('title', 'Carnet personnalisé')

@section('content')
<div class="container">
    <div class="row">
        <h1 class="text-center text-muted mb-3 mt-5">Bonjour {{$user['first_name']}}</h1>
        <div class="row">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-md-7">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <div class="d-flex text-black">
                                <div class="flex-shrink-0">
                                    @if (Auth::user()->picture != null)
                                        <img src="{{asset("assets/img/user/".Auth::user()->picture)}}"
                                        alt="Generic placeholder image" class="img-fluid"
                                        style="width: 200px; border-radius: 10px; clip-path:circle();">
                                    @else
                                        <img src="{{asset('assets/img/login_logo.png')}}"
                                        alt="Generic placeholder image" class="img-fluid"
                                        style="width: 180px; border-radius: 10px;">
                                    @endif

                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1">{{$user['first_name'] . " " . $user['last_name']}}</h5>
                                    <p class="mb-2 pb-1" style="color: #2b2a2a;">{{$age}} ans</p>
                                    <div class="d-flex justify-content-center rounded-3 p-2 mb-2" style="background-color: #efefef;">
                                        <div class="col-md-3 ms-5">
                                            <p class="small text-muted mb-1">Recettes</p>
                                            <p class="mb-0">{{$countUserRecipes}}</p>
                                        </div>
                                        <div class="col-md-3 ms-4">
                                            <p class="small text-muted mb-1">Plats</p>
                                            <p class="mb-0">{{$countUserMeals}}</p>
                                        </div>
                                        <div class="col-md-3">
                                            <p class="small text-muted mb-1">Favorites</p>
                                            <p class="mb-0">{{$countUserFavoriteRecipes}}</p>
                                        </div>
                                    </div>
                                    <form action="{{ route('app_my_account') }}" method="get">
                                        <div class="d-flex pt-1">
                                            <button type="submit" class="btn btn-outline-primary me-1 flex-grow-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear-fill me-2" viewBox="0 0 16 16">
                                                <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                            </svg> Modifier
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h2 class="text-center text-muted mb-3 mt-5 ">Vos recette favorites</h2>
        @if ($userFavoriteRecipes->count() > 0)
            <div class="card my-5 border-0 rounded-0" id="carousel-favorites">
                <div class="card-body d-flex justify-content-center">
                    <div id="carouselFade" class="carousel slide carousel-fade col-md-7" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($userFavoriteRecipes as $recipe)
                            <div class="carousel-item @if ($loop->first) active @endif">
                                <a href="{{ route('app_recipe', $recipe->id) }}">
                                    <img src="{{asset('assets/img/recipe/' . $recipe->picture)}}" class="card-img-top d-block w-100 cover rounded" alt="">
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselFade" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Précédent</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselFade" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Suivant</span>
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="d-flex justify-content-center">
                Améliorez votre carnet personnel en adorant des recettes.
            </div>
        @endif
        <div class="col-md-6 d-flex justify-content-start">
            <div class="">
                <a class="btn btn-primary" href="{{ route('app_favorites_recipes_of_user', $user->id) }}" role="button">Consultez vos recettes favorites</a>
            </div>
        </div>
    </div>
    <div class="row">
        <h2 class="text-center text-muted mb-3 mt-5">Vos recettes</h2>
        <div class="row gy-3">
            @forelse ($userRecipes as $recipe)
                <div class="col-md-4">
                    <div class="card h-100" style="width: 18rem;">
                        <a href="{{ route('app_recipe', $recipe->id) }}">
                            <img src="{{asset('assets/img/recipe/'. $recipe->picture)}}" class="card-img-top mt-0" alt="...">
                        </a>
                        <div class="card-body">
                        <h5 class="card-title"><a href="{{ route('app_recipe', $recipe->id) }}">{{$recipe->name}}</a></h5>
                        <p class="card-text">{{$recipe->description_recipe}}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="d-flex justify-content-center">Vous n'avez créé aucune recette.</div>
            @endforelse
        </div>
        <div class="row g-2">
            @if ($userRecipes->count() > 0)
                <div class="col-md-6 d-flex justify-content-center">
                    <div class="">
                        <a class="btn btn-primary" href="{{ route('app_recipes_of_user', $user->id) }}" role="button">Consultez vos recettes</a>
                    </div>
                </div>
                <div class="col-md-6 d-flex justify-content-center">
                    <div class="">
                        <a class="btn btn-primary" href="{{route('app_add_new_recipe')}}" role="button">Ajouter une recette</a>
                    </div>
                </div>
            @else
            <div class="d-flex justify-content-center">
                <div class="">
                    <a class="btn btn-primary" href="{{route('app_add_new_recipe')}}" role="button">Ajouter une recette</a>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="row mb-3">
        <h2 class="text-center text-muted mb-3 mt-5">Vos plats</h2>
        <div class="row gy-3">
            @forelse ($userMeals as $meal)
            <div class="col-md-4">
                <div class="card h-100" style="width: 18rem;">
                    <a href="{{ route('app_meal_recipes', ['id' => $meal->id]) }}">
                        <img src="{{asset('assets/img/meal/'. $meal->picture_meal)}}" class="card-img-top mt-0" alt="...">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('app_meal_recipes', ['id' => $meal->id]) }}">{{$meal->name_meal}}</a>
                        </h5>
                        <div class="card-text">
                            Catégories:
                            @foreach ($mealsWithCategories[$meal->id] as $category)
                                    <span><a href="{{route('app_meals_of_category', $category->id)}}">{{$category->name_category_meal}}</a></span>
                                    @if (!$loop->last)
                                        ,
                                    @else
                                    .
                                    @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="d-flex justify-content-center">Vous n'avez créé aucun plat.</div>
            @endforelse
        </div>
        <div class="row g-2">
            @if ($userMeals->count() > 0)
            <div class="col-md-6 d-flex justify-content-center">
                <div class="">
                    <a class="btn btn-primary" href="{{ route('app_meals_of_user', $user->id) }}" role="button">Consultez vos plats</a>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-center">
                <div class="">
                    <a class="btn btn-primary" href="{{route('app_meal_create')}}" role="button">Ajouter un plat</a>
                </div>
            </div>
            @else
            <div class="d-flex justify-content-center">
                <div class="">
                    <a class="btn btn-primary" href="{{route('app_meal_create')}}" role="button">Ajouter un plat</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection


