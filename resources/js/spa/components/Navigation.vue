<template>
    <div id="app">
        <nav class="flex gap-4">
            <router-link :to="{ name: 'home' }">Home</router-link>
            <router-link :to="{ name: 'about' }">About</router-link>
            <router-link :to="{ name: 'get.index' }">Get</router-link>
            <router-link :to="{ name: 'user.login' }">Login</router-link>
            <router-link :to="{ name: 'user.registration' }"
                >Registration</router-link
            >
        </nav>
    </div>
</template>

<script setup lang="ts">
// здесь может быть логика приложения
</script>
