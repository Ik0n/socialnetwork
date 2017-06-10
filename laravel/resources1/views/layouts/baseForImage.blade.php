<!DOCTYPE html>

<html lang="{{ App::getLocale() }}" >

<head>

    <meta charset= "utf-8">

    <meta http-equiv= "X-UA-Compatible" content="IE=Edge">

    <meta name="HandheldFriendly" content="true">

    <meta name="MobileOptimized" content="width">

    <meta name="viewport"

          content= "width=device-width, initial-scale=1.0, shrink-to-fit=no" >

    <title>@yield('title')</title>

    <!--[if lt IE 9]>

    <script

            src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" >

    </script>

    <![endif]-->

    <!-- Bootstrap -->

    <link rel="stylesheet"

          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

    <link rel="stylesheet"

          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

    <link rel="stylesheet"

          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"

    >

</head>

<body>

<header class="navbar navbar-static-top navbar-inverse">

    <div class="container-fluid">

        <div class="navbar-header">

            <a class="navbar-brand" href="{{ route('images.index') }}">

            {{ config ('app.name') }}

            </a>

        </div>

        <div class="collapse navbar-collapse ">

            <ul class="nav navbar-nav">

                <li>

                    {{ Html::secureLink (route ('images.add'), __('messages.images.new' )) }}

                </li>

            </ul>

        </div>

    </div>

</header>

<main tabindex= "-1">

    <div class="container-fluid ">

        <h1> @yield('title')</h1>

        @if ($errors->count())

            {{-- Перечень ошибок. --}}

            <div class="alert alert-danger ">

                {{ Html::ul ($errors->all()) }}

            </div>

        @endif

        @yield('main')

    </div>

</main>

<footer></footer>

</body>

</html>