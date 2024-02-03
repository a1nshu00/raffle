@include('layouts.header')
@php 
    $html = html_entity_decode($aboutHtml->body);
@endphp

{!! $html !!}
@include('layouts.footer')
