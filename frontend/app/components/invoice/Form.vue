<script setup lang="ts">
import {z} from 'zod'

const schema = z.object({
  supplier_name: z
      .string()
      .min(3, {message: 'Назва має бути не менше 3 символів'}),

  net_amount: z
      .coerce
      .number()
      .positive({message: 'Сума має бути більше 0'}),

  vat_amount: z
      .coerce
      .number()
      .min(0, {message: 'ПДВ не може бути від’ємним'}),

  due_date: z
      .string()
      .min(1, {message: 'Оберіть дату оплати'}),

  status: z.string()
})

type Schema = z.output<typeof schema>

const props = defineProps<{
  initialData?: Invoice | null
}>()

const emit = defineEmits(['saved', 'cancel'])

const config = useRuntimeConfig()
const isSaving = ref(false)

const state = reactive({
  supplier_name: props.initialData?.supplier_name || '',
  net_amount: Number(props.initialData?.net_amount) || 0,
  vat_amount: Number(props.initialData?.vat_amount) || 0,
  due_date: props.initialData?.due_date ? props.initialData.due_date.split('T')[0] : '',
  status: props.initialData?.status || 'pending'
})

const isLocked = computed(() => props.initialData?.status !== 'pending' && !!props.initialData)

async function onSubmit() {
  isSaving.value = true

  const isEditing = !!props.initialData?.id

  const url = isEditing
      ? `/invoices/${props.initialData?.id}`
      : '/invoices'

  const method = isEditing ? 'PUT' : 'POST'

  try {
    await $fetch(url, {
      method,
      baseURL: config.public.apiBase,
      body: {
        supplier_name: state.supplier_name,
        net_amount: state.net_amount,
        vat_amount: state.vat_amount,
        due_date: state.due_date,
        status: state.status
      }
    })

    emit('saved')
  } catch (err: any) {
    console.error('Помилка API:', err.data)

    const backendErrors = err.data?.errors
    if (backendErrors) {
      alert('Перевірте правильність заповнення полів')
    }
  } finally {
    isSaving.value = false
  }
}
</script>

<template>
  <UForm :schema="schema" :state="state" class="space-y-4" @submit="onSubmit">

    <UFormGroup label="Постачальник" name="supplier_name">
      <UInput
          v-model="state.supplier_name"
          placeholder="Наприклад: ТОВ 'Енерго'"
          :disabled="isLocked"
          icon="i-heroicons-building-office"
      />
    </UFormGroup>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <UFormGroup label="Сума без ПДВ (Net)" name="net_amount">
        <UInput
            v-model.number="state.net_amount"
            type="number"
            step="0.01"
            :disabled="isLocked"
            icon="i-heroicons-banknotes"
        />
      </UFormGroup>

      <UFormGroup label="ПДВ (VAT)" name="vat_amount">
        <UInput
            v-model.number="state.vat_amount"
            type="number"
            step="0.01"
            :disabled="isLocked"
            icon="i-heroicons-receipt-percent"
        />
      </UFormGroup>
    </div>

    <UFormGroup label="Дата оплати" name="due_date">
      <UInput
          v-model="state.due_date"
          type="date"
          :disabled="isLocked"
          icon="i-heroicons-calendar-days"
      />
    </UFormGroup>

    <div class="flex justify-end gap-3 mt-6 border-t pt-4">
      <UButton
          color="gray"
          variant="ghost"
          label="Скасувати"
          @click="emit('cancel')"
      />
      <UButton
          type="submit"
          color="primary"
          :loading="isSaving"
          :disabled="isLocked"
          :label="props.initialData ? 'Оновити інвойс' : 'Створити інвойс'"
      />
    </div>
  </UForm>
</template>

<style scoped>

</style>