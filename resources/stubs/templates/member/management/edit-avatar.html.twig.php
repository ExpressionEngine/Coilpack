{% extends 'ee::<?=$template_group?>/_layout' %}
{% block title %}Edit Avatar{% endblock %}

{% block contents %}

    {% if global.logged_out %}
        {{ exp.redirect("<?=$template_group?>/login") }}
    {% endif %}

    <a href="{{ global.cp_url }}?/cp/design/template/edit/{{ global.template_id }}" target="_blank">View Template</a>

    {% if global.last_segment == "success" %}
        <h4>Avatar edited successfully!</h4>
    {% endif %}

    <div class="result">
        {% set form = exp.member.edit_avatar({return: "<?=$template_group?>/edit-avatar/success"}) %}

        {{ form.open() | raw }}
            Current Avatar:
            {% if form.avatar_url %}
                My avatar: <img src="{{ form.avatar_url }}" border="0" width="{{ form.avatar_width }}" height="{{ form.avatar_height }}" />
            {% else %}
                No Avatar
            {% endif %}

            <div>
                Upload an avatar: <input type="file" name="userfile" size="20" class="input" /><br>
            </div>

            <input type='submit' class='submit' value='Upload Avatar' />

            {% if form.avatar_url %}
                <input type='submit' class='submit' value='Remove Avatar' name="remove" />
            {% endif %}

        {{ form.close() | raw }}
    </div>

{% endblock %}