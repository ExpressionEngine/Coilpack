{% extends 'ee::<?=$template_group?>/_layout' %}
{% block title %}Member Registration{% endblock %}

{% block contents %}
    <a href="{{ global.cp_url }}?/cp/design/template/edit/{{ global.template_id }}" target="_blank">View Template</a>

    {% if global.logged_in %}
        {{ exp.redirect("<?=$template_group?>/index") }}
    {% endif %}

    <div class="result">
    {% if global.last_segment == "success" %}
        <h4>Account Created!</h4>

        {% if global.logged_in %}
            <p>We took the liberty of logging you in already!</p>
            <h5>Go forth and do stuff!</h5>
        {% else %}
            <p>You can now <a href="{{ exp.path('<?=$template_group?>/login') }}">login</a>.</p>
            <p>Depending on your member activation settings you will receive an email to confirm your registration.</p>
        {% endif %}
    {% elseif global.logged_in %}
        <p>You are already registered and logged in.</p>

        <p><a class="btn btn-primary" href="{{ exp.path('<?=$template_group?>/profile') }}">Go to Profile</a> &nbsp;&nbsp;&nbsp; <a class="btn btn-sm btn-warning" href="{{ exp.path('logout') }}">Logout</a></p>
    {% else %}
        {% set form = exp.member.registration_form({
                return: "<?=$template_group?>/registration/success",
                inline_errors: "yes"
            })
        %}

        {{ form.open() | raw }}
            {# You can display all errors at the top of the page or use the individual field {error:} tags shown later #}
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
                <h4>Login details</h4>

                <p>
                    <label for="username">Username*:</label><br />
                    <input type="text" name="username" id="username" value="{% if form.username %}{{ form.username }}{% endif %}"/><br />
                    {% if form.errors().has('username') %}
                        <span class="error">{{ form.errors().get('username') }}</span>
                    {% endif %}
                </p>

                <p>
                    <label for="email">Email*:</label><br />
                    <input type="text" name="email" id="email" value="{% if form.email %}{{ form.email }}{% endif %}"/><br />
                    {% if form.errors().has('email') %}
                        <span class="error">{{ form.errors().get('email') }}</span>
                    {% endif %}
                </p>

                <p>
                    <label for="password">Password*:</label><br />
                    <input type="password" name="password" id="password" value="{% if form.password %}{{ form.password }}{% endif %}"/>
                    {% if form.errors().has('password') %}
                        <span class="error">{{ form.errors().get('password') }}</span>
                    {% endif %}
                </p>

                <p>
                    <label for="password_confirm">Confirm password*:</label><br />
                    <input type="password" name="password_confirm" id="password_confirm" value="{% if form.password_confirm %}{{ form.password_confirm }}{% endif %}"/>
                    {% if form.errors().has('password_confirm') %}
                        <span class="error">{{ form.errors().get('password_confirm') }}</span>
                    {% endif %}
                </p>

                <p>
                    <label for="terms_of_service">Terms of service:</label><br />
                    <div>All messages posted at this site express the views of the author, and do not necessarily reflect the views of the owners and administrators
                        of this site. By registering at this site you agree not to post any messages that are obscene, vulgar, slanderous, hateful, threatening, or that violate any laws. We will
                        permanently ban all users who do so. We reserve the right to remove, edit, or move any messages for any reason.</div>
                </p>

                <p>
                    <label><input type="checkbox" name="accept_terms" value="y" {% if form.accept_terms == 'y' %}checked="checked"{% endif %} /> I accept these terms</label>
                    {% if form.errors().has('accept_terms') %}
                        <span class="error">{{ form.errors().get('accept_terms') }}</span>
                    {% endif %}
                </p>

                <?php foreach (array_filter($fields, function ($field) { return ($field['show_registration'] === 'y'); }) as $field) : ?>

                    <p>
                        <?php if($show_comments ?? false): ?>

                        {!-- Field: <?=$field['field_label']?> --}
                        {!-- Fieldtype: <?=$field['field_type']?> --}
                        {!-- Docs: <?=$field['docs_url']?> --}
                        <?php endif; ?>

                        <label for="<?=$field['field_name']?>" ><?=$field['field_label']?></label><br/>
                        {{ form.fields().get('<?=$field['field_name']?>').input | raw }}
                        {% if form.errors().has('<?=$field['field_name']?>') %}
                            <span class="error">{{ form.errors().get('<?=$field['field_name']?>') }}</span>
                        {% endif %}
                        <?php if($show_comments ?? false): ?>

                        {!-- End field: <?=$field['field_label']?> --}
                        <?php endif; ?>

                    </p>

                <?php endforeach; ?>

                {% if form.captcha %}
                <p>
                    <label for="captcha">Please enter the word you see in the image below:</label><br/>
                    {{ form.captcha | raw }}<br/>
                    <input type="text" id="captcha" name="captcha" value="" size="20" maxlength="20" style="width:140px;"/>
                    {% if form.errors().has('captcha') %}
                        <span class="error">{{ form.errors().get('captcha') }}</span>
                    {% endif %}
                </p>
                {% endif %}
            </fieldset>

            <input type="submit" value="Register" class="btn btn-primary" />
        {{ form.close() | raw }}
    {% endif %}
    </div>

{% endblock %}