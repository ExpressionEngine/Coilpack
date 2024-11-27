{% extends 'ee::<?=$template_group?>/_layout' %}
{% block title %}Role Groups{% endblock %}

{% block contents %}

<a href="{{ global.cp_url }}?/cp/design/template/edit/{{ global.template_id }}" target="_blank">View Template</a>

<div class="result">
  <h2>Your member role groups:</h2>
  <ul>
    {% for group in exp.member.role_groups() %}
      <li>{{ group.role_group_name }} ({{ group.role_group_id }})</li>
    {% endfor %}
  </ul>
</div>

{% endblock %}