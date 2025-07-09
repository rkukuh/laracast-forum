<template>
    <AppLayout :title="post.title">
        <h1>{{ post.title }}</h1>
        <span>{{ post.created_at }}</span>

        <article>{{ post.body }}</article>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps(['post']);
</script>
