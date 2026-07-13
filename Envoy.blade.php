@servers(['begetTech'=>'y95075ef@y95075ef.beget.tech'])

@task('deploy', ['on' => 'begetTech'])
// Путь к корневой папке сайта на хостинге (получен командой pwd, запущенной по ssh).
cd /home/y/y95075ef/y95075ef.beget.tech

set -e

echo "Deploying started..."

git pull origin main

php8.2 artisan down

php8.2 composer.phar install --no-dev --optimize-autoloader

php8.2 artisan migrate --force

php8.2 artisan config:cache

php8.2 artisan route:cache

php8.2 artisan view:cache

php8.2 artisan event:cache

php8.2 artisan queue:restart

php8.2 artisan up

echo "Deploying completed"

@endtask

@task('deploy', ['on' => 'begetTech'])

@endtask
