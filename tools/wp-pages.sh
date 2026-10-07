#!/bin/bash
# wp-cli sidecar with the same mounts the WP container has (volume + themes bind).
MSYS_NO_PATHCONV=1 docker run --rm --user 33:33 \
  --network container:wordpress_site2 \
  -v testwebsite_wordpress_site2_data:/var/www/html \
  -v "$(pwd)/themes:/var/www/html/wp-content/themes" \
  -v "$(pwd)/tools:/mnt/tools" \
  -e WORDPRESS_DB_HOST=db:3306 -e WORDPRESS_DB_USER=wordpress \
  -e WORDPRESS_DB_PASSWORD=wordpress_password -e WORDPRESS_DB_NAME=wordpress_site2 \
  wordpress:cli "$@"
