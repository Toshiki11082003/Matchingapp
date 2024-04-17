<script>
    const elementInputMessage = document.getElementById("input_message");
    const chatId = document.getElementById("chat_id").value;

    {{-- formのsubmit処理 --}}
    function onsubmit_Form() {
        {{-- 送信用テキストHTML要素からメッセージ文字列の取得 --}}
        let strMessage = elementInputMessage.value;
        if (!strMessage) {
            return;
        }
        params = {
            'message': strMessage,
            'chat_id': chatId
        };

        {{-- POSTリクエスト送信処理とレスポンス取得処理 --}}
        axios
            .post('/chat', params)
            .then(response => {
                console.log(response);
                console.log(chatId)
            })
            .catch(error => {
                console.log(error.response)
            });
        {{-- テキストHTML要素の中身のクリア --}}
        elementInputMessage.value = "";
    }

    // ページロード時に実行される処理
    window.addEventListener("DOMContentLoaded", () => {
        const elementListMessage = document.getElementById("list_message");

        // Listen開始と、イベント発生時の処理の定義
        window.Echo.private('chat').listen('MessageSent', (e) => {
            console.log(e);

            // 受け取ったメッセージのchat_idがこのページのchat_idと一致する場合のみ表示
            if (e.chat.chat_id === chatId) {
                let strUsername = e.chat.userName;
                let strMessage = e.chat.body;

                let elementLi = document.createElement("li");
                let elementUsername = document.createElement("strong");
                let elementMessage = document.createElement("div");
                elementUsername.textContent = strUsername;
                elementMessage.textContent = strMessage;
                elementLi.append(elementUsername);
                elementLi.append(elementMessage);
                elementListMessage.prepend(elementLi); // リストの一番上に追加
            }
        });
    });
</script>
