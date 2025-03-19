<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Lazio</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
        @vite(['resources/js/app.js', 'resources/css/app.css'])
        @inertiaHead
        @routes
    </head>
    <body class="bg-white text-gray-800 dark:bg-gray-900 dark:text-gray-300">
        @inertia
    </body>
</html>