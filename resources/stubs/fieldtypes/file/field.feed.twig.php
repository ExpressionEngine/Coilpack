{% if <?=$field_name?>.mime_type starts with 'image/' %}
    <media:group>
        <?php foreach ($dimensions as $dimension) : ?>

            <media:content medium="image" fileSize="{{ <?=$field_name?>.file_size }}" url="{{ <?=$field_name?>.manipulation('<?=$dimension?>').url }}" width="{{ <?=$field_name?>.manipulation('<?=$dimension?>').width }}" height="{{ <?=$field_name?>.manipulation('<?=$dimension?>').height }}" />
        <?php endforeach; ?>

        <media:content isDefault="true" medium="image" fileSize="{{ <?=$field_name?>.file_size }}" url="{{ <?=$field_name?>.url }}" width="{{ <?=$field_name?>.width }}" height="{{ <?=$field_name?>.height }}">
            <media:title type="plain">{{ <?=$field_name?>.title }}</media:title>
            <media:description type="plain">{{ <?=$field_name?>.description }}</media:description>
            <media:credit>{{ <?=$field_name?>.credit }}</media:credit>
        </media:content>
    </media:group>
{% else %}
    <media:content url="{{ <?=$field_name?>.url }}" fileSize="{{ <?=$field_name?>.file_size }}" type="{{ <?=$field_name?>.mime_type }}" isDefault="true">
        <media:title type="plain">{{ <?=$field_name?>.title }}</media:title>
        <media:description type="plain">{{ <?=$field_name?>.description }}</media:description>
        <media:credit>{{ <?=$field_name?>.credit }}</media:credit>
    </media:content>
{% endif %}
