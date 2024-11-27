<html>
    <head>
        <title>Publish Entry in <?=$channel_title?></title>
        {# https://docs.expressionengine.com/latest/channels/channel-form/overview.html #}
        <link href="{{ exp.path('css/_ee_channel_form_css') }}" type="text/css" rel="stylesheet" media="screen">
    </head>
    <body>
        <div>
            {% if segment_2 is not empty %}
                {% for entry in exp.channel.entries({channel: "<?= $channel ?>", url_title: segment_2}) %}
                    <h1>Edit entry {{ entry.title }}</h1>
                {% else %}
                    {{ exp.redirect("<?=$template_group?>") }}
                {% endfor %}
            {% else %}
                <h1>Create entry in <?=$channel_title?></h1>
            {% endif %}
            {# Use error_handling="inline" if you want to show error messages next to their fields #}
            {% set form = exp.channel.form({channel: "<?=$channel?>", url_title: segment_2, error_handling: "message"}) %}
            {{ form.open() | raw }}
                <fieldset>
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" value="{{ form.title }}" size="50" maxlength="200" onkeyup="liveUrlTitle(event);">
                    {% if form.errors.has('title') %}
                        {{ form.errors.get('title') }}
                    {% endif %}
                </fieldset>

                <fieldset>
                    <label for="url_title">URL Title</label>
                    <input type="text" name="url_title" id="url_title" value="{{ form.url_title }}" maxlength="<?=URL_TITLE_MAX_LENGTH?>" size="50">
                    {% if form.errors.has('url_title') %}
                        {{ form.errors.get('url_title') }}
                    {% endif %}
                </fieldset>

                <?php foreach ($fields as $field) : ?>
                    <?php if($show_comments ?? false): ?>

                    {# Field: <?=$field['field_label']?> #}
                    {# Fieldtype: <?=$field['field_type']?> #}
                    {# Docs: <?=$field['docs_url']?> #}
                    <?php endif; ?>

                    <fieldset class="element-wrapper <?=$field['field_type']?>-wrap">
                        <label for="<?=$field['field_name']?>" class="element-label"><?=$field['field_label']?></label>
                        {{ form.fields().get('<?=$field['field_name']?>').input | raw }}
                        {% if form.errors().has('<?=$field['field_name']?>') %}
                            {{ form.errors().get('<?=$field['field_name']?>') }}
                        {% endif %}
                    </fieldset>
                    <?php if($show_comments ?? false): ?>

                    {# End field: <?=$field['field_label']?> #}
                    <?php endif; ?>
                <?php endforeach; ?>

                <button type="submit">Submit</button>
            {{ form.close() | raw }}
        </div>
    </body>
</html>