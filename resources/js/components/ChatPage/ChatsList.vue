<template>
    <div id="chat-list">
        <div id="chats-container">
            <ul>
                <li v-for="chat in chats" class="chat">
                    <span class="author-name">{{ getUserName(chat.user_id) }}:</span>
                    {{ chat.content }}
                </li>
            </ul>
        </div>

        <input v-model="content" id="content" type="text" placeholder="Type a comment" v-on:keyup.enter="onSendChat">
        <button type="button" @click="onSendChat">Send</button>
    </div>
</template>

<script>
export default {
    name: "ChatsList",
    props: ['chats', 'users'],
    data() {
        return {
            content: ''
        }
    },
    methods: {
        getUserName(userId) {
            let user = this.users.find(u => u.id === userId)
            if (!user) {
                return console.error(`Unknown user id ${userId}`)
            }

            return user.name
        },
        onSendChat() {
            this.content = this.content.trim()
            if (!this.content) {
                return
            }

            this.$emit('chats-list:send-chat', this.content)
            this.content = ''
        },
    },
}
</script>

<style scoped>
#chat-list {
    width: 100%;
}

#chats-container {
    border: 1px solid grey;
    border-radius: 5px;
    width: 80%;
    height: 100%;
    overflow-y: scroll;
    overflow-wrap: break-word;
}

.chat {
    margin-bottom: 4px;
}

ul {
    list-style: none;
    padding: 2px 5px;
}

li {
    margin-bottom: 4px;
}

.author-name {
    background: lightgrey;
    border-radius: 2px;
    padding: 2px;
}
</style>
