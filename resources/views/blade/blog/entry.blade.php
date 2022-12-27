@extends('coilpack::blade/layouts/_blog-layout')

{{--
	Redirect
	============
	This is a blog single entry page, it'll never need a fourth segment, so we use the following code to make sure the page redirects if someone types in an incorrect URL in the browser address bar, by adding new segments. i.e. http://example.com/blog/entry/title/nothing
--}}
@if($segment_4)
	{{ $exp->redirect("${segment_1}/${segment_2}/${segment_3}") }}
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
@endphp

@section('blog_contents')
        @php
            $entry = $exp->channel->entries(['channel' => $ch, 'dynamic' => true, 'limit' => 1]);//->require_entry('yes');
            // dd('here', $entry);
            /*
				no results redirect
				===================
				If the entry doesn't exist, we redirect to 404. This works in tandem with the require_entry='yes' parameter on the channel entries tag.
            */
            if(!$entry) {
                $exp->redirect(404);
            }
        @endphp
		{{-- single-entry pagination --}}
		<div class="paginate single">
			@if($prev = $exp->channel->prev_entry(['channel' => $ch, 'url_title' => $entry->url_title]))
				<a class="page-prev" href="{{ $exp->path("{$p_url}/{$p_url_entry}/{$prev->url_title}") }}" title="{{ $prev->title }}">Previous</a>
			@endif
			@if($next = $exp->channel->next_entry(['channel' => $ch, 'url_title' => $entry->url_title]))
				<a class="page-next" href="{{ $exp->path("{$p_url}/{$p_url_entry}/{$next->url_title}") }}" title="{{ $next->title }}">Next</a>
			@endif
		</div>
		{{-- require_entry makes it so if someone types the wrong URL, they will get a 404 page --}}

			{{-- layout vars, dynamic, not output --}}
			@section('title', '{seo_title}{gv_sep}{p_title}{gv_sep}')
			@section('description', '{seo_desc}')
			@section('entry_ch', '{ch}')
			{{-- OpenGraph meta output --}}
			@section('og_title', '{seo_title}')
			@section('og_url', $exp->path('{p_url}'))
			@section('og_description', '{seo_desc}')
			{{-- /layout vars, dynamic, not output --}}

			{{-- content output --}}
			<h1>{{ $entry->title }}</h1>
			{{-- video, youtube or vimeo? (GRID) --}}
			@if($entry->blog_video)
				@foreach($entry->blog_video as $blog_video)
					@if($blog_video->type == 'youtube')
						<figure class="video">
							<div class="player">
								<iframe width="940" height="529" src="http://www.youtube.com/embed/{{ $blog_video->id }}?rel=0&controls=2&color=white&autohide=1" frameborder="0" allowfullscreen></iframe>
							</div>
						</figure>
					@endif
					@if($blog_video->type == 'vimeo')
						<figure class="video">
							<div class="player">
								<iframe src="//player.vimeo.com/video/{{ $blog_video->id }}?color=f0a400" width="940" height="529" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
							</div>
						</figure>
					@endif
				@endforeach
			@endif
			{{-- audio, soundcloud or bandcamp? (GRID) --}}
			@if($entry->blog_audio)
				@foreach($entry->blog_audio as $blog_audio)
					@if($blog_audio->type == 'soundcloud')
						<figure class="audio-wrap">
							<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/{{ $blog_audio->id }}&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false"></iframe>
						</figure>
					@endif
					@if($blog_audio->type == 'bandcamp')
						<figure class="audio-wrap">
							<iframe style="border: 0; width: 100%; height: 120px;" src="http://bandcamp.com/EmbeddedPlayer/album={{ $blog_audio->id }}/size=large/bgcol=ffffff/linkcol=0687f5/tracklist=false/artwork=small/transparent=true/" seamless></iframe>
						</figure>
					@endif
				@endforeach
			@endif
			{{-- image (GRID) --}}
			@if($entry->blog_image)
				@foreach($entry->blog_image as $blog_image)
					<figure>
						<img src="{{ $blog_image->image }}" alt="{{ $blog_image->caption->attr_safe }}">
						<figcaption>{{ $blog_image->caption }}</figcaption>
					</figure>
				@endforeach
			@endif
			{{-- blog_content is a textarea with HTML output we don't need to wrap this tag with HTML as that is already included in it's output. --}}
			{!! $entry->blog_content !!}
			{{-- /content output --}}


			{{--
				comments
				comment:entries and comment:form are independent of channel:entries
				we've put them into a embed here to demonstrate how to get a specific
				display on the front end of the site using allow_comments.
				This would not work without the embed, as these tags would not parse
				inside the channel:entries tag.
			--}}
			@if($entry->allow_comments)
				@include("coilpack::blade/{$p_url}/_comments")
			@else
				@if($entry->comment_total >= 1)
                    @include("coilpack::blade/{$p_url}/_comments")
				@endif
				<div class="alert warn no-results">
					@if($entry->comment_expiration_date < $global->current_time->timestamp AND $entry->comment_expiration_date != 0)
						<p>{!! $global->gv_comment_expired !!}</p>
					@else
						<p>{!! $global->gv_comment_disabled !!}</p>
					@endif
				</div>
			@endif
@endsection
