{% for fluid_row in <?=$field_name?> %}
    <?php if($show_comments ?? false): ?>

    {# Fluid Field variables
    Value: {{ fluid_row }}

    Field Type: {{ fluid_row._field_type }} or {{ fluid_row.field.field_type }}
    Field Name: {{ fluid_row._field_name }} or {{ fluid_row.field.field_name }}
    Group Name: {{ fluid_row._field_name }} or {{ fluid_row.group.short_name }}

    Field (when fluid_row is a field): {{ fluid_row.field }}
    Group (when fluid_row is a field group): {{ fluid_row.group }}

    Condition for fields - {% if fluid_row.field %} ... {% endif %}
    Condition for field groups - {% if fluid_row.group %} ... {% endif %}
    #}
    <?php endif; ?>


<?php foreach ($fluidFields as $fluidFieldName => $fluidField) : ?>
    <?php if($show_comments ?? false): ?>

    {# Fluid Field: <?= $fluidField['field_label'] ?> #}
    {# Fieldtype: <?= $fluidField['field_type'] ?> #}
    {# Docs: <?= $fluidField['docs_url'] ?> #}
    <?php endif; ?>

    {% if fluid_row.field and fluid_row._field_name == '<?=$fluidField['field_name']?>' %}

    <?php $fluidField['field_name'] = "fluid_row"; ?>

    <?= $this->embed($fluidField['stub'], $fluidField) ?>

    {% endif %}
    <?php if($show_comments ?? false): ?>

    {# End Fluid Field: <?= $fluidField['field_label'] ?> #}
    <?php endif; ?>
<?php endforeach; ?>
<?php foreach ($fluidFieldGroups as $fluidFieldGroupName => $fluidFields) : ?>
    <?php if($show_comments ?? false): ?>

    {# Fluid Field Group: <?= $fluidFieldGroupName ?> #}
    <?php endif; ?>
<?php foreach ($fluidFields as $fluidFieldName => $fluidField) : ?>
    <?php if($show_comments ?? false): ?>

    {# Fluid Field: <?= $fluidField['field_label'] ?> #}
    {# Fieldtype: <?= $fluidField['field_type'] ?> #}
    {# Docs: <?= $fluidField['docs_url'] ?> #}
    <?php endif; ?>

    {% if fluid_row.group and fluid_row._field_name == '<?= $fluidFieldGroupName ?>' %}

    <?php $fluidField['field_name'] = "fluid_row.fields.{$fluidField['field_name']}"; ?>
    <?= $this->embed($fluidField['stub'], $fluidField) ?>

    {% endif %}
    <?php if($show_comments ?? false): ?>

    {# End Fluid Field: <?= $fluidField['field_label'] ?> #}
    <?php endif; ?>
<?php endforeach; ?>
    <?php if($show_comments ?? false): ?>

    {# End Fluid Field Group: <?= $fluidFieldGroupName ?> #}
    <?php endif; ?>
<?php endforeach; ?>

{% endfor %}