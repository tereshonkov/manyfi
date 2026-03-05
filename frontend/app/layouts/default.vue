<script setup lang="ts">

</script>

<template>
  <div class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-900">
    <header class="border-b border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 sticky top-0 z-50">
      <UContainer class="py-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
          <UIcon name="i-heroicons-command-line" class="w-8 h-8 text-primary"/>
          <span class="font-bold text-xl">MyProject</span>
        </div>

        <div class="flex items-center gap-2">
          <UAvatar src="https://avatars.githubusercontent.com/u/739984?v=4" alt="Avatar"/>
        </div>
      </UContainer>
    </header>

    <main class="flex-grow py-8">
      <UContainer>
        <slot/>
      </UContainer>
    </main>

    <footer class="border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 py-6">
      <UContainer class="text-center text-sm text-gray-500">
        &copy; {{ new Date().getFullYear() }} Footer.
      </UContainer>
    </footer>
  </div>
</template>

<style scoped>

</style>