<template>
    <AppLayout>
        <Container>
            <div class="mx-auto max-w-2xl p-4">
                <div class="mb-3 flex items-center justify-between">
                    <h1 class="text-2xl font-bold">Create Speech</h1>
                    <div class="text-sm/6">
                        <a
                            href="#"
                            class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300"
                            @click.prevent="toggleDatePicker"
                        >
                            Pick a workshop
                            <span aria-hidden="true"> &rarr;</span>
                        </a>
                    </div>
                    <!-- Calendar shown only if toggled -->
                    <div v-if="showDatePicker" class="mt-2">
                        <VueDatePicker
                            v-model="workshopDate"
                            :min-date="minDate"
                            :max-date="futureSixMonths"
                            :allowed-dates="props.workshops.map((w) => new Date(w.date))"
                            :enable-time-picker="false"
                        ></VueDatePicker>
                    </div>
                </div>
                <form @submit.prevent="submit">
                    <div>
                        <!-- <label for="title" class="block text-sm font-medium text-gray-700">Title</label> -->
                        <InputLabel for="title">Title</InputLabel>
                        <TextInput
                            type="text"
                            id="title"
                            name="title"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="How to save a life"
                            v-model="speechForm.title"
                        />
                        <InputError :message="speechForm.errors.title" class="mt-1" />
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel for="type">Pathway</InputLabel>
                            <SelectInput
                                :options="pathways"
                                label-prop="name"
                                class="!mt-1"
                                v-model="speechForm.pathway"
                            ></SelectInput>
                            <InputError :message="speechForm.errors.pathway" class="mt-1" />
                        </div>
                        <div>
                            <InputLabel for="length">Length (mins)</InputLabel>
                            <TextInput
                                type="text"
                                id="length"
                                name="length"
                                v-model="speechForm.length"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            />
                            <InputError :message="speechForm.errors.length" class="mt-1" />
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel for="type">Level</InputLabel>
                            <TextInput
                                v-model="speechForm.level"
                                type="number"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            ></TextInput>
                            <InputError :message="speechForm.errors.level" class="mt-1" />
                        </div>
                        <div>
                            <InputLabel for="project">Project</InputLabel>
                            <TextInput
                                v-model="speechForm.project"
                                type="number"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            ></TextInput>
                            <InputError :message="speechForm.errors.project" class="mt-1" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <InputLabel for="abstract">Objectives</InputLabel>
                        <TextArea rows="4" class="mt-1" v-model="speechForm.objectives"></TextArea>
                        <p class="mt-1 text-sm text-gray-500">
                            Describe the objectives of your talk. What will the audience learn?
                        </p>
                        <InputError :message="speechForm.errors.objectives" class="mt-1" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="organizer_notes">Evaluator Notes</InputLabel>
                        <TextArea rows="4" class="mt-1" v-model="speechForm.evaluator_notes"></TextArea>
                        <p class="mt-1 text-sm text-gray-500">
                            Write any notes you may want to pass to the evaluator about this talk.
                        </p>
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="button"
                            class="mr-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            @click="cancel"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </Container>
    </AppLayout>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const showDatePicker = ref(false);
const minDate = new Date('2025-09-11');
const futureSixMonths = new Date();
futureSixMonths.setMonth(minDate.getMonth() + 6);

// const disabledDates = ref([
//   new Date(), // Today
//   { days: [0, 6] } // Weekends
// ]);

const toggleDatePicker = () => {
    showDatePicker.value = !showDatePicker.value;
};

const props = defineProps({
    pathways: {
        type: Array,
        required: true,
    },
    errors: {
        type: Object,
        default: () => ({}),
    },
    speech: {
        type: Object,
        default: () => ({}),
    },
    isEdit: {
        type: Boolean,
        default: false,
    },
    workshops: {
        type: Array,
        default: () => [],
    },
    workshop_id: {
        type: [Number, null],
        default: null,
    },
});

const speechForm = useForm({
    title: props.speech.title || '',
    pathway: props.speech.pathway || '',
    length: props.speech.length || '',
    objectives: props.speech.objectives || '',
    evaluator_notes: props.speech.evaluator_notes || '',
    level: props.speech.level || '',
    project: props.speech.project || '',
    // workshopDate: props.speech.workshop?.date || null, // date selected in calendar
    workshop_id: props.workshop_id || null, // actual id to save
});

// console.log('Initial speech form:', speechForm.workshop_id);

const dateToIdMap = Object.fromEntries(props.workshops.map((w) => [w.date, w.id]));
const idToDateMap = Object.fromEntries(props.workshops.map((w) => [w.id, w.date]));

const workshopDate = computed({
    get() {
        return speechForm.workshop_id ? new Date(idToDateMap[speechForm.workshop_id]) : null;
    },
    set(newDate) {
        if (newDate) {
            const formattedDate = newDate.toISOString().split('T')[0];
            speechForm.workshop_id = dateToIdMap[formattedDate] || null;
        } else {
            speechForm.workshop_id = null;
        }
    },
});

// console.log(props.workshops[0].date);

// watch(
//     () => speechForm.workshopDate,
//     (newDate) => {
//         // convert Thu Sep 25 2025 20:41:00 GMT+0100 (Irish Standard Time) to YYYY-MM-DD
//         const formattedDate = newDate.toISOString().split('T')[0];
//         // console.log('Selected date changed:', formattedDate);
//         speechForm.workshop_id = dateToIdMap[formattedDate] || null;
//         // console.log('Updated workshop_id:', speechForm.workshop_id);
//     },
// );

const submit = () => {
    props.isEdit ? speechForm.put(route('speeches.update', props.speech)) : speechForm.post(route('speeches.store'));
};

const cancel = () => {
    // Logic to handle cancel action, e.g., redirect to the speeches list
    window.history.back();
};
</script>
