<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Order System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

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

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 35px 20px;
        }

        .login-card {
            width: 100%;
            max-width: 520px;
            padding: 45px 42px;
            background: #fff;
            border: 1px solid #e7ddff;
            border-radius: 24px;
            box-shadow: 0 25px 70px rgba(91, 49, 180, 0.15);
        }

        .brand-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 35px;
            color: #7138e5;
        }

        .brand-logo i {
            font-size: 38px;
        }

        .brand-logo h2 {
            margin: 0;
            font-size: 27px;
            font-weight: 750;
        }

        .brand-logo p {
            margin: 5px 0 0;
            color: #85809e;
            font-size: 12px;
            letter-spacing: 1px;
        }

        .lock-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 22px;
            border-radius: 50%;
            color: #6b35df;
            background: #f0e8ff;
            font-size: 30px;
        }

        .form-heading {
            margin-bottom: 8px;
            text-align: center;
            font-size: 32px;
            font-weight: 750;
            letter-spacing: -1px;
        }

        .form-subtitle {
            margin-bottom: 30px;
            color: #85809e;
            text-align: center;
            font-size: 14px;
        }

        .form-label {
            margin-bottom: 9px;
            font-size: 14px;
            font-weight: 650;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap > .input-icon {
            position: absolute;
            top: 50%;
            left: 16px;
            transform: translateY(-50%);
            color: #9180c5;
            font-size: 18px;
        }

        .form-control {
            height: 53px;
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
            right: 15px;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #8c81ac;
            cursor: pointer;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 20px 0 27px;
            font-size: 13px;
        }

        .form-check-input:checked {
            border-color: #7138e5;
            background-color: #7138e5;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(113, 56, 229, 0.15);
        }

        .purple-link {
            color: #7138e5;
            text-decoration: none;
            font-weight: 600;
        }

        .purple-link:hover {
            color: #4d1bb5;
            text-decoration: underline;
        }

        .btn-purple {
            width: 100%;
            min-height: 53px;
            border: 0;
            border-radius: 11px;
            background: linear-gradient(100deg, #7138e5, #803be8);
            color: #fff;
            font-weight: 700;
            font-size: 16px;
            box-shadow: 0 8px 20px rgba(113, 56, 229, 0.22);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-purple:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(113, 56, 229, 0.3);
        }

        .btn-purple i {
            margin-left: 9px;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 27px 0;
            color: #9991b5;
            font-size: 12px;
        }

        .divider::before,
        .divider::after {
            content: "";
            height: 1px;
            flex: 1;
            background: #e6e0f2;
        }

        .register-text {
            color: #85809e;
            text-align: center;
            font-size: 14px;
        }

        .copyright {
            margin-top: 28px;
            color: #9991b5;
            text-align: center;
            font-size: 12px;
        }

        @media (max-width: 600px) {
            .login-wrapper {
                justify-content: center;
                padding: 20px 12px;
            }

            .login-card {
                padding: 32px 23px;
                border-radius: 18px;
            }

            .form-heading {
                font-size: 28px;
            }

            .form-options {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

<div class="login-wrapper">

    <div class="login-card">

        <!-- Logo -->
        <div class="brand-logo">
            <i class="bi bi-cart3"></i>
            <div>
                <h2>Order System</h2>
                <p>Simple · Fast · Reliable</p>
            </div>
        </div>

        <!-- Login heading -->
        <div class="lock-icon">
            <i class="bi bi-lock-fill"></i>
        </div>

        <h1 class="form-heading">Welcome Back</h1>

        <p class="form-subtitle">
            Login to your Order System account
        </p>

        <!-- Success message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error message -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login form -->
        <form action="{{ route('login.store') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="form-label">
                    Email Address
                </label>

                <div class="input-wrap">
                    <i class="bi bi-envelope input-icon"></i>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="Enter your email"
                        autocomplete="email"
                        required
                        autofocus
                    >
                </div>

                @error('email')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">
                    Password
                </label>

                <div class="input-wrap">
                    <i class="bi bi-lock input-icon"></i>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control password-input"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        id="togglePassword"
                        aria-label="Show password"
                    >
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Remember me -->
            <div class="form-options">
                <div class="form-check">
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        id="remember"
                        class="form-check-input"
                    >

                    <label for="remember" class="form-check-label">
                        Remember me
                    </label>
                </div>

                <a href="#" class="purple-link">
                    Forgot password?
                </a>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-purple">
                Login <i class="bi bi-arrow-right"></i>
            </button>
        </form>

        <div class="divider">OR</div>

        <!-- Register link -->
        <p class="register-text mb-0">
            Don't have an account?
            <a href="{{ route('register') }}" class="purple-link">
                Register here
            </a>
        </p>

        <div class="copyright">
            © {{ date('Y') }} Order System. All rights reserved.
        </div>

    </div>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const isPassword = passwordInput.type === 'password';

        passwordInput.type = isPassword ? 'text' : 'password';

        togglePassword.innerHTML = isPassword
            ? '<i class="bi bi-eye-slash"></i>'
            : '<i class="bi bi-eye"></i>';

        togglePassword.setAttribute(
            'aria-label',
            isPassword ? 'Hide password' : 'Show password'
        );
    });
</script>

</body>
</html>