<!-- resources/views/layouts/app.blade.php -->
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>@yield('title', 'NIC Project')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha384-Hk1t8z8d8lYFnNcxZFb+T8vWeqmw0vqwo/aB1xlJJfcjLlSj+1q5M5Ze5yWKRMCk" crossorigin="anonymous">

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

        html {
            font-family: "Poppins", sans-serif !important;
        }
    </style>

</head>

<body>
    <div class="container">
        @yield('content')
    </div>
</body>

</html>
