<template>
    <AppLayout>
        <Container>
            <PageHeading title="All workshops"></PageHeading>

            <ul class="mt-4 divide-y divide-gray-200">
                <li
                    v-for="workshop in workshops.data"
                    :key="workshop.id"
                    class="flex flex-col items-baseline justify-between md:flex-row"
                >
                    <Link :href="route('workshops.show', workshop.id)" class="group block px-2 py-4">
                        <span class="text-lg font-bold group-hover:text-indigo-500">{{ workshop.title }}</span>
                        <span class="block pt-1 text-sm text-gray-600 first-letter:uppercase"
                            >{{ workshop.date }}
                        </span>
                    </Link>
                    <!-- <Link :href="route('speeches.index', {type: speech.type.slug}) " class="mb-2 rounded-full border border-pink-500 px-2 py-0.5 text-pink-500 hover:bg-indigo-500 hover:text-indigo-50">
                        {{ speech.type.name}}
                    </Link> -->
                </li>
            </ul>
            <Pagination :meta="workshops.meta" />
        </Container>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';
import PageHeading from '@/Components/PageHeading.vue';
import { relativeDate } from '@/Utilities/date.js';
import { Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';

// const formattedDate = (speech) => relativeDate(speech.created_at);

defineProps({
    workshops: {
        type: Object,
        required: true,
    },
});
</script>
