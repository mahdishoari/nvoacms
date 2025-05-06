<template>
    <Link v-bind="$attrs">
        <slot />
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<style lang="scss" scoped>

</style>