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
            <input id="title" type="text" v-model="title" :disabled="loading">

            <label for="content">Post</label>
            <textarea id="content" v-model="content" :disabled="loading"></textarea>

            <span class="action-buttons">
                <button @click="onSubmitClick" :disabled="loading">Submit</button>
                <button @click="onClearClick" :disabled="loading">Clear</button>
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
            this.loading = true

            let payload = { title: this.title, content: this.content, }

            axios.post('/home', payload)
                .then((res) => {
                    this.posts.push(res.data.post)

                    // Clear form
                    this.title = ''
                    this.content = ''

                    // Hide form
                    this.showPostForm = false
                })
                .catch((err) => {
                    console.error(err)
                    this.errorMessage = `Failed to save post: ${err}`
                })
                .finally(() => this.loading = false)
        },
        onClearClick() {
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
}

#create-post-link > a {
    cursor: pointer;
}

.action-buttons {
    margin-top: 10px;
}
</style>
