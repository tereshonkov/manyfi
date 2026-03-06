export const formatDate = (date?: string) => {
    if (!date) return '—'
    return new Date(date).toLocaleDateString('uk-UA', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}

export const getStatusColor = (status: string) => {
    const colors: Record<string, string> = {
        pending: 'orange',
        approved: 'green',
        rejected: 'red'
    }
    return colors[status] || 'gray'
}