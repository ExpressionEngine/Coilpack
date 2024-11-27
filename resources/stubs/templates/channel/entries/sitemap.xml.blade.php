<?='<?xml version="1.0" encoding="UTF-8"?>'."\n"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    @foreach($exp->channel->entries(['channel' => "<?= $channel ?>"]) as $entry)
    <url>
        <loc>{{ $exp->path('<?=$template_group?>/entry', $entry->url_title) }}</loc>
        <lastmod>{{ $entry->edit_date->format('Y-m-d') }}</lastmod>
    </url>
    @endforeach
</urlset>
