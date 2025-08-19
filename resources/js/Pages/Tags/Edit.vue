<template>
    <div dir="rtl" class="flex  flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0 dark:bg-gray-900">
        <form @submit.prevent="form.put('/tags/' + tag.id)" class="grid grid-col-1 gap-8">
            <ui-input label="عنوان تگ" :error="form.errors.name" v-model="form.name" />
            <button class="btn" type="submit">ارسال</button>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    tag: Object,
});

defineOptions({
    layout: AuthenticatedLayout,
});

const form = useForm({
    name: props.tag.name,
});
</script>

<style scoped></style>
