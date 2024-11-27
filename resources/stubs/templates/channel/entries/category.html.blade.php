<?php if($show_comments ?? false): ?>
{{-- This template will only include title and search excerpt --}}
{{-- URL Format template_group/category/CATEGORY_URL_TITLE --}}
<?php endif; ?>

<html>

<head>
    <title><?= $channel_title ?> Categories</title>
</head>

<body>
    <div>
        <?php if($show_comments ?? false): ?>
        {{-- If a category url_title is not provided list all of the categories --}}
        <?php endif; ?>

        @if(empty($segment_3))
        <h1><?= $channel_title ?> Categories</h1>
        @forelse($exp->channel->categories(['channel' => "<?= $channel ?>"]) as $category)
            <div>
                <a href="{{ $exp->path('<?= $template_group ?>/category', $category->cat_url_title) }}">{{ $category->cat_name }}</a>
                @if($category->cat_description){{ $category->cat_description }}@endif
            </div>
        @empty
            <p>No categories.</p>
        @endforelse
        <?php if($show_comments ?? false): ?>
        {{-- Otherwise show entries for this category --}}
        <?php endif; ?>

        @else
            @php
                $category = $exp->channel->category_heading(['channel' => "<?= $channel ?>", 'category_url_title' => $segment_3<?=(strpos($channel, '|') !== false) ? ", 'relaxed_categories' => 'yes'" : ''?>]);
            @endphp
            <h1>{{ $category->category_name }}</h1>
            @if($category->category_description)
                <p>{{ $category->category_description }}</p>
            @endif

            @php
                $entries = $exp->channel->entries(['channel' => "<?= $channel ?>", 'per_page' => 10, 'category' => $category->category_url_title ]);
            @endphp

            @forelse($entries as $entry)
            <h3><a href="{{ $exp->path('<?= $template_group ?>/entry', $entry->url_title) }}">{{ $entry->title }}</a></h3>
            <?php foreach (array_filter($fields, function ($field) { return $field['is_search_excerpt']; }) as $field) : ?>
                <?php $field['modifiers'] = ['limit' => ['characters' => 120]]; ?>
                <?php $field['field_name'] = "entry->{$field['field_name']}"; ?>
                <?php if($show_comments ?? false): ?>

                {{-- Field: <?= $field['field_label'] ?> --}}
                {{-- Fieldtype: <?= $field['field_type'] ?> --}}
                {{-- Docs: <?= $field['docs_url'] ?> --}}
                <?php endif; ?>
                <?= $this->embed($field['stub'], $field); ?>

                <?php if($show_comments ?? false): ?>

                {{-- End field: <?= $field['field_label'] ?> --}}
                <?php endif; ?>

            <?php endforeach; ?>

            @empty
                <p>No entries for this category.</p>
            @endforelse
            {{ $entries->links() }}
        @endif
    </div>
</body>

</html>
