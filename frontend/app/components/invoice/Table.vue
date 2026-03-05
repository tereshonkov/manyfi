<script setup lang="ts">

defineProps<{
  items: any[]
  loading: boolean
}>()

const emit = defineEmits(['select'])

const columns = [
  { key: 'number', label: 'Number' },
  { key: 'supplier_name', label: 'Supplier Name' },
  { key: 'gross_amount', label: 'Gross Amount' },
  { key: 'status', label: 'Status' },
  { key: 'due_date', label: 'Due Date' }
]
</script>

<template>
  <UTable
      :rows="items"
      :columns="columns"
      :loading="loading"
      by="id"
      @select="(row: any) => emit('select', row)"
  />
</template>

<style scoped>

</style>