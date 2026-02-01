<template>
    <AppLayout>
        <Container>
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold text-gray-900 dark:text-white">Users</h1>
                        <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                            A list of all the users in your account including their name, email, status, role, and
                            assignments.
                        </p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <button
                            type="button"
                            class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500"
                        >
                            Add user
                        </button>
                    </div>
                </div>
                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div
                                class="overflow-hidden rounded-lg border border-gray-200 bg-white dark:border-white/10 dark:bg-gray-900"
                            >
                                <table class="relative min-w-full divide-y divide-gray-300 dark:divide-white/15">
                                    <thead>
                                        <tr>
                                            <th
                                                scope="col"
                                                class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white"
                                            >
                                                Name
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white"
                                            >
                                                Speeches
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white"
                                            >
                                                Roles
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white"
                                            >
                                                Status
                                            </th>

                                            <th scope="col" class="py-3.5 pl-3 pr-6">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="divide-y divide-gray-200 bg-white dark:divide-white/10 dark:bg-gray-900"
                                    >
                                        <tr v-for="user in users.data" :key="user.email">
                                            <td class="whitespace-nowrap py-5 pl-6 pr-3 text-sm">
                                                <div class="group flex items-center">
                                                    <div class="size-11 shrink-0">
                                                        <img
                                                            class="size-11 rounded-full dark:outline dark:outline-1 dark:outline-white/10"
                                                            :src="user.profile_photo"
                                                            alt=""
                                                        />
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900 dark:text-white">
                                                            <Link :href="route('users.show', user.id)">{{
                                                                user.name
                                                            }}</Link>
                                                        </div>
                                                        <div
                                                            class="mt-1 flex items-center gap-x-2 text-gray-500 dark:text-gray-400"
                                                        >
                                                            <span class="group-hover:hidden">{{
                                                                maskEmail(user.email)
                                                            }}</span>
                                                            <span class="hidden group-hover:inline">{{
                                                                user.email
                                                            }}</span>
                                                            <button
                                                                type="button"
                                                                class="inline-flex items-center rounded p-0.5 text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 dark:text-gray-500 dark:hover:text-gray-300"
                                                                :aria-label="`Copy email for ${user.name}`"
                                                                title="Copy email"
                                                                @click.stop="copyEmail(user)"
                                                            >
                                                                <ClipboardIcon class="size-4" aria-hidden="true" />
                                                            </button>
                                                            <span
                                                                v-if="copiedUserId === user.id"
                                                                class="text-xs text-emerald-600 dark:text-emerald-400"
                                                            >
                                                                Copied
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td
                                                class="whitespace-nowrap px-3 py-5 text-sm text-gray-500 dark:text-gray-400"
                                            >
                                                <div class="flex flex-wrap gap-x-2 gap-y-1">
                                                    <Link
                                                        v-for="speech in user.speeches || []"
                                                        :key="speech.id"
                                                        :href="route('speeches.show', { id: speech.id })"
                                                        class="inline-flex items-center rounded-md bg-gray-50 px-2 py-0.5 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-gray-100 dark:bg-white/5 dark:text-gray-300 dark:ring-white/10 dark:hover:bg-white/10"
                                                    >
                                                        {{ speech.title }}
                                                    </Link>
                                                </div>
                                            </td>
                                            <td
                                                class="whitespace-nowrap px-4 py-5 text-sm text-gray-500 dark:text-gray-400"
                                            >
                                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                                                    <span
                                                        v-for="assignment in aggregateAssignments(user.assignments)"
                                                        :key="assignment.role"
                                                        class="inline-flex items-center gap-x-1"
                                                    >
                                                        <span :title="assignment.label">{{ assignment.icon }}</span>
                                                        <span class="text-gray-400 dark:text-gray-500"
                                                            >({{ assignment.count }})</span
                                                        >
                                                    </span>
                                                </div>
                                            </td>
                                            <td
                                                class="whitespace-nowrap px-3 py-5 text-sm text-gray-500 dark:text-gray-400"
                                            >
                                                <span
                                                    class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"
                                                    :class="
                                                        user.active
                                                            ? 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-900/30 dark:text-green-400 dark:ring-green-500/50'
                                                            : 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-900/30 dark:text-red-400 dark:ring-red-500/50'
                                                    "
                                                >
                                                    {{ user.active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td class="whitespace-nowrap py-5 pl-3 pr-6 text-right text-sm font-medium">
                                                <Link
                                                    :href="route('users.show', user.id)"
                                                    class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                                >
                                                    View<span class="sr-only">, {{ user.name }}</span>
                                                </Link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="mt-6 border-t border-gray-100 pt-4 text-xs/5 text-gray-500 dark:border-white/10 dark:text-gray-400"
                >
                    <p class="font-medium text-gray-700 dark:text-gray-300">Role icons</p>
                    <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1">
                        <span v-for="role in roleLegend" :key="role.key" class="inline-flex items-center gap-x-2">
                            <span aria-hidden="true">{{ role.icon }}</span>
                            <span>{{ role.label }}</span>
                        </span>
                    </div>
                </div>
                <Pagination :meta="users.meta" />
            </div>
        </Container>
    </AppLayout>
</template>

<script setup>
import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

import { Link } from '@inertiajs/vue3';
import { ClipboardIcon } from '@heroicons/vue/20/solid';
import { ref } from 'vue';

const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
});

const roleMeta = {
    GENERAL_EVALUATOR: { label: 'General Evaluator', icon: '⚖️' },
    TOAST_MASTER: { label: 'Toastmaster', icon: '█▬▬' },
    TIME_KEEPER: { label: 'Timekeeper', icon: '⏱️' },
    TOPICS_MASTER: { label: 'Topics Master', icon: '💡' },
    WORD_MASTER: { label: 'Word Master', icon: '📝' },
};

const roleLegend = Object.entries(roleMeta).map(([key, meta]) => ({
    key,
    label: meta.label,
    icon: meta.icon,
}));

const normalizeRoleKey = (role) => (role || 'UNKNOWN').replace(/\s+/g, '_').toUpperCase();

const aggregateAssignments = (assignments = []) => {
    const counts = assignments.reduce((acc, assignment) => {
        const role = assignment.role ?? 'Unknown';
        const key = normalizeRoleKey(role);
        if (!acc[key]) {
            acc[key] = { key, role, count: 0 };
        }
        acc[key].count += 1;
        return acc;
    }, {});

    return Object.values(counts).map((item) => {
        const meta = roleMeta[item.key] || { label: item.role, icon: '❔' };
        return {
            role: item.role,
            count: item.count,
            label: meta.label,
            icon: meta.icon,
        };
    });
};

const maskEmail = (email) => {
    if (!email || typeof email !== 'string') return '';
    const [name, domain] = email.split('@');
    if (!domain) return '••••••••';
    const nameMasked = name.length <= 2 ? `${name[0] ?? ''}•` : `${name[0]}••••${name[name.length - 1]}`;
    return `${nameMasked}@${domain}`;
};

const copiedUserId = ref(null);
let copiedTimer = null;

const copyEmail = async (user) => {
    const email = user?.email;
    if (!email || typeof email !== 'string') return;
    try {
        if (navigator?.clipboard?.writeText) {
            await navigator.clipboard.writeText(email);
            copiedUserId.value = user.id;
            if (copiedTimer) clearTimeout(copiedTimer);
            copiedTimer = setTimeout(() => {
                copiedUserId.value = null;
            }, 1200);
            return;
        }
        const textarea = document.createElement('textarea');
        textarea.value = email;
        textarea.setAttribute('readonly', '');
        textarea.style.position = 'absolute';
        textarea.style.left = '-9999px';
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        copiedUserId.value = user.id;
        if (copiedTimer) clearTimeout(copiedTimer);
        copiedTimer = setTimeout(() => {
            copiedUserId.value = null;
        }, 1200);
    } catch (error) {
        console.error('Failed to copy email:', error);
    }
};

// console.log(props.users);
</script>
