<script setup lang="ts">
interface Invoice {
  id: number
  number: string
  supplier_name: string
  gross_amount: string
  status: string
  due_date: string
}

interface LaravelPagination<T> {
  data: T[]
  current_page: number
  last_page: number
  total: number
}
const config = useRuntimeConfig()
const { data: response, pending, error } = await useFetch<LaravelPagination<Invoice>>('/invoices', {
  baseURL: config.public.apiBase
})
const handleSelect = (row: any) => {
  const id = row.id;
  navigateTo(`/${id}`);
}
</script>

<template>
  <InvoiceTable
      :items="response?.data || []"
      :loading="pending"
      @select="handleSelect"
  />
</template>

<style scoped>

</style>