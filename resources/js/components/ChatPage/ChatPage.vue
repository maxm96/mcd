<template>
    <div id="chat-page">
        <input v-model="content" id="content" type="text" placeholder="">
        <button type="button" @click="onSubmit">Submit</button>
    </div>
</template>

<script>
export default {
    name: "ChatPage",
    data() {
        return {
            content: '',
        }
    },
    methods: {
        onSubmit() {
            axios.post('/chat', { content: this.content })
                .then(console.log)
                .catch(console.error)
                .finally(() => {
                    this.content = ''
                })
        },
    },
    mounted() {
        Echo.join('chat-room')
            .here((users) => {
                console.log('HERE', users)
            })
            .joining((user) => {
                console.log('JOINING', user)
            })
            .leaving((user) => {
                console.log('LEAVING', user)
            })
            .error(console.error)
            .listen('ChatSent', (e) => {
                console.log('ChatSent', e)
            })
    },
}
</script>

<style scoped>

</style>
