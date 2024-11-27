<?php if($show_comments ?? false): ?>
{# This template will only include title and search excerpt #}
{# URL Format template_group/archive/YEAR/MONTH #}
<?php endif; ?>
<html>

<head>
    <title><?= $channel_title ?> Archives</title>
</head>

<body>
    <div>
        <h1><?= $channel_title ?> Archives</h1>
        {% if segment_3 == '' %}
            {% set current_year = null %}
            {% for link in exp.channel.month_links({channel: "<?= $channel ?>", limit: 24}) %}
                {% if current_year != link.year %}
                    <h2><a href="{{ exp.path('<?= $template_group ?>/archive', link.year) }}">{{ link.year }}</a></h2>
                {% endif %}
                {% set current_year = link.year %}
                <a href="{{ exp.path('<?= $template_group ?>/archive', link.year, link.month_num) }}">{{ link.month }}</a><br/>
            {% endfor %}
        {% else %}
            <h2>{{ segment_3 }}{% if segment_4 is not empty %}/{{ segment_4 }}{% endif %}</h2>
            {% set entries = exp.channel.entries({channel: "<?= $channel ?>", per_page: 10, year: segment_3, month: segment_4 ? segment_4 : null}) %}
            {% for entry in entries %}
                <div>
                    <span>{{ entry.entry_date.format('Y/m/d') }}</span>
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

                </div>
            {% else %}
                <p>No entries.</p>
            {% endfor %}
            {{ entries.links }}
        {% endif %}
    </div>
</body>
</html>
