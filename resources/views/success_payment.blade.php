<html>
<head>
</head>
<body>
    <form name="downloadForm" action="{{ $result->Model->AcsUrl }}" method="POST">
        <input type="hidden" name="PaReq" value="{{ $result->Model->PaReq }}">
        <input type="hidden" name="MD" value="{{ $result->Model->TransactionId }}">
        {{-- Purchase id route param --}}
        <input type="hidden" name="TermUrl" value="{{ route('checkout-success', ['_token' => csrf_token(), 'purchase_id' => $purchase->id]) }}">
    </form>
<script>
    window.onload = submitForm;
    function submitForm() { downloadForm.submit(); }
</script>
</body>
</html>
