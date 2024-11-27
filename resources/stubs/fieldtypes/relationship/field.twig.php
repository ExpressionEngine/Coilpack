{% for related_entry in <?=$field_name?> %}
    {{ related_entry.title }} - {{ related_entry.url_title }}
{% endfor %}