#!/bin/bash

# Configuration
REMOTE_USER="ec2-user"
REMOTE_HOST="ec2-15-207-254-153.ap-south-1.compute.amazonaws.com"
DOMAIN="pandeyamit.com"

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m'

echo -e "${GREEN}Setting up domain configuration...${NC}"

# Upload virtual host configuration
echo "Uploading virtual host configuration..."
scp -i nextviralpostai.pem pandeyamit.com.conf $REMOTE_USER@$REMOTE_HOST:/tmp/

# Execute remote commands
echo "Configuring Apache..."
ssh -i nextviralpostai.pem $REMOTE_USER@$REMOTE_HOST "sudo bash -c ' \
    echo \"Setting up virtual host...\" && \
    sudo mv /tmp/pandeyamit.com.conf /etc/apache2/sites-available/ && \
    echo \"Enabling site...\" && \
    sudo a2ensite pandeyamit.com.conf && \
    echo \"Enabling mod_rewrite...\" && \
    sudo a2enmod rewrite && \
    echo \"Setting permissions...\" && \
    sudo chown -R www-data:www-data /var/www/html/nextviralpost && \
    sudo chmod -R 755 /var/www/html/nextviralpost && \
    echo \"Restarting Apache...\" && \
    sudo systemctl restart apache2 && \
    echo \"Checking Apache status...\" && \
    sudo systemctl status apache2'"

# Verify configuration
echo "Verifying configuration..."
ssh -i nextviralpostai.pem $REMOTE_USER@$REMOTE_HOST "sudo apache2ctl -S"

echo -e "${GREEN}Domain setup completed!${NC}"
echo "Please wait for DNS propagation (can take up to 48 hours)"
echo "You can check DNS propagation using: dig pandeyamit.com" 