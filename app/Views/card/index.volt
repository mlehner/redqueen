<div class="row">
    <div class="span12">
        <h1>Cards</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Card No.</th>
                    <th>Member</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Last Login</th>
                </tr>
            </thead>
            <tbody>
            {% for card in cards %}
                <tr>
                    <td>{{ link_to('card/edit/' ~ card.getId(), card.getCode()) }}</td>
                    <td>{{ link_to('member/edit/' ~ card.getMembers().getId(), card.getMembers().getName()) }}</td>
                    <td>{{ card.getCreatedAt().format('Y-m-d H:i:s') }}</td>
                    <td>{{ card.getUpdatedAt().format('Y-m-d H:i:s') }}</td>
                    <td>{{ card.getLastLog() ? card.getLastLog().getDateTime() : 'Never' }}</td>
                </tr>
            {% endfor %}
            </tbody>
        </table>
    </div>
</div>
