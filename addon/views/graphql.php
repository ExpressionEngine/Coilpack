<?php $this->extend('ee:_templates/default-nav'); ?>


<?php if (config('coilpack.graphql.enabled') && config('coilpack.graphql.graphiql') !== false) : ?>
    <div style="height: 100%">
        <iframe src="/graphiql" width="100%" style="border:none;height:85vh;"></iframe>
    </div>
<?php else : ?>
    <div class="box panel">
        <div class="panel-heading">
            <h2>GraphQL</h2>
        </div>
        <div class="panel-body">
            <p><strong>GraphQL support is currently disabled.</strong></p>
            <p>Learn how to enable and use GraphQL through <a href="https://expressionengine.github.io/coilpack-docs/docs/graphql/" target="_blank">the Coilpack Documentation</a>.</p>
        </div>
    </div>
<?php endif; ?>