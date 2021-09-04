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
#user-list {
    border: 1px solid grey;
    border-radius: 5px;
    width: 20%;
}

ul {
    list-style: none;
    padding: 2px 10px;
}
</style>
