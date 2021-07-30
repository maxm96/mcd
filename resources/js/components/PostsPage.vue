<template>
    <div id="posts-page">
        <span v-if="errorMessage.length" id="error">{{ errorMessage }}</span>
        <div id="posts">
            <p v-if="!posts.length">No posts yet ...</p>
            <ul v-else>
                <li v-for="post in posts">
                    <h4>{{ post.title }}</h4>
                    <p>{{ post.content }}</p>
                    <p>Submitted by: {{ post.author }}</p>
                </li>
            </ul>
        </div>
        <div id="create-post-link">
            <a @click="onCreatePostLinkClick">
                {{ showPostForm ? 'Close' : 'Create a post' }}
            </a>
        </div>
        <div v-if="showPostForm" id="submit-post">
            <label for="title">Title</label>
            <input id="title" type="text" v-model="title">

            <label for="content">Post</label>
            <textarea id="content" v-model="content"></textarea>

            <label for="author">Username</label>
            <input type="text" id="author" v-model="author">

            <span class="action-buttons">
                <button @click="onSubmitClick">Submit</button>
                <button @click="onClearClick">Clear</button>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    name: "PostsPage",
    data() {
        return {
            posts: [],
            title: '',
            content: '',
            author: '',
            loading: false,
            errorMessage: '',
            showPostForm: false,
        }
    },
    methods: {
        onCreatePostLinkClick() {
            this.showPostForm = !this.showPostForm
        },
        onSubmitClick() {

        },
        onClearClick() {
            // Don't clear author
            this.title = ''
            this.content = ''
        },
    },
    mounted() {
        this.loading = true

        axios.get('/home/get_posts')
            .then((res) => {
                this.posts = res.data
            })
            .catch((err) => {
                console.error(err)
                this.message = `Failed to fetch posts: ${err}`
            })
            .finally(() => this.loading = false)
    },
}
</script>

<style scoped>
#posts {
    height: 100%;
    width: 100%;
    text-align: center;
}

#submit-post {
    display: flex;
    flex-direction: column;
    width: 20%;
    margin: 0 auto;
}

#create-post-link {
    width: 20%;
    margin: 0 auto;
    cursor: pointer;
}

.action-buttons {
    margin-top: 10px;
}
</style>
