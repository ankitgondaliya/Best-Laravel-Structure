@extends('layouts.app')
@section('content')

<section class="content">
      <div class="container-fluid">
        <div class="row">
            @foreach ($statistics as $value)
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box {{$value['class']}}">
                    <div class="inner">
                        <h3>{{$value['count']??0}}</h3>
                        <p>{{$value['title']??""}}</p>
                    </div>
                    <div class="icon">
                        <i class="{{$value['icon']}}"></i>
                    </div>
                    <a href="{{route($value['route']??"/")}}" class="small-box-footer">View {{$value['title']??""}} <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
      </div>
    </section>
@endsection
