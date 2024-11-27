{% extends 'ee::<?=$template_group?>/_layout' %}
{% block title %}Logout{% endblock %}

{% block contents %}

    {% if global.logged_out %}
        {{ exp.redirect("<?=$template_group?>/login") }}
    {% endif %}

    <a href="{{ global.cp_url }}?/cp/design/template/edit/{{ global.template_id }}" target="_blank">View Template</a>

    {% set form = exp.member.logout_form({return: "<?=$template_group?>/login"}) %}
    {{ form.open() | raw }}
        <input type="submit" value="Logout">
    {{ form.close() | raw }}

{% endblock %}