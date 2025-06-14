<template>
    <div class="grid grid-cols-1 gap-4">
        <h3 class="text-2xl font-bold">
            لیست نظرات
        </h3>
        <div v-for="comment in comments" class="odd:bg-slate-50 odd:bg-slate-100 p-4 rounded-2xl">
            {{ comment.body }}
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    comments: Array
})
</script>

<style lang="scss" scoped>

</style>
