<script setup lang="ts">
import { getStatusColor } from "~/utils/format";
defineProps<{
  items: any[]
  loading: boolean
}>()

const emit = defineEmits(['select', 'edit'])

const columns = [
  {key: 'number', label: 'Number'},
  {key: 'supplier_name', label: 'Supplier Name'},
  {key: 'gross_amount', label: 'Gross Amount'},
  {key: 'status', label: 'Status'},
  {key: 'due_date', label: 'Due Date'},
  { key: 'actions', label: '' }
]
</script>

<template>
  <UTable
      :rows="items"
      :columns="columns"
      :loading="loading"
      by="id"
      @select="(row: any) => emit('select', row)"
  >
    <template #status-data="{ row }">
      <UBadge
          :color="getStatusColor(row.status) as any"
          variant="subtle"
      >
        {{ row.status }}
      </UBadge>
    </template>

    <template #gross_amount-data="{ row }">
      <span class="font-bold">
        {{ row.gross_amount }} {{ row.currency }}
      </span>
    </template>

    <template #due_date-data="{ row }">
      {{ new Date(row.due_date).toLocaleDateString('uk-UA') }}
    </template>
    <template #actions-data="{ row }">
      <UButton
          icon="i-heroicons-pencil-square"
          size="sm"
          color="blue"
          variant="ghost"
          @click.stop="emit('edit', row)"
      />
    </template>
  </UTable>
</template>

<style scoped>

</style>