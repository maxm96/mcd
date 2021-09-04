<template>
    <div class="comment">
        <p class="content">{{ content }}</p>
        <span class="author">- {{ author }}</span>
    </div>
</template>

<script>
export default {
    name: "Comment",
    props: ['content', 'author']
}
</script>

<style scoped>
.comment {
    background: lightgrey;
    padding: 4px;
    border-radius: 4px;
    margin-bottom: 7px;
}

.content {
    font-weight: bold;
    margin-top: 0;
    margin-bottom: 3px;
}
</style>
