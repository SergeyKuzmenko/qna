## Описание:
Проект реализующий основную идею и функционал сервиса вопросов и ответов о программировании (аналог  
[qna.habr.com](https://qna.habr.com/))

## Установка
1. Клонируйте проект `git clone https://github.com/SergeyKuzmenko/qna.git`
2. Перейдите в созданую директорию `cd qna`
3. Выполните: `composer install`
3. Выполните: `npm install && npm run dev`
4. Создайте файл .env и установите параметры для подключения к базе данных.
5. Выполните: `php artisan key:generate`
6. Выполните: `php artisan migrate`
7. Выполните: `php artisan db:seed` (Опционально)
8. Готово
