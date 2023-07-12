<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    project: { type: Object },
    assignedUsers: { type: Object },
    users: { type: Object },
});

const form = useForm({
    title: props.project.title,
    description: props.project.description,
    start_date: props.project.start_date,
    finish_date: props.project.finish_date,
    users: props.assignedUsers,
});

const e = props.users;
</script>

<template>
    <Head title="Edit project" />
    {{ console.log("e", e) }}
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit project
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 md:min-h-max overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <form
                        @submit.prevent="
                            ($event) =>
                                form.patch(route('projects.update', project))
                        "
                    >
                        <div class="mb-6">
                            <label
                                for="title"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Project title</label
                            >
                            <input
                                type="text"
                                id="title"
                                v-model="form.title"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Landing page..."
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
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Project description</label
                            >
                            <input
                                type="text"
                                id="description"
                                v-model="form.description"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Here is some description about the project..."
                            />
                            <span
                                v-if="form.errors.description"
                                class="text-sm text-red-500 font-semibold"
                                >{{ form.errors.description }}</span
                            >
                        </div>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <label
                                    for="start_date"
                                    class="block mb-2 text-sm font-medium text-gray-900"
                                    >Start date</label
                                >
                                <input
                                    type="date"
                                    id="start_date"
                                    v-model="form.start_date"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                />
                                <span
                                    v-if="form.errors.start_date"
                                    class="text-sm text-red-500 font-semibold"
                                    >{{ form.errors.start_date }}</span
                                >
                            </div>
                            <div>
                                <label
                                    for="finish_date"
                                    class="block mb-2 text-sm font-medium text-gray-900"
                                    >Start date</label
                                >
                                <input
                                    type="date"
                                    id="finish_date"
                                    v-model="form.finish_date"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                />
                                <span
                                    v-if="form.errors.finish_date"
                                    class="text-sm text-red-500 font-semibold"
                                    >{{ form.errors.finish_date }}</span
                                >
                            </div>
                        </div>
                        <p class="block mb-2 text-sm font-medium text-gray-900">
                            Assign users
                        </p>
                        <div class="grid md:grid-cols-3 lg:grid-cols-5">
                            <label
                                v-for="(user, i) in users"
                                :key="user.id"
                                class="text-sm"
                            >
                                <input
                                    type="checkbox"
                                    id="users"
                                    v-model="form.users"
                                    class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300"
                                    :value="user.id"
                                    checked
                                />
                                {{ user.name }}
                            </label>
                        </div>
                        <PrimaryButton :disabled="form.processing" class="mt-4"
                            ><i class="fa-solid fa-floppy-disk"></i>
                            Update</PrimaryButton
                        >
                    </form>
                    <!-- {{ $page.props.auth.user.name }} -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
