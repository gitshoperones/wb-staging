@extends('layouts.dashboard')

@section('content')
    <section class="content dashboard-container">
        <div class="row row-no-padding m-b-28">
            <div class="col-sm-12">
                @include('partials.dashboard.todo-list')
            </div>
        </div>
    </section>
@endsection