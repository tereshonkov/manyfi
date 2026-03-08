<script setup lang="ts">
const { getInvoices } = useInvoices()
const page = ref(1)
const { data: response, pending, refresh, error } = await getInvoices(page)
const handleSelect = (row: any) => {
  const id = row.id;
  navigateTo(`/${id}`);
}
const isOpen = ref<boolean>(false);
const selectedInvoice = ref<Invoice | null>(null)
const openModal = (invoice: Invoice | null = null) => {
  if (invoice && typeof invoice === 'object' && 'isTrusted' in invoice) {
    invoice = null
  }
  selectedInvoice.value = invoice ? { ...invoice } : null
  isOpen.value = true
}
const handleSaved = async () => {
  isOpen.value = false
  await refresh()
}

watch(isOpen, (newVal) => {
  if (!newVal) {
    selectedInvoice.value = null
  }
})
</script>

<template>
  <div class="mb-6 flex justify-end">
    <UButton label="Створити інвойс" @click="() => openModal()" />
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
      <div class="p-4" v-if="isOpen">
        <InvoiceForm
            :key="selectedInvoice?.id || 'create'"
            :initial-data="selectedInvoice"
            @saved="handleSaved"
            @cancel="isOpen = false"
        />
      </div>
    </UCard>
  </UModal>

  <InvoiceTable
      :items="response?.data || []"
      :loading="pending"
      :total="response?.total || 0"
      :page-size="response?.per_page || 10"
      v-model:page="page"
      @select="handleSelect"
      @edit="openModal"
  />
</template>

<style scoped>

</style>