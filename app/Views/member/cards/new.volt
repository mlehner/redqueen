<div class="row">
	<div class="span12">
		<form class="form-horizontal" method="post">
            <fieldset>
                <legend>Member</legend>

                <div class="control-group{{ form.hasMessagesFor('pin') ? ' error' : '' }}">
                    <label class="control-label" for="card-pin">Pin</label>
                    <div class="controls">
                        {{ form.render('pin') }}
                    </div>
                </div>

                <div class="control-group{{ form.hasMessagesFor('code') ? ' error' : '' }}">
                    <label class="control-label" for="card-code">Code</label>
                    <div class="controls">
                        {{ form.render('code') }}
                    </div>
                </div>
            </fielset>
		</form>
	</div>
	
</div>
