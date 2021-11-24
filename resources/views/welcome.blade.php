@extends('layouts.app')

@section('content')

    <section class="pt-6">

        <div class="container">
            <div class="py-8 px-5 position-relative text-center"
                 style="background-color: rgba(223, 215, 249, 0.199);border-radius: 129px 20px 20px 20px;">
                <div class="position-absolute start-100 top-0 translate-middle ms-md-n3 ms-n4 mt-3"><img
                        src="{{asset('assets/assets/img/cta/send.png')}}" style="max-width:70px;" alt="send icon"/>
                </div>
                <div class="position-absolute end-0 top-0 z-index--1"><img
                        src="{{asset('assets/assets/img/cta/shape-bg2.png')}}" width="264" alt="cta shape"/></div>
                <div class="position-absolute start-0 bottom-0 ms-3 z-index--1 d-none d-sm-block"><img
                        src="{{asset('assets/assets/img/cta/shape-bg1.png')}}" style="max-width: 340px;"
                        alt="cta shape"/></div>
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <h2 class="text-secondary lh-1-7 mb-7">Enjoy using Real Time Testing</h2>
                        <form class="row g-3 align-items-center w-lg-75 mx-auto" method="post"
                              action="{{url('test/in')}}">
                            @csrf
                            <div class="col-sm">
                                <input class="form-control form-little-squirrel-control"
                                       style="padding: 0 0 0 10px !important;"
                                       type="text" name="test_id" placeholder="ID of Test"/>
                            </div>
                            <div class="col-sm-auto">
                                <button type="submit" class="btn btn-danger orange-gradient-btn fs--1">Enter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- end of .container-->

    </section>

@endsection


