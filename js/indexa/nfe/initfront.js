Event.observe(window, 'load', function() {
    initElements( 'shipping:' );
    initElements( 'billing:' );
    initElements( '' );
    
});

function initElements( strPrefix ){
    if( $(strPrefix + 'country_id') != undefined ){
        var objCountry = $(strPrefix + 'country_id');
    }
    if( $(strPrefix + 'country') != undefined ){
        var objCountry = $(strPrefix + 'country');
    }
    
    if( objCountry != undefined ){
        Event.observe( objCountry , 'change', function() {
                if( $(strPrefix + 'city_id') != undefined && objCountry.value == 'BR' ){
                    $(strPrefix + 'city').style.display = 'none';
                    $(strPrefix + 'city_id').style.display = '';
                } else {
                    if( $(strPrefix + 'city_id') != undefined ){
                        $(strPrefix + 'city').style.display = '';
                        $(strPrefix + 'city_id').style.display = 'none';
                    }
                }           
        });

        Event.observe( $(strPrefix + 'region_id') , 'change', function() {
            if( objCountry.value == 'BR' ){
                if( !$(strPrefix + 'city_id') ){
                    $(strPrefix + 'city').insert({before: '<select name="city_id" id="'+strPrefix +'city_id"></select>'});
                    Event.observe( $(strPrefix + 'city_id') , 'change', function() {
                        $(strPrefix + 'city').value = $(strPrefix + 'city_id').value;
                     });
                     $(strPrefix + 'city_id').value = $(strPrefix + 'city').value;
                    $(strPrefix + 'city').style.display = 'none';
                }
            }   

        });
        
        Event.observe( $(strPrefix + 'region_id') , 'change', function() {
               new IndexaNfe(  $(strPrefix + 'region_id'), $(strPrefix + 'city_id'), '/nfe/ajax/load/filter/region', true, function(){  $(strPrefix + 'city_id').value = $(strPrefix + 'city').value; }  );
        });
        
        if( $(strPrefix + 'region_id').style.display != 'none' && objCountry.value == 'BR' && $(strPrefix + 'city') != undefined ){
            $(strPrefix + 'city').insert({before: '<select name="city_id" id="'+strPrefix +'city_id"></select>'});
                Event.observe( $(strPrefix + 'city_id') , 'change', function() {
                    $(strPrefix + 'city').value = $(strPrefix + 'city_id').value;
                 });
                 new IndexaNfe(  $(strPrefix + 'region_id'),  $(strPrefix + 'city_id'), '/nfe/ajax/load/filter/region', true, function(){  $(strPrefix + 'city_id').value = $(strPrefix + 'city').value; }  );
                 
                 $(strPrefix + 'city').style.display = 'none';
        }
    }
    
}
