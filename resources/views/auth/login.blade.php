<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- <div class="min-h-[80vh] flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12 px-4 sm:px-6 lg:px-8"> -->
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <!-- <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-book-open text-white text-2xl"></i>
                    </div>
                </div> -->
                <!-- <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    Welcome Back
                </h2> -->
                <p class="mt-2 font-bold text-gray-600 text-xl">
                    Sign in to your ShelfLink account
                </p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6 bg-white p-8 rounded-2xl">
                @csrf

                <!-- Email Address -->
                <div class="space-y-2">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-envelope text-blue-500 text-sm"></i>
                        <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium" />
                    </div>
                    <div class="relative">
                        <x-text-input 
                            id="email" 
                            class="block mt-1 w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autofocus 
                            autocomplete="username"
                            placeholder="Enter your email address"
                        />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-lock text-blue-500 text-sm"></i>
                        <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                    </div>
                    <div class="relative">
                        <x-text-input 
                            id="password" 
                            class="block mt-1 w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            type="password"
                            name="password"
                            required 
                            autocomplete="current-password"
                            placeholder="Enter your password"
                        />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-key text-gray-400"></i>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 focus:ring-2 focus:ring-offset-0 transition-all duration-200" 
                            name="remember"
                        >
                        <span class="ms-2 text-sm text-gray-600 font-medium">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200" href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-sign-in-alt text-blue-200 group-hover:text-blue-100 transition-colors duration-200"></i>
                        </span>
                        {{ __('Sign in to your account') }}
                    </button>
                </div>

                <!-- Divider -->
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">New to ShelfLink?</span>
                    </div>
                </div>

                <!-- Register Link -->
                @if (Route::has('register'))
                    <div class="text-center">
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                            <i class="fas fa-user-plus mr-2 text-gray-500"></i>
                            {{ __('Create new account') }}
                        </a>
                    </div>
                @endif
            </form>

            <!-- Additional Info -->
            <!-- <div class="text-center">
                <p class="text-xs text-gray-500">
                    By signing in, you agree to our 
                    <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">Terms of Service</a> 
                    and 
                    <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">Privacy Policy</a>
                </p>
            </div> -->
        </div>
    <!-- </div> -->

    <!-- Add Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <style>
        .bg-gradient-to-br {
            background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
        }
        
        .from-blue-50 {
            --tw-gradient-from: #dbeafe;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgb(219 234 254 / 0));
        }
        
        .to-purple-50 {
            --tw-gradient-to: #faf5ff;
        }
        
        .bg-gradient-to-r {
            background-image: linear-gradient(to right, var(--tw-gradient-stops));
        }
        
        .from-blue-600 {
            --tw-gradient-from: #2563eb;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgb(37 99 235 / 0));
        }
        
        .to-purple-600 {
            --tw-gradient-to: #9333ea;
        }
    </style>
</x-guest-layout>