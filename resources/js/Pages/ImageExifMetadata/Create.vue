<template>
    <div class="p-6 max-w-xl mx-auto">
      <h1 class="text-xl font-bold mb-4">Upload Image</h1>
  
      <form @submit.prevent="submit">
        <input type="file" @change="handleFile" class="mb-4" />
  
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded" :disabled="form.processing">Upload</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { useForm, router } from '@inertiajs/vue3'
  
  const form = useForm({ image: null })
  
  const handleFile = (e) => {
    form.image = e.target.files[0]
  }
  
  const submit = () => {
    form.post(route('image-overwrites.store'))
  }
  </script>