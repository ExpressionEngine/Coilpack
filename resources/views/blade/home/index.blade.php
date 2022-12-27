@extends('coilpack::blade/layouts/_html-wrapper')

@php
// page vars (prefix p_)
$p_url = 'blog';
$p_url_entry = 'entry';
// channel vars (prefix ch_)
$ch = 'blog';
$ch_status = 'Open|Default Page';
$ch_disable = 'categories|category_fields|member_data|pagination';
@endphp

{{-- page vars (prefix p_) --}}
@section('p_url', $p_url)
@section('p_url_entry', $p_url_entry)
{{-- channel vars (prefix ch_) --}}
@section('ch', $ch)
@section('ch_disable', 'category_fields|member_data')

@section('contents')
<section class="row content home pad">
	<section class="w-16">
		<figure class="cycle-slideshow"
			data-cycle-fx="scrollHorz"
			data-cycle-pause-on-hover="true"
			data-cycle-speed="500"
			data-cycle-prev=".prev-slide"
    		data-cycle-next=".next-slide"
		>
			{{-- slideshow images from a specific directory, and category --}}
			@foreach($exp->file->entries(['directory_id' => 7, 'limit' => 5, 'category' => 'not 25']) as $file)
				<img src="{{ $file->file_url }}" alt="{{ $file->file_name }}" @if($loop->first) class="act" @endif>
				@if($loop->first)
					<div class="slide-ctrls">
						<a class="prev-slide" href="#"></a>
						<a class="next-slide" href="#"></a>
					</div>
				@endif
			@endforeach
		</figure>
		<h1>Recent Blog Posts <a class="btn all" href="{{ $exp->path($p_url) }}">All Posts</a></h1>
	</section>
	<section class="w-8">
		<div class="entries">
			@forelse($exp->channel->entries(['channel' => $ch, 'limit' => 4]) as $entry)
				{{-- listing as a snippet, as it's used through more than one template --}}
				@include('coilpack::blade/_partials/snp_blog_list')
            @empty
                {{-- no results --}}
                <div class="alert warn no-results">
                    <p>{{ $global->gv_entries_none }}</p>
                </div>
            @endforelse
		</div>
	</section>
	<section class="w-8">
		<div class="entries">
			{{-- using the offset='' parameter here to start the listing on the 5th item. which allows us to split it into two columns without any wonky math --}}
			@forelse($exp->channel->entries(['channel' => $ch, 'limit' => 4, 'offset' => 4]) as $entry)
				{{-- listing as a snippet, as it's used through more than one template --}}
				@include('coilpack::blade/_partials/snp_blog_list')
            @empty
				{{-- no results --}}
                <div class="alert warn no-results">
                    <p>{{ $global->gv_entries_none }}</p>
                </div>
            @endforelse
		</div>
	</section>
</section>
@endsection