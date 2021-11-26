@extends('layouts.app')

@section('content')
    <preview-test :test="{{$test}}" :answerimages="{{json_encode($variants)}}"></preview-test>
@endsection



