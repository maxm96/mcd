<template>
    <div class="post">
        <h4 class="post-title">{{ post.title }}</h4>
        <p class="post-content">{{ post.content }}</p>
        <hr>
        <span>Submitted by: {{ post.author }}</span>
    </div>
</template>

<script>
export default {
    name: "Post",
    props: ['post'],
}
</script>

<style scoped>
.post {
    text-align: left;
    width: 20%;
    margin: 0 auto;
    background-color: lightgrey;
    border-radius: 5px;
    padding: 5px;
}
</style>
