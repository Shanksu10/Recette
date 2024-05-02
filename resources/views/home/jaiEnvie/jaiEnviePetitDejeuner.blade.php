@extends('base')

@section('title', 'Petit déjeuner')

@section('content')
<div class="container">
    <div class="row">
        <h1 class="text-center text-muted mb-3 mt-5">Nos petits déjeuner</h1>
        <div class="row">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-md-7">
                    @forelse ($petitDejeuners as $recipe)
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <a href="{{ route('app_recipe', $recipe->id) }}">
                                        <img src="{{asset('assets/img/recipe/' . $recipe->picture)}}" class="card-img-top cover rounded" alt="">
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><a href="{{ route('app_recipe', $recipe->id) }}">{{$recipe->name}}</a></h5>
                                        <p class="card-text">{{$recipe->description_recipe}}</p>
                                        <p class="card-text"><small class="text-muted">{{$recipe->created_at}}</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div>Aucun petit déjeuner.</div>
                    @endforelse
                    <div class="row">
                        {{ $petitDejeuners->onEachSide(2)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



