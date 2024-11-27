{% if <?=$field_name?>.mime_type starts with 'image/' %}
    <picture>
        <?php foreach ($dimensions as $dimension) : ?>

        <source
            type="{{ <?=$field_name?>.mime_type }}"
            srcset="{{ <?=$field_name?>.manipulation('<?=$dimension?>').url }}"
            width="{{ <?=$field_name?>.manipulation('<?=$dimension?>').width }}"
            height="{{ <?=$field_name?>.manipulation('<?=$dimension?>').height }}"
            alt="{{ <?=$field_name?>.title }}"
            >
        <?php endforeach; ?>

        <img src="{{ <?=$field_name?>.url }}" width="{{ <?=$field_name?>.width }}" height="{{ <?=$field_name?>.height }}" alt="{{ <?=$field_name?>.title }}">
    </picture>
{% else %}
    <b><a href="{{ <?=$field_name?>.url }}" target="_blank">View {{ <?=$field_name?>.title }}</a></b>
{% endif %}
<br>Credit: {{ <?=$field_name?>.credit }}
<br>Location: {{ <?=$field_name?>.location }}
<br>File Name: {{ <?=$field_name?>.file_name }}
<br>File Size: {{ <?=$field_name?>.file_size }}
<br>Description: {{ <?=$field_name?>.description }}
<br>Upload Directory: {{ <?=$field_name?>.directory_title }}
<br>Upload Date: {{ <?=$field_name?>.upload_date.format("Y m d") }}
<br>Modified Date: {{ <?=$field_name?>.modified_date.format("Y m d") }}