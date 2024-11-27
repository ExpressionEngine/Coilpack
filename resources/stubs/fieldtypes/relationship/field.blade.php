@foreach(<?=$field_name?> as $related_entry)
    {{ $related_entry->title }} - {{ $related_entry->url_title }}
@endforeach