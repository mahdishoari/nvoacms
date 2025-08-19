<template>
    <div class="mt-2 border-0" v-bind="$attrs">
        <label :class="['label', { 'text-red-700 dark:text-red-500': error }]">{{ label }}</label>
        <span v-for="tag in models" :key="tag.id || tag.name">
            {{ tag.name }}
            <button type="button" @click="removeTag(tag)">
                <svg
                    class="h-6 w-6 text-gray-800 dark:text-white"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                    />
                </svg>
            </button>
        </span>
        <input
            @keyup.prevent="handleKeyPress"
            v-model="form.name"
            :style="`width: ${form.name.length > 4 ? form.name.length * 12 : 60}`"
        />
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { useVModel } from '@vueuse/core';
import { useCookies } from '@vueuse/integrations/useCookies';
// import {useStepper as cookies} from "@vueuse/core/index.mjs";

const props = defineProps({
    modelValue: Array,
    label: String,
});

const form = useForm({
    name: '',
});

const cookies = useCookies(['locale']);
const emit = defineEmits(['update:modelValue']);
const model = useVModel(props, 'modelValue', emit);

async function handleKeyPress(event) {
    if (event.key === 'Enter' || event.key === ',') {
        const trimmed = form.name.trim().replace(',', '');
        if (!trimmed) return;

        form.name = trimmed;

        const response = await fetch('/tags', {
            method: 'post',
            body: JSON.stringify({
                name: trimmed,
            }),
            headers: {
                'Content-Type': 'application/json',
                'X-XSRF-TOKEN': cookies.get('XSRF-TOKEN'),
            },
        });

        if (!response.ok) {
            throw new Error('network error');
        }

        const data = await response.json();
        if (data.tag && data.tag.name) {
            const exists = model.value.some(
                (tag) => tag.name.toLowerCase() === data.tag.name.toLowerCase()
            );
            if (!exists) {
                model.value = [...model.value, data.tag];
            }
            form.reset();
        }
    }
}



function removeTag(tag) {
    const index = model.value.findIndex(
        (t) => t.name.toLowerCase() === tag.name.toLowerCase(),
    );
    if (index !== -1) {
        model.value.splice(index, 1);
        return true;
    }
    return false;
}
</script>

<style scoped></style>
