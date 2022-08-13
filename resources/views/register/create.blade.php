<x-layout>
    <x-slot name="styling">
    </x-slot>
    <x-slot name="content">
        <form action="/register" method="post">
            @csrf
            <div>
                <label for="name">
                    Name
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            </div>
            <div>
                <label for="username">
                    Username
                </label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" required>
            </div>
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
                    Submit
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
        <script src="./javascript/register.js"></script>
    </x-slot>
</x-layout>


<!-- <form id="join-form" class="hidden" action="newAccount.php" method="post">
      <div class="join-form-flex">
        <div class="join-form-left"></div>
        <h3 class="join-form-right">New Account</h3>
      </div>
      <div class="join-form-flex">
        <label class="join-form-left" for="name">Username:</label>
        <input
          class="join-form-right"
          type="text"
          name="name"
          id="name"
          value=""
        />
      </div>
      <br />
      <div class="join-form-flex">
        <label class="join-form-left" for="password">Password:</label>
        <input
          class="join-form-right"
          type="text"
          name="password"
          id="password"
          value=""
        />
      </div>
      <div class="join-form-flex">
        <label class="join-form-left" for="retyped">Retype:</label>
        <input
          class="join-form-right"
          type="text"
          name="retyped"
          id="retyped"
          value=""
        />
      </div>
      <br />
      <div class="join-form-flex">
        <label class="join-form-left" for="email">Email:</label>
        <input
          class="join-form-right"
          type="text"
          name="email"
          id="email"
          value=""
        />
      </div>
      <br />
      <div class="join-form-flex">
        <div class="join-form-left">
          <input type="checkbox" name="subscribed" id="subscribed" />
        </div>
        <div class="join-form-right">
          <label for="subscribed">Receive email updates</label>
        </div>
      </div>
      <br />
      <br />
      <div class="join-form-flex">
        <div class="button-decoration-far-left"></div>
        <div class="button-decoration-left"></div>
        <button class="join-form-right" type="submit" id="submit-new-account">
          Create Account
        </button>
      </div>
      <div class="join-form-flex">
        <div class="join-form-left"></div>
        <div class="join-form-right">
          <div id="feedback"></div>
        </div>
      </div>
    </form>
    <form id="login-form" class="hidden" method="POST">
      <div class="join-form-flex">
        <div class="join-form-left"></div>
        <h3 class="join-form-right">Sign In</h3>
      </div>
      <div class="join-form-flex">
        <label class="join-form-left" for="userName">Username:</label>
        <input
          class="join-form-right"
          type="text"
          name="userName"
          id="userName"
          value=""
        />
      </div>
      <br /> -->

      <!-- BELOW IS ACTUALLY COMMENTED OUT -->
      <!-- <div class="inputDiv" id="userDiv">
        <label for="userName">Username: </label>
        <input type="text" id="userName" name="userName" />
      </div> -->

      <!-- <div class="join-form-flex">
        <label class="join-form-left" for="userPassword">Password:</label>
        <input
          id="userPassword"
          name="userPassword"
          class="join-form-right"
          type="text"
          value=""
        />
      </div>
      <br />
      <br /> -->

      <!-- BELOW IS ACTUALLY COMMENTED OUT -->
      <!-- <div class="inputDiv" id="passwordDiv">
        <label for="userPassword">Password: </label>
        <input type="text" id="userPassword" name="userPassword" />
      </div> -->

      <!-- <div class="join-form-flex">
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
    </form>
     -->