<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Forbidden</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="d-flex align-items-center border-top border-top-2 border-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5 col-xl-4 my-5">
                <div class="text-center">
                    <!-- Preheading -->
                    <h6 class="text-uppercase text-muted mb-4">
                        403 Forbidden
                    </h6>

                    <!-- Heading -->
                    <h1 class="display-4 mb-3">
                        There’s no page here
                    </h1>

                    <!-- Subheading -->
                    <p class="text-muted mb-4">
                        Looks like you don't have not enough permissions
                    </p>

                    <!-- Button -->
                    <a href="{{ route('admin.dashboard') }}"
                       class="btn btn-lg btn-primary">
                        Return to your dashboard
                    </a>
                </div>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</body>

</html>