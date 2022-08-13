<x-layout>
    <x-slot name="styling">
        <link rel="stylesheet" href="/css/loginRegister.css">
    </x-slot>
    <x-slot name="content">
        <form id="login-form" action="/login" method="post">
            @csrf

            <div class="join-form-flex">
                <div class="join-form-left"></div>
                <h3 class="join-form-right">Sign In</h3>
            </div>
            <div class="join-form-flex">
                <label class="join-form-left" for="email">Email:</label>
                <input
                class="join-form-right"
                type="email"
                name="email"
                id="email"
                value="{{ old('email') }}"
                required
                />
            </div>

            <div class="join-form-flex">
                <label class="join-form-left" for="password">
                    Password:
                </label>
                <!-- maybe add toggle to view password characters -->
                <input id="password" name="password" class="join-form-right" type="password" value="" required
                />
                <!-- following is an alternative to the foreach loop below -->
                <!-- @error('password')
                <p>{{ $message }}</p>
                @enderror -->
            </div>

            <div class="join-form-flex button-container">
                <div class="button-decoration-far-left"></div>
                <div class="button-decoration-left"></div>
                <button
                id="login-button"
                class="join-form-right"
                type="submit"
                name="submit"
                value="LOG IN"
                >
                Log In
                </button>
            </div>

            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </form>
    </x-slot>
</x-layout>