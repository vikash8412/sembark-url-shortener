<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sembark URL Shortner - Login</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: Arial, sans-serif;
            background: white;
            font-size: 13px;
        }

        .login-frame {
            width: 500px;
            margin: 30px auto;
            border: 1px solid #333;
            background: lightgray;
        }

        .login-header {
            padding: 9px 12px;
            border-bottom: 2px solid orange;
            font-size: 13px;
            color: #222;
        }

        .url-logo {
            display: inline-block;
            border: 1px solid orange;
            color: orange;
            padding: 2px 5px;
            margin-right: 8px;
            font-size: 10px;
        }

        .login-body {
            padding: 24px 15px 30px;
        }

        .form-control {
            border: 1px solid #333;
            border-radius: 0;
            font-size: 12px;
            padding: 5px 7px;
            height: 28px;
        }

        .form-label {
            font-size: 11px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="login-frame">

            {{-- Header --}}
            <div class="login-header">
                <span class="url-logo">&lt;URL&gt;</span>
                <strong>Sembark URL Shortner</strong>
            </div>

            {{-- Login Form --}}
            <div class="login-body">

                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label d-block">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            placeholder="Enter your email..."
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label d-block">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Enter your password..."
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary">
                        Login
                    </button>
                </form>

            </div>
        </div>
    </div>

</body>
</html>