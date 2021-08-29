<template>
<div>
    11122222222222222222222222222222
</div>
</template>

<script>

export default {
    name: 'App',
    data() {
        return {
            message: "",
        }
    },
    created(){
        try {
            const ws = new WebSocket("ws://localhost:3000/");
            ws.onmessage = ({data}) => {
                console.log(data);
            }
        } catch(err) {
            console.log(err);
        }
    },
}
</script>
