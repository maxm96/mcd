@extends('welcome')

@section('content')
    <div id="app">
        <chat-page></chat-page>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
