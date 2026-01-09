<!DOCTYPE html>
<html>
<head>
    <title>New Contact Message</title>
</head>
<body style="font-family: 'Poppins', sans-serif; color: #333;">
    <h2>New Message from Rimaginarius Website</h2>

    <p><strong>Name:</strong> {{ $contact->name }}</p>
    <p><strong>Email:</strong> {{ $contact->email }}</p>
    <p><strong>Subject:</strong> {{ $contact->subject }}</p>

    <hr>

    <p><strong>Message:</strong></p>
    <p style="white-space: pre-wrap;">{{ $contact->message }}</p>
</body>
</html>
