<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="{{ route('admin.send') }}" method="post">

    @csrf

    <div class="mb-3">
        <label for="message" class="form-label">Your Message</label>
        <textarea name="message" class="form-control" id="message" rows="3" required="required"></textarea>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">To Phone Number</label>
        <input type="text" name="to" class="form-control" id="phone" placeholder="+919876543210" required="required">
    </div>

    <div>
        <button type="submit" class="btn btn-primary">Send</button>
    </div>
</form></body>






<form action="{{ url('admin/customer_action') }}" method="post">
    incoming-message
    @csrf

    <div class="mb-3">
        <label for="message" class="form-label">Your Message</label>
        <textarea name="Body" class="form-control" id="message" rows="3" required="required"></textarea>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">from</label>
        <input type="text" name="From" class="form-control" id="phone" placeholder="+919876543210" required="required">
    </div>

    <div>
        <button type="submit" class="btn btn-primary">Send</button>
    </div>
</form>


</html>
