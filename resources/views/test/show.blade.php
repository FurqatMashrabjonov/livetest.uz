@extends('layouts.app')

@section('content')
    @if($test->user_id === auth()->user()->getAuthIdentifier())
        <test-admin :test_users="{{$test_users}}" :test="{{$test}}" :user="{{auth()->user()}}"></test-admin>
    @else
        <test :test_users="{{$test_users}}" :test="{{$test}}" :user="{{auth()->user()}}"></test>

    @endif

@endsection
