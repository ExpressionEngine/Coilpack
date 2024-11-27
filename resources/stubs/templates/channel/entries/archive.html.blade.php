<?php if($show_comments ?? false): ?>
{{-- This template will only include title and search excerpt --}}
{{-- URL Format template_group/archive/YEAR/MONTH --}}
<?php endif; ?>
<html>

<head>
    <title><?= $channel_title ?> Archives</title>
</head>

<body>
    <div>
        <h1><?= $channel_title ?> Archives</h1>
        @if($segment_3 == '')
            @php
                $current_year = null;
            @endphp
            @foreach($exp->channel->month_links(['channel' => "<?= $channel ?>", 'limit' => 24]) as $link)
                @if($current_year != $link->year)
                    <h2><a href="{{ $exp->path('<?= $template_group ?>/archive', $link->year) }}">{{ $link->year }}</a></h2>
                @endif
                @php
                    $current_year = link->year;
                @endphp
                <a href="{{ $exp->path('<?= $template_group ?>/archive', $link->year, $link->month_num) }}">{{ $link->month }}</a><br/>
            @endforeach
        @else
            <h2>{{ $segment_3 }}@if(!empty($segment_4))/{{ $segment_4 }}@endif</h2>
            @php
                $entries = $exp->channel->entries(['channel' => "<?= $channel ?>", 'per_page' => 10, 'year' => $segment_3, 'month' => ($segment_4 ?: null) ]);
            @endphp
            @forelse($entries as $entry)
                <div>
                    <span>{{ $entry->entry_date->format('Y/m/d') }}</span>
                    <h3><a href="{{ $exp->path('<?= $template_group ?>/entry', $entry->url_title) }}">{{ $entry->title }}</a></h3>
                    <?php foreach (array_filter($fields, function ($field) { return $field['is_search_excerpt']; }) as $field) : ?>
                        <?php $field['modifiers'] = ['limit' => ['characters' => 120]]; ?>
                        <?php $field['field_name'] = "\$entry->{$field['field_name']}"; ?>
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

                </div>
            @empty
                <p>No entries.</p>
            @endforelse
            {{ $entries->links() }}
        @endif
    </div>
</body>
</html>
