<template>
    <div class="container mx-auto p-10">
        <UiDatagrid :options="options" :data="data">
            <template #columnStatus="{data}">
                <button @click="changeStatus(data)" v-if="data.status === 'approved'" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">تایید شده</button>
                <button @click="changeStatus(data)" v-if="data.status === 'unapproved'" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">رد شده</button>
                <button @click="changeStatus(data)" v-else class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">نامعلوم</button>
            </template>
        </UiDatagrid>
    </div>
</template>

<script setup>
import {useForm} from "@inertiajs/vue3";

defineOptions({
    layout: AuthenticatedLayout,
});

const props = defineProps({
    data: [Object, Array],
});

const form = useForm({
    id: '',
});

function changeStatus(data) {
    form.id = data.id;
    form.post('/comments/status', {
       preserveScroll: true,
        onSuccess: () => {
           router.reload({only: ['data']});
           form.reset();
        },
    });
}
const options = reactive({
    title: 'لیست نظرات',
    columns: {
        email: 'ایمیل',
        body: 'متن پیام',
        status: 'وضعیت',
    },
    actions: {
        trash: {
            route: 'comments.trash',
            icon: '<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">\n' +
                '  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>\n' +
                '</svg>\n',
        },
        delete: {
            route: 'comments.delete',
            icon: '<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">\n' +
                '  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>\n' +
                '</svg>\n',
        },
    },
    routeKey: 'comments',
});
// console.log(Object.keys(useSlots()))
</script>

<style scoped></style>
