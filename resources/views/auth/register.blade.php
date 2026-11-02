<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | Order System</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #f5f0ff, #eee7ff, #faf8ff);
            font-family: Arial, sans-serif;
            color: #17152f;
        }

        /* Center the register card */

        .register-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 35px 20px;
        }

        .register-card {
            width: 100%;
            max-width: 520px; /* 480px ကနေ 520px ပြောင်းပါ */
            background: #fff;
            border: 1px solid #e7ddff;
            border-radius: 24px;
            box-shadow: 0 25px 70px rgba(91, 49, 180, 0.15);
            overflow: hidden;
        }

        .form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .form-content {
            width: 100%;
            max-width: 410px;
        }

        /* Register icon */

        .form-icon {
            width: 66px;
            height: 66px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border-radius: 50%;
            color: #6b35df;
            background: #f0e8ff;
            font-size: 30px;
        }

        .form-heading {
            margin-bottom: 8px;
            text-align: center;
            font-size: 34px;
            font-weight: 750;
            letter-spacing: -1px;
        }

        .form-subtitle {
            margin-bottom: 28px;
            color: #85809e;
            text-align: center;
            font-size: 14px;
        }

        /* Input fields */

        .form-label {
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 650;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap > i {
            position: absolute;
            top: 50%;
            left: 16px;
            transform: translateY(-50%);
            color: #9180c5;
            font-size: 17px;
            pointer-events: none;
        }

        .form-control {
            height: 51px;
            padding-left: 46px;
            border: 1px solid #ded4f8;
            border-radius: 11px;
            background: #fdfcff;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #8248ed;
            box-shadow: 0 0 0 4px rgba(130, 72, 237, 0.12);
        }

        .password-input {
            padding-right: 45px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 14px;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #8c81ac;
            cursor: pointer;
        }

        /* Purple register button */

        .btn-purple {
            width: 100%;
            min-height: 53px;
            border: 0;
            border-radius: 11px;
            background: linear-gradient(100deg, #7138e5, #803be8);
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(113, 56, 229, 0.22);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-purple:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(113, 56, 229, 0.3);
        }

        .btn-purple i {
            margin-left: 8px;
        }

        /* Links and messages */

        .purple-link {
            color: #7138e5;
            font-weight: 600;
            text-decoration: none;
        }

        .purple-link:hover {
            color: #4d1bb5;
            text-decoration: underline;
        }

        .login-text {
            margin-top: 24px;
            margin-bottom: 0;
            color: #85809e;
            text-align: center;
            font-size: 14px;
        }

        .terms-text {
            color: #85809e;
            font-size: 12px;
            line-height: 1.6;
        }

        /* Mobile responsive */

        @media (max-width: 480px) {
            .register-wrapper {
                padding: 20px 12px;
            }

            .form-panel {
                padding: 30px 22px;
            }

            .form-heading {
                font-size: 29px;
            }
        }
    </style>
</head>

<body>

<div class="register-wrapper">
    <div class="register-card">

        <section class="form-panel">
            <div class="form-content">

                <div class="form-icon">
                    <i class="bi bi-person-plus-fill"></i>
                </div>

                <h1 class="form-heading">Create Account</h1>

                <p class="form-subtitle">
                    Join us and get started today
                </p>

                {{-- Display validation errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Registration form --}}
                <form action="{{ route('register.store') }}" method="POST">
                    @csrf

                    {{-- Full Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Full Name
                        </label>

                        <div class="input-wrap">
                            <i class="bi bi-person"></i>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="Enter your full name"
                                autocomplete="name"
                                maxlength="255"
                                required
                            >
                        </div>

                        @error('name')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Email Address --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Email Address
                        </label>

                        <div class="input-wrap">
                            <i class="bi bi-envelope"></i>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="Enter your email"
                                autocomplete="email"
                                required
                            >
                        </div>

                        @error('email')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Password
                        </label>

                        <div class="input-wrap">
                            <i class="bi bi-lock"></i>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control password-input @error('password') is-invalid @enderror"
                                placeholder="At least 8 characters"
                                autocomplete="new-password"
                                minlength="8"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                data-target="password"
                                aria-label="Show password"
                            >
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>

                        @error('password')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">
                            Confirm Password
                        </label>

                        <div class="input-wrap">
                            <i class="bi bi-shield-lock"></i>

                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control password-input"
                                placeholder="Enter password again"
                                autocomplete="new-password"
                                minlength="8"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                data-target="password_confirmation"
                                aria-label="Show confirm password"
                            >
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <p class="terms-text mb-3">
                        By creating an account, make sure you use
                        a valid email address and a strong password.
                    </p>

                    <button type="submit" class="btn btn-purple">
                        Create Account
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </form>

                <p class="login-text">
                    Already have an account?
                    <a href="{{ route('login') }}" class="purple-link">
                        Login here
                    </a>
                </p>

            </div>
        </section>

    </div>
</div>

<script>
    document.querySelectorAll('.password-toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            const input = document.getElementById(
                button.getAttribute('data-target')
            );

            const showPassword = input.type === 'password';

            input.type = showPassword ? 'text' : 'password';

            button.innerHTML = showPassword
                ? '<i class="bi bi-eye-slash"></i>'
                : '<i class="bi bi-eye"></i>';

            button.setAttribute(
                'aria-label',
                showPassword ? 'Hide password' : 'Show password'
            );
        });
    });
</script>

</body>
</html>