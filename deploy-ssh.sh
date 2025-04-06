#!/bin/bash

# Configuration
REMOTE_USER="ec2-user"
REMOTE_HOST="ec2-3-110-187-180.ap-south-1.compute.amazonaws.com"
REMOTE_PATH="/var/www/html/nextviralpost"
LOCAL_PATH="/c/Users/ameet/nextviralpost"

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m'

# Function to check command success
check_success() {
    if [ $? -ne 0 ]; then
        echo -e "${RED}Error: $1 failed${NC}"
        exit 1
    fi
}

echo -e "${GREEN}Starting deployment to EC2...${NC}"

# Create deployment package
echo "Creating deployment package..."
/bin/rm -rf deploy
check_success "Removing old deploy directory"
/bin/mkdir -p deploy
check_success "Creating deploy directory"
/bin/cp -r * deploy/
check_success "Copying files to deploy directory"
cd deploy

# Remove unnecessary files
echo "Cleaning up files..."
/bin/rm -rf node_modules vendor .git .gitignore deploy.sh deploy-ssh.sh .env .env.example .env.production storage/framework/cache/* storage/framework/sessions/* storage/framework/views/* storage/logs/* tests phpunit.xml README.md package.json package-lock.json vite.config.js postcss.config.js tailwind.config.js
check_success "Cleaning up files"

# Create storage directories
echo "Creating storage directories..."
/bin/mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs
check_success "Creating storage directories"

# Set proper permissions
echo "Setting permissions..."
/bin/chmod -R 755 storage bootstrap/cache
/bin/chmod -R 755 public
check_success "Setting permissions"

# Create zip file
echo "Creating zip file..."
/usr/bin/zip -r ../deploy.zip ./*
check_success "Creating zip file"
cd ..

# Upload to EC2
echo "Uploading to EC2..."
/usr/bin/scp -i nextviralpostai.pem deploy.zip $REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/
check_success "Uploading to EC2"

# Execute remote commands
echo "Executing remote commands..."
/usr/bin/ssh -i nextviralpostai.pem $REMOTE_USER@$REMOTE_HOST "cd $REMOTE_PATH && \
    echo 'Unzipping files...' && \
    /usr/bin/unzip -o deploy.zip && \
    echo 'Removing zip file...' && \
    /bin/rm deploy.zip && \
    echo 'Installing composer dependencies...' && \
    /usr/local/bin/composer install --no-dev --optimize-autoloader && \
    echo 'Caching configuration...' && \
    /usr/bin/php artisan config:cache && \
    echo 'Caching routes...' && \
    /usr/bin/php artisan route:cache && \
    echo 'Caching views...' && \
    /usr/bin/php artisan view:cache && \
    echo 'Running migrations...' && \
    /usr/bin/php artisan migrate --force && \
    echo 'Setting permissions...' && \
    /bin/chmod -R 755 storage bootstrap/cache && \
    /bin/chmod -R 755 public && \
    echo 'Restarting web server...' && \
    sudo systemctl restart apache2"
check_success "Executing remote commands"

# Clean up
echo "Cleaning up..."
/bin/rm -rf deploy
/bin/rm deploy.zip
check_success "Cleaning up"

echo -e "${GREEN}Deployment completed successfully!${NC}"

# Verify deployment
echo "Verifying deployment..."
/usr/bin/ssh -i nextviralpostai.pem $REMOTE_USER@$REMOTE_HOST "cd $REMOTE_PATH && \
    echo 'Checking file permissions...' && \
    ls -la && \
    echo 'Checking storage directory...' && \
    ls -la storage/ && \
    echo 'Checking cache directory...' && \
    ls -la bootstrap/cache/ && \
    echo 'Checking Laravel logs...' && \
    tail -n 5 storage/logs/laravel.log" 