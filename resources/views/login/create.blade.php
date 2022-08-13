<x-layout>
    <x-slot name="styling">
        <!-- adding this stylesheet fixes the nav bar for some reason -->
        <link rel='stylesheet' href='./css/games.css' />
    </x-slot>
    <x-slot name="content">
        <h1>Log In</h1>
        <form action="/login" method="post">
            @csrf
            <div>
                <label for="email">
                    Email
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            </div>
            <div>
                <label for="password">
                    Password
                </label>
                <!-- maybe add toggle to view password characters -->
                <input type="password" name="password" id="password" required>
                <!-- following is an alternative to the foreach loop below -->
                <!-- @error('password')
                <p>{{ $message }}</p>
                @enderror -->
            </div>
        <div>
            <button type="submit">
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