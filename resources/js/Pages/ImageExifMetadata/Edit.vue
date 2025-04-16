<template>
    <div class="p-6 max-w-xl mx-auto">
      <h1 class="text-xl font-bold mb-4">Edit EXIF Metadata</h1>
  
      <form @submit.prevent="submit">
        <div v-for="(value, key) in form.exif_data" :key="key" class="mb-4">
          <label class="block text-sm font-medium mb-1">{{ key }}</label>
          <input v-model="form.exif_data[key]" class="w-full border rounded px-2 py-1" />
        </div>
  
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded" :disabled="form.processing">Update</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { useForm } from '@inertiajs/vue3'
  import { defineProps } from 'vue'
  
  const props = defineProps({ imageOverwrite: Object })
  
  const form = useForm({
    exif_data: { ...props.imageOverwrite.exif_data }
  })
  
  const submit = () => {
    form.put(route('image-overwrites.update', props.imageOverwrite.id))
  }
  </script>