<!DOCTYPE html>
<html data-theme="winter" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ENSSEA - Portail</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- DaisyUI CDN -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.css" rel="stylesheet" type="text/css" />

    <!-- Styles -->
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen bg-base-200">
    <div class="hero min-h-screen">
        <div class="hero-content text-center">
            <div class="max-w-md">
                <h1 class="text-5xl font-bold mb-8">ENSSEA</h1>
                <p class="text-xl mb-8">École Nationale Supérieure de Statistique et d'Économie Appliquée</p>
                <div class="flex flex-col gap-4">
                    <a href="{{ url('/admin') }}" class="btn btn-primary">
                        Espace Administrateur
                    </a>
                    <a href="{{ url('/professor') }}" class="btn btn-secondary">
                        Espace Professeur
                    </a>
                    @if (env('SWAGGER_ENABLED', false))
                        <a href="{{ url('/swagger/documentation') }}" class="btn btn-neutral">
                            Swagger Documentation
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>

</html>
