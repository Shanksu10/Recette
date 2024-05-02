@extends('base')

@section('title')
{{ $recipe->name }}
@endsection

@section('content')
<?php
//Sharing buttons
function showSharer($url, $message){
    ?>
    <div class="d-flex justify-content-end">
        <a class="resp-sharing-button__link col-md-3 d-flex justify-content-center" href="https://facebook.com/sharer/sharer.php?u=<?php echo urlencode($url) ?>" target="_blank" rel="noopener" aria-label="Share on Facebook">
            <div class="resp-sharing-button resp-sharing-button--facebook resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/></svg>
            </div>Partager sur Facebook</div>
        </a>
    </div>
    <?php
}
?>
<div class="container">
    <form action="#" method="post">
        <input type="hidden" value="{{$recipe->id}}" id="recipe-id">
    </form>
    <div class="row">
        <?php
		showSharer("www.recettesFrangine.com/recipes/id={{$recipe->id}}", "Le meilleur site de recettes !");
		?>
        <div class="popup-save col-md-12" id="popup-save">
            <div class="popup">
                <h4 class="message mb-3"></h4>
                <div class="col d-flex justify-content-center">
                    <button id="yes-save" class="col-md-5 me-2">Oui</button>
                    <button id="no-save" class="col-md-5">Non</button>
                </div>
            </div>
        </div>
        <div class="popup-delete col-md-12" id="popup-delete">
            <div class="popup">
                <h4 class="message-delete mb-3">Voulez vous supprimer cette recette ?</h4>
                <div class="col d-flex justify-content-center">
                    <a class="btn btn-outline-danger col-md-5 me-2" id="yes-delete" href="{{ route('app_delete_recipe', $recipe->id) }}" role="button">Oui</a>
                    <!--<button id="yes-delete" onclick="{{ route('app_delete_recipe', $recipe->id) }}" class="col-md-5 me-2">Oui</button>-->
                    <button id="no-delete" class="btn btn-outline-success col-md-5">Non</button>
                </div>
            </div>
        </div>
        <h1 class="text-center text-muted mb-3 mt-3">{{ $recipe->name }}</h1>
        <div class="col-md-12 d-flex justify-content-center mb-3">
            <div class="row col-md-4">
                <img style="height: 100%;" src="{{ asset('assets/img/recipe/' .$recipe->picture) }}" alt="">
            </div>
        </div>
        <div class="row col-md-12 mb-4">
            <div class="btn-toolbar d-flex justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group me-2" role="group" aria-label="first group">
                    <button type="button" class="btn btn-primary" onClick="window.print()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                        </svg>
                        Imprimer
                    </button>
                </div>
                @if ($myRecipe)
                <div class="btn-group me-2" role="group" aria-label="second group">
                    <a class="btn btn-primary" href="{{ route('app_modify_recipe_form', $recipe->id) }}" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                        </svg>
                        Modifier
                    </a>

                </div>
                <div class="btn-group me-2" id="delete-btn" role="group" aria-label="Third group">
                    <button type="button" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                        </svg>
                        Supprimer
                    </button>
                </div>
                @endif
                @if (Auth::check() && !$myRecipe)
                <div class="btn-group" id="save-btn" data-saved="@if (!$isSaved) 0
                @else 1
                @endif" role="group" aria-label="Fourth group">
                    <button type="button" class="btn @if (!$isSaved)
                        btn-primary
                        @else btn-success
                    @endif" id="btn-save-style">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-save-fill" viewBox="0 0 16 16">
                            <path d="M8.5 1.5A1.5 1.5 0 0 1 10 0h4a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h6c-.314.418-.5.937-.5 1.5v7.793L4.854 6.646a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l3.5-3.5a.5.5 0 0 0-.708-.708L8.5 9.293V1.5z"/>
                        </svg>
                        @if (!$isSaved)
                            Sauvegarder
                        @else
                            Retirer
                        @endif
                    </button>
                </div>
                @endif
            </div>
        </div>
        <div class="row col-md-12">
            <div class="d-flex justify-content-center line-time">
                <div class="horizontal-line"></div>
                <div class="row d-flex justify-content-center align-items-center ms-2 me-2">

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stopwatch" viewBox="0 0 16 16">
                        <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5V5.6z"/>
                        <path d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64a.715.715 0 0 1 .012-.013l.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354a.512.512 0 0 1-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5zM8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3z"/>
                    </svg>

                </div>
                <div class="horizontal-line"></div>
            </div>
        </div>
        <div class="row g-3 mt-0 mb-3">
            <div class="col-md-8 d-flex mx-auto">
                <div class="col-md-6">
                    <h5 class="text-center">Temps de Préparation</h5>
                    <p class="text-center">{{$recipe->preparation_time}} min</p>
                </div>
                <div class="col-md-6">
                    <h5 class="text-center">Temps de cuisson</h5>
                    <p class="text-center">{{$recipe->cooking_time}} min</p>
                </div>
            </div>
        </div>
        <div class="row col-md-12 mb-3">
            <div class="d-flex justify-content-center line-time">
                <div class="horizontal-line-left"></div>
                <div class="row d-flex justify-content-center align-items-center ms-2 me-2" style="width: 60px; height: auto;">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" version="1.1" id="Layer_1" viewBox="0 0 321.428 321.428" xml:space="preserve">
                        <g>
                            <g>
                                <g>
                                    <path d="M243.482,284.952c-0.208-5.264-4.68-34.512-7.38-37.628c-3.472-4.004-34.696-14.432-49.34-19.16l-4.096-5.596     c0.06-0.072,0.096-0.128,0.064-0.14l0.34-4.176c2.032-1.308,4-2.76,5.864-4.376c4.428-3.84,7.62-8.568,9.496-14.04l0.816-2.36     c0.624-1.808,1.224-3.616,1.816-5.432c0.732-1.152,1.344-2.376,1.776-3.7c0.12-0.372,0.196-0.76,0.292-1.144     c0.54-0.72,1.216-1.372,2.208-2.008c2.892-1.856,4.388-5.112,5.708-7.984l0.296-0.636c0.744-1.604,6.48-20.904-0.008-27.128     c-0.464-5.504-1.016-10.74-1.956-15.836c0.296-0.188,0.56-0.384,0.756-0.576c0.7-0.672,1.54-1.92,1.552-4.032l0.024-3.616     c0.024-3.328,0.024-3.328,0-6.328l-0.032-4.1c-0.032-4.18-2.988-5.136-5.616-5.4c-0.032-1.704-0.1-3.26-0.164-4.668     c-0.136-3.02-0.26-5.876,0.256-6.8c0.364-0.652,1.952-1.264,3.228-1.76c0.952-0.368,1.908-0.744,2.736-1.196     C226.794,87.18,234.29,72.1,231.674,55.78c-2.724-16.992-15.56-29.42-32.692-31.672c-0.34-0.048-1.136-0.624-1.32-1.016     c-5.988-12.84-18.864-21.684-33.16-22.936L162.526,0l-0.976,0.004L160.502,0l-1.976,0.056v0.1     c-14.296,1.252-27.168,10.092-33.16,22.936c-0.184,0.396-0.976,0.972-1.316,1.016C106.914,26.36,94.078,38.792,91.358,55.78     c-2.62,16.32,4.872,31.396,19.552,39.352c0.832,0.452,1.784,0.828,2.736,1.196c1.276,0.496,2.864,1.112,3.228,1.76     c0.516,0.924,0.392,3.78,0.256,6.804c-0.06,1.404-0.128,2.956-0.164,4.656c-2.5,0.232-5.588,1.136-5.616,5.408l-0.032,4.012     c-0.024,3.056-0.024,3.056,0,6.312l0.024,3.72c0.012,2.108,0.852,3.356,1.552,4.032c0.188,0.184,0.428,0.376,0.708,0.56     c-0.484,2.964-0.924,5.932-1.308,8.848c-0.364,2.756-0.728,5.512-1.164,8.256c-0.052,0.328-0.068,0.668-0.072,1.008     c-0.004,0.164-0.008,0.38,0,0.388c-3.948,8.624-2.292,17.076-0.156,24.204c1.12,3.736,3.128,8.308,8.536,10.464     c0.12,0.536,0.236,1.072,0.408,1.588c0.256,0.776,0.648,1.476,1.008,2.196c0.992,2.884,1.996,5.764,2.892,8.668     c2.36,7.66,7.656,14.076,15.736,19.124l0.264,3.264l-4.72,6.452c-14.5,4.68-46.204,15.244-49.704,19.28     c-2.7,3.116-7.172,32.36-7.376,37.628c-0.276,6.968,1.944,33.304,2.04,34.42l0.152,1.776l1.78,0.056     c5.284,0.164,25.884,0.216,50.628,0.216c41.856,0,95.552-0.156,106.904-0.216l1.828-0.008l0.156-1.824     C241.538,318.256,243.758,291.916,243.482,284.952z M185.282,230.936l1.644,1.24c-1,1.972-3.472,6.708-8.012,14.592     c-4.536,7.88-11.36,9.192-14.212,9.384v-3.292c0-3.904,0.688-5.412,2.636-7.696c3.576-4.196,10.796-15.716,13.572-20.208     L185.282,230.936z M156.534,243.324c-3.344-3.924-10.288-14.976-13.14-19.576v-3.216c4.64,2.42,9.492,4.432,14.076,6.224     c1.16,0.452,2.54,0.684,3.86,0.684c1.052,0,2.068-0.148,2.912-0.444c4.796-1.7,10.016-3.752,15.04-6.508v1.7     c-1.68,2.736-10.264,16.632-14.104,21.14c-2.244,2.636-3.312,4.736-3.312,9.532v3.32h-2.016v-3.32     C159.85,248.06,158.778,245.96,156.534,243.324z M115.326,119l0.032-4.02c0.008-1.144,0.008-1.416,3.668-1.536l35.592-0.232     v-2.268h-33.656c0.012-2.176,0.092-4.156,0.168-5.876c0.188-4.224,0.308-7.016-0.764-8.932c-1.068-1.908-3.204-2.736-5.272-3.536     c-0.788-0.308-1.584-0.608-2.276-0.984C99.674,84.492,92.966,71.004,95.31,56.412c2.436-15.2,13.924-26.324,29.264-28.34     c0.164-0.02,0.332-0.104,0.496-0.144c9.124-1.892,17.868,0.228,24.072,5.912c4.992,4.572,7.488,10.836,6.68,16.76l2.808,0.384     c0.932-6.84-1.9-14.032-7.576-19.232c-5.812-5.324-13.604-7.812-21.924-7.224c5.688-11.928,18-19.968,31.472-20.5L161.106,4h0.44     h0.18l0.692,0.028c13.576,0.532,25.984,8.68,31.612,20.752c0.756,1.62,2.696,3.064,4.42,3.292     c15.336,2.016,26.824,13.14,29.264,28.34c2.34,14.592-4.372,28.084-17.512,35.204c-0.688,0.372-1.488,0.676-2.276,0.984     c-2.068,0.8-4.204,1.628-5.272,3.536c-1.072,1.916-0.948,4.708-0.76,8.928c0.076,1.724,0.156,3.704,0.168,5.88h-5.692v2.472     l7.968,0.04c3.336,0.112,3.336,0.384,3.344,1.524l0.032,4.104c0.024,2.972,0.024,2.972,0,6.264l-0.024,3.616     c0,0.324-0.048,0.912-0.328,1.18c-0.24,0.232-0.772,0.348-1.436,0.332c-0.512-0.016-57.384-0.024-62.348-0.024l6.672-9.316     l-1.844-1.32l-7.616,10.636c-2.16,0-4.2,0-6.068,0l6.672-9.316l-1.844-1.32l-7.616,10.636c-2.28,0-4.312,0-6.068,0.004     l6.672-9.32l-1.844-1.32l-7.62,10.64c-3.688,0.004-5.696,0.012-5.952,0.02c-0.048,0-0.076-0.008-0.12-0.008l6.684-9.332     l-1.844-1.32l-6.488,9.06l-0.024-3.628C115.302,122.028,115.302,122.028,115.326,119z M207.442,150.896     c-1.348,0.176-2.412,0.092-3.052-0.356c-1.268-0.888-1.524-3.364-1.792-5.984c-0.34-3.3-0.768-7.308-3.412-10.096     c3.152,0.004,5.38,0.008,6.232,0.012c0.948,5.168,1.532,10.484,2,16.136L207.442,150.896z M124.342,134.456     c-2.644,2.792-3.076,6.796-3.416,10.1c-0.268,2.62-0.524,5.096-1.792,5.984c-0.72,0.504-1.912,0.612-3.536,0.324     c0-1.02,0.016-2.24,0.064-3.6c0.2-1.436,0.416-2.868,0.608-4.308c0.368-2.8,0.756-5.644,1.212-8.484     C118.174,134.464,120.702,134.46,124.342,134.456z M119.03,181.976c-2.424-1.756-3.516-4.284-4.28-6.836     c-1.924-6.416-3.436-13.976-0.04-21.396c0.028-0.06,0.028-0.116,0.052-0.176c0.876,0.172,1.704,0.288,2.44,0.288     c1.436,0,2.612-0.332,3.556-0.992c2.332-1.632,2.652-4.736,2.988-8.016c0.472-4.584,1.004-8.912,6.284-10.392     c9.664-0.004,22.556,0,30.5,0.004h1.98c10.024-0.004,22.124-0.004,30.984,0c5.28,1.476,5.812,5.804,6.284,10.392     c0.336,3.284,0.656,6.388,2.988,8.016c0.944,0.664,2.12,0.992,3.556,0.992c0.896,0,1.912-0.148,3.016-0.404     c2.536,5.028-0.452,18.908-1.624,21.432l-0.3,0.648c-1.044,2.268-2.148,4.56-3.776,5.884c-0.248-3.716-1.492-7.588-3.712-11.24     l-2.6-4.276l-0.028,5.004c-0.028,4.836-1.948,11.268-6.176,14.732c-2.38,1.952-5.16,2.632-8.248,2.036     c-1.6-0.312-3.876-2.04-6.08-3.712c-3.8-2.888-7.732-5.876-11.516-4.872c-1.528,0.4-2.84,1.436-3.924,3.084     c-1.084-1.652-2.396-2.684-3.924-3.084c-3.776-1-7.716,1.988-11.516,4.872c-2.204,1.672-4.48,3.4-6.08,3.712     c-3.104,0.596-5.872-0.084-8.252-2.036c-4.228-3.464-6.148-9.896-6.176-14.732l-0.028-5.004l-2.6,4.276     C120.45,174.012,119.182,178.092,119.03,181.976z M127.582,198.024c-0.044-0.14-0.096-0.28-0.14-0.42     c0.956,0.584,1.944,1.148,3.048,1.604c8.9,3.692,17.916,2.8,24.128-2.38c0,0-15.132,3.044-23.044-0.236     c-2.284-0.948-4.2-2.208-5.72-3.744c-2.076-1.62-3.968-5.62-3.94-9.212c-0.136-2.492,0.236-5.12,1.212-7.748     c0.944,4.412,3.1,9.028,6.652,11.94c3.02,2.48,6.676,3.384,10.588,2.624c2.244-0.436,4.676-2.28,7.248-4.236     c3.112-2.36,6.64-5.028,9.084-4.392c1.212,0.32,2.28,1.528,3.168,3.588l0.72,0.856h1.868l0.368-0.856     c0.888-2.06,1.956-3.268,3.168-3.588c2.46-0.632,5.972,2.032,9.084,4.392c2.576,1.952,5.004,3.8,7.252,4.236     c3.908,0.76,7.568-0.148,10.588-2.624c3.552-2.912,5.708-7.528,6.652-11.94c1,2.692,1.376,5.388,1.208,7.936     c0.04,3.4-3.08,9.984-9.652,12.764c-7.884,3.336-23.044,0.236-23.044,0.236c3.676,3.068,8.336,4.632,13.372,4.632     c3.472,0,7.124-0.744,10.756-2.248c0.976-0.404,1.832-0.916,2.696-1.42l-0.26,0.748c-1.664,4.864-4.392,8.892-8.332,12.316     c-6.988,6.068-15.752,9.66-23.412,12.372c-0.992,0.348-2.816,0.256-3.98-0.196c-4.68-1.828-9.652-3.864-14.3-6.344     C135.534,211.84,129.958,205.736,127.582,198.024z M136.102,231.264l4.708-6.304c2.772,4.488,9.996,16.008,13.568,20.204     c1.944,2.284,2.636,3.788,2.636,7.696v3.284c-2.848-0.208-9.716-1.556-14.212-9.372c-4.54-7.884-7.012-12.62-8.012-14.592     L136.102,231.264z M127.67,317.424c-20.304-0.008-37.156-0.052-43.836-0.172c-0.5-6.168-2.104-26.44-1.88-32.144     c0.296-7.508,4.944-32.868,6.404-35.164c1.964-2.24,22.36-9.732,43.772-16.744c0.908,1.808,3.364,6.564,8.212,14.988     c2.248,3.908,5,6.392,7.68,7.996h-11.304c-5.332,0-8.884,4.656-9.04,11.856C127.334,283.6,127.622,312.84,127.67,317.424z      M237.606,317.216c-14.688,0.064-66.9,0.212-107.1,0.208c-0.048-4.496-0.336-33.776,0.004-49.324     c0.096-4.392,1.78-9.084,6.208-9.084h27c0.04,0,0.06,0,0.104,0c0.012,0,0.036,0,0.048,0l1.632-0.104     c3.688-0.372,10.96-2.204,15.864-10.724c4.768-8.28,7.228-13.028,8.176-14.908c21.324,6.992,41.568,14.424,43.48,16.596     c1.516,2.368,6.168,27.728,6.464,35.236C239.71,290.804,238.114,311.008,237.606,317.216z"/>
                                    <rect x="161.21" y="110.964" width="26.616" height="2.268"/>
                                    <rect x="136.53" y="94.444" width="2.268" height="10.28"/>
                                    <rect x="160.45" y="94.444" width="2.268" height="10.28"/>
                                    <rect x="184.33" y="94.444" width="2.268" height="10.28"/>
                                    <path d="M141.618,271.64c-2.472,0-4.48,2.008-4.48,4.48c0,2.472,2.008,4.48,4.48,4.48s4.48-2.008,4.48-4.48     C146.098,273.648,144.09,271.64,141.618,271.64z M141.618,278.332c-1.22,0-2.212-0.992-2.212-2.212     c0-1.22,0.992-2.212,2.212-2.212c1.22,0,2.212,0.992,2.212,2.212C143.83,277.34,142.838,278.332,141.618,278.332z"/>
                                    <path d="M166.274,271.64c-2.472,0-4.48,2.008-4.48,4.48c0,2.472,2.008,4.48,4.48,4.48s4.48-2.008,4.48-4.48     C170.754,273.648,168.742,271.64,166.274,271.64z M166.274,278.332c-1.22,0-2.212-0.992-2.212-2.212     c0-1.22,0.992-2.212,2.212-2.212c1.22,0,2.212,0.992,2.212,2.212C168.486,277.34,167.49,278.332,166.274,278.332z"/>
                                    <path d="M141.618,296.4c-2.472,0-4.48,2.008-4.48,4.48c0,2.472,2.008,4.48,4.48,4.48s4.48-2.008,4.48-4.48     C146.098,298.408,144.09,296.4,141.618,296.4z M141.618,303.092c-1.22,0-2.212-0.992-2.212-2.212c0-1.22,0.992-2.212,2.212-2.212     c1.22,0,2.212,0.992,2.212,2.212C143.83,302.1,142.838,303.092,141.618,303.092z"/>
                                    <path d="M166.274,296.4c-2.472,0-4.48,2.008-4.48,4.48c0,2.472,2.008,4.48,4.48,4.48s4.48-2.008,4.48-4.48     C170.754,298.408,168.742,296.4,166.274,296.4z M166.274,303.092c-1.22,0-2.212-0.992-2.212-2.212     c0-1.22,0.992-2.212,2.212-2.212c1.22,0,2.212,0.992,2.212,2.212C168.486,302.1,167.49,303.092,166.274,303.092z"/>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <div class="horizontal-line-center"></div>
                <div class="row d-flex justify-content-center align-items-center ms-2 me-2" style="width: 60px; height: 60px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" viewBox="0 0 108 108" id="Layeri">
                        <title/>
                        <g id="Line">
                        <path d="M104,52H86v4h6A38,38,0,0,1,27,80.67,10,10,0,0,0,22,62a9.86,9.86,0,0,0-4.85,1.28A38,38,0,0,1,52,16v7.16A9.43,9.43,0,0,0,50,23a10,10,0,0,0,0,20,9.43,9.43,0,0,0,2-.21V54a2,2,0,0,0,2,2H74V52H56V4a2,2,0,0,0-2-2,52,52,0,1,0,52,52A2,2,0,0,0,104,52ZM52,38.64a6,6,0,1,1,0-11.28ZM22,66a6,6,0,0,1,2.22,11.57,38.18,38.18,0,0,1-5.84-10.34A5.92,5.92,0,0,1,22,66Zm32,36A48,48,0,0,1,52,6v6A42,42,0,1,0,96,56h6A48.06,48.06,0,0,1,54,102Z"/>
                        <circle cx="58" cy="74" r="7.64"/>
                        <circle cx="78.5" cy="63.5" r="1.5"/>
                        <circle cx="43.5" cy="64.5" r="2.52"/>
                        <circle cx="28.5" cy="46.5" r="3.7"/>
                        <circle cx="81.5" cy="26.5" r="1.88"/>
                        <path d="M64,47h40a2,2,0,0,0,2-2A42,42,0,0,0,64,3a2,2,0,0,0-2,2V45A2,2,0,0,0,64,47Zm9.88-4a6.13,6.13,0,0,1,12.25,0Zm16.25,0a10.13,10.13,0,0,0-20.25,0H66V15.07A30,30,0,0,1,93.93,43Zm11.82,0h-4A34,34,0,0,0,66,11.06v-4A38.06,38.06,0,0,1,101.95,43Z"/>
                        <rect height="4" rx="2" ry="2" width="4" x="78" y="52"/>
                        </g>
                    </svg>
                </div>
                <div class="horizontal-line-right"></div>
            </div>
        </div>
        <div class="row g-3 col-md-8 mt-0 mx-auto mb-3">
            <div class="col-md-6 d-flex mx-auto">
                <div class="col-md-6">
                    <h5 class="text-center">Type(s)</h5>
                    <ul class="d-flex justify-content-center row">
                        @foreach ($types as $type)
                            <li>{{$type->name_type_recipe}}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5 class="text-center">Catégories</h5>
                    <ul class="text-center">
                        @foreach ($categories as $category)
                            <li>{{$category->name_category_recipe}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-6 d-flex mx-auto">
                <div class="col-md-6">
                    <h5 class="text-center">Portions</h5>
                    <p class="text-center">{{$recipe->number_per}}</p>
                </div>
                <div class="col-md-6">
                    <h5 class="text-center">Valeur nutritionnelle</h5>
                    <p class="text-center">{{$nutriVal}} Kcal</p>
                </div>
            </div>
        </div>
        <div class="row col-md-12 mb-3">
            <div class="d-flex justify-content-center line-time">
                <div class="me-2">
                    <h3 class="text-muted">Ingrédients</h3>
                </div>
                <div class="horizontal-line-2"></div>
            </div>
        </div>
        <div class="col-md-12 d-flex justify-content-start mb-3">
            <div class="col-md-3"></div>
            <div class="row">
                <ul>
                    @foreach ($ingredients as $ingredient)
                        <li>{{$ingredient->quantity_ingredient}} {{$ingredient->unit}} de {{$ingredient->name_ingredient}}.</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row col-md-12 mb-3">
            <div class="d-flex justify-content-center line-time">
                <div class="me-2">
                    <h3 class="text-muted">Préparation</h3>
                </div>
                <div class="horizontal-line-2"></div>
            </div>
        </div>
        <div class="col-md-12 d-flex justify-content-start mb-3">
            <div class="col-md-3"></div>
            <div class="row col-md-6">
                {{$recipe->preparation_steps}}
            </div>
        </div>
        @if (Auth::check())
            <div class="row col-md-12 mb-3">
                <div class="d-flex justify-content-center line-time">
                    <div class="horizontal-line-20 me-4"></div>
                    <div class="me-4">
                        <h3 class="text-muted">Commentaire</h3>
                    </div>
                    <div class="horizontal-line-20"></div>
                </div>
            </div>
            <div class="container text-dark mb-3">
                <div class="row d-flex justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-6">
                    <div class="card">
                    <div class="card-body p-4">
                        <div class="d-flex flex-start w-100">
                        <img class="rounded-circle shadow-1-strong me-3"
                            src="@if (Auth::user()->picture != null)
                                {{asset("assets/img/user/".Auth::user()->picture)}}
                            @else
                                {{ asset('assets/img/login_logo.png') }}
                            @endif" alt="avatar" style="width: auto; height: 40px; clip-path:circle();"/>
                        <div class="w-100">
                            <h5>Ajouter un commentaire</h5>
                            <div class="form-outline">
                            <textarea class="form-control" id="text-comment" rows="4">

                            </textarea>
                            </div>
                            <h5>Noter la recette</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <i class="star" data-note="1">&#9733;</i>
                                        <i class="star" data-note="2">&#9733;</i>
                                        <i class="star" data-note="3">&#9733;</i>
                                        <i class="star" data-note="4">&#9733;</i>
                                        <i class="star" data-note="5">&#9733;</i>
                                    </div>
                                </div>
                                <div class="col col-md-6 d-flex justify-content-end">
                                    <span class="me-2">Note : </span>
                                    <i class="note"></i>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-primary" id="add-comment">
                                Envoyer
                            </button>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        @endif
        <div class="mb-3 d-flex justify-content-center">
            <div class="horizontal-line-50"></div>
        </div>
        <div class="row d-flex justify-content-center mb-3" id="result-comments">
            <div class="col-md-8 col-lg-6">
              <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                <div class="card-body p-4">
                @forelse ($comments as $comment)
                <div class="card mb-4">
                    <div class="card-body">
                      <p>{{$comment['comment']}}</p>
                      <div class="d-flex justify-content-between">
                        <div class="d-flex flex-row align-items-center">
                          <img src="@if ($comment['picture'] != null)
                                        {{asset("assets/img/user/".$comment['picture'])}}
                                    @else
                                        {{ asset('assets/img/login_logo.png') }}
                                    @endif" alt="avatar" style="width: auto; height: 40px; clip-path:circle();"/>
                          <p class="small mb-0 ms-2">{{$comment['first_name']}}</p>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <?php
                                for ($i=0; $i < $comment['mark']; $i++) {
                                    ?><i class="hover">&#9733;</i><?php
                                }
                            ?>
                        </div>
                      </div>
                    </div>
                  </div>
                @empty
                  <div class="d-flex justify-content-center">
                    <p>Aucun commentaire.</p>
                  </div>
                @endforelse
                <div class="row mb-3">
                    {{ $comments->onEachSide(1)->links() }}
                </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </div>
</div>
@endsection


