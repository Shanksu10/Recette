@extends("base")

@section('title', 'Modifier un plat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <h1 class="text-center text-muted mb-3 mt-5">Modifier un plat</h1>
            <form method="POST" action="{{route('app_update_meal', $meal['id'])}}" enctype="multipart/form-data" autocomplete="off">
                @csrf 

                <div class="container col-md-12 mx-auto">
                    <div class="mb-3">
                        <label for="nom_plat" class="col-sm-4 col-form-label">Nom du plat</label>
                        <input num="1" type="text" class="form-control @error('nom_plat') is-invalid @enderror" id="nom_plat" name="nom_plat" placeholder="Nom du plat" value="{{$meal['name_meal']}}"  required autofocus>
                        @error ('nom_plat')
                            <small class="text-danger fw-bold" id="error-register-nom-plat">{{$message}}</small>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label for="category_meal" class="form-label">Catégories du plat (sélection multiple)</label>
                        <select id="category-meal" name="category_meal" class="form-select" autofocus>
                            <option value="" disabled selected>Sélectionnez les catégories du plat</option>
                            @foreach ($categoriesOfMeal as $category)
                                <option value="{{ $category->id }}">{{ $category->name_category_meal }}</option>
                            @endforeach
                        </select>
                        @error('category_meal')
                            <small class="text-danger fw-bold" id="error-register-category-meal">{{$message}}</small>
                        @enderror
                        {{ csrf_field() }}
                    </div>
                    <div class="mb-3">
                        <p>Les catégories sélectionnées : 
                            <span id="selected_categories">
                                @foreach($mealCategories as $category) 
                                    {{$category['name_category_meal']}}
                                @if(!$loop->last)
                                ,
                                @else
                                .
                                @endif
                                @endforeach
                            </span>
                        </p>
                        <input type="hidden" id="selected_categories_input" name="category_meal" value="@foreach($mealCategories as $category) {{$category['id']}}@endforeach">
                    </div>
                    
                    <div class="mb-3">
                        <label for="entree" class="form-label">Entrée</label>
                        <input num="1" type="search" class="form-control @error('entree') is-invalid @enderror" id="entree" name="entree" placeholder="Saisissez une entrée" value="{{$mealRecipes[0]['name']}}"  required autofocus>
                        <div id="entreeList" class="dropdownlist"></div>
                        @error ('entree')
                            <small class="text-danger fw-bold" id="error-register-entree">{{$message}}</small>
                        @enderror
                        <div class="text-end text-muted mt-2"><a href="#" style="color: black;">Recette non trouvée ?</a></div>
                        {{ csrf_field() }}
                    </div>

                    <div class="mb-3">
                        <label for="plat_principal" class="form-label">Plat principal</label>
                        <input num="2" type="text" class="form-control @error('plat_principal') is-invalid @enderror" id="plat_principal" name="plat_principal" placeholder="Saisissez un plat principal" value="{{$mealRecipes[1]['name']}}"  required autofocus>
                        <div id="mainCourseList" class="dropdownlist"></div>
                        @error ('plat_principal')
                            <small class="text-danger fw-bold" id="error-register-plat-principal">{{$message}}</small>
                        @enderror
                        <div class="text-end text-muted mt-2"><a href="#" style="color: black;">Recette non trouvée ?</a></div>
                        {{ csrf_field() }}
                    </div>
                    <div class="mb-3">
                        <label for="dessert" class="form-label">Dessert</label>
                        <input num="3" type="text" class="form-control @error('dessert') is-invalid @enderror" id="dessert" name="dessert" placeholder="Saisissez un dessert" value="{{$mealRecipes[2]['name']}}"  required autofocus>
                        <div id="dessertList" class="dropdownlist"></div>
                        @error ('dessert')
                            <small class="text-danger fw-bold" id="error-register-dessert">{{$message}}</small>
                        @enderror
                        <div class="text-end text-muted mt-2"><a href="#" style="color: black;">Recette non trouvée ?</a></div>
                        {{ csrf_field() }}
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Ajouter une image (Ancienne image: {{$meal['picture_meal']}})</label>
                        <input class="form-control" type="file" id="formFile" name="picture_meal" value="">
                        @error ('picture_meal')
                            <small class="text-danger fw-bold" id="error-register-picture-meal">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="mb-3 d-grid gap-2 col-12 mx-auto">
                        <button type="submit" class="btn btn-primary">Modifier le plat</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
