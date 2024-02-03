@include('layouts.header')
@php 
    $html = html_entity_decode($disclaimer_html->body);
@endphp

{!! $html !!}


@include('layouts.footer')
