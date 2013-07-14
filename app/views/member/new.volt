<div class="row">
    <div class="span12">
        <h1>New Member</h1>

        <form class="form-horizontal" method="post">
            <fieldset>
                <legend>Member</legend>

                <div class="control-group{{ form.hasMessagesFor('name') ? ' error' : '' }}">
                    <label class="control-label" for="member-name">Name</label>
                    <div class="controls">
                        {{ form.render('name') }}
                    </div>
                </div>

                <div class="control-group{{ form.hasMessagesFor('username') ? ' error' : '' }}">
                    <label class="control-label" for="member-name">Username</label>
                    <div class="controls">
                        {{ form.render('username') }}
                    </div>
                </div>
                <div class="control-group{{ form.hasMessagesFor('email') ? ' error' : '' }}">
                    <label class="control-label" for="member-name">Email</label>
                    <div class="controls">
                        {{ form.render('email') }}
                    </div>
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

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn">Cancel</button>
                </div>
            </fielset>
        </form>
    </div>
</div>
