<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import { sortBy } from "@/services/sortBy";

const props = defineProps({
    users: { type: Object },
    project: { type: Object },
    tasks: { type: Object },
});
const sortedTask = ref(props.tasks);
const isAsc = ref(true);

const titleTaskSort = (data, order) => {
    isAsc.value = !order;

    sortedTask.value = data.sort(
        sortBy("title", order, (a) => a.toUpperCase())
    );
};

const stateTaskSort = (data, order) => {
    isAsc.value = !order;

    sortedTask.value = data.sort(
        sortBy("state", order, (a) => a.toUpperCase())
    );
};
</script>

<template>
    <Head title="Create project" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create project
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 md:min-h-max overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <section class="grid gap-6 md:grid-cols-2">
                        <div class="shadow-sm sm:rounded-lg bg-gray-50 p-4">
                            <h3 class="font-bold text-xl text-teal-600">
                                Project info
                            </h3>
                            <div class="mt-4">
                                <h1 class="font-semibold">
                                    {{ project.title }}
                                    <span
                                        class="block font-normal text-sm text-justify"
                                        >{{ project.description }}</span
                                    >
                                </h1>
                                <div class="grid grid-cols-2 mt-4">
                                    <p class="font-semibold text-md">
                                        Start date<span
                                            class="block text-sm text-gray-700"
                                            >{{ project.start_date }}</span
                                        >
                                    </p>
                                    <p class="font-semibold text-md">
                                        Due date<span
                                            class="block text-sm text-gray-700"
                                            >{{ project.finish_date }}</span
                                        >
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="shadow-sm sm:rounded-lg bg-gray-50 p-4">
                            <h3 class="font-bold text-xl text-teal-600">
                                Assigned users
                            </h3>
                            <table
                                class="w-full text-sm text-left text-gray-500 bg-white rounded-lg overflow-hidden mt-3"
                            >
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50"
                                >
                                    <tr>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 border border-gray-100"
                                        >
                                            User
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 border border-gray-100"
                                        >
                                            Email
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(user, i) in users"
                                        :key="user.id"
                                    >
                                        <th
                                            scope="row"
                                            class="px-6 py-4 font-medium border border-gray-100 text-gray-900"
                                        >
                                            {{ user.name }}
                                        </th>
                                        <th
                                            scope="row"
                                            class="px-6 py-4 font-medium border border-gray-100 text-gray-900"
                                        >
                                            {{ user.email }}
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                    <div class="shadow-sm sm:rounded-lg bg-gray-50 p-4 mt-6">
                        <h3 class="font-bold text-xl text-teal-600">
                            Project tasks
                        </h3>
                        <table
                            class="w-full text-sm text-left text-gray-500 bg-white rounded-lg overflow-hidden mt-3"
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50"
                            >
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-gray-100 cursor-pointer"
                                        @click="
                                            titleTaskSort(sortedTask, isAsc)
                                        "
                                    >
                                        Task <i class="fa-solid fa-sort"></i>
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-gray-100"
                                    >
                                        Project
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-gray-100 cursor-pointer"
                                        @click="
                                            stateTaskSort(sortedTask, isAsc)
                                        "
                                    >
                                        Status <i class="fa-solid fa-sort"></i>
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-gray-100"
                                    >
                                        Created at
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(task, i) in sortedTask"
                                    :key="task.id"
                                >
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
                                        {{ project.title }}
                                    </th>
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium border border-gray-100 text-gray-900"
                                    >
                                        <span
                                            class="py-1 px-2 rounded-lg text-white"
                                            :class="
                                                task.state === 'Pendiente'
                                                    ? 'bg-slate-500'
                                                    : task.state ===
                                                      'En proceso'
                                                    ? 'bg-green-500'
                                                    : 'bg-blue-600'
                                            "
                                            >{{ task.state }}</span
                                        >
                                    </th>
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium border border-gray-100 text-gray-900"
                                    >
                                        {{
                                            new Date(
                                                task.created_at
                                            ).toLocaleDateString("en-us", {
                                                year: "numeric",
                                                month: "long",
                                                day: "2-digit",
                                            })
                                        }}
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
