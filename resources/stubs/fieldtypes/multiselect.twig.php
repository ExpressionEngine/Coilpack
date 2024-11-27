{% for value, label in <?=$field_name?>.selected %}
    {{ label }}: {{ value }}
{% endfor %}