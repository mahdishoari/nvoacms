<template>
    <main>
        <slot />
    </main>
</template>
<style scoped>
main {
    @apply container mx-auto w-full flex-grow p-5 px-4 py-8 md:w-3/4;
}
</style>
