require('./bootstrap')
import Vue from 'vue'

import ChatPage from "./components/ChatPage/ChatPage"
import PostsPage from "./components/PostsPage/PostsPage"

Vue.component('chat-page', ChatPage)
Vue.component('posts-page', PostsPage)

const app = new Vue({
    el: '#app'
})
