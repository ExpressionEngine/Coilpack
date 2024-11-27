<ul>
    @foreach(<?=$field_name?> as $related_entry)
    <li @if($loop->last) class="last" @endif><a href="{{ $exp->path("$segment_1/details", $related_entry->url_title) }}">{{ $related_entry->title }}</a></li>
    @endforeach
</ul>