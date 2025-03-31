Задание:
Реализовать приложение для трекинга валютных/обменных курсов валют без UI.

Функционал:
Обменные курсы (например USD -> EUR, EUR -> USD и т.д.) должны храниться в БД.
История значений обменных курсов (исторические данные)
добавление/удаление пар валют для трекинга (за которыми приложение начнёт следить) через консольную команду.
Курсы должны обновляться каждую минуту
JSON API эндпоинт для получения обменного курса (использовать внутренние данные приложения) по 2-м валютам с точностью до выбранной даты и времени


Желательно использовать внешний бесплатный API - https://freecurrencyapi.com , но опционально можно использовать mock API ответов


Установка:

Необходим установленный Docker
Для развертывания необходимо выполнить команды:
git clone git@github.com:AndreyNegrov/test_task_nda.git test_task
cd test_task
cp docker/.env.dist docker/.env
cp .env.dev .env.local
docker network create test-task-network
docker-compose up -d
docker-compose exec -it php composer install
docker-compose exec -it php php bin/console doctrine:migration:migrate


Команда добавления трекинга валютной пары:
docker-compose exec -it php php bin/console app:add-tracking EUR USD

Команда остановки трекинга валютной пары:
docker-compose exec -it php php bin/console app:remove-tracking EUR USD

Командазапуска трекинга:
docker-compose exec -it php php bin/console app:start-tracking

URL на получение курса:
http://localhost/api/rate?baseCurrency=USD&targetCurrency=CAD&date=2025-03-31%2014:30
