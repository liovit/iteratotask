<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Iterato Task : Weather API</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <!-- CSS -->
        <link rel="stylesheet" href="{{ url('css/style.css') }}">

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        <!-- Icons -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    </head>

    <body>
        
        {{-- Container, form --}}
        <div class="container-sm margin-top">

            <p>Very basic weathers page. You can check the current weather here by simply entering your API key from <a href="https://openweathermap.org/">https://openweathermap.org/</a> website and city name. Tabs will appear after submitting, they will only be saved until you quit or reload the website.</p>
            <p>In case <a href="https://openweathermap.org/">https://openweathermap.org/</a> would be down or the link would be disrupted, <br> other API website would be used in it's place: <a href="https://www.weatherapi.com/">https://www.weatherapi.com/</a></p>
            <p>Here's a quick API key for testing (openweathermap.org): <b>de7b23c3ab49d5c9a26a30c9c762e055</b></p>
            <p>Here's other API key for testing (weatherapi.com): <b>989bc263ac0743b880680006221401</b></p>

            <form id="weatherForm">

                @csrf

                <div class="form-group">
                    <label for="apiKey">Enter your API key</label>
                    <input type="text" class="form-control" id="apiKey" placeholder="API key">
                </div>
                <div class="form-group mt-2 prepend">
                    <label for="city">Enter the city name</label>
                    <input type="text" class="form-control" id="city" placeholder="City">

                    <div class="input-group-btn">
                        <button class="btn btn-success" type="submit" data-toggle="tooltip" data-placement="top" title="Submit">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

            </form>

        </div>
        {{-- Container, form end --}}

        {{-- Container, tabs --}}

        <div class="container-sm margin-top-sm">

            {{-- <p>Choose city</p> --}}

            <ul class="nav nav-tabs d-none">

                

            </ul>

            <div class="cards-box">



            </div>

        </div>

        <div id="loading-box">
            <div id="loading">

            </div>
        </div>

        {{-- Scripts --}}
        <script src="{{ url('js/script.js') }}"></script>

    </body>
</html>
