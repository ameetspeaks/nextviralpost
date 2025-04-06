#!/bin/bash

# Configuration
REMOTE_USER="ec2-user"
REMOTE_HOST="ec2-3-110-187-180.ap-south-1.compute.amazonaws.com"
REMOTE_PATH="/var/www/html/nextviralpost"
GIT_REPO="https://github.com/ameetspeaks/nextviralpost.git"

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m'

echo -e "${GREEN}Starting Git-based deployment to EC2...${NC}"

# Execute remote commands
echo "Executing remote commands..."
/usr/bin/ssh -i nextviralpostai.pem $REMOTE_USER@$REMOTE_HOST "cd $REMOTE_PATH && \
    echo 'Pulling latest changes...' && \
    git pull origin main && \
    echo 'Installing composer dependencies...' && \
    composer install --no-dev --optimize-autoloader && \
    echo 'Caching configuration...' && \
    php artisan config:cache && \
    echo 'Caching routes...' && \
    php artisan route:cache && \
    echo 'Caching views...' && \
    php artisan view:cache && \
    echo 'Running migrations...' && \
    php artisan migrate --force && \
    echo 'Setting permissions...' && \
    chmod -R 755 storage bootstrap/cache && \
    chmod -R 755 public && \
    echo 'Restarting web server...' && \
    sudo systemctl restart apache2"

# Verify deployment
echo "Verifying deployment..."
/usr/bin/ssh -i nextviralpostai.pem $REMOTE_USER@$REMOTE_HOST "cd $REMOTE_PATH && \
    echo 'Checking Git status...' && \
    git status && \
    echo 'Checking file permissions...' && \
    ls -la && \
    echo 'Checking storage directory...' && \
    ls -la storage/ && \
    echo 'Checking cache directory...' && \
    ls -la bootstrap/cache/ && \
    echo 'Checking Laravel logs...' && \
    tail -n 5 storage/logs/laravel.log"

echo -e "${GREEN}Git-based deployment completed!${NC}" 