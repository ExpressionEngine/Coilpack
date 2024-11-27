@foreach(<?=$field_name?> as $related_member)
    {{ $related_member->screen_name }} - {{ $related_member->username }}
@endforeach