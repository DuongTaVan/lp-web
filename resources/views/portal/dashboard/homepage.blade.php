@extends('portal.dashboard.base')

@section('content')

@if (!is_null(session()->get('dataSuccess')))
    <div id="show-toast-success" data-msg="{{ session()->get('dataSuccess')['msg'] }}"></div>
@elseif (!is_null(session()->get('dataError')))
    <div id="show-toast-error" data-msg="{{ session()->get('dataError')['error']['msg'] }}"></div>
@endif
<div class="container-fluid">
    <div class="fade-in"></div>
</div>

@endsection

@section('javascript')
    
<script src="{{ asset('js/main.js') }}" defer></script>
@endsection
