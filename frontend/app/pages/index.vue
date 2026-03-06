<script setup lang="ts">
const config = useRuntimeConfig()
const { data: response, pending, error } = await useFetch<LaravelPagination<Invoice>>('/invoices', {
  baseURL: config.public.apiBase
})
const handleSelect = (row: any) => {
  const id = row.id;
  navigateTo(`/${id}`);
}

const isOpen = ref<boolean>(false);
const selectedInvoice = ref<Invoice | null>(null)
const openCreateModal = () => {
  selectedInvoice.value = null
  isOpen.value = true
}

const openEditModal = (invoice: Invoice) => {
  selectedInvoice.value = { ...invoice }
  isOpen.value = true
}

const handleSaved = () => {
  isOpen.value = false
  refresh()
}
</script>

<template>
  <div class="mb-6 flex justify-end">
    <UButton label="Створити інвойс" @click="openCreateModal" />
  </div>
  <div v-if="error" class="mb-6">
    <UAlert
        icon="i-heroicons-exclamation-triangle"
        color="red"
        variant="soft"
        title="Помилка завантаження"
        :description="error.statusText || 'Не вдалося отримати дані з сервера'"
    />
  </div>
  <UModal v-model="isOpen">
    <UCard>
      <template #header>
        <div class="flex items-center justify-between">
          <h3 class="text-base font-semibold leading-6 text-gray-400">
            {{ selectedInvoice ? 'Редагувати' : 'Новий інвойс' }}
          </h3>
          <UButton color="gray" variant="ghost" icon="i-heroicons-x-mark-20-solid" class="-my-1" @click="isOpen = false" />
        </div>
      </template>
    </UCard>
  <div class="p-4" v-if="isOpen">
    <InvoiceForm
        :initial-data="selectedInvoice"
        @saved="handleSaved"
        @cancel="isOpen = false"
    />
  </div>
  </UModal>

  <InvoiceTable
      :items="response?.data || []"
      :loading="pending"
      @select="handleSelect"
      @edit="openEditModal"
  />
</template>

<style scoped>

</style>