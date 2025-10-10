<template>
    <AppLayout>
        <Container>
            <PageHeading title="All speeches"></PageHeading>
            <ul role="list" class="divide-y divide-gray-100 dark:divide-white/5">
                <li v-for="user in users.data" :key="user.email" class="flex justify-between gap-x-6 py-5">
                    <div class="flex min-w-0 gap-x-4">
                        <img
                            class="size-12 flex-none rounded-full bg-gray-50 dark:bg-gray-800 dark:outline dark:outline-1 dark:-outline-offset-1 dark:outline-white/10"
                            :src="user.profile_photo"
                            alt=""
                        />
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm/6 font-semibold text-gray-900 dark:text-white">
                                <Link :href="route('users.show', user.id)">{{ user.name }}</Link>
                            </p>
                            <p class="mt-1 truncate text-xs/5 text-gray-500 dark:text-gray-400">{{ user.email }}</p>
                        </div>
                    </div>
                    <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm/6 text-gray-900 dark:text-white">{{ user.role }}</p>
                        <p v-if="user.lastSeen" class="mt-1 text-xs/5 text-gray-500 dark:text-gray-400">
                            Last seen <time :datetime="user.lastSeenDateTime">{{ user.lastSeen }}</time>
                        </p>
                        <div v-else class="mt-1 flex items-center gap-x-1.5">
                            <div class="flex-none rounded-full bg-emerald-500/20 p-1 dark:bg-emerald-500/30">
                                <div
                                    class="size-1.5 rounded-full"
                                    :class="user.active ? 'bg-emerald-500' : 'bg-red-500'"
                                />
                            </div>
                            <p class="text-xs/5 text-gray-500 dark:text-gray-400">
                                {{ user.active ? 'Active' : 'Inactive' }}
                            </p>
                        </div>
                    </div>
                </li>
            </ul>

            <Pagination :meta="users.meta" />
        </Container>
    </AppLayout>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import PageHeading from '@/Components/PageHeading.vue';
import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

import { Link } from '@inertiajs/vue3';

defineProps({
    users: {
        type: Object,
        required: true,
    },
});
</script>
