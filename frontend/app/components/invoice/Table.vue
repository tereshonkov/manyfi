<script setup lang="ts">
import { getStatusColor } from "~/utils/format";
const props = defineProps<{
  items: any[]
  loading: boolean
  total: number
  page: number
  pageSize: number
}>()

const emit = defineEmits(['select', 'edit', 'update:page'])

const columns = [
  {key: 'number', label: 'Number'},
  {key: 'supplier_name', label: 'Supplier Name'},
  {key: 'gross_amount', label: 'Gross Amount'},
  {key: 'status', label: 'Status'},
  {key: 'due_date', label: 'Due Date'},
  { key: 'actions', label: '' }
]

const currentPage = computed({
  get: () => props.page,
  set: (value) => emit('update:page', value)
})
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
  <div v-if="total > pageSize" class="flex justify-center border-t border-gray-200 dark:border-gray-700 pt-4">
    <UPagination
        v-model="currentPage"
        :page-count="pageSize"
        :total="total"
        :ui="{ rounded: 'rounded-full' }"
    />
  </div>
</template>

<style scoped>

</style>