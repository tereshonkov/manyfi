# 1. Собрать образы и запустить контейнеры в фоне
docker-compose up -d --build

# 2. Создать структуру базы данных (миграции)
docker exec -it invoice_api php artisan migrate

# Frontend (Nuxt)	http://localhost:3001
# Backend API (Laravel)	http://localhost:8001/api/invoices