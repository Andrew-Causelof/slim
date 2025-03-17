#!/bin/bash
# Синхронизация js файлов с сервером после обновления

trap "echo 'Скрипт остановлен'; exit" SIGINT SIGTERM

DIST_DIR="dist/"
$SRC_DIR="src/"
REMOTE_DIR="sergii3d_andrey@sergii3d.beget.tech:~/spinelife.seo-gravity.ru/public_html/local/templates/spinelife/components/seogravity/auth/login/js/dist/"
LAST_RUN=0
INTERVAL=3  # Интервал проверки изменений (в секундах)

echo "Отслеживание изменений в $DIST_DIR для синхронизации с сервером..."

while true; do
    CURRENT_TIME=$(date +%s)
    # Проверка изменений в директории с последнего запуска
    if find $SRC_DIR -type f -newermt "@$LAST_RUN" | grep -q .; then
        echo "Обнаружены изменения в jsx файлах. Запуск сборки..."
        if npm run build; then
            echo "Сборка завершена успешно. Синхронизация с сервером..."
            rsync -rvht $DIST_DIR $REMOTE_DIR
            echo "Папка синхронизирована."
            LAST_RUN=$CURRENT_TIME
        else
            echo "Ошибка во время сборки. Синхронизация отменена."
        fi
    fi
    sleep $INTERVAL
done