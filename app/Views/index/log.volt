<table class="table">
    <thead>
        <tr>
            <th>Card No.</th>
            <th>Valid Pin?</th>
            <th>Date/Time</th>
            <th>Member</th>
        </tr>
    </thead>
    <tbody>
        {% for log in logs %}
        <tr>
            <td>{{ log.getCode() }}</td>
            <td>{{ log.wasValidPin() ? '<span class="badge badge-success">yes</span>' : '<span class="badge badge-danger">no</span>' }}</td>
            <td>{{ log.getDatetime() }}</td>
            <td>{{ log.getMemberName() }}</td>
        </tr>
        {% endfor %}
        {% if logs|length == 0 %}
        <tr>
            <td colspan="2">No logs available.</td>
        </tr>
        {% endif %}
    </tbody>
</table>
