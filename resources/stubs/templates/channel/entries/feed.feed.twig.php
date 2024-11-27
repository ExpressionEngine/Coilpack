<?='<?xml version="1.0"?>'."\n"?>
<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/">
    <channel>
        <title>{{ global.site_name }}</title>
        <link>{{ global.site_url }}</link>
        <description>{{ global.site_description }}</description>
        {% for entry in exp.channel.entries({channel: "<?= $channel ?>", with: "categories"}) %}
        <item>
            <title>{{ entry.title }}</title>
            <link>{{ exp.path('<?=$template_group?>/entry', entry.url_title) }}</link>
            <pubDate>{{ entry.entry_date.format('r') }}</pubDate>
            {% for category in entry.categories %}
                <category>{{ category.category_name }}</category>
            {% endfor %}
            <?php foreach (array_filter($fields, function ($field) { return $field['is_search_excerpt']; }) as $field) : ?>
                <?php $field['modifiers'] = ['limit' => ['characters' => 120]]; ?>
                <?php $field['field_name'] = "entry.{$field['field_name']}"; ?>
                <description>
                    <?=$this->embed($field['stub'], $field);?>
                </description>
            <?php endforeach; ?>

        </item>
        {% endfor %}
    </channel>
</rss>

