<x-layout>
    <x-slot name="styling">
      <link rel="stylesheet" href="/css/loginRegister.css">
    </x-slot>
    <x-slot name="content">
        <form action="/register" method="post">
            @csrf
            <div class="join-form-flex">
              <div class="join-form-left"></div>
              <h3 class="join-form-right">New Account</h3>
            </div>
            <div class="join-form-flex">
              <label class="join-form-left" for="name">
                Name:
              </label>
              <input class="join-form-right" type="text" name="name" id="name" value="{{ old('name') }}" required>
            </div>

            <div class="join-form-flex">
              <label class="join-form-left" for="username">
                Username:
              </label>
              <input class="join-form-right" type="text" name="username" id="username" value="{{ old('username') }}" required>
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
              <label class="join-form-left" for="password">Password:
              </label>
              <!-- maybe add toggle to view password characters -->
              <input
                class="join-form-right"
                type="password"
                name="password"
                id="password"
                value=""
                required
              />
            </div>

              <div class="join-form-flex">    
                <label class="join-form-left" for="retyped_password">
                  Retype:
                </label>
                <!-- maybe add toggle to view password characters -->
                <input class="join-form-right" type="password" name="retyped_password" id="retyped_password" value="" required>
                <!-- following is an alternative to the foreach loop below -->
                <!-- @error('password')
                <p>{{ $message }}</p>
                @enderror -->
            </div>

            <!-- <div class="join-form-flex">
              <div class="join-form-left">
                <input type="checkbox" name="subscribed" id="subscribed" />
              </div>
              <div class="join-form-right">
                <label for="subscribed">Receive email updates</label>
              </div>
            </div> -->

            <div class="join-form-flex button-container">
              <div class="button-decoration-far-left"></div>
              <div class="button-decoration-left"></div>
              <button class="join-form-right" type="submit" id="submit-new-account">
                Create Account
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