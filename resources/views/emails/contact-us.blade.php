<body>
    @if (isset($requestData['phone']))
        <br>
        Phone Number: {{ $requestData['phone'] }}
    @endif
    @if (isset($requestData['source']))
        <br>
        How did you hear about us: {{ $requestData['source'] }}
    @endif
    @if (isset($requestData['reason']))
        <br>
        Reason For Contacting Us: {{ $requestData['reason'] }}
    @endif
    <br>
    <br>

    Message: {{ $requestData['message']}}
</body>