@include('layouts.header')
@php 
    $html = html_entity_decode($privacy_policy_html->body);
@endphp

{!! $html !!}


@include('layouts.footer')
