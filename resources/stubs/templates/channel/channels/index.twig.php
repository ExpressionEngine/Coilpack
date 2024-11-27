{% set entries = exp.channel.entries({channel: "<?= $channel ?>", per_page: 5}) %}
{% for entry in entries %}
    {{ entry.title }} - {{ exp.path("<?= $template_group ?>/entry/", entry.url_title) }}
    <?php foreach ($fields as $field) : ?>
    <?php if($show_comments ?? false): ?>

    {# Field: <?=$field['field_label']?> #}
    {# Fieldtype: <?=$field['field_type']?> #}
    {# Docs: <?=$field['docs_url']?> #}
    <?php endif; ?>

    <?php $field['field_name'] = "entry.{$field['field_name']}"; ?>

    <?= $this->embed($field['stub'], $field); ?>

    <?php if($show_comments ?? false): ?>

    {# End field: <?=$field['field_label']?> #}
    <?php endif; ?>

    <?php endforeach; ?>

{% endfor %}
{{ entries.links }}