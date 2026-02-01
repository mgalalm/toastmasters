<template>
    <AppLayout>
        <Container>
            <PageHeading :title="user.name">
                <template #actions>
                    <span class="hidden sm:block">
                        <form @submit.prevent="deleteUser">
                            <button
                                type="submit"
                                class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            >
                                <TrashIcon class="-ml-0.5 mr-1.5 size-5 text-gray-400" aria-hidden="true" />
                                Delete
                            </button>
                        </form>
                    </span>

                    <span class="ml-3 hidden sm:block">
                        <button
                            type="button"
                            class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            @click="router.visit(route('users.edit', user.id))"
                        >
                            <PencilIcon class="-ml-0.5 mr-1.5 size-5 text-gray-400" aria-hidden="true" />
                            Edit
                        </button>
                    </span>
                </template>
            </PageHeading>
            <div class="mt-6 border-t border-gray-100 dark:border-white/10">
                <dl class="divide-y divide-gray-100 dark:divide-white/10">
                    <div
                        class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0"
                        v-for="assignment in assignments"
                        :key="assignment.id"
                    >
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-white">{{ assignment.role }}</dt>
                        <dd class="mt-1 flex text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                            <span class="grow">{{ assignment.workshop_title }}</span>
                            <span class="ml-4 shrink-0">
                                <button
                                    type="button"
                                    class="rounded-md bg-white font-medium text-indigo-600 hover:text-indigo-500 dark:bg-transparent dark:text-indigo-400 dark:hover:text-indigo-300"
                                >
                                    Update
                                </button>
                            </span>
                        </dd>
                    </div>

                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-white">Speeches</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                            <ul
                                role="list"
                                class="divide-y divide-gray-100 rounded-md border border-gray-200 dark:divide-white/5 dark:border-white/10"
                            >
                                <li
                                    class="flex items-center justify-between py-4 pl-4 pr-5 text-sm/6"
                                    v-for="speech in speeches"
                                    :key="speech.id"
                                >
                                    <div class="flex w-0 flex-1 items-center">
                                        <PaperClipIcon
                                            class="size-5 shrink-0 text-gray-400 dark:text-gray-500"
                                            aria-hidden="true"
                                        />
                                        <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                            <Link :href="route('speeches.show', { id: speech.id })"
                                                ><span class="truncate font-medium text-gray-900 dark:text-white">{{
                                                    speech.title
                                                }}</span></Link
                                            >
                                            <span class="shrink-0 text-gray-400 dark:text-gray-500">{{
                                                speech.size
                                            }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex shrink-0 space-x-4">
                                        <button
                                            type="button"
                                            class="rounded-md bg-white font-medium text-indigo-600 hover:text-indigo-500 dark:bg-transparent dark:text-indigo-400 dark:hover:text-indigo-300"
                                        >
                                            Update
                                        </button>
                                        <span class="text-gray-200 dark:text-gray-600" aria-hidden="true">|</span>
                                        <button
                                            type="button"
                                            class="rounded-md bg-white font-medium text-gray-900 hover:text-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:text-white"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                </li>
                            </ul>
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-white">Evaluations</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                            <ul
                                role="list"
                                class="divide-y divide-gray-100 rounded-md border border-gray-200 dark:divide-white/5 dark:border-white/10"
                            >
                                <li
                                    class="flex items-center justify-between py-4 pl-4 pr-5 text-sm/6"
                                    v-for="speech in evaluations"
                                    :key="speech.id"
                                >
                                    <div class="flex w-0 flex-1 items-center">
                                        <PaperClipIcon
                                            class="size-5 shrink-0 text-gray-400 dark:text-gray-500"
                                            aria-hidden="true"
                                        />
                                        <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                            <Link :href="route('speeches.show', { id: speech.id })"
                                                ><span class="truncate font-medium text-gray-900 dark:text-white">{{
                                                    speech.title
                                                }}</span></Link
                                            >
                                            <span class="shrink-0 text-gray-400 dark:text-gray-500">{{
                                                speech.size
                                            }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex shrink-0 space-x-4">
                                        <button
                                            type="button"
                                            class="rounded-md bg-white font-medium text-indigo-600 hover:text-indigo-500 dark:bg-transparent dark:text-indigo-400 dark:hover:text-indigo-300"
                                        >
                                            Update
                                        </button>
                                        <span class="text-gray-200 dark:text-gray-600" aria-hidden="true">|</span>
                                        <button
                                            type="button"
                                            class="rounded-md bg-white font-medium text-gray-900 hover:text-gray-800 dark:bg-transparent dark:text-gray-400 dark:hover:text-white"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                </li>
                            </ul>
                        </dd>
                    </div>
                </dl>
            </div>
        </Container>
    </AppLayout>
</template>
<script setup>
import Container from '@/Components/Container.vue';
import PageHeading from '@/Components/PageHeading.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { PencilIcon, TrashIcon } from '@heroicons/vue/20/solid';
import { Link, router } from '@inertiajs/vue3';

import { useConfirm } from '@/Utilities/Composables/useConfirm';
import { PaperClipIcon } from '@heroicons/vue/20/solid';

const { confirmation } = useConfirm();

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    speeches: {
        type: Array,
        required: false,
    },
    assignments: {
        type: Array,
        required: false,
    },
    evaluations: {
        type: Array,
        required: false,
    },
});

console.log('User props:', props.assignments);
console.log('Evaluations props:', props.evaluations);

const deleteUser = async () => {
    if (
        !(await confirmation(
            'Are you sure you want to delete this user?',
            'This action cannot be undone.',
            'Delete User',
        ))
    )
        return;

    router.delete(route('users.destroy', props.user.id), {
        onSuccess: () => {
            console.log('User deleted successfully');
        },
        onError: (error) => {
            console.error('Error deleting user:', error);
        },
    });
};
</script>
