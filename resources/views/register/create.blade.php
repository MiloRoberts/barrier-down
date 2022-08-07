<x-layout>
    <form action="/register" method="post">
        @csrf
        <div>
            <label for="name">
                Name
            </label>
            <input type="text" name="name" id="name" required>
        </div>
        <div>
            <label for="username">
                Username
            </label>
            <input type="text" name="username" id="username" required>
        </div>
        <div>
            <label for="email">
                Email
            </label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <label for="password">
                Password
            </label>
            <!-- maybe add toggle to view password characters -->
            <input type="password" name="password" id="password" required>
            <!-- to also add later -->
            <!-- @error('password')
                <p>{{ $message }}</p>
            @enderror -->
        </div>
        <div>
            <button type="submit">
                Submit
            </button>
        </div>
    </form>
</x-layout>