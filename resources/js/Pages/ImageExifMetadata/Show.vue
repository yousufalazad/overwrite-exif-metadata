<template>
    <div class="p-6 max-w-4xl mx-auto">
      <h1 class="text-2xl font-bold mb-4">Image: {{ imageOverwrite.original_name }}</h1>
  
      <img :src="`/storage/${imageOverwrite.stored_path}`" alt="Uploaded Image" class="max-w-sm mb-6 rounded shadow" />
  
      <h2 class="font-semibold text-lg mb-2">EXIF Metadata:</h2>
      <div class="grid grid-cols-2 gap-4">
        <div v-for="(value, key) in imageOverwrite.exif_data" :key="key" class="border p-2 rounded">
          <strong>{{ key }}:</strong> <span class="text-sm">{{ value }}</span>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  defineProps({ imageOverwrite: Object })
  </script>