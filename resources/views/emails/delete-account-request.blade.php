<body>
    user type: {{ $user->account }}
    <br/><br/>
    reason: {{ $data['reason'] ?? '--' }}
    <br/><br/>
    details: {{ $data['details'] ?? '--' }}
</body>