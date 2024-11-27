<?php if($show_comments ?? false): ?>
{{-- This template will only include title and search excerpt --}}
<?php endif; ?>
<html>

<head>
    <title><?= $channel_title ?></title>
</head>

<body>
    <div>
        <h1><?= $channel_title ?></h1>
        @php
            $entries = $exp->channel->entries(['channel' => "<?= $channel ?>", 'per_page' => 10]);
        @endphp
        @forelse($entries as $entry)
        <h3><a href="{{ $exp->path('<?= $template_group ?>/entry', $entry->url_title) }}">{{ $entry->title }}</a></h3>
        <?php foreach (array_filter($fields, function ($field) {
            return $field['is_search_excerpt'];
        }) as $field) : ?>
            <div>
                <?php if($show_comments ?? false): ?>

                {{-- Field: <?=$field['field_label']?> --}}
                {{-- Fieldtype: <?=$field['field_type']?> --}}
                {{-- Docs: <?=$field['docs_url']?> --}}
                <?php endif; ?>

                <?php $field['field_name'] = "\$entry->{$field['field_name']}"; ?>
                <?= $this->embed($field['stub'], $field); ?>

                <?php if($show_comments ?? false): ?>

                {{-- End field: <?=$field['field_label']?> --}}
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        @empty
            <p>No entries.</p>
        @endforelse
        {{ $entries->links() }}
    </div>
</body>
</html>