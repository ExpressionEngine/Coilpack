<ul>
    @foreach(<?=$field_name?> as $related_member)
    <li @if($loop->last) class="last" @endif><a href="{{ $exp->path("$segment_1/member", $related_member->username) }}">{{ $related_member->screen_name }}</a></li>
    @endforeach
</ul>