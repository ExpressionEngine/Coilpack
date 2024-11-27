{% extends 'ee::<?=$template_group?>/_layout' %}
{% block title %}Member Search{% endblock %}

{% block contents %}

<a href="{{ global.cp_url }}?/cp/design/template/edit/{{ global.template_id }}" target="_blank">View Template</a>

<div class="result">

    {% set form = exp.member.member_search({return: "<?=$template_group?>/index", inline_errors: "yes"}) %}
    {{ form.open() | raw }}
        {% if not form.errors().isEmpty() %}
            <fieldset class="error">
                <legend>Errors</legend>
                {% for error in form.errors() %}
                    <p>{{ error }}</p>
                {% endfor %}
            </fieldset>
        {% endif %}
        <input type="text" name="search_keywords_1" />
        <select name='search_field_1' class='select' >
            <option value='screen_name'>Search Field</option>
            <option value='screen_name'>Screen Name</option>
            <option value='email'>Email Address</option>
            {{ form.options.custom_profile_field_options | raw }}
        </select>

        {% if form.options.group_id_options is not empty %}
        <select name='search_group_id' class='select' >
            {{ form.options.group_id_options | raw }}
        </select>
        {% endif %}

        <div class="itempadbig">&nbsp; <input type='submit' value='search' class='submit' /></div>

    {{ form.close() | raw }}
</div>

{% endblock %}