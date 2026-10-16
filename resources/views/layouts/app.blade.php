<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Sembark URL Shortner')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            background: white;
        }

        .app-frame {
            border: 1px solid black;
            background: lightgray;
        }

        .app-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            border-bottom: 2px solid orange;
            background: lightgray;
        }

        .url-logo {
            display: inline-block;
            border: 1px solid orange;
            color: orange;
            padding: 2px 5px;
            margin-right: 8px;
            font-size: 10px;
        }

        .header-link {
            color: #222;
            text-decoration: none;
        }

        .app-content {
            padding: 20px;
        }

        .form-control,
        .form-select {
            border-radius: 0;
            border-color: #333;
            font-size: 12px;
        }

        .btn-app {
            background: #b9dcff;
            color: #0066cc;
            border: 1px solid #1684e8;
            border-radius: 0;
            font-size: 12px;
        }

        .btn-app:hover {
            background: #a5d0fa;
            color: #0056b3;
        }
    </style>
</head>

<body>

<div class="container py-4">
    <div class="app-frame">

        {{-- Header --}}
        <header class="app-header">
            <div>
                <span class="url-logo">&lt;URL&gt;</span>

                <strong>
                    @auth
                        <a href="{{ route('dashboard') }}" class="header-link">Dashboard</a>
                    @else
                        Sembark URL Shortner
                    @endauth
                </strong>
            </div>

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="btn btn-link header-link p-0">
                        Logout &rarr;
                    </button>
                </form>
            @endauth
        </header>

        {{-- Page Content --}}
        <main class="app-content">
            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success py-2">
                    {{ session('success') }}

                    @if (session('invite_link'))
                        <div class="mt-1">
                            Invite link (mail driver is "log", so copy from here):
                            <a href="{{ session('invite_link') }}">{{ session('invite_link') }}</a>
                        </div>
                    @endif
                </div>
            @endif

            @yield('content')
        </main>

    </div>
</div>

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- jQuery Validation Plugin --}}
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.21.0/dist/jquery.validate.min.js"></script>

{{-- Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>