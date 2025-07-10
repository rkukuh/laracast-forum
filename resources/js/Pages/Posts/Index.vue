<template>
    <AppLayout>
        <Container>
            <ul class="divide-y">
                <li v-for="post in posts.data"
                    :key="post.id">

                    <Link
                        class="block group px-2 py-4"
                        :href="route('posts.show', post.id)">

                        <span class="font-bold text-lg group-hover:text-indigo-500">
                            {{ post.title }}
                        </span>

                        <span class="block pt-1 text-sm text-gray-500">
                            {{ formattedDate(post) }}
                            by {{ post.user.name }}
                        </span>

                    </Link>
                </li>
            </ul>

            <Pagination :meta="posts.meta" />
        </Container>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';
import Pagination from '@/Components/Pagination.vue';
import {Link} from "@inertiajs/vue3";
import {formatDistance, parseISO} from "date-fns";

defineProps(['posts']);

const formattedDate = (post) => {
    return formatDistance(parseISO(post.created_at), new Date(), {
        addSuffix: true,
    })
}
</script>
