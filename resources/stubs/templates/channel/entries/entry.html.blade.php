<html>
    @php
        $entry = $exp->channel->entries(['channel' => "<?= $channel ?>", 'dynamic' => true])->first();
    @endphp
    @if(empty($entry))
        {{ $exp->redirect(404) }}
    @endif
    <head>
        <title>{{ $entry->title }}</title>
    </head>

    <body>
        <h1>{{ $entry->title }}</h1>
        <p>by {{ $entry->author->screen_name }} on <a href="{{ $exp->path('<?=$template_group?>/archive', $entry->entry_date->format('Y')) }}">{{ $entry->entry_date->format('F d, Y') }}</a></p>
        @foreach($entry->categories as $category)
            <a href="{{ $exp->path('<?=$template_group?>/category', $category->cat_url_title) }}">{{ $category->cat_name }}</a>
        @endforeach
        <?php foreach ($fields as $field) : ?>

            <div>
                <?php if($show_comments ?? false): ?>

                {{-- Field: <?=$field['field_label']?> --}}
                {{-- Fieldtype: <?=$field['field_type']?> --}}
                {{-- Docs: <?=$field['docs_url']?> --}}
                <?php endif; ?>

                <?php $field['field_name'] = "\$entry->{$field['field_name']}"; ?>
                <?=$this->embed($field['stub'], $field);?>
                <?php if($show_comments ?? false): ?>

                {{-- End field: <?=$field['field_label']?> --}}
                <?php endif; ?>

            </div>

        <?php endforeach; ?>

        <hr>
        {!! $exp->embed("<?=$template_group?>/_comment_form") !!}

        <hr>

        @php
            $prev = $exp->channel->prev_entry(['channel' => "<?=$channel?>", 'url_title' => $entry->url_title]);
            $next = $exp->channel->next_entry(['channel' => "<?=$channel?>", 'url_title' => $entry->url_title]);
        @endphp

        @if(!empty($next->title))
            <p>Next entry: <a href="{{ $exp->path('<?=$template_group?>/entry', $next->url_title) }}">{{ $next->title }}</a></p>
        @endif

        @if(!empty($prev->title))
            <p>Previous entry: <a href="{{ $exp->path('<?=$template_group?>/entry', $prev->url_title) }}">{{ $prev->title }}</a></p>
        @endif
    </body>
</html>