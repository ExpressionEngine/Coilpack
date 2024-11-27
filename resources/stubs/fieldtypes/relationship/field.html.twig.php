<ul>
    {% for related_entry in <?=$field_name?> %}
    <li {% if loop.last %} class="last" {% endif %}><a href="{{ exp.path('#{segment_1}/details', related_entry.url_title) }}">{{ related_entry.title }}</a></li>
    {% endfor %}
</ul>