require('./bootstrap')
import Vue from 'vue'

import PostsPage from "./components/PostsPage/PostsPage";

Vue.component('posts-page', PostsPage)

const app = new Vue({
    el: '#app'
})
