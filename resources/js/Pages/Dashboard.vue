<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
const props = defineProps({
    projects: { type: Number },
    tasks: { type: Number },
    users: { type: Number },
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 md:min-h-max overflow-hidden shadow-sm sm:rounded-lg grid items-start gap-6 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <div
                        class="w-full max-w-sm border bg-white border-gray-200 rounded-lg shadow"
                    >
                        <div class="flex flex-col items-center py-10">
                            <i
                                class="fa-solid fa-briefcase text-6xl text-gray-700"
                            ></i>
                            <h5 class="mb-1 text-xl font-medium text-gray-900">
                                {{ projects }}
                            </h5>
                            <span
                                class="text-sm text-gray-500 dark:text-gray-400"
                                >Projects</span
                            >
                            <div class="flex mt-4 space-x-3 md:mt-6">
                                <Link
                                    :href="route('projects.index')"
                                    :class="'inline-flex items-center px-4 py-2 text-sm  text-center   rounded-lg   bg-teal-500 hover:bg-teal-400 transition-colors duration-300 text-white hover:text-gray-700 font-bold'"
                                    >View projects</Link
                                >
                            </div>
                        </div>
                    </div>
                    <div
                        class="w-full max-w-sm border bg-white border-gray-200 rounded-lg shadow"
                    >
                        <div class="flex flex-col items-center py-10">
                            <i
                                class="fa-solid fa-list-check text-6xl text-gray-700"
                            ></i>
                            <h5 class="mb-1 text-xl font-medium text-gray-900">
                                {{ tasks }}
                            </h5>
                            <span
                                class="text-sm text-gray-500 dark:text-gray-400"
                                >Tasks</span
                            >
                            <div class="flex mt-4 space-x-3 md:mt-6">
                                <Link
                                    :href="route('tasks.index')"
                                    :class="'inline-flex items-center px-4 py-2 text-sm  text-center   rounded-lg   bg-teal-500 hover:bg-teal-400 transition-colors duration-300 text-white hover:text-gray-700 font-bold'"
                                    >View tasks</Link
                                >
                            </div>
                        </div>
                    </div>
                    <div
                        class="w-full max-w-sm border bg-white border-gray-200 rounded-lg shadow"
                    >
                        <div class="flex flex-col items-center py-10">
                            <i
                                class="fa-solid fa-user text-6xl text-gray-700"
                            ></i>
                            <h5 class="mb-1 text-xl font-medium text-gray-900">
                                {{ users }}
                            </h5>
                            <span
                                class="text-sm text-gray-500 dark:text-gray-400"
                                >Users</span
                            >
                            <div class="flex mt-4 space-x-3 md:mt-6">
                                <Link
                                    :href="route('users')"
                                    :class="'inline-flex items-center px-4 py-2 text-sm  text-center   rounded-lg   bg-teal-500 hover:bg-teal-400 transition-colors duration-300 text-white hover:text-gray-700 font-bold'"
                                    v-if="
                                        $page.props.auth.role.name === 'ADMIN'
                                    "
                                    >View users</Link
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
