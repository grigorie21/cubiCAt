<template>
    <h1>Container index</h1>
</template>

<script>
export default {
    data() {
        return {
            containers: [],
        };
    },
    mounted() {
        let socket = new WebSocket("ws://localhost:6380");

        socket.onopen = () => {
            console.log("Соединение установлено.");
        };

        socket.onclose = (event) => {
            if (event.wasClean) {
                console.log('Соединение закрыто чисто');
            } else {
                console.log('Обрыв соединения'); // например, "убит" процесс сервера
            }
            console.log('Код: ' + event.code + ' причина: ' + event.reason);
        };

        socket.onmessage = (event) => {
            let data = JSON.parse(event.data);
            switch (data.type) {
                case 'event':
                    if (data.context == 'container_update') {
                        console.log(data);
                    }
                    break;
            }
        };

        socket.onerror = (error) => {
            console.log("Ошибка " + error.message);
        };
    }
};
</script>

