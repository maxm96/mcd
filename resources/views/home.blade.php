@extends('welcome')

@section('content')
    <div id="app">
        <posts-page></posts-page>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
