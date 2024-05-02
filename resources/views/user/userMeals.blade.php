@extends('base')

@section('title', 'Vos plats')

@section('content')
<div class="container">
    <div class="row">
        <h1 class="text-center text-muted mb-3 mt-5">Vos Plats</h1>
        <div class="row">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-md-7">
                    @forelse ($meals as $meal)
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <a href="{{ route('app_meal_recipes', ['id' => $meal->id]) }}">
                                        <img src="{{asset('assets/img/meal/' . $meal->picture_meal)}}" class="card-img-top cover rounded" alt="">
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h3 class="card-title text-center">
                                            <a href="{{ route('app_meal_recipes', ['id' => $meal->id]) }}">{{$meal->name_meal}}</a>
                                        </h3>
                                        <p class="card-text mb-0"><span class="text-muted"> Entrée:</span> <a href="{{ route('app_recipe', $arrayIdmealsWithRecipes[$meal->id][0]['id']) }}">{{$arrayIdmealsWithRecipes[$meal->id][0]['name']}}</a></p>
                                        <p class="card-text mb-0"><span class="text-muted"> Plat principal:</span> <a href="{{ route('app_recipe', $arrayIdmealsWithRecipes[$meal->id][1]['id']) }}">{{$arrayIdmealsWithRecipes[$meal->id][1]['name']}}</a></p>
                                        <p class="card-text"><span class="text-muted"> Dessert:</span> <a href="{{ route('app_recipe', $arrayIdmealsWithRecipes[$meal->id][2]['id']) }}">{{$arrayIdmealsWithRecipes[$meal->id][2]['name']}}</a></p>
                                        <p class="card-text">Catégories:
                                            @foreach ($arrayIdMealsWithCategories[$meal->id] as $category)
                                                    <span><a href="{{route('app_meals_of_category', $category->id)}}">{{$category->name_category_meal}}</a></span>
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
                        </div>
                    @empty
                        <div>Aucune plat.</div>
                    @endforelse
                    <div class="row mb-3">
                        {{ $meals->onEachSide(2)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


