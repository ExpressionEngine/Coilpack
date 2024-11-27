{% for related_member in <?=$field_name?> %}
    {{ related_member.screen_name }} - {{ related_member.username }}
{% endfor %}