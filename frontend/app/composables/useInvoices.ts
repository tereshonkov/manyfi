export const useInvoices = () => {
    const config = useRuntimeConfig()
    const apiBase = import.meta.server ? config.apiUrl : config.public.apiBase

    const getInvoices = (page = 1) => {
        return useFetch<LaravelPagination<Invoice>>('/invoices', {
            baseURL: apiBase,
            query: { page },
            key: `invoices-list-page-${page}`,
        })
    }

    const getInvoice = (id: number | string) => {
        return useFetch<Invoice>(`/invoices/${id}`, {
            baseURL: apiBase,
            key: `invoice-detail-${id}`
        })
    }

    const createInvoice = async (payload: any) => {
        return await $fetch('/invoices', {
            method: 'POST',
            baseURL: apiBase,
            body: payload
        })
    }

    const updateInvoice = async (id: number, payload: any) => {
        return await $fetch(`/invoices/${id}`, {
            method: 'PUT',
            baseURL: apiBase,
            body: payload
        })
    }

    return {
        getInvoices,
        getInvoice,
        createInvoice,
        updateInvoice
    }
}