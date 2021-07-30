@extends('welcome')

@section('content')
    <form id="login-form" method="POST" action="{{ route('login.post') }}">
        @csrf

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
            <br>
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <br>

        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
            <br>
            @error('name')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <br>
            @error('password')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <br>

        <input type="submit" value="Submit">
    </form>
@endsection
