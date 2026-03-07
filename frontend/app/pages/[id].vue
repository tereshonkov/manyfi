<script setup lang="ts">
import { formatDate } from "~/utils/format";

const route = useRoute()
const invoiceId = computed(() => {
  const id = route.params.id
  return Array.isArray(id) ? id[0] : id
})
const getStatusColor = (status: string): any => {
  const colors = { pending: 'orange', approved: 'green', rejected: 'red' }
  return colors[status as keyof typeof colors] || 'gray'
}
const { getInvoice } = useInvoices()
const { data: invoice, pending, error } = await getInvoice(invoiceId.value as string)
</script>

<template>
  <UContainer class="py-8">
    <div class="mb-6">
      <UButton to="/" icon="i-heroicons-arrow-left" variant="ghost">
        Назад до списку
      </UButton>
    </div>

    <div v-if="pending" class="space-y-4">
      <USkeleton class="h-12 w-1/3" />
      <USkeleton class="h-64 w-full" />
    </div>

    <UAlert v-else-if="error" color="red" variant="soft" title="Помилка" description="Інвойс не знайдено" />

    <UCard v-else-if="invoice">
      <template #header>
        <div class="flex justify-between items-center">
          <h1 class="text-2xl font-bold">Інвойс {{ invoice?.number }}</h1>
          <UBadge :color="getStatusColor(invoice.status)" variant="subtle" class="capitalize text-lg px-3">
            {{ invoice.status }}
          </UBadge>
        </div>
      </template>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="space-y-4">
          <div>
            <div class="flex justify-between mb-1">
              <span class="text-sm text-gray-400 block uppercase tracking-wider">Постачальник</span>
              <p class="text-xl font-semibold text-gray-400">{{ invoice.supplier_name }}</p>
            </div>
            <p class="text-sm text-gray-500">ЄДРПОУ/TIN: {{ invoice.supplier_tax_id }}</p>
          </div>
          <div class="flex justify-between mb-1">
            <span class="text-gray-500">Сума без ПДВ (Net):</span>
            <span>{{ invoice.net_amount }} {{ invoice.currency }}</span>
          </div>
          <div class="flex justify-between mb-1">
            <span class="text-gray-500">ПДВ (VAT):</span>
            <span>{{ invoice.vat_amount }} {{ invoice.currency }}</span>
          </div>
          <div class="flex justify-between pt-2 border-t font-bold text-xl text-primary">
            <span>Разом (Gross):</span>
            <span>{{ invoice.gross_amount }} {{ invoice.currency }}</span>
          </div>
        </div>

        <div class="space-y-4 bg-gray-50 p-6 rounded-xl border border-gray-100">
          <div class="flex justify-between">
            <span class="text-sm text-gray-500">Дата виписки:</span>
            <span class="font-medium">{{ formatDate(invoice.issue_date) }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-sm text-gray-500">Граничний термін:</span>
            <span class="font-medium text-orange-600">{{ formatDate(invoice.due_date) }}</span>
          </div>

          <div class="pt-6 border-t border-gray-200 mt-4">
            <div class="flex justify-between items-center text-xs text-gray-400">
              <span>Створено:</span>
              <span>{{ formatDate(invoice?.created_at) }}</span>
            </div>
            <div class="flex justify-between items-center text-xs text-gray-400 mt-1">
              <span>Останні зміни:</span>
              <span class="font-medium text-gray-500">{{ formatDate(invoice?.updated_at) }}</span>
            </div>
          </div>
        </div>
      </div>
    </UCard>
  </UContainer>
</template>