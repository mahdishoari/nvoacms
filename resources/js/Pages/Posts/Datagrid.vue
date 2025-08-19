<template>
    <UiDatagrid :options="options" :data="data"/>
</template>

<script setup>
defineOptions({
    layout: AuthenticatedLayout,
});

const props = defineProps({
    data: [Object, Array]
})

const options = reactive({
    title: 'لیست پست ها',
    columns: {
        title: 'عنوان',
        comment_no: 'نظرات',
        author: 'نویسنده',
    },
    actions: {
        edit: {
            title: 'ویرایش',
            route: 'posts.edit',
        },
    },
    routeKey: 'posts',

})
</script>

<style scoped>

</style>
