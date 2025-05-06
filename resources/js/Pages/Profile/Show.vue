<template>
    <div>
        <h1>{{ user.email }}</h1>
        <h1>{{ user.profile }}</h1>
    </div>
</template>

<script setup>
const props = defineProps ({user:Object})
</script>

<style lang="scss" scoped>

</style>   