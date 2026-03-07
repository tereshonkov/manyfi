import { z } from 'zod'

export const invoiceUpdateSchema = z.object({
    net_amount: z.coerce.number().positive('Сума має бути більше 0'),
    vat_amount: z.coerce.number().min(0, 'ПДВ не може бути від’ємним'),
    due_date: z.string().min(1, 'Оберіть дату оплати')
})
export const invoiceCreateSchema = invoiceUpdateSchema.extend({
    number: z.string().min(1, 'Номер обов’язковий'),
    supplier_name: z.string().min(3, 'Назва занадто коротка'),
    supplier_tax_id: z.string().min(1, 'Податковий номер обов’язковий'),
    currency: z.string().length(3, 'Код валюти — 3 символи'),
    issue_date: z.string().min(1, 'Оберіть дату виписки')
})