@foreach(<?=$field_name?> as $row)
    <?php foreach ($columns as $column) : ?>
    <?php $column['field_name'] = "\$row->{$column['col_name']}"; ?>

    <?php if($show_comments ?? false): ?>

    {{-- Grid column: <?= $column['field_label'] ?> --}}
    {{-- Column type: <?= $column['field_type'] ?> --}}
    {{-- Docs: <?= $column['docs_url'] ?> --}}
    <?php endif; ?>

    <?= $this->embed($column['stub'], $column) ?>

    <?php if($show_comments ?? false): ?>

    {{-- End Grid column: <?= $column['field_label'] ?> --}}
    <?php endif; ?>
    <?php endforeach; ?>

@endforeach