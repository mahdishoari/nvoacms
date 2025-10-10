<template>
    <div>
        <header>
            {{ user.name }}
        </header>
        <section>
            <div id="messageContainer">
                <div v-for="m in messages" :key="m.id" id="conversation">
                    <div v-if="m.from_id === currentUser.id" class="form">
                        {{ m.text }}
                    </div>
                    <div v-else class="to">
                        {{ m.text }}
                    </div>
                </div>
            </div>
            <small v-if="isTyping">{{ user.name }} در حال نوشتن است... </small>
        </section>
        <footer>
            <ui-input
                v-model="form.message"
                @keydown="sendTypingEvent"
                @keyup.enter="sendMessage"
            />
            <button @click="sendMessage">ارسال</button>
        </footer>
    </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
const page = usePage();
const currentUser = page.props.auth.user;
const messages = ref([]);
const isTyping = ref(false);
const isTypingTimer = ref(false);
const props = defineProps({
    user: Object,
});
const form = useForm({
    message: '',
});

async function getMessages(u) {
    await axios.get(`/messenger/${u.id}`).then((response) => {
        messages.value = response.data;
    });
}

function sendMessage() {
    if (form.message.trim() !== '') {
        axios
            .post(`/messenger/${props.user.id}`, {
                message: form.message,
            })
            .then((response) => {
                messages.value.push(response.data);
                form.reset();
            });
    }
}
// await getMessages(props.user);

function sendTypingEvent() {
    window.Echo.private(`chat.${props.user.id}`).whisper('typing', {
        userID: currentUser.id,
    });
}
onMounted(() => {
    getMessages(props.user);
});
watch(
    () => props.user,
    (newUser) => {
        if (newUser && newUser.id) {
            getMessages(newUser);
        }
        window.Echo.private(`chat.${currentUser.id}`)
            .listen('ChatMessage', (response) => {
                messages.value.push(response.message);
            })
            .listenForWhisper('typing', (response) => {
                isTyping.value = response.userID === props.user.id;
                if (isTypingTimer.value) {
                    clearTimeout(isTypingTimer);
                }
                isTypingTimer.value = setTimeout(() => {
                    isTyping.value = false;
                }, 1000);
            });
    },
    { immediate: true },
);
</script>

<style scoped></style>
