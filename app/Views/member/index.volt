<div class="row">
    <div class="span12">
        <h1>Members</h1>

        {{ link_to('member/new/', 'Add Member', 'class': 'btn') }}

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Number of Cards</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Last Log</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            {% for member in members %}
                <tr>
                    <td>{{ link_to('member/edit/' ~ member.getId(), member.getName()) }}</td>
                    <td>{{ member.getEmail() }}</td>
                    <td>{{ member.Cards | length }}</td>
                    <td>{{ member.getCreatedAt().format('Y-m-d H:i:s') }}</td>
                    <td>{{ member.getUpdatedAt().format('Y-m-d H:i:s') }}</td>
                    <td>{{ member.getLastLog() ? member.getLastLog().getDateTime() : 'Never' }}</td>
                    <td>{{ link_to('member/' ~ member.getId() ~ '/card/new', 'Add Card', 'class': 'btn') }}</td>
                </tr>
            {% endfor %}
            </tbody>
        </table>
    </div>
</div>
