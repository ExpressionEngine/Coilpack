{% if <?=$field_name?>.has_excerpt == 'y' %}
    <details>
        <summary>{{ <?=$field_name?>.excerpt | raw }}</summary>
        {{ <?=$field_name?>.extended | raw }}
    </details>
{% else %}
    {{ <?=$field_name?> | raw }}
{% endif %}