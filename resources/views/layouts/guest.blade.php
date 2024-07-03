<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite('resources/sass/app.scss')
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        .full-screen {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .auth-cover-wrapper,
        .signin-wrapper {
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .auth-cover-wrapper .auth-cover .shape-image {
            bottom: 30%;

        }
    </style>
</head>
<body>

<div class="row g-0 auth-row">
    <div class="full-screen">
        @yield('content')
    </div>
</div>
</body>
</html>
