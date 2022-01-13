$(document).ready(function () {

    // toggle tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

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
            url: "/request-weather-data",
            type:"POST",
            data: {
                "_token": token,
                city: city,
                apiKey: apiKey,
            },
            success: function(response){

                // console.log(response);

                // check if the city was found
                if(response.cod == '404') {
                    // if not, return response and stop next methods
                    alert('City has not been found.');
                    return false;
                }

                // check if the api key is found
                if(response.cod == '401') {
                    // if not, return response and stop next methods
                    alert('Provided API key is invalid.');
                    return false;
                }

                // show the tabs line
                $('.nav-tabs').removeClass('d-none');

                // clear city input
                $('#city').val('');

                // check if the city is already present in tabs
                if($('#'+response.name).length == 0) {

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
                        <a class="nav-link active" id="'+response.name+'" aria-current="page" href="#">'+response.name+'</a>\
                    </li>');

                    var temperature = calcTemp(response.main.temp);
                    var feelsLike = calcTemp(response.main.feels_like);

                    // add new city card, information about city, country, wind, temperature
                    $('.cards-box').append('<div class="card mx-auto mt-4 '+response.name+'" style="width: 18rem;">\
                        <div class="card-body">\
                            <h5 class="card-title">'+response.name+'</h5>\
                            <h6 class="card-subtitle mb-2 text-muted">'+response.sys.country+'</h6>\
                            <p class="card-text">Wind: '+response.wind.speed+' m/s</p>\
                            <p class="card-text">Current temperature: '+temperature+' celsius</p>\
                            <p class="card-text">Feels like: '+feelsLike+' celsius</p>\
                        </div>\
                    </div>');

                }

            },
            error: function(response) {
                console.log(response);
            },
        });

    });

    $('.nav-tabs').on('click', '.nav-link', function() {

        // get the clicked city
        var clickedLinkId = $(this).attr('id');

        // remove active class from all tab links
        $('.nav-link').each(function() {
            $(this).removeClass('active');
        });

        // hide all cards
        $('.card').each(function() {
            $(this).addClass('d-none');
        });

        // show the information card of clicked city
        $('.'+clickedLinkId).removeClass('d-none');
        // add active class to clicked city
        $('#'+clickedLinkId).addClass('active');

    });

    function calcTemp(temp) {

        // calculate Kelvin to Celsius
        var calculation = temp - 273.15;
        // round up the result
        var result = Math.ceil(calculation);
        // return result
        return result;

    }

});