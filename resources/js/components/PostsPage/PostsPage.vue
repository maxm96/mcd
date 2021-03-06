<template>
    <div id="posts-page">
        <span v-if="errorMessage.length" id="error">{{ errorMessage }}</span>
        <div id="posts">
            <p v-if="!posts.length">No posts yet ...</p>
            <div v-else>
                <post
                    v-for="post in posts"
                    :key="post.id"
                    :post="post"
                    @post:show-comments-click="showComments"
                ></post>
            </div>
        </div>

        <pagination-buttons
            :current="currentPage"
            :page-count="totalPages"
            @pagination-buttons:page-click="onPageClick"
        ></pagination-buttons>

        <comments-viewer
            :show="showCommentsViewer"
            :comments="comments"
            :title="selectedPost ? selectedPost.title : ''"
            :post-id="selectedPost ? selectedPost.id : null"
            @comments-viewer:close="showCommentsViewer = false"
            @comments-viewer:comments-updated="onCommentsUpdated"
        ></comments-viewer>

        <div id="create-post-link">
            <a @click="onCreatePostLinkClick">
                {{ showPostForm ? 'Close' : 'Create a post' }}
            </a>
        </div>
        <div v-if="showPostForm" id="submit-post">
            <label for="title">Title</label>
            <input id="title" type="text" v-model="title" :disabled="loading">
            <span v-if="errors.title.length" class="error">{{ errors.title }}</span>

            <label for="content">Post</label>
            <textarea id="content" v-model="content" :disabled="loading"></textarea>
            <span v-if="errors.content.length" class="error">{{ errors.content }}</span>

            <span class="action-buttons">
                <button @click="onSubmitClick" :disabled="loading">Submit</button>
                <button @click="onClearClick" :disabled="loading">Clear</button>
            </span>
        </div>
    </div>
</template>

<script>
import Post from "./Post"
import CommentsViewer from "./CommentsViewer";
import PaginationButtons from "./PaginationButtons";

export default {
    name: "PostsPage",
    components: { Post, CommentsViewer, PaginationButtons },
    data() {
        return {
            posts: [],
            selectedPostId: null,
            title: '',
            content: '',
            loading: false,
            errorMessage: '',
            showPostForm: false,
            showCommentsViewer: false,
            errors: {
                title: '',
                content: '',
            },
            currentPage: 1,
            totalPages: 0,
            totalPosts: 0,
            postCount: 5, // The number of posts per page
        }
    },
    computed: {
        selectedPost() {
            if (!this.selectedPostId) {
                return null
            }

            let post = this.posts.find(p => p.id === this.selectedPostId)
            if (!post) {
                console.error(`Unable to find post with ID ${this.selectedPostId}`)
                return null
            }

            return post
        },
        comments() {
            return (this.selectedPost && this.selectedPost.comments)
                ? this.selectedPost.comments
                : []
        },
    },
    methods: {
        onPageClick(page) {
            this.currentPage = page
            this.getPostsPage()
        },
        onCreatePostLinkClick() {
            this.showPostForm = !this.showPostForm
        },
        validatePost() {
            let pass = true

            // Trim inputs
            this.title = this.title.trim()
            this.content = this.content.trim()

            // Validate that inputs are not empty
            if (this.title.length < 1) {
                this.errors.title = 'The title cannot be empty'
                pass = false
            } else {
                this.errors.title = ''
            }

            if (this.content.length < 1) {
                this.errors.content = 'The post cannot be empty'
                pass = false
            } else {
                this.errors.content = ''
            }

            return pass
        },
        onSubmitClick() {
            if (!this.validatePost()) {
                return
            }

            this.loading = true

            axios.post('/home', { title: this.title, content: this.content, })
                .then((res) => {
                    // Update the current page of posts
                    this.getPostsPage()

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
        onCommentsUpdated(comments) {
            let postIndex = this.posts.findIndex(p => p.id === this.selectedPostId)
            if (postIndex < 0) {
                return console.log(`Unable to find post with id ${this.selectedPostId}`)
            }

            this.posts[postIndex].comments.splice(0, this.posts[postIndex].comments.length, ...comments)
        },
        onClearClick() {
            this.title = ''
            this.content = ''
        },
        showComments(postId) {
            this.selectedPostId = postId
            this.showCommentsViewer = true
        },
        getPostsPage() {
            this.loading = true

            axios.get(`/home/get_posts/${this.currentPage - 1}/${this.postCount}`)
                .then((res) => {
                    this.posts.splice(0, this.posts.length, ...res.data.posts)
                    this.totalPosts = res.data.total
                    this.totalPages = Math.ceil(this.totalPosts / this.postCount)
                })
                .catch((err) => {
                    console.error(err)
                    this.errorMessage = `Failed to fetch posts: ${err}`
                })
                .finally(() => this.loading  = false)
        },
    },
    mounted() {
        this.getPostsPage()
    },
}
</script>

<style scoped>
#posts {
    height: 100%;
    width: 100%;
    text-align: center;
    margin-top: 10px;
}

#submit-post {
    display: flex;
    flex-direction: column;
    width: 20%;
    margin: 0 auto;
}

#create-post-link {
    width: 20%;
    margin: 20px auto;
}

#create-post-link > a {
    cursor: pointer;
}

.action-buttons {
    margin-top: 10px;
}

.error {
    color: #c30000;
    font-size: 16px;
}
</style>
