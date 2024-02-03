@include('layouts.header')
@php 
    $html = html_entity_decode($how_to_play_html->body);
@endphp

{!! $html !!}

@include('layouts.footer')
