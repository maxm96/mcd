<template>
    <div id="user-list">
        <ul>
            <li v-for="user in users">{{ user.name }}</li>
        </ul>
    </div>

</template>

<script>
export default {
    name: "UserList",
    props: ['users'],
}
</script>

<style scoped>
ul {
    list-style: none;
}
</style>
