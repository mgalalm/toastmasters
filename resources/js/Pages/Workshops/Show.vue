<template>
    <AppLayout>
        <Container>
            <div class="lg:flex lg:items-center lg:justify-between">
                <div class="min-w-0 flex-1">
                    <h2
                        class="text-2xl/7 font-bold text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight dark:text-white"
                    >
                        {{ workshop.title }}
                    </h2>
                    <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <MapPinIcon
                                class="mr-1.5 size-5 shrink-0 text-gray-400 dark:text-gray-500"
                                aria-hidden="true"
                            />
                            {{ workshop.location }}
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <CalendarIcon
                                class="mr-1.5 size-5 shrink-0 text-gray-400 dark:text-gray-500"
                                aria-hidden="true"
                            />
                            {{ workshop.date }}
                        </div>
                    </div>
                </div>
                <div class="mt-5 flex lg:ml-4 lg:mt-0 print:hidden">
                    <span class="hidden sm:block">
                        <button
                            type="button"
                            :disabled="speeches.length >= 3"
                            :class="[
                                'inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold shadow-sm',
                                speeches.length >= 3
                                    ? 'cursor-not-allowed bg-gray-200 text-gray-500 dark:bg-gray-700/40 dark:text-gray-400 dark:shadow-none'
                                    : 'bg-white text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-white/10 dark:text-white dark:shadow-none dark:ring-white/5 dark:hover:bg-white/20',
                            ]"
                            @click="router.get(route('speeches.create', { workshop_id: workshop.id }))"
                        >
                            <PencilIcon
                                class="-ml-0.5 mr-1.5 size-5 text-gray-400 dark:text-white"
                                aria-hidden="true"
                            />
                            Add Speech
                        </button>
                    </span>

                    <div class="flex justify-between">
                        <span class="sm:ml-3">
                            <Link
                                :href="route('assignments.create', { workshop_id: workshop.id })"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:shadow-none dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500"
                            >
                                <ScaleIcon class="-ml-0.5 mr-1.5 size-5" aria-hidden="true" />
                                Add Role
                            </Link>
                        </span>
                    </div>

                    <!-- Dropdown -->
                    <Menu as="div" class="relative ml-3 sm:hidden">
                        <MenuButton
                            class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-white/10 dark:text-white dark:shadow-none dark:ring-white/5 dark:hover:bg-white/20"
                        >
                            More
                            <ChevronDownIcon
                                class="-mr-1 ml-1.5 size-5 text-gray-400 dark:text-white"
                                aria-hidden="true"
                            />
                        </MenuButton>

                        <transition
                            enter-active-class="transition ease-out duration-200"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform scale-100"
                            leave-to-class="transform opacity-0 scale-95"
                        >
                            <MenuItems
                                class="absolute left-0 z-10 -mr-1 mt-2 w-24 origin-top-right rounded-md bg-white py-1 shadow-lg outline outline-1 outline-black/5 dark:bg-gray-800 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10"
                            >
                                <MenuItem v-slot="{ active }">
                                    <a
                                        href="#"
                                        :class="[
                                            active ? 'bg-gray-100 outline-none dark:bg-white/5' : '',
                                            'block px-4 py-2 text-sm text-gray-700 dark:text-gray-300',
                                        ]"
                                        >Edit</a
                                    >
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <a
                                        href="#"
                                        :class="[
                                            active ? 'bg-gray-100 outline-none dark:bg-white/5' : '',
                                            'block px-4 py-2 text-sm text-gray-700 dark:text-gray-300',
                                        ]"
                                        >View</a
                                    >
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>

            <h1 class="my-4 text-2xl font-bold">Roles</h1>
            <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <li
                    v-for="person in assignments"
                    :key="person.email"
                    class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow dark:divide-white/10 dark:bg-gray-800/50 dark:shadow-none dark:outline dark:outline-1 dark:-outline-offset-1 dark:outline-white/10"
                >
                    <div class="flex w-full items-center justify-between space-x-6 p-6">
                        <div class="flex-1 truncate">
                            <div class="flex items-center space-x-3">
                                <h3 class="truncate text-sm font-medium text-gray-900 dark:text-white">
                                    <Link :href="route('users.show', { id: person.user_id })">{{ person.name }}</Link>
                                </h3>
                                <span
                                    class="inline-flex shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-green-500/10 dark:text-green-500 dark:ring-green-500/10"
                                    >{{ person.role }}</span
                                >
                            </div>
                            <p class="mt-1 truncate text-sm text-gray-500 dark:text-gray-400">{{ person.title }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button
                                v-if="isAdmin"
                                type="button"
                                class="inline-flex size-10 items-center justify-center rounded-full bg-gray-50 text-gray-400 ring-1 ring-inset ring-gray-200 hover:bg-red-50 hover:text-red-600 hover:ring-red-200 focus:outline-none focus:ring-2 focus:ring-red-500/40 dark:bg-gray-800/60 dark:text-gray-500 dark:ring-white/10 dark:hover:bg-red-500/10 dark:hover:text-red-400 dark:hover:ring-red-500/20"
                                :aria-label="`Unassign ${person.name}`"
                                title="Unassign"
                                @click.prevent="confirmUnassign(person)"
                            >
                                <XMarkIcon class="size-5" aria-hidden="true" />
                            </button>
                        </div>
                    </div>
                    <div></div>
                </li>
            </ul>
            <h1 class="my-4 text-2xl font-bold">Speeches</h1>
            <ul role="list" class="grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                <li
                    v-for="speech in speeches"
                    :key="speech.id"
                    class="col-span-1 flex cursor-pointer flex-col divide-y divide-gray-200 rounded-lg bg-white text-center shadow hover:bg-gray-50 dark:divide-white/10 dark:bg-gray-800/50 dark:shadow-none dark:outline dark:outline-1 dark:-outline-offset-1 dark:outline-white/10 dark:hover:bg-gray-700"
                    @click="router.get(route('speeches.show', { id: speech.id }))"
                >
                    <div class="flex flex-1 flex-col p-8">
                        <img
                            class="mx-auto size-32 shrink-0 rounded-full bg-gray-300 outline outline-1 -outline-offset-1 outline-black/5 dark:bg-gray-700 dark:outline-white/10"
                            :src="speech.profile_photo"
                            alt=""
                        />
                        <Link :href="route('users.show', { id: speech.speaker_id })" @click="$event.stopPropagation()">
                            <h3 class="mt-6 text-sm font-medium text-gray-900 dark:text-white">{{ speech.speaker }}</h3>
                        </Link>
                        <dl class="mt-1 flex grow flex-col justify-between">
                            <dt class="sr-only">Title</dt>
                            <dd class="text-sm text-gray-500 dark:text-gray-400">{{ speech.title }}</dd>
                            <dt class="sr-only">Pathway</dt>
                            <dd class="mt-3">
                                <span
                                    class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20 dark:bg-red-500/10 dark:text-red-500 dark:ring-red-500/10"
                                    >{{ speech.pathway }}</span
                                >
                            </dd>
                        </dl>
                    </div>
                    <div>
                        <div class="-mt-px flex divide-x divide-gray-200 dark:divide-white/10">
                            <div class="flex w-0 flex-1">
                                <a
                                    :href="`mailto:${speech.email}`"
                                    class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-gray-900 dark:text-white"
                                    @click.stop
                                >
                                    <ScaleIcon class="size-7 text-gray-400 dark:text-gray-500" aria-hidden="true" />
                                    <template v-if="speech.evaluator_id">
                                        <Link :href="route('users.show', { id: speech.evaluator_id })">{{
                                            speech.evaluator
                                        }}</Link>
                                    </template>
                                    <template v-else>
                                        <span class="text-gray-400 dark:text-gray-500">No evaluator</span>
                                    </template>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </Container>
    </AppLayout>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { CalendarIcon, ChevronDownIcon, MapPinIcon, PencilIcon, ScaleIcon, XMarkIcon } from '@heroicons/vue/20/solid';
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

import { useConfirm } from '@/Utilities/Composables/useConfirm';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';

const { confirmation } = useConfirm();
const page = usePage();
const isAdmin = computed(() => page.props.auth?.user?.is_admin);

const props = defineProps({
    workshop: {
        type: Object,
        required: true,
    },
    assignments: {
        type: Array,
        required: true,
    },
    speeches: {
        type: Array,
        required: true,
    },
});

const confirmUnassign = async (assignment) => {
    if (
        !(await confirmation(
            'Remove assignment?',
            'This will unassign the user from this workshop role.',
            'Remove Assignment',
        ))
    )
        return;

    router.delete(route('assignments.destroy', assignment.id), {
        preserveScroll: true,
    });
};

const deleteWorkshop = async () => {
    if (
        !(await confirmation(
            'Are you sure you want to delete this workshop?',
            'This action cannot be undone.',
            'Delete Workshop',
        ))
    )
        return;

    router.delete(route('workshops.destroy', props.workshop.id), {
        onSuccess: () => {
            // Optionally handle success
        },
        onError: (error) => {
            // Optionally handle error
        },
    });
};

console.log(props.speeches);
</script>
