<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Swal from "sweetalert2";
import { sortBy } from "@/services/sortBy";

const props = defineProps({
    projects: { type: Object },
});
const sortedProjects = ref(props.projects);
const isAsc = ref(true);

const form = useForm({
    id: "",
});

const deleteProject = (id, title) => {
    const confirm = Swal.mixin({
        buttonsStyling: true,
    });
    confirm
        .fire({
            title: "Are you going to delete the " + title + " project?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText:
                '<i class="fa-solid fa-thumbs-up"></i> Yes, delete',
            cancelButtonText: '<i class="fa-solid fa-xmark"></i> Cancel',
        })
        .then((result) => {
            if (result.isConfirmed) {
                form.delete(route("projects.destroy", id));
                sortedProjects.value = props.projects.filter(
                    (project) => project.id !== id
                );
            }
        });
};

const titleProjectSort = (data, order) => {
    isAsc.value = !order;

    sortedProjects.value = data.sort(
        sortBy("title", order, (a) => a.toUpperCase())
    );
};

const startDateProjectSort = (data, order) => {
    isAsc.value = !order;
    sortedProjects.value = data.sort(sortBy("start_date", order, parseInt));
};
const finishDateProjectSort = (data, order) => {
    isAsc.value = !order;
    sortedProjects.value = data.sort(sortBy("due_date", order, parseInt));
};
</script>

<template>
    <Head title="Projects" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Projects
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div>
                        <Link
                            :href="route('projects.create')"
                            :class="'px-4 py-2 rounded-md bg-teal-500 hover:bg-teal-400 transition-colors duration-300 text-white hover:text-gray-700 font-bold'"
                            v-if="$page.props.auth.role.name === 'ADMIN'"
                            ><i class="fa-solid fa-circle-plus"></i> New
                            project</Link
                        >
                    </div>
                    <div
                        class="relative overflow-x-auto shadow-md sm:rounded-lg mt-8"
                    >
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50"
                            >
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-gray-100 cursor-pointer"
                                        @click="
                                            titleProjectSort(
                                                sortedProjects,
                                                isAsc
                                            )
                                        "
                                    >
                                        Project title
                                        <i class="fa-solid fa-sort"></i>
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-gray-100 cursor-pointer"
                                        @click="
                                            startDateProjectSort(
                                                sortedProjects,
                                                isAsc
                                            )
                                        "
                                    >
                                        Start date
                                        <i class="fa-solid fa-sort"></i>
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-gray-100 cursor-pointer"
                                        @click="
                                            finishDateProjectSort(
                                                sortedProjects,
                                                isAsc
                                            )
                                        "
                                    >
                                        Finish date
                                        <i class="fa-solid fa-sort"></i>
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
                                <tr
                                    v-for="(project, i) in sortedProjects"
                                    :key="project.id"
                                >
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium border border-gray-100 text-gray-900"
                                    >
                                        {{ project.title }}
                                    </th>
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium border border-gray-100 text-gray-900"
                                    >
                                        {{ project.start_date }}
                                    </th>
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium border border-gray-100 text-gray-900"
                                    >
                                        {{ project.due_date }}
                                    </th>
                                    <th
                                        scope="row"
                                        class="flex gap-3 justify-center py-4 font-medium border border-gray-100 text-gray-900"
                                    >
                                        <Link
                                            :href="
                                                route(
                                                    'projects.show',
                                                    project.id
                                                )
                                            "
                                            :class="'font-medium text-blue-600 hover:underline'"
                                            title="View"
                                            ><i class="fa-solid fa-eye"></i
                                        ></Link>
                                        <Link
                                            :href="
                                                route(
                                                    'projects.edit',
                                                    project.id
                                                )
                                            "
                                            :class="'font-medium text-gray-600 hover:underline'"
                                            title="Edit"
                                            v-if="
                                                $page.props.auth.role.name ===
                                                'ADMIN'
                                            "
                                            ><i class="fa-solid fa-pen"></i>
                                        </Link>
                                        <button
                                            @click="
                                                ($event) =>
                                                    deleteProject(
                                                        project.id,
                                                        project.title
                                                    )
                                            "
                                            class="font-medium text-red-600 hover:underline"
                                            title="Delete"
                                            v-if="
                                                $page.props.auth.role.name ===
                                                'ADMIN'
                                            "
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
