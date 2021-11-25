@extends('layouts.app')

@section('content')
<test-create :variants="{{json_encode($variants)}}"></test-create>
@endsection



