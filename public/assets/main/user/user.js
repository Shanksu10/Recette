/*
    script pour la vérification de l'enregistrement des utilisateurs
*/

// event for register button (of type submit)

$('#register-user').click(e => {
    var agreeTerms = $('#agreeTerms');
    if(agreeTerms.is(':checked')){
        agreeTerms.removeClass("is-invalid");
        $('#error-register-agreeTerms').text("")
    }else {
        agreeTerms.addClass("is-invalid");
        $('#error-register-agreeTerms').text("You must accept the conditions");
    }
});

// event for checkBox 'agreeTerms'
$('#agreeTerms').change(e => {
    var agreeTerms = $('#agreeTerms');
    if(agreeTerms.is(':checked')){
        agreeTerms.removeClass("is-invalid");
        $('#error-register-agreeTerms').text("");
    }
    else{
        agreeTerms.addClass("is-invalid");
    }
})
