@extends('templates/main')

@section('title')
    Artisan presentation
@endsection

@section('content')
    <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12"
         id="register_body">
        <h1 style="text-align: center">Show Artisan</h1>

        <div style="text-align: left">
            <p>Name : {{ $artisan->first_name.' '.$artisan->last_name }}</p>

            <p>Email : {{ $artisan->email }}</p>

            <p>Gender : {{ $artisan->sex }}</p>

            <p>Specialty : {{ $artisan->specialty }}</p>

            <p>Description : {{ $artisan->description }}</p>

            {{--<p>Salon : {!! link_to_route('salon.show', $artisan->salon->name, [$artisan->salon_id]) !!}</p>--}}

            <p>photo : {!! Html::image($artisan->main_photo, 'Main photo', ['width'=>'100px']) !!}</p>

            should be link to a description
            <p>Services provided :
                @foreach($artisan->services as $service)
                    {!! link_to_route('service.show', $service->name, [$service->id]) !!},
                @endforeach
            </p>
            <a href="javascript:history.back()" class="btn btn-primary">
                <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
            </a>
        </div>
    </div>
@endsection