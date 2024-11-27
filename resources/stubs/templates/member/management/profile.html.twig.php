{% extends 'ee::<?=$template_group?>/_layout' %}

{% set profile = exp.member.custom_profile_data({member_id: segment_3 ?: ''}) %}

{% block title %}{{ profile.username }} Profile{% endblock %}

{% block contents %}
    {% if global.logged_out %}
        {{ exp.redirect("<?=$template_group?>/login") }}
    {% endif %}

    <a href="{{ global.cp_url }}?/cp/design/template/edit/{{ global.template_id }}" target="_blank">View Template</a>

    <div class="result">

        <table id="memberprofile" class="tableborder" border="0" cellpadding="3" cellspacing="0" style="width:100%;">
        <thead>
            <tr>
                <td class="memberprofileHead" style="width:25%;"><h3>Key</h3></td>
                <td class="memberprofileHead" style="width:75%;"><h3>Member Data</h3></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Username</td>
                <td>{{ profile.username }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ profile.email }}</td>
            </tr>
            <tr>
                <td>Screen Name</td>
                <td>{{ profile.screen_name }}</td>
            </tr>
            <tr>
                <td>Member ID</td>
                <td>{{ profile.member_id }}</td>
            </tr>
            <tr>
                <td>Member Group</td>
                <td>{{ profile.group_title }}</td>
            </tr>
            <tr>
                <td>Join Date</td>
                <td>{{ profile.join_date.format("Y-m-d H:i:s") }}</td>
            </tr>
            <tr>
                <td>Last Visit</td>
                <td>{{ profile.last_visit ? profile.last_visit.format("Y-m-d H:i:s") : '--' }}</td>
            </tr>
            <tr>
                <td>Local Time</td>
                <td>{{ profile.local_time.format("Y-m-d H:i:s") }}</td>
            </tr>
            {% if profile.avatar %}
            <tr>
                <td>Avatar</td>
                <td><img src="{{ profile.avatar_url }}" width="{{ profile.avatar_width }}" height="{{ profile.avatar_height }}" alt="{{ profile.screen_name }}'s avatar"></td>
            </tr>
            {% endif %}

            <?php foreach (array_filter($fields, function ($field) { return $field['show_profile'] === 'y'; }) as $field) : ?>

                <tr>
                    <?php if($show_comments ?? false): ?>

                    {!-- Field: <?=$field['field_label']?> --}
                    {!-- Fieldtype: <?=$field['field_type']?> --}
                    {!-- Docs: <?=$field['docs_url']?> --}
                    <?php endif; ?>

                    <td><?=$field['field_label']?></td>
                    <td>

                        <?php $field['field_name'] = "profile.{$field['field_name']}"; ?>

                        <?=$this->embed($field['stub'], $field);?>

                    </td>
                    <?php if($show_comments ?? false): ?>

                    {!-- End field: <?=$field['field_label']?> --}
                    <?php endif; ?>

                </tr>
            <?php endforeach; ?>

            <tr>
                <td>Signature</td>
                <td>{{ profile.signature }}</td>
            </tr>
        </tbody>
        </table>
    </div>
{% endblock %}