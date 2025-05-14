<template>
    <div class="my-3 border-0">
        <label for="name" class="label" :class="{ 'error-label': error }">{{ label }}</label>
        <textarea row="4" v-bind="$attrs" class="textarea" :class="{ 'error': error }" :placeholder="placeholder" v-model="model"/>
        <p v-if="error" class="error-text">{{ error }}</p>
    </div>

</template>

<script setup>
import {useVModel} from '@vueuse/core';

const props = defineProps({
    modelValue: String,
    error: {
        type: {Boolean, String},
        default: false
    },
    placeholder: String,
    label: String
})

const emit = defineEmits(['update:modelValue'])
const model = useVModel(props, 'modelValue', emit)
</script>

<style scoped></style>
