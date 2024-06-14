<!-- resources/views/chats/chat.blade.php -->
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
                    <h3>ルームID: {{ $chat->id }}</h3>
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
<script>
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
            })
            .catch(error => {
                console.log(error.response);
            });

        elementInputMessage.value = "";
    }

    window.addEventListener("DOMContentLoaded", () => {
        const elementListMessage = document.getElementById("list_message");

        window.Echo.private('chat.' + chatId) // 修正: ルームごとに異なるチャンネルに変更
            .listen('MessageSent', (e) => {
                console.log(e);

                if (e.chat.chat_id === parseInt(chatId)) { // 修正: room_id を chat_id に変更
                    let strUsername = e.chat.userName; 
                    let strMessage = e.chat.body;

                    let elementLi = document.createElement("li");
                    let elementUsername = document.createElement("strong");
                    let elementMessage = document.createElement("div");
                    elementUsername.textContent = strUsername;
                    elementMessage.textContent = strMessage;
                    elementLi.append(elementUsername);
                    elementLi.append(elementMessage);
                    elementListMessage.prepend(elementLi);
                }
            });
    });
</script>
</x-app-layout>
