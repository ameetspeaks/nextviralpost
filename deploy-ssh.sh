#!/bin/bash

# Configuration
REMOTE_USER="u837433364"
REMOTE_HOST="46.202.161.83"
REMOTE_PATH="/home/pandeyamit.com/public_html/nextpostai"
LOCAL_PATH="C:\Users\ameet\nextviralpost"

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m'

echo -e "${GREEN}Starting deployment to Hostinger...${NC}"

# Create deployment package
echo "Creating deployment package..."
rm -rf deploy
mkdir -p deploy
cp -r * deploy/
cd deploy

# Remove unnecessary files
echo "Cleaning up files..."
rm -rf node_modules
rm -rf vendor
rm -rf .git
rm -rf .gitignore
rm -rf deploy.sh
rm -rf deploy-ssh.sh
rm -rf .env
rm -rf .env.example
rm -rf .env.production
rm -rf storage/framework/cache/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*
rm -rf storage/logs/*
rm -rf tests
rm -rf phpunit.xml
rm -rf README.md
rm -rf package.json
rm -rf package-lock.json
rm -rf vite.config.js
rm -rf postcss.config.js
rm -rf tailwind.config.js

# Create storage directories
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs

# Set proper permissions
chmod -R 755 storage bootstrap/cache
chmod -R 755 public

# Create zip file
echo "Creating zip file..."
zip -r ../deploy.zip ./*
cd ..

# Upload to server
echo "Uploading to server..."
scp deploy.zip $REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/

# Execute remote commands
echo "Executing remote commands..."
ssh $REMOTE_USER@$REMOTE_HOST "cd $REMOTE_PATH && \
    unzip -o deploy.zip && \
    rm deploy.zip && \
    composer install --no-dev --optimize-autoloader && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force && \
    chmod -R 755 storage bootstrap/cache && \
    chmod -R 755 public"

# Clean up
echo "Cleaning up..."
rm -rf deploy
rm deploy.zip

echo -e "${GREEN}Deployment completed successfully!${NC}" 