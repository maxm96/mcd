<template>
    <div id="chat-page">
        <user-list :users="users"></user-list>
        <chats-list
            :chats="chats"
            :users="users"
            @chats-list:send-chat="onSendChat"
        ></chats-list>
    </div>
</template>

<script>
import UserList from "./UserList";
import ChatsList from "./ChatsList";

export default {
    name: "ChatPage",
    components: { UserList, ChatsList },
    data() {
        return {
            users: [],
            chats: [],
        }
    },
    methods: {
        onSendChat(content) {
            axios.post('/chat', { content: content })
                .then(console.log)
                .catch(console.error)
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
                this.chats.push(e.chat)
            })
    },
}
</script>

<style scoped>
#chat-page {
    display: flex;
    height: 500px;
}
</style>
