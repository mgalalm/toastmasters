<template>
    <AppLayout>
        <Container>
            <div class="mx-auto max-w-2xl p-4">
                <div class="mb-3 flex items-center justify-between">
                    <h1 class="text-2xl font-bold">Assign Workshop Role</h1>
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
                    <div v-if="showDatePicker" class="mt-2">
                        <VueDatePicker
                            v-model="workshopDate"
                            :min-date="minDate"
                            :max-date="maxDate"
                            :allowed-dates="props.workshops.map((w) => new Date(w.date))"
                            :enable-time-picker="false"
                            locale="en-GB"
                            format="dd/MM/yyyy"
                            prevent-min-max-navigation
                        />
                    </div>
                </div>

                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="user_id" value="User" />
                        <SelectInput
                            id="user_id"
                            :options="users"
                            label="name"
                            value-prop="id"
                            class="!mt-1"
                            v-model="assignmentForm.user_id"
                        />
                        <InputError :message="assignmentForm.errors.user_id" class="mt-1" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="role" value="Role" />
                        <SelectInput
                            id="role"
                            :options="roles"
                            label="label"
                            value-prop="value"
                            class="!mt-1"
                            v-model="assignmentForm.role"
                        />
                        <InputError :message="assignmentForm.errors.role" class="mt-1" />
                    </div>

                    <div class="mt-4">
                        <InputLabel value="Workshop" />
                        <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Select a workshop date using “Pick a workshop” above.
                        </div>
                        <InputError :message="assignmentForm.errors.workshop_id" class="mt-1" />
                    </div>

                    <div class="mt-6 flex justify-end">
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
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const showDatePicker = ref(false);
const toggleDatePicker = () => {
    showDatePicker.value = !showDatePicker.value;
};

const props = defineProps({
    workshops: {
        type: Array,
        default: () => [],
    },
    users: {
        type: Array,
        default: () => [],
    },
    roles: {
        type: Array,
        default: () => [],
    },
    user_id: {
        type: [Number, String, null],
        default: null,
    },
    workshop_id: {
        type: [Number, String, null],
        default: null,
    },
});

const assignmentForm = useForm({
    user_id: props.user_id || null,
    workshop_id: props.workshop_id || null,
    role: '',
});

const minDate = computed(() => {
    if (!props.workshops.length) return null;
    return new Date(props.workshops[0].date);
});

const maxDate = computed(() => {
    if (!props.workshops.length) return null;
    return new Date(props.workshops[props.workshops.length - 1].date);
});

const dateToIdMap = Object.fromEntries(props.workshops.map((w) => [w.date, w.id]));
const idToDateMap = Object.fromEntries(props.workshops.map((w) => [w.id, w.date]));

const workshopDate = computed({
    get() {
        return assignmentForm.workshop_id ? new Date(idToDateMap[assignmentForm.workshop_id]) : null;
    },
    set(newDate) {
        if (newDate) {
            const formattedDate = newDate.toISOString().split('T')[0];
            assignmentForm.workshop_id = dateToIdMap[formattedDate] || null;
        } else {
            assignmentForm.workshop_id = null;
        }
    },
});

const submit = () => {
    assignmentForm.post(route('assignments.store'));
};

const cancel = () => {
    window.history.back();
};
</script>
