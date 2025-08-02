


<x-guest-layout>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {

            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 50px 40px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            position: relative;
            animation: fadeIn 0.6s ease-out;
        }

        .login-title {

            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
            color: #000000;
        }

        input[type="email"],
        input[type="password"] {
            padding: 14px 16px;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            width: 100%;
            font-size: 16px;
            transition: 0.3s ease;
        }

        input:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
        }

        .remember-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 16px;
        }

        .forgot-link {
            font-size: 0.875rem;
            color: #667eea;
            text-decoration: none;
            transition: 0.3s;
        }

        .forgot-link:hover {
            color: #764ba2;
        }

        .submit-button {
            width: 100%;
            margin-top: 30px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(102, 126, 234, 0.3);
        }

        .error {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 6px;
        }
    </style>

    <div class="login-container">
        <div class="login-title">Register</div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />


   <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>






    </div>
</x-guest-layout>















