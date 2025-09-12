<template>
    <div>
        <div>
            <nav class="sm:hidden" aria-label="Back">
                <a href="#" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                    <ChevronLeftIcon class="-ml-1 mr-1 size-5 shrink-0 text-gray-400" aria-hidden="true" />
                    Back
                </a>
            </nav>
            <!-- <nav class="hidden sm:flex" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-4">
                    <li>
                        <div class="flex">
                            <a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-700">Jobs</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <ChevronRightIcon class="size-5 shrink-0 text-gray-400" aria-hidden="true" />
                            <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"
                                >Engineering</a
                            >
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <ChevronRightIcon class="size-5 shrink-0 text-gray-400" aria-hidden="true" />
                            <a
                                href="#"
                                aria-current="page"
                                class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"
                                >{{ title }}</a
                            >
                        </div>
                    </li>
                </ol>
            </nav> -->
        </div>
        <div class="mt-2 md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl/7 font-bold text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    {{ title }}
                </h2>
            </div>
            <div class="mt-4 flex shrink-0 md:ml-4 md:mt-0">
                <slot name="actions"> </slot>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ChevronLeftIcon } from '@heroicons/vue/20/solid';
defineProps({
    title: String,
});
</script>
