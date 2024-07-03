<?php $this->extend('ee:_templates/default-nav'); ?>

<div class="box panel">
    <div class="panel-heading">
        <h2>Version Information</h2>
    </div>
    <?php
    $table = ee('CP/Table', ['autosort' => true]);
    $table->setColumns(['name', 'version']);
    $table->setData(array_map(function ($name) use ($versions) {
        return [$name, ltrim($versions[$name], 'v')];
    }, array_keys($versions)));
    $this->embed('ee:_shared/table', $table->viewData(ee('CP/URL', 'coilpack/overview')));
    ?>
    <div class="panel-footer">
        <a href="https://expressionengine.github.io/coilpack-docs/" target="_blank">Learn more about Coilpack</a>
    </div>
</div>