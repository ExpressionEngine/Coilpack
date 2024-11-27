Title: {{ <?=$field_name?>->title }}
URL: {{ <?=$field_name?>->url }}
Mime Type: {{ <?=$field_name?>->mime_type }}
Credit: {{ <?=$field_name?>->credit }}
Location: {{ <?=$field_name?>->location }}
File Name: {{ <?=$field_name?>->file_name }}
File Size: {{ <?=$field_name?>->file_size }}
Description: {{ <?=$field_name?>->description }}
Upload Directory: {{ <?=$field_name?>->directory_title }}
Upload Date: {{ optional(<?=$field_name?>->upload_date)->format("Y m d") }}
Modified Date: {{ optional(<?=$field_name?>->modified_date)->format("Y m d") }}

@if(\Illuminate\Support\Str::startsWith(<?=$field_name?>->mime_type, 'image/'))
    Width: {{ <?=$field_name?>->width }}
    Height: {{ <?=$field_name?>->height }}

    <?php foreach ($dimensions as $dimension) : ?>

        <?=$dimension?> URL: {{ <?=$field_name?>->manipulation('<?=$dimension?>')->url }}
        <?=$dimension?> Width: {{ <?=$field_name?>->manipulation('<?=$dimension?>')->width }}
        <?=$dimension?> Height: {{ <?=$field_name?>->manipulation('<?=$dimension?>')->height }}
    <?php endforeach; ?>

@endif