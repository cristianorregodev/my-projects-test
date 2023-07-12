<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import Modal from "@/Components/Modal.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";
import Swal from "sweetalert2";

const nameInput = ref(null);
const modal = ref(false);
const modalTitle = ref("");
const operation = ref(1);
const id = ref("");
const taskStates = {
    0: { id: "Pendiente", title: "Pendiente" },
    1: { id: "En proceso", title: "En proceso" },
    2: { id: "Finalizada", title: "Finalizada" },
};
const props = defineProps({
    tasks: { type: Object },
    projects: { type: Object },
});
const form = useForm({
    title: "",
    description: "",
    state: "",
    project_id: "",
});

const openModal = (op, title, description, state, project_id, task_id) => {
    modal.value = true;
    nextTick(() => {
        nameInput.value.focus();
    });
    operation.value = op;
    id.value = task_id;
    if (op === 1) {
        modalTitle.value = "Create task";
    } else {
        modalTitle.value = "Edit task";
        form.title = title;
        form.description = description;
        form.state = state;
        form.project_id = project_id;
    }
};

const closeModal = () => {
    modal.value = false;
    form.reset();
};

const saveTask = () => {
    if (operation.value == 1) {
        form.post(route("tasks.store"), {
            onSuccess: () => {
                ok("Task created");
            },
        });
    } else {
        form.put(route("tasks.update", id.value), {
            onSuccess: () => {
                ok("Task updated");
            },
        });
    }
};

const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({ title: msj, icon: "success" });
};

const deleteTask = (id, title) => {
    const confirm = Swal.mixin({
        buttonsStyling: true,
    });
    confirm
        .fire({
            title: "Are you going to delete the " + title + " task?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText:
                '<i class="fa-solid fa-thumbs-up"></i> Yes, delete',
            cancelButtonText: '<i class="fa-solid fa-xmark"></i> Cancel',
        })
        .then((result) => {
            if (result.isConfirmed) {
                form.delete(route("tasks.destroy", id), {
                    onSuccess: () => {
                        ok("Task deleted");
                    },
                });
            }
        });
};
</script>

<template>
    <Head title="Tasks" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tasks
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div>
                        <button
                            @click="($event) => openModal(1)"
                            :class="'px-4 py-2 rounded-md bg-teal-500 hover:bg-teal-400 transition-colors duration-300 text-white hover:text-gray-700 font-bold'"
                        >
                            <i class="fa-solid fa-circle-plus"></i> New task
                        </button>
                    </div>
                    <div
                        class="relative overflow-x-auto shadow-md sm:rounded-lg mt-8"
                    >
                        <table
                            class="w-full text-sm text-left text-gray-500 table-fixed"
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50"
                            >
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-gray-100"
                                    >
                                        Task title
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-gray-100"
                                    >
                                        Description
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-gray-100"
                                    >
                                        Project
                                    </th>

                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-gray-100 text-center w-24"
                                    >
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(task, i) in tasks" :key="task.id">
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium border border-gray-100 text-gray-900"
                                    >
                                        {{ task.title }}
                                    </th>
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium border border-gray-100 text-gray-900"
                                    >
                                        {{ task.description }}
                                    </th>
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium border border-gray-100 text-gray-900"
                                    >
                                        {{ task.project.title }}
                                    </th>

                                    <th
                                        scope="row"
                                        class="py-4 font-medium border border-gray-100 text-gray-900"
                                    >
                                        <div class="flex gap-3 justify-center">
                                            <button
                                                @click="
                                                    ($event) =>
                                                        openModal(
                                                            2,
                                                            task.title,
                                                            task.description,
                                                            task.state,
                                                            task.project_id,
                                                            task.id
                                                        )
                                                "
                                                :class="'font-medium text-gray-600 hover:underline'"
                                                title="Edit"
                                            >
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            <button
                                                @click="
                                                    ($event) =>
                                                        deleteTask(
                                                            task.id,
                                                            task.title
                                                        )
                                                "
                                                class="font-medium text-red-600 hover:underline"
                                                title="Delete"
                                                v-if="
                                                    $page.props.auth.role
                                                        .name === 'ADMIN'
                                                "
                                            >
                                                <i
                                                    class="fa-solid fa-trash"
                                                ></i>
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <Modal :show="modal" @close="closeModal">
                <div class="p-4">
                    <h2 class="text-lg font-medium">{{ modalTitle }}</h2>
                    <div class="mb-6">
                        <label
                            for="title"
                            class="block text-sm font-medium text-gray-900"
                            >Task title</label
                        >
                        <input
                            type="text"
                            id="title"
                            v-model="form.title"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Test endpoints..."
                        />
                        <span
                            v-if="form.errors.title"
                            class="text-sm text-red-500 font-semibold"
                            >{{ form.errors.title }}</span
                        >
                    </div>
                    <div class="mb-6">
                        <label
                            for="description"
                            class="block text-sm font-medium text-gray-900"
                            >Task description</label
                        >
                        <input
                            type="text"
                            id="description"
                            v-model="form.description"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Some comments about the task..."
                        />
                        <span
                            v-if="form.errors.description"
                            class="text-sm text-red-500 font-semibold"
                            >{{ form.errors.description }}</span
                        >
                    </div>
                    <div class="mb-6">
                        <label
                            for="state"
                            class="block text-sm font-medium text-gray-900"
                            >Task state</label
                        >
                        <SelectInput
                            id="state"
                            v-model="form.state"
                            :options="taskStates"
                        >
                        </SelectInput>

                        <span
                            v-if="form.errors.state"
                            class="text-sm text-red-500 font-semibold"
                            >{{ form.errors.state }}</span
                        >
                    </div>
                    <div class="mb-6">
                        <label
                            for="project_id"
                            class="block text-sm font-medium text-gray-900"
                            >Assign project</label
                        >
                        <SelectInput
                            id="project_id"
                            v-model="form.project_id"
                            :options="projects"
                        >
                        </SelectInput>

                        <span
                            v-if="form.errors.project_id"
                            class="text-sm text-red-500 font-semibold"
                            >{{ form.errors.project_id }}</span
                        >
                    </div>
                    <div class="relative">
                        <PrimaryButton
                            :disabled="form.processing"
                            @click="saveTask"
                            class="mt-4"
                            ><i class="fa-solid fa-floppy-disk"></i>
                            Save</PrimaryButton
                        >
                        <button
                            :disabled="form.processing"
                            @click="closeModal"
                            class="absolute right-0 bottom-0 inline-flex items-center px-4 py-2 bg-gray-100 border rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:bg-red-600 transition ease-in-out duration-150"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
