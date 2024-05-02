@extends('base')

@section('title', '{{$category->name_category_meal}}')

@section('content')
<div class="container">
    <div class="row">
        <h1 class="text-center text-muted mb-3 mt-5">{{$category->name_category_meal}}</h1>
        <div class="row">
            <div class="row d-flex justify-content-center">
                <div class="col-md-7">
                    @forelse ($result as $meal)
                        <div class="card mb-3">
                            
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="{{ route('app_meal_recipes', ['id' => $meal['id_meal']]) }}">
                                            <img src="{{asset('assets/img/meal/' . $meal['picture_meal'])}}" class="card-img-top cover rounded" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="card-body">
                                            <h3 class="card-title text-center"> 
                                                <a href="{{ route('app_meal_recipes', ['id' => $meal['id_meal']]) }}">{{$meal['name_meal']}}</a>
                                            </h3>
                                            <p class="card-text mb-0"><span class="text-muted"> Entrée:</span> <a href="{{ route('app_recipe', $meal['recipes'][0]['id']) }}">{{$meal['recipes'][0]['name']}}</a></p>
                                            <p class="card-text mb-0"><span class="text-muted"> Plat principal:</span> <a href="{{ route('app_recipe', $meal['recipes'][1]['id']) }}">{{$meal['recipes'][1]['name']}}</a></p>
                                            <p class="card-text"><span class="text-muted"> Dessert:</span> <a href="{{ route('app_recipe', $meal['recipes'][2]['id']) }}">{{$meal['recipes'][2]['name']}}</a></p>
                                            <p class="card-text">Catégories:
                                                @foreach ($meal['categories'] as $category)
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
                        <div class="">Aucune plat.</div>
                    @endforelse
                    <div class="row mb-3">
                        {{ $result->onEachSide(2)->links() }}
                    </div>
                    <div class="col-md-6 d-flex justify-content-start mb-3">
                        <div class="">
                            <a class="btn btn-primary" href="{{ route('app_meal_create') }}" role="button">Ajouter un plat</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


