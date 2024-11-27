@foreach(<?=$field_name?>->selected as $value => $label)
    {{ $label }}: {{ $value }}
@endforeach