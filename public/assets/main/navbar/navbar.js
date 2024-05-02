var mouse_is_inside_search_list_item = false;

$(document).ready(function(){
    $('#search').keyup(function(){
        $('#result-search').html("");

        var field = $('#formControl-search').val();
        var search = $(this).val();
        if (search != "") {
            $.ajax({
                type: 'get',
                url: '/search',
                data: {'search' : search.trim(), 'field': field},
                success: function(data){
                    if(data != ""){
                        $.each(data, function(index, element) {
                            $('#result-search').fadeIn(10, function(){
                                $('#result-search').append(`<li class="search-list-item"><a href="/recipes/id=`+ element['id']+`" class="ms-3 item-link">`+element['name']+`</a></li>`);
                            });

                            $('.item-link').click((e)=>{
                                $('#result-search').fadeOut(100);
                            });

                            $('.search-list-item, .search-input').hover(function(){
                                mouse_is_inside_search_list_item = true;
                            }, function(){
                                mouse_is_inside_search_list_item = false;
                            });

                            $("body").mouseup(function(){
                                if(! mouse_is_inside_search_list_item) $('#result-search').fadeOut(100);
                            });
                        });
                    }
                }
            });
        }
    });
});


