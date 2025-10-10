<template>
    <ul>
        <li v-for="u, i in users" @click="onChatWith(u)" :class="{'selected': selectedUser && selectedUser.id && selectedUser.id === u.id}">
            {{u.name}}
        </li>
    </ul>
</template>

<script setup>
const props = defineProps({
    users: Array,
    selectedUser: Object,
});
const emit = defineEmits(['chat']);

function onChatWith(u) {
    emit('chat', u);
}
</script>

<style scoped></style>
