{% extends 'ee::<?=$template_group?>/_layout' %}
{% block title %}Forgot Username{% endblock %}

{% block contents %}
    {% if global.logged_in %}
        <h2>You are already logged in as {{ global.username }}.</h2>
    {% endif %}

    <div class="result">
        {% if segment_3 == 'sent' %}
            <div class="info">
                <p>If this email address is associated with an account, an email containing your username has just been emailed to you.</p>
                <p>For security reasons, we cannot confirm if this email address matches an existing account.</p>
            </div>
        {% endif %}

        {% set form = exp.member.forgot_username_form({
                return: "<?=$template_group?>/login/forgot-username",
                inline_errors: "yes",
                email_subject: "Your Username",
                email_template: "<?=$template_group?>/email-forgot-username",
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