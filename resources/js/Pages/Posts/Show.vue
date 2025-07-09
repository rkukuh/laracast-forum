<template>
    <AppLayout :title="post.title">
        <h1>{{ post.title }}</h1>
        <span>{{ formattedDate }}</span>

        <article>{{ post.body }}</article>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import {computed} from "vue";
import {formatDistance, parseISO} from "date-fns";

const props = defineProps(['post']);

const formattedDate = computed(() => formatDistance(parseISO(props.post.created_at), new Date(), {
    addSuffix: true,
}))
</script>
