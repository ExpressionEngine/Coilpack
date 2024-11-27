{% extends 'ee::<?=$template_group?>/_layout' %}
{% block title %}Edit Profile{% endblock %}

{% block contents %}

    {% if global.logged_out %}
        {{ exp.redirect("<?=$template_group?>/login") }}
    {% endif %}

    <a href="{{ global.cp_url }}?/cp/design/template/edit/{{ global.template_id }}" target="_blank">View Template</a>

    {% if global.last_segment == "success" %}
        <h4>Edited successfully!</h4>
    {% endif %}

    <div class="result">
        <p>
            {% set mfa = exp.member.mfa_links() %}
            <h4>MFA</h4>
            {% if mfa.disable_mfa_link %}
                <a href="{{ mfa.disable_mfa_link }}">Disable MFA</a>
            {% else %}
                <a href="{{ mfa.enable_mfa_link }}">Enable MFA</a>
            {% endif %}
        </p>
        {% set form = exp.member.edit_profile({
            return: "<?=$template_group?>/edit-profile/success",
            include_assets: "yes",
            inline_errors: "yes",
            datepicker: "yes",
        }) %}

        {{ form.open() | raw }}
            {# You can display all errors at the top of the page or use the individual field {% if form.errors().has('field') %} tags shown later #}
            {#
            {% if not form.errors().isEmpty() %}
                <fieldset class="error">
                    <legend>Errors</legend>
                    {% for key, error in form.errors() %}
                        <p>{{ key }}: {{ error }}</p>
                    {% endfor %}
                </fieldset>
            {% endif %}
            #}
            <p>* Required fields</p>
            <fieldset>
                <h4>Profile</h4>
                <p>
                    <label for="username">Username*:</label><br />
                    <input type="text" name="username" id="username" value="{% if form.old().has('username') %}{{ form.old().get('username') }}{% else %}{{ form.username }}{% endif %}" /><br />
                    {% if form.errors().has('username') %}
                        <span class="error">{{ form.errors().get('username') }}</span>
                    {% endif %}
                </p>

                <p>
                    <label for="email">Email:</label><br />
                    <input type="text" name="email" id="email" value="{% if form.old().has('email') %}{{ form.old().get('email') }}{% else %}{{ form.email }}{% endif %}" /><br />
                    {% if form.errors().has('email') %}
                        <span class="error">{{ form.errors().get('email') }}</span>
                    {% endif %}
                </p>

                <p>
                    <label for="password">Password:</label><br />
                    <input type="password" name="password" id="password" value="" />
                    {% if form.errors().has('password') %}
                        <span class="error">{{ form.errors().get('password') }}</span>
                    {% endif %}
                </p>

                <p>
                    <label for="password_confirm">Confirm password*:</label><br />
                    <input type="password" name="password_confirm" id="password_confirm" value="" />
                    {% if form.errors().has('password_confirm') %}
                        <span class="error">{{ form.errors().get('password_confirm') }}</span>
                    {% endif %}
                </p>

                <p>
                    <label for="current_password">Current password*:</label><br />
                    <em>You <b>must</b> enter your current password to change your password, username or email.</em>
                    <input type="password" name="current_password" id="current_password" value="" />
                    {% if form.errors().has('current_password') %}
                        <span class="error">{{ form.errors().get('current_password') }}</span>
                    {% endif %}
                </p>


                {% for field in form.fields() %}
                <p>
                    <label>{{ field.field_label }}</label><br>
                    {% if field.field_description %}
                        <small>{{ field.field_description }}</small><br>
                    {% endif %}

                    {{ field.input | raw }}
                    {% if form.errors().has(field.field_name) %}
                        <span class="error">{{ form.errors().get(field.field_name) }}</span>
                    {% endif %}
                </p>
                {% endfor %}

                <input type="submit" value="Save" class="btn btn-primary" />

            </fieldset>
        {{ form.close() | raw }}
    </div>

{% endblock %}