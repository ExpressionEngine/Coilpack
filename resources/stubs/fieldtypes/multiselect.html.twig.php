<ul>
    {% for value, label in <?=$field_name?>.selected %}
    <li aria-label="{{ label }}">{{ label }} ({{ value }})</li>
    {% endfor %}
</ul>