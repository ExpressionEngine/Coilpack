@extends('coilpack::blade/layouts/_blog-layout')

{{-- prevents 4th ++ segments on no results searches --}}
@if($segment_4)
	{{ redirect("$segment_1/$segment_2/$segment_3") }}
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
    <div class="alert warn no-results">
        <p>Sorry, zero entries found matching "<b>{{ $exp->search->keywords }}</b>".</p>
    </div>
@endsection