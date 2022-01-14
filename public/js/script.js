$(document).ready(function () {

    // toggle tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    var cityCount = 0;
    var cityExists = false;

    // ajax form submit
    $("form").submit(function (event) {

        event.preventDefault();

        // data
        var apiKey = $("#apiKey").val();
        var city = $("#city").val();
        var token = $("input[name=_token]").val();

        // check if inputs have been filled in
        if(!apiKey || !city) {
            alert('Please fill in all fields.');
            return false;
        }

        // ajax call
        $.ajax({
            url: "/request/weather",
            beforeSend: function() { 
                $('#loading').show(); 
                $('#loading-box').show();
            },
            complete: function() { 
                $('#loading').hide(); 
                $('#loading-box').hide();
            },
            type:"POST",
            data: {
                "_token": token,
                city: city,
                apiKey: apiKey,
            },
            success: function(response){

                // console.log(response);

                // check if the city was found
                if(response.message) {
                    // if not, return response and stop next methods
                    alert(response.message);
                    return false;
                }

                // show the tabs line
                $('.nav-tabs').removeClass('d-none');

                // clear city input
                $('#city').val('');

                // check if city is present in any of tabs
                $('.nav-link').each(function() {
                    var city = $(this).attr('data-city');
                    // console.log(city);
                    if (city === response.name) {
                        cityExists = true;
                        return false;
                    }
                });

                // if city is present
                if(cityExists == true) {
                    // reset the boolean for future checking if cities already exist in the tab list
                    cityExists = false;
                    // stop execution
                    return false;
                }

                // remove the active class for each of tab links
                $('.nav-link').each(function() {
                    $(this).removeClass('active');
                });

                // hide all city information cards
                $('.card').each(function() {
                    $(this).addClass('d-none');
                });

                // add new tab, with active class
                $('.nav-tabs').append('<li class="nav-item">\
                    <a class="nav-link active" id="city'+cityCount+'" aria-current="page" data-city="'+response.name+'" href="#">'+response.name+'</a>\
                </li>');

                // var temperature = calcTemp(response.main.temp);
                // var feelsLike = calcTemp(response.main.feels_like);

                // add new city card, information about city, country, wind, temperature
                $('.cards-box').append('<div class="card mx-auto mt-4 city'+cityCount+'" style="width: 18rem;">\
                    <div class="card-body">\
                        <h5 class="card-title">'+response.name+'</h5>\
                        <h6 class="card-subtitle mb-2 text-muted">'+response.country+'</h6>\
                        <p class="card-text">Wind: '+response.wind+' m/s</p>\
                        <p class="card-text">Current temperature: '+response.temperature+' celsius</p>\
                        <p class="card-text">Feels like: '+response.feelsLike+' celsius</p>\
                    </div>\
                </div>');

                // add city count
                cityCount++;

            },
            error: function(response) {
                console.log(response);
            },
        });

    });

    $('.nav-tabs').on('click', '.nav-link', function() {

        // get the clicked city
        var clickedLink = $(this).attr('id');

        // remove active class from all tab links
        $('.nav-link').each(function() {
            $(this).removeClass('active');
        });

        // hide all cards
        $('.card').each(function() {
            $(this).addClass('d-none');
        });

        // show the information card of clicked city
        $('.'+clickedLink).removeClass('d-none');
        // add active class to clicked city
        $('#'+clickedLink).addClass('active');

    });

    // function calcTemp(temp) {

    //     // calculate Kelvin to Celsius
    //     var calculation = temp - 273.15;
    //     // round up the result
    //     var result = Math.ceil(calculation);
    //     // return result
    //     return result;

    // }

});