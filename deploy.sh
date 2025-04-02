#!/bin/bash

# Create a temporary directory for deployment
mkdir -p deploy
cp -r * deploy/
cd deploy

# Remove unnecessary files and directories
rm -rf node_modules
rm -rf vendor
rm -rf .git
rm -rf .gitignore
rm -rf deploy.sh
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

# Create a zip file
zip -r ../nextviralpost.zip ./*
cd ..
rm -rf deploy

echo "Deployment package created: nextviralpost.zip" 