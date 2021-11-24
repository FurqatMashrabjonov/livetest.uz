
@extends('layouts.app')

@section('content')

    <test :test_users="{{$test_users}}" :test="{{$test}}" :user="{{auth()->user()}}"></test>
@endsection
