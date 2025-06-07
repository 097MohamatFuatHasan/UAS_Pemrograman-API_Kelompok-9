@extends('layouts.app')

@section('content')
<div class="row">
    {{-- <div class="col-md-3">
        @include('admin.partials.sidebar')
    </div> --}}
    <div class="col-md-9">
        @yield('admin-content')
    </div>
</div>
@endsection