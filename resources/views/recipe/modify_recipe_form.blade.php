@extends("base")

@section('title', 'Modifier la recette')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <h2 class="text-center text-muted mb-2 mt-4">Modifier la recette</h2>
                <form id="modify-recipe" method="POST" action="{{ route('app_modifiying_recipe', $recipe->id) }}" enctype='multipart/form-data' novalidate>
                    @csrf
                    <input type="hidden" id="selected_ingredients_hidden" name="selected_ingredients" value="">
                    <input type="hidden" name="recipe_id" value="{{$recipe->id}}">
                        @if(count($errors) > 0)
                            <div class="alert alert-danger text-center">
                                La modification de la recette a échoué !
                            </div>
                        @endif
                        @if(session('message'))
                            <div class="alert alert-success text-center">
                                {{ session('message') }}
                            </div>
                        @endif

                    <div  class="mb-3">
                        <label for="name_recipe" class="form-label">Nom de la recette</label>
                        <input id="name_recipe" name="name_recipe" type="text" value="{{$recipe['name']}}" class="form-control @error('name_recipe') is-invalid @enderror" required>
                        @error('name_recipe')
                            <div id="modif-name-recipe" class="error text-danger fw-bold">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description </label>
                        <textarea id="modif-description" name="description" class="form-control  @error('description') is-invalid @enderror" rows="3">{{$recipe['description_recipe']}}</textarea>
                        @error('description')
                            <div id="modif-error-description" class="error text-danger fw-bold">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Choisissez le(s) type(s) de la recette :</label>
                        <br>
                        <input type="checkbox" id="entree" name="type_recipe[]" value="entrée" @if($isEntree) checked @endif>
                        <label for="entree">Entrée</label>
                        <br>
                        <input type="checkbox" id="plat_principal" name="type_recipe[]" value="plat principal" @if($isPlatPrincipal) checked @endif>
                        <label for="plat_principal">Plat principal</label>
                        <br>
                        <input type="checkbox" id="dessert" name="type_recipe[]" value="dessert" @if($isDessert) checked @endif>
                        <label for="dessert">Dessert</label>
                        <br>
                        @error('type_recipe')
                            <div id="modif-type-error" class="error text-danger fw-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category-recipe" class="form-label">Catégorie(s) de la recette</label>
                        <select id="category-recipe" name="category_recipe" class="form-select @error('category_recipe') is-invalid @enderror mb-2" required>
                            <option  selected value="" disabled selected >Sélectionnez ou retirez la(les) catégorie(s) de la recette</option>
                            @foreach ($allCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name_category_recipe }} </option>
                            @endforeach
                            <input type="hidden" id="selected_categories_input" name="category_recipe" value="">
                        </select>
                        <div id="category-msg" class="form-label mb-3"></div>
                        @error('category_recipe')
                            <div id="category_recipe" class="error text-danger fw-bold">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <span id="selected_categories" class="badge rounded-pill bg-light text-dark badge-font-size mb-3">
                        @foreach($categories as $categoryRecipe)
                            {{ $categoryRecipe->name_category_recipe }}
                            @if(!$loop->last)
                            ,
                            @endif
                        @endforeach
                    </span>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="preparation_time" class="form-label">Temps de préparation</label>
                            <input  id="preparation-time" name="preparation_time" class="form-control @error('preparation_time') is-invalid @enderror" value="{{$recipe['preparation_time']}}" type="number" min="0" placeholder="Temps de préparation en min" required />
                            @error('preparation_time')
                            <div id="preparation_time" class="error text-danger fw-bold">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="cooking_time" class="form-label">Temps de cuisson</label>
                            <input  id="cooking-time" name="cooking_time" class="form-control @error('cooking_time') is-invalid @enderror" value="{{$recipe['cooking_time']}}"  type="number" min="0" max="10000" placeholder="Temps de cuisson en min" />
                            @error('cooking_time')
                            <div id="cooking_time" class="error text-danger fw-bold">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div  class="mb-3">
                        <label for="number_per" class="form-label">Nombre de personne </label>
                        <input id="number-per" name="number_per" class="form-control @error('number_per') is-invalid @enderror" value="{{$recipe['number_per']}}" type="number" min="0" max="10000" step="1" required/>
                        @error('number_per')
                            <div id="number_per" class="error text-danger fw-bold">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div  class="mb-3">
                        <label for="picture" class="form-label">Image actuelle: {{$recipe->picture}} </label>
                        <div class="input-group">
                                <input type="file" class="custom-file-input @error('picture') is-invalid @enderror" name="picture" aria-describedby="inputGroupFileAddon04" aria-label="Upload"/>
                        </div>
                        @error('picture')
                        <div class=" error text-danger fw-bold">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <p class="text-center text-muted mb-3">Composez les ingrédients pour votre recette</p>
                    </div>
                    <div class="mb-3 text-center" id="ingredient-added">

                    </div>
                    <div class="row">
                        <div id="ingredient-list-container" class="col-md-6 mb-4">
                            <div>
                                <label class="mb-3" for="name_ingredient">Nom de l'ingrédient</label>
                                <div class="input-group">
                                    <input type="text" class="form-control ingredient-input" name="name_ingredient[]" id="name_ingredient_input" placeholder="Entrez le nom de l'ingrédient">
                                    <div id="ingredientList">

                                    </div>
                                </div>
                                <div id="name_ingredient_exist_error" class="text-danger fw-bold"></div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="mb-3" for="quantity">Quantité </label>
                            <input  id="quantity" name="quantity" class="form-control quantity @error('quantity') is-invalid @enderror" value="{{old('quantity')}}" type="number" min="0" max="1000" step="1" required autofocus>
                            <span id="quantity_error" class="text-danger fw-bold text-end"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="mb-3" for="unit-label">Unité</label>
                            <input  id="unit-label" name="unit-label" class="form-control unit-label" value="" type="text" disabled>
                        </div>
                    </div>

                    <div class="text-center mb-3">
                            <button class="btn btn-primary" type="button" id="ajout-ingredient-button" name="ajout-ingredient" data-recipe-id="">Ajouter ingrédient</button>
                    </div>

                    <div class="text-center mb-4" ><a href="javascript:void(0);"  data-toggle="modal" data-target="#myModal" id="openModal">Ingrédient non trouvé?</a></div>

                    <h3 class="form-label" name="ingredients" id="ingredient-list-title"></h3>
                    <div id="ingredient-list" name="selected_ingredients" class="@if(empty(old('selected_ingredients'))) border-0 @endif" class="@error('selected_ingredients') is-invalid @enderror form-control">
                        <table class="w-100" id='table-ingredient-list'>
                            @foreach($ingredients as $ingredient)
                            <tr>
                                <td><div id="ingredient-name-div-{{$ingredient->id}}" data-ingredient-name-id="{{$ingredient->id}}">{{$ingredient->name_ingredient}}</div></td>
                                <td><div>{{$ingredient->quantity_ingredient}} {{$ingredient->unit}}</div></td>
                                <td>
                                    <div class="ingredient-trash'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" id="{{$ingredient->id}}" class="bi bi-trash" viewBox="0 0 16 16"> <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>

                    </div>
                        @error('selected_ingredients')
                        <div class=" error text-danger fw-bold">{{ $message }}</div>
                        @enderror


                    <div class="my-4">
                        <label class="mb-3" for="preparation">Instructions de préparation </label>
                        <textarea id="preparation" name="preparation" class="form-control @error('preparation') is-invalid @enderror" rows="3">{{$recipe['preparation_steps']}}</textarea>
                        @error('preparation')
                            <div id="preparation" class="error text-danger fw-bold">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <div class="text-center text-muted mb-8">
                            <button id="terminer-ajout-recette" class="btn btn-primary mb-4" type="submit">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

   <!-- Formulaire de creation nouveau ingrédient -->
   @include('recipe.add_new_ingredient')

@endsection
