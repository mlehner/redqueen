<div class="row">
    <div class="span12">
        <h1>Quick Add Member</h1>

        <form class="form-horizontal" method="post">
            <fieldset>
                <legend>Member</legend>

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

                <div class="control-group{{ form.hasMessagesFor('code') ? ' error' : '' }}">
                    <label class="control-label" for="code">Code</label>
                    <div class="controls">
                        {{ form.render('code') }}
                    </div>
                </div>

                <div class="control-group{{ form.hasMessagesFor('pin') ? ' error' : '' }}">
                    <label class="control-label" for="member-name">Pin</label>
                    <div class="controls">
                        {{ form.render('pin') }}
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save</button>
                    {{ link_to('member', 'Cancel', 'class':'btn') }} 
                </div>
            </fielset>
        </form>
    </div>
</div>
