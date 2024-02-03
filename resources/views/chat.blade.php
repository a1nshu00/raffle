<!-- resources/views/chat.blade.php -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<form id="chatForm">
    @csrf
    <textarea id="messages" name="messages" rows="5" cols="50"></textarea>
    <button type="submit">Generate Chat</button>
</form>

<div id="response"></div>

<script>
    document.getElementById('chatForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const messages = document.getElementById('messages').value;

        // Fetch the CSRF token from the meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/generate-chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken, // Include CSRF token in headers
            },
            body: JSON.stringify({ messages }),
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('response').innerText = data.choices[0].message.content;
        })
        .catch(error => console.error(error));
    });
</script>
