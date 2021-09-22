<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <meta name="_token" content="{{ csrf_token() }}">
    @yield('extra_css')
    <title>Task man - Better scheduling</title>
</head>
<body>
    <div class="wrapper">
        <div class="text text-center">
            <h1 class="alert alert-info">Task man - stay organized</h1>
        </div>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-2">
                    <ul class="list-group">
                        <li class="list-group-item {{ Request::is('task') ? 'active' : '' }}" aria-current="true"><a href="{{ route('task.index') }}">Tasks</a></li>
                        <li class="list-group-item {{ Request::is('project') ? 'active' : '' }}" aria-current="true"><a href="{{ route('project.index') }}">Projects</a></li>
                    </ul>
                </div>
                <div class="col-10">
                    <main>
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
        <div class="push"></div>
    </div>

    <footer class="footer text-center">Developed by <a href="mailto:fongohmartin@gmail.com">Fongoh Martin</a></footer>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
    @yield('extra_js')
</body>
</html>