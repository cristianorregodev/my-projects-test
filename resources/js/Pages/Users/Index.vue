<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    users: { type: Object },
});
</script>

<template>
    <Head title="Users" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 overflow-hidden shadow-sm sm:rounded-lg"
                >
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
                                    >
                                        User name
                                        <i class="fa-solid fa-sort"></i>
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-gray-100 cursor-pointer"
                                    >
                                        user email
                                        <i class="fa-solid fa-sort"></i>
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-gray-100 cursor-pointer"
                                    >
                                        Role
                                        <i class="fa-solid fa-sort"></i>
                                    </th>

                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-gray-100 text-center w-24"
                                    >
                                        Created at
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, i) in users" :key="user.id">
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
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium border border-gray-100 text-gray-900"
                                    >
                                        {{
                                            user?.roles[0]?.name ||
                                            "Sin asignar"
                                        }}
                                    </th>
                                    <th
                                        scope="row"
                                        class="flex gap-3 justify-center py-4 font-medium border border-gray-100 text-gray-900"
                                    >
                                        {{ user.created_at }}
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
