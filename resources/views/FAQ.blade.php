@include('layouts.header')
@php 
    $html = html_entity_decode($faqHtml->body);
@endphp

{!! $html !!}

@include('layouts.footer')
