#!/bin/bash

# Check if the vendor directory exists
if [ ! -d "/var/www/html/vendor" ]; then
  echo "Vendor directory not found. Running composer install..."
  composer install
else
  echo "Vendor directory found. Skipping composer install."
fi

# # Check if the post directory exists and create it if it doesn't
# if [ ! -d "/var/www/html/post" ]; then
#   echo "Post directory not found. Creating post directory..."
#   mkdir -p /var/www/html/post
#   chown -R www-data:www-data /var/www/html/post
# else
#   echo "Post directory found. Skipping creation."
# fi

# # Check if the app is in development mode and run start-dev.bat if it is
# if [ "$CI_ENVIRONMENT" = "development" ]; then
#   echo "Running in development mode. Executing start-dev.bat..."
#   /usr/local/bin/start-dev.bat
# fi

# Run the default command
exec "$@"
