<div class="row">
    <div class="span12">
        <h1>Members</h1>

        {{ link_to('member/new/', 'Add Member', 'class': 'btn') }}

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
                <tr>
                    <td>{{ link_to('member/edit/' ~ member.id, member.name) }}</td>
                    <td>{{ member.username }}</td>
                    <td>{{ member.email }}</td>
                    <td></td>
                    <td>{{ link_to('member/' ~ member.id ~ '/card/new', 'Add Card', 'class': 'btn') }}</td>
                </tr>
            {% endfor %}
            </tbody>
        </table>
    </div>
</div>
