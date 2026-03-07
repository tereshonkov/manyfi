<script setup lang="ts">
const props = defineProps<{
  initialData?: Invoice | null
}>()
const emit = defineEmits(['saved', 'cancel'])
const {updateInvoice, createInvoice} = useInvoices()
const isSaving = ref(false)
const initialDataRef = computed(() => props.initialData)

const state = reactive({
  number: initialDataRef.value?.number || '',
  supplier_name: initialDataRef.value?.supplier_name || '',
  supplier_tax_id: initialDataRef.value?.supplier_tax_id || '',
  currency: initialDataRef.value?.currency || 'UAH',
  issue_date: initialDataRef.value?.issue_date ? initialDataRef.value.issue_date.split('T')[0] : '',

  net_amount: Number(initialDataRef.value?.net_amount) || 0,
  vat_amount: Number(initialDataRef.value?.vat_amount) || 0,
  due_date: initialDataRef.value?.due_date ? initialDataRef.value.due_date.split('T')[0] : '',
})

watch(initialDataRef, (newData) => {
  state.number = newData?.number || ''
  state.supplier_name = newData?.supplier_name || ''
  state.supplier_tax_id = newData?.supplier_tax_id || ''
  state.currency = newData?.currency || 'UAH'
  state.issue_date = newData?.issue_date ? newData.issue_date.split('T')[0] : ''
  state.net_amount = Number(newData?.net_amount) || 0
  state.vat_amount = Number(newData?.vat_amount) || 0
  state.due_date = newData?.due_date ? newData.due_date.split('T')[0] : ''
}, { immediate: true })

const isLocked = computed(() => initialDataRef.value?.status !== 'pending' && !!initialDataRef.value)
const isEditing = computed(() => !!initialDataRef.value?.id)
const schema = computed(() => isEditing.value ? invoiceUpdateSchema : invoiceCreateSchema)

async function onSubmit() {
  isSaving.value = true
  try {
    if (isEditing.value) {
      await updateInvoice(initialDataRef.value!.id, {
        net_amount: state.net_amount,
        vat_amount: state.vat_amount,
        due_date: state.due_date
      })
    } else {
      await createInvoice({...state})
    }
    emit('saved')
  } catch (err: any) {
    console.error('Помилка API:', err.data)
  } finally {
    isSaving.value = false
  }
}
</script>

<template>
  <UForm :schema="schema" :state="state" class="space-y-4" @submit="onSubmit">

    <template v-if="!isEditing">
      <div class="grid grid-cols-2 gap-4">
        <UFormGroup label="Номер" name="number">
          <UInput v-model="state.number"/>
        </UFormGroup>
        <UFormGroup label="Валюта" name="currency">
          <USelect v-model="state.currency" :options="['UAH', 'USD', 'EUR']"/>
        </UFormGroup>
      </div>

      <UFormGroup label="Постачальник" name="supplier_name">
        <UInput v-model="state.supplier_name"/>
      </UFormGroup>

      <UFormGroup label="Tax ID" name="supplier_tax_id">
        <UInput v-model="state.supplier_tax_id"/>
      </UFormGroup>

      <UFormGroup label="Дата виписки" name="issue_date">
        <UInput v-model="state.issue_date" type="date"/>
      </UFormGroup>
    </template>

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
          :label="isEditing ? 'Оновити інвойс' : 'Створити інвойс'"
      />
    </div>
  </UForm>
</template>

<style scoped>

</style>