<template>
    <div id="chat-page">
        <user-list :users="users"></user-list>

        <input v-model="content" id="content" type="text" placeholder="">
        <button type="button" @click="onSubmit">Submit</button>
    </div>
</template>

<script>
import UserList from "./UserList";

export default {
    name: "ChatPage",
    components: { UserList },
    data() {
        return {
            content: '',
            users: [],
            chats: [],
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
                this.users = users
            })
            .joining((user) => {
                this.users.push(user)
            })
            .leaving((user) => {
                this.users = this.users.filter(u => u.id !== user.id)
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
