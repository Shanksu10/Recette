<nav class="navbar navbar-expand-lg bg-light fixed-top">
    <div class="container">
      <a class="logo" href="{{route("app_home")}}"><img style="width: 160px; height: auto" src="{{asset("assets/img/Logo.png")}}"/></a>
      <!-- <a class="navbar-brand" href="{{route("app_home")}}">{{ config('app.name') }}</a> -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-5 mt-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{route("app_home")}}">Accueil</a>
          </li>
          <li class="nav-item">
            <div class="btn-group">
                <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Plats
                </button>
                <ul class="dropdown-menu">
                    <?php
                        $meal_categories = DB::table('category_meals')->get();
                    ?>
                    @foreach ($meal_categories as $category)
                        <li><a class="dropdown-item" href="{{route('app_meals_of_category', $category->id)}}">{{$category->name_category_meal}}</a></li>
                    @endforeach
                </ul>
              </div>
          </li>
          <li class="nav-item">
            <div class="btn-group">
                <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Catégories
                </button>
                <ul class="dropdown-menu">
                    <?php
                        $recipe_categories = DB::table('category_recipes')->get();
                    ?>
                    @foreach ($recipe_categories as $category)
                        <li><a class="dropdown-item" href="{{route('app_recipes_of_category', $category->id)}}">{{$category->name_category_recipe}}</a></li>
                    @endforeach
                </ul>
              </div>
          </li>
          <li class="nav-item mx-5">
            <form id="search-form" method="POST" action="{{route('app_search')}}">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="row no-gutters wrapper search-elements-form">
                            <div class="col-lg-4 col-md-3 col-sm-12 p-0">
                                <select class="form-control" id="formControl-search" name="search_fields" required>
                                    <option value="0" selected>Chercher par :</option>
                                    <option value="1">Recette</option>
                                    <option value="2">Ingrédient</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 p-0">
                                <input type="text" placeholder="Recherche..." class="search-input" id="search" name="search" autocomplete="off" required>
                            </div>
                            <div class="col-lg-1 col-md-3 col-sm-12 p-0">
                                <button type="submit" class="btn btn-base">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                </button>
                            </div>
                            <div id="result-search-test" class="col-lg-4 col-md-3 col-sm-12 p-0">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 p-0 div-search-result">
                                <ul id="result-search" class="result-search">
                                </ul>
                            </div>
                            <div class="col-lg-1 col-md-3 col-sm-12 p-0">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
          </li>
        </ul>
      </div>
      <div class="btn-group me-5 mb-2 col-md-1">
        @guest
            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Mon Compte
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{route("login")}}">Se connecter</a></li>
                <li><a class="dropdown-item" href="{{route("register")}}">S'enregistrer</a></li>
            </ul>
        @endguest

        @auth
        <div class="dropdown">
            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                @if (Auth::user()->picture != null)
                    <img class="dropdown-toggle" style="width: 50px; height: auto; clip-path:circle();" src="{{asset("assets/img/user/".Auth::user()->picture)}}"/>
                @else
                    <img class="dropdown-toggle" style="width: 30px; height: auto" src="{{asset("assets/img/login_logo.png")}}"/>
                @endif
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="{{ route('app_dashboard') }}">Mon carnet personnalisé</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{route("app_add_new_recipe")}}">Ajouter une recette</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{route('app_meal_create')}}">Ajouter un plat</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{route('app_my_account')}}">Mon compte</a>
                </li>
                <li>
                    <form id="logout-form" action="{{ url('logout') }}" method="POST">
                        {{ csrf_field() }}
                    <button class="btn btn-link" type="submit">Déconnexion</button>
                    </form>
                </li>
            </ul>
        </div>
        @endauth
      </div>
    </div>
  </nav>


