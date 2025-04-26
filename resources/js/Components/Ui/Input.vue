<template>
    <div class="mt-2 border-0"></div>
    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
        :class="{ 'block mb-2 text-sm font-medium text-red-700 dark:text-red-500': error }">{{ label }}</label>
    <input v-bind="$attrs"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
        :class="{ 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500': error }"
        :placeholder="placeholder" v-model="model" />
    <p v-if="error" class="mt-2 text-sm text-red-600 dark:text-red-500">{{ error }}</p>
</template>

<script setup>
import { useVModel } from '@vueuse/core';

const props = defineProps({
    modelValue: String,
    error: {
        type: {Boolean, String},
        default: false
    },
    placeholder: String
})

const emit = defineEmits(['update:modelValue'])

const model = useVModel(props, 'modelValue', emit)
</script>

<style scoped></style>