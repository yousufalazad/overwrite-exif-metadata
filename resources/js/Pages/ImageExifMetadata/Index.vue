<template>
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Images</h1>
        <Link :href="route('image-overwrites.create')" class="bg-blue-600 text-white px-4 py-2 rounded">Upload New</Link>
      </div>
  
      <div class="grid gap-4">
        <div v-for="img in imageOverwrites" :key="img.id" class="border p-4 rounded shadow">
          <p class="font-semibold">{{ img.original_name }}</p>
          <Link :href="route('image-overwrites.show', img.id)" class="text-blue-500">View</Link>
          <Link :href="route('image-overwrites.edit', img.id)" class="ml-4 text-green-500">Edit</Link>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  defineProps({ imageOverwrites: Array })
  import { Link } from '@inertiajs/vue3'
  </script>