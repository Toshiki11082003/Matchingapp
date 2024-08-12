<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            チャットルーム
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3>ルームID: {{ $chat->id ?? '不明' }}</h3>
                    <form method="post" onsubmit="onsubmit_Form(); return false;">
                        @csrf
                        メッセージ : <input type="text" id="input_message" autocomplete="off" />
                        <input type="hidden" id="chat_id" name="chat_id" value="{{ $chat->id }}">
                        <button type="submit" class="text-white bg-blue-700 px-5 py-2">送信</button>
                    </form>
                    <ul class="list-disc" id="list_message">
                        @foreach ($messages as $message)
                            <li>
                                <strong>{{ $message->user->name }}:</strong>
                                <div>{{ $message->body }}</div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // CSRFトークンの設定
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const elementInputMessage = document.getElementById("input_message");
        const chatId = document.getElementById("chat_id").value;

        function onsubmit_Form() {
            let strMessage = elementInputMessage.value;
            if (!strMessage) {
                return;
            }
            let params = { 
                'message': strMessage,
                'chat_id': chatId
            };
            axios
                .post('/chat', params)
                .then(response => {
                    console.log(response);
                    appendMessage(response.data.message);
                })
                .catch(error => {
                    console.log(error.response);
                    alert('メッセージの送信に失敗しました。');
                });
            elementInputMessage.value = "";
        }

        function appendMessage(message) {
            const elementListMessage = document.getElementById("list_message");
            let elementLi = document.createElement("li");
            let elementUsername = document.createElement("strong");
            let elementMessage = document.createElement("div");
            elementUsername.textContent = message.user.name + ": ";
            elementMessage.textContent = message.body;
            elementLi.append(elementUsername);
            elementLi.append(elementMessage);
            elementListMessage.prepend(elementLi);
        }

        window.addEventListener("DOMContentLoaded", () => {
            const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                encrypted: true
            });
            const channel = pusher.subscribe('chat.' + chatId);
            channel.bind('message-sent', function(data) {
                console.log('Received message:', data);
                if (data.message.chat_id === parseInt(chatId)) {
                    appendMessage(data.message);
                }
            });
        });
    </script>
</x-app-layout>