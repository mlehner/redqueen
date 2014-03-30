<div class="row">
    <div class="span12">
        {% block form_header %}{% endblock %}

        {{ content() }}

        <form class="form-horizontal" method="post">
            <fieldset>
                <legend>Member</legend>

                {% for attribute, message in form.getMessages() %}
                    {{ message }}<br>
                {% endfor %}


                <div class="control-group{{ form.hasMessagesFor('name') ? ' error' : '' }}">
                    <label class="control-label" for="member-name">Name</label>
                    <div class="controls">
                        {{ form.render('name') }}
                    </div>
                </div>

                <div class="control-group{{ form.hasMessagesFor('email') ? ' error' : '' }}">
                    <label class="control-label" for="member-name">Email</label>
                    <div class="controls">
                        {{ form.render('email') }}
                    </div>
                </div>

                <div class="control-group">
                    <span class="muted" style="padding-left: 50px">Warning Changing this field will reset the users password</span>
                </div>

                <div class="control-group{{ form.hasMessagesFor('password') ? ' error' : '' }}">
                    <label class="control-label" for="member-name">Password</label>
                    <div class="controls">
                        {{ form.render('password') }}
                    </div>
                </div>

                <div class="control-group{{ form.hasMessagesFor('password_confirm') ? ' error' : '' }}">
                    <label class="control-label" for="member-name">Password Confirm</label>
                    <div class="controls">
                        {{ form.render('password_confirm') }}
                    </div>
                </div>

                {% block form_actions %}{% endblock %}
            </fielset>
        </form>
    </div>
</div>
