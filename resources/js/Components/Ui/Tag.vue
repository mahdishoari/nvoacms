<template>
    <div class="mt-2 border-0 py-5" v-bind="$attrs">
        <label :class="['block mb-1 text-sm font-bold text-gray-700', labelClass, error ? 'text-red-700 dark:text-red-500' : '']">
            {{ label }}
        </label>

        <div class="flex flex-wrap items-center gap-2 bg-white dark:bg-gray-800 p-2 rounded border border-gray-300 dark:border-gray-600">
            <!-- Tags -->
            <span v-for="tag in tags" :key="tag.name" class="flex items-center bg-blue-100 text-blue-800 text-sm rounded px-2 py-1">
        {{ tag.name }}
        <button type="button" @click="removeTag(tag)" class="ml-1 text-blue-800 hover:text-red-600">
          ×
        </button>
      </span>

            <!-- Input -->
            <input
                v-model="form.name"
                @keyup.prevent="handleKeyPress"
                :style="{ width: (form.name.length > 1 ? form.name.length * 10 + 20 : 80) + 'px' }"
                class="outline-none border-none focus:ring-0 text-sm min-w-[80px] rounded bg-blue-100"
                placeholder="افزودن..."
            />
        </div>

        <p v-if="error" class="text-sm text-red-600 mt-1">{{ error }}</p>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { useVModel } from '@vueuse/core';
import { useCookies } from '@vueuse/integrations/useCookies';

const props = defineProps({
    modelValue: Array,
    label: String,
    labelClass: {
        type: String,
        default: '',
    },
    error: {
        type: String,
        default: '',
    }
});
const tags = computed(() => model.value);
const form = useForm({ name: '' });
const cookies = useCookies(['XSRF-TOKEN']);
const emit = defineEmits(['update:modelValue']);
const model = useVModel(props, 'modelValue', emit);

async function handleKeyPress(event) {
    if (event.key === 'Enter' || event.key === ',') {
        form.name = form.name.replace(',', '').trim();
        if (!form.name) return;

        const response = await fetch('/tags', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-XSRF-TOKEN': cookies.get('XSRF-TOKEN')
            },
            body: JSON.stringify({ name: form.name })
        });

        if (!response.ok) {
            console.error('Failed to create tag');
            return;
        }

        const data = await response.json();
        if (data?.tag?.name) {
            const exists = model.value.some(
                (tag) => tag.name.toLowerCase() === data.tag.name.toLowerCase()
            );
            if (!exists) {
                emit('update:modelValue', [...model.value, data.tag]);
            }
        }

        form.reset();
    }
}

function removeTag(tag) {
    const index = model.value.findIndex(
        (t) => t.name.toLowerCase() === tag.name.toLowerCase()
    );
    if (index !== -1) {
        const updated = [...model.value];
        updated.splice(index, 1);
        emit('update:modelValue', updated);
    }
}

watch(model, () => {
    console.log('Model changed:', model.value);
});
</script>

<style scoped>
</style>
