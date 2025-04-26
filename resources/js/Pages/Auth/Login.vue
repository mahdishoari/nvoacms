<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
defineOptions({
    layout: GuestLayout
})
defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>

    <Head title="Log in" />
    <ui-card>
        <ui-alert v-if="status" type="success">
            {{ status }}
        </ui-alert>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <h5 class="text-xl font-medium text-gray-900 dark:text-white">به سامانه مدیریت وارد شوید</h5>
            <ui-input name="email" v-model="form.email" label="پست الکترونیکی" placeholder="پست الکترونیکی" :error="form.errors.email" />
            <ui-input name="password" placeholder="رمز عبور" type="password" v-model="form.password" label="رمز عبور" :error="form.errors.password" />
            <ui-toggle label="مرا به خاطر بسپار" v-model="form.remember" />
            <div class="mt-4 flex items-center justify-end">
                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800">
                رمز عبور را فراموش کرده اید؟ </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    ورود به سیستم
                </PrimaryButton>
            </div>
        </form>
    </ui-card>
</template>
