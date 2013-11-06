<div class="row">
    <div class="span12">
        <h1>Members</h1>

        {{ link_to('member/new/', 'Add Member', 'class': 'btn') }}

		<?php $this->flashSession->output() ?>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Number of Cards</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            {% for member in members %}

			{{ dump(member) }}
                <tr>
                    <td>{{ link_to('member/edit/' ~ member.getId(), member.getName()) }}</td>
                    <td>{{ member.getUsername() }}</td>
                    <td>{{ member.getEmail() }}</td>
                    <td>{{ member.getCards() }}</td>
                    <td>{{ link_to('member/' ~ member.getId() ~ '/card/new', 'Add Card', 'class': 'btn') }}</td>
                </tr>
            {% endfor %}
            </tbody>
        </table>
    </div>
</div>
