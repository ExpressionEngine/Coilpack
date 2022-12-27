@extends('coilpack::blade/layouts/_blog-layout')

{{--
	404 Redirect
	============
	This is a listing page, it needs categories and pagination to work, but also needs to redirect if segment_2 is invalid . i.e. http://example.com/blog/nothing
--}}
@if($segment_2)
	@if($segment_2 != 'category' && preg_match('/^(?!P\d+).*/', $segment_2))
		{{ redirect("404") }}
	@endif
@endif

{{-- prevents 3rd ++ segments on non category listings --}}
@if($segment_3)
	@if($segment_2 != 'category')
		{{ redirect("$segment_1/$segment_2") }}
	@endif
@endif

{{-- prevents 4th ++ segments on category listings --}}
@if($segment_4)
	@if(preg_match('/^(?!P\d+).*/', $segment_4))
		{{ redirect("$segment_1/$segment_2/$segment_3") }}
	@endif
@endif

{{-- prevents 5th ++ segments on paginated category listings --}}
@if($segment_5)
	{{ redirect("$segment_1/$segment_2/$segment_3/$segment_4") }}
@endif

@php
// page vars (prefix p_)
$p_title='My Blog';
$p_description='A blog about things, things I like and things I do.';
$p_url='blog';
$p_url_entry='entry';
// channel vars (prefix ch_)
$ch='blog';
$ch_disable='category_fields|member_data';
$cat_ch=($segment_2 == 'category') ? $ch : null;
@endphp

{{-- every template using the blog layout will set these which lets us use
	 shared markup with customizable details. --}}

{{-- layout vars, channel/page related --}}
@section('ch', $ch)

@section('p_url', $p_url)
@section('p_title', $p_title)
{{-- layout vars, static --}}
@section('title', $p_title . $global->gv_sep)
@section('description', $p_description)
{{-- OpenGraph meta output --}}
@section('og_title', $p_title)
@section('og_url', $exp->path($p_url))
@section('og_description', $p_description)

{{-- Everything below is the "meat" of the template. We'll use tags to output content,
	which will populate the layout:contents of the layouts/_blog-layout layout --}}

@section('blog_contents')
			{{-- Heading output is different in the case of category listings. --}}
			@if($segment_2 == 'category')
				@php
                    $category = $exp->channel->category_heading(['channel' => $ch]);
                @endphp
                <h1>{{ $category->category_name }}</h1>
                @if($category->category_description)
                    <p>{{ $category->category_description }}</p>
                @endif
			@else
				<h1>{{ $p_title }}</h1>
				<p>{{ $p_description }}</p>
			@endif
			<div class="entries">
                @php
                    $parameters = ['channel' => $ch, 'paginate' => 5];
                    if($segment_2 == 'category') {
                        $parameters['category'] = $segment_3;
                    }
                    $entries = $exp->channel->entries($parameters);
                @endphp
				@forelse($entries as $entry)
					{{-- listing as a snippet, as it's used through more than one template --}}
					@include('coilpack::blade/_partials/snp_blog_list')
                @empty
					{{-- no results output --}}
                    <div class="alert warn no-results">
                        <p>{!! $global->gv_entries_none !!}</p>
                    </div>
                @endforelse

                {{-- pagination --}}
                @include('coilpack::blade/_partials/snp_blog_list_paginate')
			</div>
@endsection