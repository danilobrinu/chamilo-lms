<div class="social-profile text-center">
    {% if show_group %}
        <img src="{{ user_group_image.file }}" class="img-profile img-responsive img-circle">
        <div class="caption">
            <h4 class="group-title">
                <a href="{{ _p.web_main ~ 'social/group_view.php?id=' ~ group_id }}">{{ user_group.name }}</a>
            </h4>
            <p class="group-description">{{ user_group.description }}</p>
            {% if user_is_group_admin %}
                <div id="edit_image">
                    <a class="btn btn-default" href="{{ _p.web_main ~ 'social/group_edit.php?id=' ~ group_id }}">
                        {{ 'EditGroup'|get_lang }}
                    </a>
                </div>
            {% endif %}
        </div>
    {% elseif show_user %}
        <a href="{{ user_image.big }}" class="expand-image">
            <img class="img-responsive img-circle" src="{{ user_image.normal }}">
        </a>
    {% endif %}
</div>
