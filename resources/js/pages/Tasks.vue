<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import TaskList from '@/components/TaskList.vue'
</script>

<template>
    <Head title="Tareas" />

    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <div
            class="w-full mt-4 mb-4 max-w-5xl flex flex-col gap-6 rounded-2xl border p-8 shadow-lg bg-white dark:bg-gray-900 dark:border-gray-700"
        >
            <h1 class="text-2xl font-semibold mb-4 text-center">Gestor de Tareas</h1>
            <TaskList />
        </div>
    </div>
</template>
