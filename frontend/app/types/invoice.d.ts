declare global {
    interface Invoice {
        id: number
        number: string
        supplier_name: string
        supplier_tax_id?: string
        gross_amount: string
        net_amount?: string
        vat_amount?: string
        currency?: string
        status: string
        issue_date?: string
        due_date: string
        created_at?: string
        updated_at?: string
    }

    interface LaravelPagination<T> {
        data: T[]
        current_page: number
        last_page: number
        total: number
        per_page: number
    }
}

export {}