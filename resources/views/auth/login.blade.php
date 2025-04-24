<x-guest-layout>
    <style>
        /* Particle animation for background */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        .particle {
            position: absolute;
            background: rgba(16, 1, 100, 0.3);
            border-radius: 90%;
            animation: float 15s infinite linear;
        }
        @keyframes float {
            0% { transform: translateY(100vh); opacity: 0; }
            50% { opacity: 0.5; }
            100% { transform: translateY(-100vh); opacity: 0; }
        }

        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg, rgb(14, 212, 226) 0%, rgb(240, 245, 245) 100%);
            display: flex;
            flex-direction: column; /* Stack elements vertically */
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding-bottom: 60px; /* Add padding to avoid overlap with the button */
        }
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("{{ asset('img/puerto-fondo.png') }}") no-repeat center center;
            background-size: cover;
            opacity: 0.1;
            z-index: 1;
        }
        .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 80px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23003087' fill-opacity='0.3' d='M0,160L48,144C96,128,192,96,288,112C384,128,480,192,576,202.7C672,213,768,171,864,149.3C960,128,1056,128,1152,154.7C1248,181,1344,235,1392,261.3L1440,288L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E");
            background-size: cover;
            animation: wave 10s linear infinite;
            z-index: 1;
        }
        @keyframes wave {
            0% { transform: translateX(0); }
            50% { transform: translateX(-25%); }
            100% { transform: translateX(0); }
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            width: 90%;
            z-index: 2;
            animation: fadeIn 1s ease-in-out;
            transition: box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-card:hover {
            box-shadow: 0 0 20px rgba(0, 48, 135, 0.5);
        }
        .login-logo {
            transition: transform 0.3s ease;
            max-height: 60px;
            display: block;
            margin: 0 auto;
        }
        .login-logo:hover {
            transform: scale(1.05);
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            width: 100%;
        }
        .form-group {
            flex: 1;
            min-width: 300px;
        }
        .form-control {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
        }
        .form-control:focus {
            border-color: #003087;
            box-shadow: 0 0 8px rgba(0, 48, 135, 0.3);
            transform: scale(1.02);
        }
        .btn-primary {
            background-color: #003087;
            border-color: #003087;
            transition: all 0.3s ease;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }
        .btn-primary:hover {
            background-color: #00205b;
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(0, 48, 135, 0.5);
        }
        .btn-primary:active::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 10px;
            height: 10px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            animation: ripple 0.6s linear;
        }
        @keyframes ripple {
            to {
                transform: translate(-50%, -50%) scale(20);
                opacity: 0;
            }
        }
        .text-link {
            color: #003087;
            transition: color 0.3s ease;
        }
        .text-link:hover {
            color: #00205b;
            text-decoration: none;
        }
        .form-label {
            position: relative;
            display: inline-block;
        }
        .form-label::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #003087;
            transition: width 0.3s ease;
        }
        .form-label:hover::after {
            width: 100%;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        /* Back to Home Button */
        .back-to-home {
            margin-top: 20px;
            z-index: 3;
        }
        .btn-back {
            background-color: #003087;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background-color: #00205b;
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(0, 48, 135, 0.5);
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .login-card {
                max-width: 500px;
                aspect-ratio: 1 / 1;
            }
            .form-row {
                flex-direction: column;
            }
            .form-group {
                min-width: 100%;
            }
        }
    </style>

    <div class="login-container">
        <!-- Particle animation -->
        <div class="particles">
            <script>
                // Generate particles dynamically
                for (let i = 0; i < 20; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'particle';
                    particle.style.width = `${Math.random() * 5 + 3}px`;
                    particle.style.height = particle.style.width;
                    particle.style.left = `${Math.random() * 100}vw`;
                    particle.style.animationDuration = `${Math.random() * 10 + 10}s`;
                    particle.style.animationDelay = `${Math.random() * 5}s`;
                    document.querySelector('.particles').appendChild(particle);
                }
            </script>
        </div>

        <div class="wave"></div>
        <div class="login-card">
            <!-- Logo -->
            <div class="text-center mb-4">
                <img src="{{ asset('img/LOGODALLAS.png') }}" alt="Dallas Express Envios Logo" class="login-logo">
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Form Row for Horizontal Layout -->
                <div class="form-row">
                    <!-- Email Address -->
                    <div class="form-group">
                        <x-input-label for="email" :value="__('Email')" class="fw-semibold text-dark form-label" />
                        <x-text-input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <x-input-label for="password" :value="__('Password')" class="fw-semibold text-dark form-label" />
                        <x-text-input id="password" class="block mt-1 w-full form-control"
                                      type="password"
                                      name="password"
                                      required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-link rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3 btn-primary">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- Back to Home Button (Centered at Bottom) -->
        <div class="back-to-home">
            <a href="/" class="btn btn-back">Volver al Inicio</a>
        </div>
    </div>
</x-guest-layout>