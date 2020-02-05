<body>
    user type: {{ $user->account }}
    <br/><br/>
    email: {{ $user->email }}
    <br/><br/>
    firstname: {{ $user->fname ?: '--' }}
    <br/><br/>
    lastname: {{ $user->lname ?: '--' }}
</body>