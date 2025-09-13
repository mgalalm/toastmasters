<template>
    <AppLayout>
        <Container>
            <PageHeading :title="speech.title">
                <template #actions>
                    <span class="hidden sm:block">
                        <form @submit.prevent="deleteSpeech">
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
                            @click="router.visit(route('speeches.edit', speech.id))"
                        >
                            <PencilIcon class="-ml-0.5 mr-1.5 size-5 text-gray-400" aria-hidden="true" />
                            Edit
                        </button>
                    </span>

                    <span class="sm:ml-3">
                        <button
                            type="button"
                            class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            <CheckIcon class="-ml-0.5 mr-1.5 size-5" aria-hidden="true" />
                            Publish
                        </button>
                    </span>
                </template>
            </PageHeading>

            <div>
                <div class="mt-6 border-t border-gray-100 dark:border-white/10">
                    <dl class="divide-y divide-gray-100 dark:divide-white/10">
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">By</dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                                <Link
                                    :href="route('users.show', { id: speech.speaker_id })"
                                    class="font-medium text-gray-900 dark:text-white"
                                    >{{ speech.speaker }}</Link
                                >
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Pathway</dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                                {{ speech.pathway }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Level</dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                                {{ speech.level }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Project</dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                                {{ speech.project }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Objectives</dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                                {{ speech.objectives }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Evaluator Notes</dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                                {{ speech.evaluator_notes }}
                            </dd>
                        </div>
                        <!-- <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
          <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Attachments</dt>
          <dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0 dark:text-white">
            <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200 dark:divide-white/5 dark:border-white/10">
              <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm/6">
                <div class="flex w-0 flex-1 items-center">
                  <PaperClipIcon class="size-5 shrink-0 text-gray-400 dark:text-gray-500" aria-hidden="true" />
                  <div class="ml-4 flex min-w-0 flex-1 gap-2">
                    <span class="truncate font-medium text-gray-900 dark:text-white">resume_back_end_developer.pdf</span>
                    <span class="shrink-0 text-gray-400 dark:text-gray-500">2.4mb</span>
                  </div>
                </div>
                <div class="ml-4 shrink-0">
                  <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Download</a>
                </div>
              </li>
              <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm/6">
                <div class="flex w-0 flex-1 items-center">
                  <PaperClipIcon class="size-5 shrink-0 text-gray-400 dark:text-gray-500" aria-hidden="true" />
                  <div class="ml-4 flex min-w-0 flex-1 gap-2">
                    <span class="truncate font-medium text-gray-900 dark:text-white">coverletter_back_end_developer.pdf</span>
                    <span class="shrink-0 text-gray-400 dark:text-gray-500">4.5mb</span>
                  </div>
                </div>
                <div class="ml-4 shrink-0">
                  <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Download</a>
                </div>
              </li>
            </ul>
          </dd>
        </div> -->
                    </dl>
                </div>
            </div>
        </Container>
    </AppLayout>
</template>
<script setup>
import Container from '@/Components/Container.vue';
import PageHeading from '@/Components/PageHeading.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { CheckIcon, PencilIcon, TrashIcon } from '@heroicons/vue/20/solid';
import { Link, router } from '@inertiajs/vue3';

// import { useRouter } from '@inertiajs/vue3';

import { useConfirm } from '@/Utilities/Composables/useConfirm';

const { confirmation } = useConfirm();

const props = defineProps({
    speech: {
        type: Object,
        required: true,
    },
});

const deleteSpeech = async () => {
    console.log('Deleting speech:', props.speech.id);
    if (
        !(await confirmation(
            'Are you sure you want to delete this speech?',
            'This action cannot be undone.',
            'Delete Speech',
        ))
    )
        return;

    router.delete(route('speeches.destroy', props.speech.id), {
        onSuccess: () => {
            console.log('Speech deleted successfully');
        },
        onError: (error) => {
            console.error('Error deleting speech:', error);
        },
    });
};
</script>
