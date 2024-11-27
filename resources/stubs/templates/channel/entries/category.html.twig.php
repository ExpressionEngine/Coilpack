<?php if($show_comments ?? false): ?>
{# This template will only include title and search excerpt #}
{# URL Format template_group/category/CATEGORY_URL_TITLE #}
<?php endif; ?>

<html>

<head>
    <title><?= $channel_title ?> Categories</title>
</head>

<body>
    <div>
        <?php if($show_comments ?? false): ?>
        {# If a category url_title is not provided list all of the categories #}
        <?php endif; ?>

        {% if segment_3 is empty %}
        <h1><?= $channel_title ?> Categories</h1>
        {% for category in exp.channel.categories({channel: "<?= $channel ?>"}) %}
            <div>
                <a href="{{ exp.path('<?= $template_group ?>/category', category.cat_url_title) }}">{{ category.cat_name }}</a>
                {% if category.cat_description %}{cat_description}{% endif %}
            </div>
        {% else %}
            <p>No categories.</p>
        {% endfor %}
        <?php if($show_comments ?? false): ?>
        {# Otherwise show entries for this category #}
        <?php endif; ?>

        {% else %}
            {% set category = exp.channel.category_heading({channel: "<?= $channel ?>", category_url_title: segment_3<?=(strpos($channel, '|') !== false) ? ', relaxed_categories:"yes"' : ''?> }) %}
            <h1>{{ category.category_name }}</h1>
            {% if category.category_description %}
                <p>{{ category.category_description }}</p>
            {% endif %}

            {% set entries = exp.channel.entries({channel: "<?= $channel ?>", per_page: 10, category: category.category_url_title}) %}
            {% for entry in entries %}
            <h3><a href="{{ exp.path('<?= $template_group ?>/entry', entry.url_title) }}">{{ entry.title }}</a></h3>
            <?php foreach (array_filter($fields, function ($field) { return $field['is_search_excerpt']; }) as $field) : ?>
                <?php $field['modifiers'] = ['limit' => ['characters' => 120]]; ?>
                <?php $field['field_name'] = "entry.{$field['field_name']}"; ?>
                <?php if($show_comments ?? false): ?>

                {# Field: <?= $field['field_label'] ?> #}
                {# Fieldtype: <?= $field['field_type'] ?> #}
                {# Docs: <?= $field['docs_url'] ?> #}
                <?php endif; ?>
                <?= $this->embed($field['stub'], $field); ?>

                <?php if($show_comments ?? false): ?>

                {# End field: <?= $field['field_label'] ?> #}
                <?php endif; ?>

            <?php endforeach; ?>

            {% else %}
                <p>No entries for this category.</p>
            {% endfor %}
            {{ entries.links }}
        {% endif %}
    </div>
</body>

</html>
