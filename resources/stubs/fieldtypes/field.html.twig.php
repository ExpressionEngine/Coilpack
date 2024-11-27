<?php if ($is_tag_pair) : ?>
<div>
    {% for row in <?=$field_name?> %}
        {# This field is built to be used as tag pair #}
        {# But we could not determine the possible variables to use inside tag pair #}
        {# Please refer to the documentation link above #}
        {{ row }}
    {% endfor %}
</div>
<?php else : ?>
<div>
    {{ <?=$field_name?> }}
</div>
<?php endif; ?>