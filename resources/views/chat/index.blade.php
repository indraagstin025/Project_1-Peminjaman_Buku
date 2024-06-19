<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Chat with Pustakawan</title>

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include custom styles if any -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    @include('layouts.navigation')
    <br>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">   
                <h1 class="h4">Chat with Pustakawan</h1>
            </div>
            <div class="card-body">
                <div class="chat-box mb-3 overflow-auto" style="max-height: 500px;">
                    @foreach ($chats as $chat)
                        <div class="d-flex {{ $chat->user_id === Auth::id() ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                            <div class="p-3 rounded {{ $chat->user_id === Auth::id() ? 'bg-secondary text-white' : 'bg-primary text-white' }}">
                                <strong>{{ $chat->user_id === Auth::id() ? Auth::user()->name : $chat->user->name }}:</strong> {{ $chat->message }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <form action="{{ route('chat.store') }}" method="POST" class="chat-form">
                    @csrf
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
