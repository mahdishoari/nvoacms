<template>
    <div dir="rtl" class="p-5">
        <button class="btn" v-if="!isOpenNewCategory" @click="openNewCategory">دسته جدید</button>

        <div v-if="isOpenNewCategory" class="inline-grid grid-cols-2 gap-4">
            <ui-input v-model="form.name" />
            <button class="btn" @click="submitForm">اضافه کن</button>
        </div>

        <!-- pass openStates down to items -->
        <UiCategoryItem
            v-for="category in categories"
            :key="category.id"
            :category="category"
            :open-states="openStates"
        />
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useForm } from '@inertiajs/vue3'


const props = defineProps({
    categories: { type: Array, required: true },
    parentId: { type: Number, default: null },
    // allow recursion to pass the same openStates object back in
    openStates: { type: Object, default: null },
});

// Use passed openStates if provided, otherwise create our own root object
const openStates = props.openStates ?? reactive({});

const form = useForm({
    name: '',
    parent_id: props.parentId,
});

const isOpenNewCategory = ref(false);
function openNewCategory() {
    isOpenNewCategory.value = true;
}

function submitForm() {
    form.post('/category', {
        onFinish: () => {
            form.reset();
            isOpenNewCategory.value = false;
        },
    });
}
</script>

<style scoped></style>
