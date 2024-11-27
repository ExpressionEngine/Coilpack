<ul>
    @foreach(<?=$field_name?>->selected as $value => $label)
    <li aria-label="{{ $label }}">{{ $label }} ({{ $value }})</li>
    @endforeach
</ul>