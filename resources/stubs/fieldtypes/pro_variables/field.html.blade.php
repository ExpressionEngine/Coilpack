<?php if ($field_settings['lv_ft_multiple'] == 'n') : ?>
{{ $exp->pro_variables->single(['var' => "<?=$field_name?>"]) }}
<?php else : ?>
    {{-- Not Yet Supported
    {{ $exp->pro_variables->pair(['var' => "<?=$field_name?>"]) }} --}}
<?php endif; ?>