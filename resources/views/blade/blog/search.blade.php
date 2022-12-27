@extends('coilpack::blade/layouts/_blog-layout')

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
$p_description='Search Results';
$p_url='blog';
$p_url_entry='entry';
// channel vars (prefix ch_)
$ch='blog';
$ch_disable='category_fields|member_data';
$search = 'y';
// layout vars
$title="search results{$global->gv_sep}{$p_title}{$global->gv_sep}";
$description=$p_description;
@endphp
@section('blog_contents')
		<h1>Search Results, {{ $p_title }}</h1>
		<div class="entries">
			@foreach($exp->search->search_results as $entry)
				{{-- listing as a snippet, as it's used through more than one template --}}
				@include('coilpack::blade/_partials/snp_blog_list')
				{{-- pagination --}}
				@include('coilpack::blade/_partials/snp_blog_list_paginate')
			@endforeach
		</div>
@endsection