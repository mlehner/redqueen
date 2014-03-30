<div class="row">
    <div class="span12">

        {{ content() }}

        <form class="form-horizontal" method="post">
            <fieldset>
                <legend>Edit Card</legend>
                    {% for attribute, message in form.getMessages() %}
                        {{ message }}<br>
                    {% endfor %}

                    <div class="control-group{{ form.hasMessagesFor('pin') ? ' error' : '' }}">
                        <label class="control-label" for="card-pin">Pin</label>
                        <div class="controls">{{ form.render('pin') }}</div>
                    </div>

                    <div class="control-group{{ form.hasMessagesFor('code') ? ' error' : '' }}">
                        <label class="control-label" for="card-code">Code</label>
                        <div class="controls">{{ form.render('code') }}</div>
                    </div>
                </div>
            </fielset>
            <button type="submit">Edit a Card</button>
        </form>
    </div>
</div>
