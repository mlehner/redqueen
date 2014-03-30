{% extends "member/form.volt" %}

{% block form_header %}
<h1>New Member</h1>
{% endblock %}

{% block form_actions %}
<div class="form-actions">
    <button type="submit" class="btn btn-primary">Save</button>
    {{ link_to('member', 'Cancel', 'class':'btn') }}
</div>
{% endblock %}
