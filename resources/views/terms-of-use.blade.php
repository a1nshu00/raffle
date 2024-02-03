@include('layouts.header')
@php 
    $html = html_entity_decode($term_of_use_html->body);
@endphp

{!! $html !!}

@include('layouts.footer')
