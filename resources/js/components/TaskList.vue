<script setup>
import { ref, onMounted } from "vue"
import api from "../api/axios.js"

const tasks = ref([])
const keywords = ref([])
const newTaskTitle = ref("")
const selectedKeywords = ref([])
const newKeywordName = ref("")
const successMessage = ref("")

onMounted(async () => {
    await fetchTasks()
    await fetchKeywords()
})

const fetchTasks = async () => {
    try {
        const res = await api.get("/tasks")
        tasks.value = res.data.data ?? res.data ?? []
    } catch (error) {
        console.error("Error al cargar tareas:", error)
    }
}

const fetchKeywords = async () => {
    try {
        const res = await api.get("/keywords")
        keywords.value = res.data.data ?? res.data ?? []
    } catch (error) {
        console.error("Error al cargar keywords:", error)
    }
}

const createTask = async () => {
    if (!newTaskTitle.value.trim()) return

    try {
        const response = await api.post("/tasks", {
            title: newTaskTitle.value,
            keywords: selectedKeywords.value,
        })

        tasks.value.push(response.data.data ?? response.data)

        newTaskTitle.value = ""
        selectedKeywords.value = []

        successMessage.value = "La tarea se creó exitosamente"

        setTimeout(() => {
            successMessage.value = ""
        }, 3000)
    } catch (error) {
        console.error("Error al crear tarea:", error)
    }
}

const toggleTask = async id => {
    try {
        const response = await api.patch(`/tasks/${id}/toggle`)
        const updatedTask = response.data.data ?? response.data

        const index = tasks.value.findIndex((t) => t.id === id)
        if (index !== -1) {
            tasks.value[index].is_done = updatedTask.is_done
        }
    } catch (error) {
        console.error("Error al cambiar estado:", error)
    }
}

const createKeyword = async () => {
    if (!newKeywordName.value.trim()) return

    try {
        const response = await api.post("/keywords", {
            name: newKeywordName.value,
        })

        keywords.value.push(response.data.data ?? response.data)

        newKeywordName.value = ""

        successMessage.value = "La palabra clave se creó exitosamente"

        setTimeout(() => {
            successMessage.value = ""
        }, 3000)
    } catch (error) {
        console.error("Error al crear keyword:", error)
    }
}
</script>

<template>
    <div class="container mt-4">
        <div
            v-if="successMessage"
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >
            {{ successMessage }}
            <button type="button" class="btn-close" @click="successMessage = ''"></button>
        </div>

        <!-- Formulario crear keyword -->
        <h5 class="mb-3">Crear nueva palabra clave</h5>
        <div class="card p-3 mb-4">
            <div class="d-flex gap-2">
                <input
                    v-model="newKeywordName"
                    type="text"
                    class="form-control"
                    placeholder="Ingresa el nombre de la palabra clave"
                />
                <button class="btn btn-primary" @click="createKeyword">
                    Crear
                </button>
            </div>
        </div>

        <!-- Formulario crear tarea -->
        <h5 class="mb-3">Crear nueva tarea</h5>
        <div class="card p-3 mb-4">
            <input
                v-model="newTaskTitle"
                type="text"
                class="form-control mb-2"
                placeholder="Ingresa el nombre de la tarea"
            />

            <select
                v-model="selectedKeywords"
                class="form-select mb-2"
                multiple
                size="5"
            >
                <option disabled value="">
                    Selecciona una o varias palabras clave
                </option>
                <option
                    v-for="keyword in keywords"
                    :key="keyword.id"
                    :value="keyword.id"
                >
                    {{ keyword.name }}
                </option>
            </select>

            <button class="btn btn-primary" @click="createTask">
                Crear tarea
            </button>
        </div>

        <!-- Lista de tareas -->
        <div class="mt-4">
            <h5 class="mb-3">Listado de tareas</h5>
            <ul class="list-group">
                <li
                    v-for="task in tasks"
                    :key="task.id"
                    class="list-group-item d-flex justify-content-between align-items-center"
                >
                    <div>
                        <strong>{{ task.title }}</strong>
                        <!-- Estado tarea -->
                        <span
                            class="badge rounded-pill ms-2 py-2"
                            :class="task.is_done ? 'bg-success' : 'bg-warning'"
                        >
                            {{ task.is_done ? "Completada" : "Pendiente" }}
                        </span>

                        <!-- Palabras clave asociadas -->
                        <div class="mt-1">
                          <span
                              v-for="keyword in task.keywords || []"
                              :key="keyword.id"
                              class="badge bg-secondary rounded-pill me-1"
                          >
                            {{ keyword.name }}
                          </span>
                        </div>
                    </div>

                    <!-- Botón cambiar estado de tarea -->
                    <button
                        @click="toggleTask(task.id)"
                        class="btn btn-sm"
                        :class="task.is_done
                          ? 'btn-outline-warning hover:bg-orange-500'
                          : 'btn-outline-success hover:bg-green-600'"
                    >
                        {{ task.is_done ? "Marcar como pendiente" : "Marcar como completada" }}
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>

