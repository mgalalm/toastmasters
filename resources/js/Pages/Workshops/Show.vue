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
                        <!-- <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
          <BriefcaseIcon class="mr-1.5 size-5 shrink-0 text-gray-400 dark:text-gray-500" aria-hidden="true" />
          Full-time
        </div> -->
                        <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <MapPinIcon
                                class="mr-1.5 size-5 shrink-0 text-gray-400 dark:text-gray-500"
                                aria-hidden="true"
                            />
                            {{ workshop.location }}
                        </div>
                        <!-- <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
          <CurrencyDollarIcon class="mr-1.5 size-5 shrink-0 text-gray-400 dark:text-gray-500" aria-hidden="true" />
          $120k &ndash; $140k
        </div> -->
                        <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <CalendarIcon
                                class="mr-1.5 size-5 shrink-0 text-gray-400 dark:text-gray-500"
                                aria-hidden="true"
                            />
                            {{ workshop.date }}
                        </div>
                    </div>
                </div>
                <div class="mt-5 flex lg:ml-4 lg:mt-0">
                    <span class="hidden sm:block">
                        <button
                            type="button"
                            class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-white/10 dark:text-white dark:shadow-none dark:ring-white/5 dark:hover:bg-white/20"
                        >
                            <PencilIcon
                                class="-ml-0.5 mr-1.5 size-5 text-gray-400 dark:text-white"
                                aria-hidden="true"
                            />
                            Add Speech
                        </button>
                    </span>

                    <!-- <span class="ml-3 hidden sm:block">
        <button type="button" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-white/10 dark:text-white dark:shadow-none dark:ring-white/5 dark:hover:bg-white/20">
          <LinkIcon class="-ml-0.5 mr-1.5 size-5 text-gray-400 dark:text-white" aria-hidden="true" />
          View
        </button>
      </span> -->

                    <div class="flex justify-between">
                        <span class="sm:ml-3">
                            <button
                                type="button"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:shadow-none dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500"
                            >
                                <CheckIcon class="-ml-0.5 mr-1.5 size-5" aria-hidden="true" />
                                Publish
                            </button>
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
                                    {{ person.name }}
                                </h3>
                                <span
                                    class="inline-flex shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-green-500/10 dark:text-green-500 dark:ring-green-500/10"
                                    >{{ person.role }}</span
                                >
                            </div>
                            <p class="mt-1 truncate text-sm text-gray-500 dark:text-gray-400">{{ person.title }}</p>
                        </div>
                        <img
                            class="size-10 shrink-0 rounded-full bg-gray-300 outline outline-1 -outline-offset-1 outline-black/5 dark:bg-gray-700 dark:outline-white/10"
                            :src="person.photo"
                            alt=""
                        />
                    </div>
                    <div></div>
                </li>
            </ul>
            <h1 class="my-4 text-2xl font-bold">Speeches</h1>
            <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <li
                    v-for="speech in speeches"
                    :key="speech.id"
                    class="col-span-1 flex flex-col divide-y divide-gray-200 rounded-lg bg-white text-center shadow dark:divide-white/10 dark:bg-gray-800/50 dark:shadow-none dark:outline dark:outline-1 dark:-outline-offset-1 dark:outline-white/10"
                >
                    <div class="flex flex-1 flex-col p-8">
                        <img
                            class="mx-auto size-32 shrink-0 rounded-full bg-gray-300 outline outline-1 -outline-offset-1 outline-black/5 dark:bg-gray-700 dark:outline-white/10"
                            :src="speech.profile_photo"
                            alt=""
                        />
                        <h3 class="mt-6 text-sm font-medium text-gray-900 dark:text-white">{{ speech.speaker }}</h3>
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
                                >
                                    <ScaleIcon class="size-7 text-gray-400 dark:text-gray-500" aria-hidden="true" />
                                    {{ speech.evaluator }}
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
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';
import PageHeading from '@/Components/PageHeading.vue';
import { router } from '@inertiajs/vue3';
import {
    PencilIcon,
    TrashIcon,
    CheckIcon,
    EnvelopeIcon,
    PhoneIcon,
    BriefcaseIcon,
    CalendarIcon,
    ChevronDownIcon,
    CurrencyDollarIcon,
    LinkIcon,
    ScaleIcon,
    MapPinIcon,
    SpeakerWaveIcon,
} from '@heroicons/vue/20/solid';

import { useConfirm } from '@/Utilities/Composables/useConfirm';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';

const { confirmation } = useConfirm();

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

// console.log(props.speeches);
</script>
