<ul>
    {% for related_member in <?=$field_name?> %}
    <li {% if loop.last %} class="last" {% endif %}><a href="{{ exp.path('#{segment_1}/member', related_member.username) }}">{{ related_member.screen_name }}</a></li>
    {% endfor %}
</ul>