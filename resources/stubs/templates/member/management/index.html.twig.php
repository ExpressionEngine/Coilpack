{% extends 'ee::<?=$template_group?>/_layout' %}
{% block title %}Member Listing{% endblock %}

{% block contents %}

    <a href="{{ global.cp_url }}?/cp/design/template/edit/{{ global.template_id }}" target="_blank">View Template</a>

    <div class="result">
        {% if segment_3 == 'sent' %}
            <div class="info">
                <p>If this email address is associated with an account, an email containing your username has just been emailed to you.</p>
                <p>For security reasons, we cannot confirm if this email address matches an existing account.</p>
            </div>
        {% endif %}

        {% set form = exp.member.memberlist({
                return: "<?=$template_group?>/login/forgot-username",
                inline_errors: "yes",
            })
        %}

            {% if not form.errors().isEmpty() %}
                <fieldset class="error">
                    <legend>Errors</legend>
                    {% for error in form.errors() %}
                        <p>{{ error }}</p>
                    {% endfor %}
                </fieldset>
            {% endif %}

            {{ form.open() | raw }}

                <table id="memberlist" class='tableborder' border="0" cellpadding="3" cellspacing="0" style="width:100%;">
                <thead>
                <tr>
                    <td class='memberlistHead' style="width:21%; font-weight: bold;">Name</td>
                    <td class='memberlistHead' style="width:13%; font-weight: bold;">Forum Posts</td>
                    <td class='memberlistHead' style="width:13%; font-weight: bold;">Join Date</td>
                    <td class='memberlistHead' style="width:13%; font-weight: bold;">Last Visit</td>
                    <td class='memberlistHead' style="width:13%; font-weight: bold;">Primary Role</td>
                </tr>
                </thead>
                <tbody>
                {% for row in form.member_rows %}
                    <tr>
                        <td class='{{ row.member_css }}' style="width:20%;">
                            <span class="defaultBold"><a href="{{ exp.path('<?=$template_group?>/profile/', row.member_id) }}">{{ row.name }}</a></span>
                            {% if row.avatar %}<img src="{{ row.avatar_path }}" />{% endif %}
                        </td>
                        <td class='{{ row.member_css }}'>{{ row.total_combined_posts }}</td>
                        <td class='{{ row.member_css }}'>{{ row.join_date.format("m/d/Y") }}</td>
                        <td class='{{ row.member_css }}'>{{ row.last_visit ? row.last_visit.format("m/d/Y") : '--' }}</td>
                        <td class='{{ row.member_css }}'>{{ row.role }} ({{ row.member_group }})</td>
                    </tr>
                {% endfor %}
                </tbody>
                <tfoot>
                <tr>
                    <td class='memberlistFooter' colspan="6" align='center' valign='middle'>
                        <div class="defaultSmall">
                            <b>show</b>

                            <select name='role_id' class='select'>
                                {{ form.options.role_options | raw }}
                            </select>

                            &nbsp; <b>sort</b>

                            <select name='order_by' class='select'>
                                {{ form.options.order_by_options | raw }}
                            </select>

                            &nbsp;  <b>order</b>

                            <select name='sort_order' class='select'>
                                {{ form.options.sort_order_options | raw }}
                            </select>

                            &nbsp; <b>rows</b>

                            <select name='row_limit' class='select'>
                                {{ form.options.row_limit_options | raw }}
                            </select>

                            &nbsp; <input type='submit' value='submit' class='submit' />
                        </div>
                    </td>
                </tr>
                </tfoot>
                </table>

                {% set pagination = form.pagination %}
                {% if pagination.links is not empty %}
                <div class="itempadbig">
                		{% if pagination.links.previous_page is not empty %}
                        	<a href="{{ pagination.links.previous_page.pagination_url }}">{{ pagination.links.previous_page.text | raw }}</a>
                        {% endif %}
                		{% for link in pagination.links.page %}
							{% if link.current_page %}
                            	<strong>{{ link.pagination_page_number }}</strong>
                            {% else %}
								<a href="{{ link.pagination_url }}">{{ link.pagination_page_number }}</a>
                            {% endif %}
						{% endfor %}
                        {% if pagination.links.next_page is not empty %}
                        	<a href="{{ pagination.links.next_page.pagination_url }}">{{ pagination.links.next_page.text | raw }}</a>
                        {% endif %}
                    <table cellpadding="0" cellspacing="0" border="0" class="paginateBorder">
                    <tr>
                        <td><div class="paginateStat">{{ pagination.current_page }} of {{ pagination.total }}</div></td>
                    </tr>
                    </table>
                </div>
                {% endif %}
            {{ form.close() | raw }}
    </div>
{% endblock %}