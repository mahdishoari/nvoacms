<template>
    <div>
        <h1>{{ title }}</h1>
        <p v-html="description"></p>
        <p><slot/></p>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
const probs = defineProps({
    title: String,
    description: String
})
</script>