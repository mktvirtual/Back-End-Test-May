<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TrabalheNaMktVirtual-BackEnd</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
        <link rel="stylesheet" href="css/fluid-gallery.css">

    </head>
    <body>
    <div class="container gallery-container">

        <h1>TrabalheNaMktVirtual-BackEnd</h1>

        @if (Route::has('login'))
            <p class="page-description text-center">@if (Auth::check())
                    <a href="{{ url('/home') }}">Início</a>
                @else
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Cadastrar</a>
                @endif</p>
        @endif

        <div class="tz-gallery">
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-sm-12 col-md-4">
                        <a class="lightbox" href="{{ $post->image }}">
                            <img src="{{ $post->image }}" alt="{{ $post->title }}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
    <script>
        baguetteBox.run('.tz-gallery');
    </script>
    </body>
</html>
