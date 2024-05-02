@extends('base')

@section('title', 'Accueil')

@section('content')
<div class="container">
    <div class="row">
        <div class="text-center text-muted mt-3" id="blog_title_row">
            <div>
                <h1 id="recettesFrangines">Recettes Frangines</h1>
                <h2 id="subtitle">Site culinaire qui fait voyager</h2>
            </div>
        </div>

        <h1 class="text-center text-muted mt-5">Nos recettes d'actualité</h1>
        @if ($lastThreeRecipes->count() > 0)
            <div class="card my-2 border-0 rounded-0" id="carousel-favorites">
                <div class="card-body d-flex justify-content-center">
                    <div id="carouselFade" class="carousel slide carousel-fade col-md-7" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($lastThreeRecipes as $recipe)
                            <div class="carousel-item @if ($loop->first) active @endif">
                                <a href="{{ route('app_recipe', $recipe->id) }}">
                                    <img src="{{ asset('assets/img/recipe/'. $recipe->picture) }}" class="d-block w-100 cover" alt="">
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
                Aucune recette.
            </div>
        @endif

        <div class="d-flex justify-content-end">
            <a href="{{ route('app_all_recipes') }}" style="text-decoration:none;">Voir toutes nos recettes...</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h1 class="text-center text-muted mt-5">Nos recettes les mieux notées</h1>
            <div class="row d-flex justify-content-center">
                @if ($threeBestMarkedRecipes->count() > 0)
                    <div class="card my-2 border-0 rounded-0" id="carousel-best">
                        <div class="card-body d-flex justify-content-center">
                            <div id="carouselExampleCaptions" class="carousel slide carouselBestRecipes" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                </div>
                                <div class="carousel-inner">
                                    @foreach ($threeBestMarkedRecipes as $recipe)
                                        <div class="carousel-item @if ($loop->first) active @endif">
                                            <a href="{{ route('app_recipe', $recipe->id) }}">
                                                <img src="{{asset('assets/img/recipe/'. $recipe->picture)}}" class="d-block w-100 cover" alt="">
                                            </a>
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>
                                                    <a href="{{ route('app_recipe', $recipe->id) }}">
                                                        {{$recipe->name}}
                                                    </a>
                                                </h5>
                                                <p>{{$recipe->description_recipe}}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="d-flex justify-content-center">
                        Aucune recette.
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h1 class="text-center text-muted mt-5">Aujourd'hui, j'ai envie...</h1>
            @include('home/jaiEnvie/jaiEnvie')
        </div>
    </div>
    <hr>
    <div class="text-center text-muted text-justify">
        <h1 class="mb-0" id="quiSommesNous">Qui sommes-nous ?</h1>
        <div class="row mt-3 mb-1" id="aboutUs">
            <div class="col-md-8 mx-auto">
                <p>Nous sommes Reda, Oumaima et Younes, étudiants en Master CCI promo 2023-2024 et passionnés par l'informatique. Nous avons créé ce site web pour partager notre amour pour la cuisine et la découverte de nouvelles recettes. Nous espérons que notre site vous plaira et que vous trouverez des recettes qui vous feront voyager.</p>
            </div>
        </div>
    </div>
</div>
@endsection


