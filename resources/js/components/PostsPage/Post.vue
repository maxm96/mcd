<template>
    <div class="post">
        <span v-if="collapsed" class="expand">
            [<a @click="toggleCollapsed">
                &plus;
            </a>]
        </span>
        <span v-else class="collapse">
            [<a @click="toggleCollapsed">
                &minus;
            </a>]
        </span>
        <div v-if="collapsed" class="collapsed">
            <h4 class="post-title">{{ post.title }}</h4>
        </div>
        <div v-else class="expanded">
            <h4 class="post-title">{{ post.title }}</h4>
            <p class="post-content">{{ post.content }}</p>
            <hr>
            <span>{{ post.author }}</span> |
            <span class="updated-at">{{ post.updated_at | date }}</span>
            <a class="show-comments-link" @click="onShowCommentsClick">Show comments</a>
        </div>

    </div>
</template>

<script>
export default {
    name: "Post",
    props: ['post'],
    data() {
        return {
            collapsed: true,
        }
    },
    methods: {
        toggleCollapsed() {
            this.collapsed = !this.collapsed
        },
        onShowCommentsClick() {
            this.$emit('post:show-comments-click', this.post.id)
        },
    },
    filters: {
        date(val) {
            return new Date(val).toDateString()
        },
    },
}
</script>

<style scoped>
.post {
    text-align: left;
    width: 20%;
    margin: 10px auto;
    background-color: lightgrey;
    border-radius: 5px;
    padding: 5px;
}

.post-title, .post-content {
    overflow-wrap: break-word;
}

.collapse, .expand {
    float: right;
    margin-bottom: -20px;
}

.collapse > a, .expand > a {
    cursor: pointer;
}

.show-comments-link {
    cursor: pointer;
    float: right;
    font-size: 14px;
}

.updated-at {
    font-size: 14px;
    font-weight: lighter;
}
</style>
