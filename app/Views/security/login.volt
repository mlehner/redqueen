{{ form() }}

<div class="well">

{{ content() }}

{% for attribute, message in form.getMessages() %}
    {{ message }}<br>
{% endfor %}



<div class="form-group">
{{ form.render('email') }}
</div>

<div class="form-group">
{{ form.render('password') }}
</div>

<div class="form-group">
{{ form.render('go') }}
</div>

{{ form.render('csrf', [ 'value': security.getSessionToken() ]) }}

</div>

</form>
