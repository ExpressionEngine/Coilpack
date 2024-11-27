<?php if ($is_tag_pair) : ?>
@foreach(<?=$field_name?> as $row)
    {{-- This field is built to be used as tag pair --}}
    {{-- But we could not determine the possible variables to use inside tag pair --}}
    {{-- Please refer to the documentation link above --}}
    {{ $row }}
@endforeach
<?php else : ?>
{{ <?=$field_name?> }}
<?php endif; ?>