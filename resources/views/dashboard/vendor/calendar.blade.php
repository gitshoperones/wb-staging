@extends('layouts.dashboard')

@section('content')
    <section class="content dashboard-container">
        <div class="row row-no-padding m-b-28">
            <div class="col-md-12">
                @include('partials.dashboard.calendar')
            </div>
        </div>
    </section>
@endsection