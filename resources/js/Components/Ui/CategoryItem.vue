<template>
    <div class="p-5 flex items-center gap-2">
        <!-- Always show toggle button -->
        <button
            type="button"
            @click.stop="toggle"
            class="w-6 h-6 flex items-center justify-center border rounded bg-gray-100 dark:bg-gray-700"
        >
            <span v-if="isOpen">−</span>
            <span v-else>+</span>
        </button>

        <span :class="{ 'font-bold': isOpen }">
      {{ category.name }}
    </span>
    </div>

    <!-- Expanded content: children + new category form -->
    <div class="ps-5" v-show="isOpen">
        <UiCategory
            :categories="category.children ?? []"
            :parentId="category.id"
            :open-states="openStates"
        />
    </div>
</template>

<script setup>
import { computed, defineAsyncComponent } from 'vue'

const props = defineProps({
    category: { type: Object, required: true },
    openStates: { type: Object, default: () => ({}) }
})

const UiCategory = defineAsyncComponent(() => import('./Category.vue'))

if (
    props.category &&
    props.category.id != null &&
    props.openStates[props.category.id] === undefined
) {
    props.openStates[props.category.id] = false
}

const isOpen = computed(() => !!props.openStates[props.category.id])

function toggle() {
    props.openStates[props.category.id] = !props.openStates[props.category.id]
}
</script>

<style scoped>
span {
    @apply dark:text-white p-1;
}
</style>
