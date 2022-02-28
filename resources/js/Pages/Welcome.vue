<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
})
</script>

<template>
    <Head title="Welcome" />

    <div class="relative min-h-screen">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-sm underline">
                Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm underline">
                    Log in
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm underline">
                    Register
                </Link>
            </template>
        </div>

        <div class="flex flex-col items-center">
            <p class="capitalize text-xl">The Guest Book</p>
            <p class="text-base">This is a simple demo of Laravel {{ laravelVersion }} and using Vue JS with Inertia JS to create a Guestbook</p>
        </div>

        <div class="flex justify-center ">
            <table class="w-full m-6">
                <thead>
                    <tr>
                        <th class="border">Functionality</th>
                        <th class="border">Package</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border">Roles</td>
                        <td class="border"><a href="https://spatie.be/docs/laravel-permission/v5/introduction" class="underline text-blue-600 hover:text-blue-800 visited:text-purple-600">spatie/laravel-permission</a></td>
                    </tr>
                    <tr>
                        <td class="border">Client side Http Agent</td>
                        <td class="border"><a href="https://axios-http.com/docs/intro" class="underline text-blue-600 hover:text-blue-800 visited:text-purple-600">Axios.</a></td>
                    </tr>
                    <tr>
                        <td class="border">Transformers</td>
                        <td class="border"><a href="https://fractal.thephpleague.com/" class="underline text-blue-600 hover:text-blue-800 visited:text-purple-600">league/fractal</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>
</template>