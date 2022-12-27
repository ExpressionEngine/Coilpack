@extends('coilpack::blade/layouts/_about-layout')

@php
//This is a multi-entry channel page, it doesn't need third segment as is. So we use the following code to make sure the page sends a 404 if someone types in an incorrect URL in the browser address bar. i.e. http://example.com/about/sub-page/nothing
if($segment_3) {
    $exp->redirect(404);
}
// page vars (prefix p_)
$p_title = "about $global->site_name";
$p_description="about $global->site_name";
$p_url = 'about';
// channel vars (prefix ch_)
$ch = 'about';
$ch_status = 'Open|Default Page';
$ch_disable = 'categories|category_fields|member_data|pagination';

// Get Channel Entry, fail to 404 if not found
if($segment_2) {
    $entry = $exp->channel->entries(['channel' => $ch, 'dynamic' => true]);
}else{
    $entry = $exp->channel->entries(['channel' => $ch, 'status' => 'Default Page', 'limit' => 1]);
}

if(empty($entry)) {
    $exp->redirect(404);
}

@endphp
{{-- layout vars, channel/page related --}}
@section('ch', $ch)
@section('p_url', $p_url)
@section('p_title', $p_title)
@section('ch_disable', $ch_disable)
@section('ch_status', $ch_status)

@if($segment_2)
    @section('entry_ch', $ch)
@endif

{{-- layout vars, dynamic, not output --}}
@section('title', ($seo_title ?? $p_title) . $global->gv_sep)
@section('description', $seo_desc ?? $p_description)
{{-- OpenGraph meta output --}}
@section('og_title', $seo_title ?? $p_title)
@section('og_url', $exp->path($p_url))
@section('og_description', $seo_desc ?? $p_description)
{{-- /layout vars, dynamic, not output --}}

@section('about.contents')
    {{-- content output --}}
    <h1>{{ $entry->title }}</h1>
    {{-- about_image is a grid field first we check to see if it exists then we output it's contents. --}}
    @if($entry->about_image)
        @foreach($entry->about_image as $image)
            {{-- @dd($image->image->value()) --}}
            <figure @if($image->align != 'none') class="{{ $image->align }}"@endif>
                <img src="{{ $image->image->url }}" alt="{{ $image->caption->attr_safe }}">
                <figcaption>{{ $image->caption }}</figcaption>
            </figure>
        @endforeach
    @endif
    {{-- page_content is a textarea with HTML output we don't need to wrap this tag with HTML as that is already included in it's output. --}}
    {{-- Need a fieldtype for textarea for typography parsing --}}
    {{-- @dd($entry->page_content) --}}
    {!! $entry->page_content !!}
    {{-- /content output --}}
@endsection