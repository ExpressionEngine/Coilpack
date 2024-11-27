{% extends 'ee::<?=$template_group?>/_layout' %}
{% block title %}Forgot Password{% endblock %}

{% block contents %}

    {% if global.logged_in %}
        <h2>You are already logged in as {{ global.username }}.</h2>
    {% endif %}

    <div class="result">
        {% if segment_3 == 'sent' %}
            <div class="info">
                <p>If this email address is associated with an account, instructions for resetting your password have just been emailed to you.</p>
                <p>For security reasons, we cannot confirm if this email address matches an existing account.</p>
            </div>
        {% endif %}

        {% set form = exp.member.forgot_password_form({
                return: "<?=$template_group?>/forgot-password/sent",
                inline_errors: "yes",
                password_reset_url: "<?=$template_group?>/reset-password",
                password_reset_email_template: "<?=$template_group?>/email-password-reset",
            })
        %}
        {{ form.open() | raw }}

            {% if not form.errors().isEmpty() %}
                <fieldset class="error">
                    <legend>Errors</legend>
                    {% for error in form.errors() %}
                        <p>{{ error }}</p>
                    {% endfor %}
                </fieldset>
            {% endif %}
            <p>
                <label>Your Email Address</label><br />
                <input type="email" name="email" value="{% if form.old().has('email') %}{{ form.old().get('email') }}{% endif %}" maxlength="120" size="40" />
            </p>

            <p><input type="submit" name="submit" value="Submit" /></p>

            <p><a href="{{ exp.path('<?=$template_group?>/login') }}">Login</a> &nbsp; &nbsp; <a href="{{ exp.path('<?=$template_group?>/registration') }}">Register</a></p>
        {{ form.close() | raw }}
    </div>

{% endblock %}