<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

defineOptions({
    layout: GuestLayout
})
defineProps<{
    status?: string;
}>();

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>

    <Head title="Forgot Password" />
    <ui-card>
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            اگر رمز عبور خود را فراموش کرده اید، جای نگرانی نیست ایمیل خود را وارد کنید تا رمز یکبار مصرف برایتان ارسال شود
        </div>
        <ui-alert v-if="status" type="success">
            {{ status }}
        </ui-alert>

        <form @submit.prevent="submit">
            <div>
                <ui-input type="email" v-model="form.email" :error="form.errors.email"/>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    رمز یک بار مصرف را برای ایمیل من ارسال کن
                </PrimaryButton>
            </div>
        </form>
    </ui-card>
</template>
