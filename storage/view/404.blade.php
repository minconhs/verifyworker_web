@extends('layouts.app')

@section('title', 'Not Found')

@section('header')
    @parent
@endsection

@section('content')
    <div class="bg-white container mx-auto h-screen flex flex-col items-center justify-center px-4 ">
        <h1 class="text-5xl font-bold text-gray-900 mb-4">404</h1>
        <p class="text-lg text-gray-700 mb-2">Oops! The page you're looking for doesn't exist.</p>
    </div>
@endsection