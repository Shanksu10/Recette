<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form  id="ingredient-form" method="POST" action="{{ route('app_ingredient.creation')}}" enctype='multipart/form-data' novalidate>
            @csrf
                @if(count($errors) > 0)
                    <div id="error-add-ingredient" class="alert alert-danger text-center">
                        L'ajout de l'ingrédient a échoué
                    </div>
                    @endif
                <!-- Formulaire pour saisir le nom de l'ingrédient, l'unité et la quantité -->
                <h2 class="text-center">Nouveau ingrédient</h2>
                <label class="mb-3" for="name_ingredient_new">Nom de l'ingrédient</label>
                <div class="input-group">
                    <input type="text" class="form-control mb-1" name="name_ingredient_new" id="new_ingredient_name" data-ingredient-id="" placeholder="Entrez le nom de l'ingrédient">
                </div>
                <div id="name_new_ingredient_error" class="text-danger fw-bold"></div>
                <!-- @error('name_ingredient_new')
                            <div id="name_ingredient_new" class="error text-danger fw-bold mb-2">
                                {{ $message }}
                        </div>
                @enderror -->

                <label class="mb-3" for="value_nutri">Valeur nutritionnelle :</label>
                <input  id="nutri" name="nutri" class="form-control mb-1 nutri" value="{{old('nutri')}}" type="number" min="0" placeholder="Entrez la valeur nutritionnelle de l'ingrédient" required autofocus>
                <div id="value_nutri_error" class="text-danger fw-bold"></div>
                <!-- @error('nutri')
                        <div id="nutri" class="error text-danger fw-bold mb-2">
                                {{ $message }}
                        </div>
                @enderror -->


                <label class="mb-3" for="unite">Unité :</label>
                <select class="form-control mb-3 unite pb-2" id="unite" name="unite" required>
                    <option value="">Sélectionnez une unité</option>
                    @foreach($units as $unit)
                        <option value="{{$unit['unit']}}">{{$unit['unit']}}</option>
                    @endforeach
                </select>   
                <div id="unite_error" class="text-danger fw-bold"></div>
                
                <!-- @error('unite')
                        <div id="unite" class="error text-danger fw-bold mt-1 mb-3">
                                {{ $message }}
                        </div>
                @enderror -->
                
                <div class="text-center mb-4">
                    <button class="btn btn-primary me-4" type="button" id="ajout-ing-button">Ajouter</button>
                    <button class="btn btn-primary" type="button" id="annuler-ing-button">Annuler</button>
                </div>
        </form>
    </div>
</div>
