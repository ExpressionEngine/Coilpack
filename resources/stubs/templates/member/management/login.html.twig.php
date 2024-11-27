{% extends 'ee::<?=$template_group?>/_layout' %}
{% block title %}Login{% endblock %}

{% block contents %}
    <a href="{{ global.cp_url }}?/cp/design/template/edit/{{ global.template_id }}" target="_blank">View Template</a>

    {% if global.logged_in %}
        <h2>You are already logged in as {{ global.username }}.</h2>
    {% endif %}

    <div class="result">
        {% if segment_3 == 'forgot-username' %}
            <div class="info">
                <p>If this email address is associated with an account, an email containing your username has just been emailed to you.</p>
                <p>For security reasons, we cannot confirm if this email address matches an existing account.</p>
            </div>
        {% endif %}

        {% set form = exp.member.login_form({ return: "<?=$template_group?>/index", inline_errors: "yes"}) %}
        {{ form.open() | raw }}
            {!-- You can display all errors at the top of the page or use the individual field {error:} tags shown later --}
            {!--
            {% if not form.errors().isEmpty() %}
                <fieldset class="error">
                    <legend>Errors</legend>
                    {% for error in form.errors() %}
                        <p>{{ error }}</p>
                    {% endfor %}
                </fieldset>
            {% endif %}
            --}

            {% if form.errors().has('general') %}
                <span class="error">{{ form.errors().get('general') }}</span>
            {% endif %}
            <p>
                <label>Username</label><br />
                <input type="text" name="username" value="{% if form.old().has('username') %}{{ form.old().get('username') }}{% endif %}" maxlength="32" size="25" />
                {% if form.errors().has('username') %}
                    <span class="error">{{ form.errors().get('username') }}</span>
                {% endif %}
            </p>
            <p>
                <label>Password</label><br />
                <input type="password" name="password" value="" maxlength="32" size="25" />
                {% if form.errors().has('password') %}
                    <span class="error">{{ form.errors().get('password') }}</span>
                {% endif %}
            </p>
            {% if form.auto_login %}
            <p>
                <input type="checkbox" name="auto_login" value="1" /> Auto-login on future visits
            </p>
            {% endif %}

            <p>
                <input type="checkbox" name="anon" value="1" checked="checked" /> Show my name in the online users list
            </p>

            <p><input type="submit" name="submit" value="Submit" /></p>

            <p><a href="{{ exp.path('<?=$template_group?>/forgot-password') }}">Forgot password?</a> &nbsp; &nbsp; <a href="{{ exp.path('<?=$template_group?>/forgot-username') }}">Forgot username?</a></p>
        {{ form.close() | raw }}
    </div>
{% endblock %}