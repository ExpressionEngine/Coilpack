<div class="entry">
	{{-- title --}}
    {{-- @dd($entry) --}}
	<h2><a href="{{ $exp->path("$p_url/$p_url_entry/$entry->url_title") }}">{{ $entry->title }}</a></h2>
	<p><b>on:</b> {{ $entry->entry_date->format('n/j/Y') }} {{-- ->format('n/j/Y') }} --}}, <b>by:</b> <a href="{{ $exp->path("member/{$entry->author_id}") }}">{{ $entry->author->screen_name }}</a>, <a href="{{ $exp->path("$p_url/$p_url_entry/$entry->url_title#comments") }}">{{ $entry->comment_total }} {{ Str::plural('comment', $entry->comment_total) }}</a></p>
</div>