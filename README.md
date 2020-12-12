#Run local environment

###1. `docker-compose up -d` - build few containers (also we can use `docker-comopose build --no-cache` and then `docker-compose up -d`)
###2. run `docker-compose exec php-fpm bash` - get into php-fpm container
###3. run `composer install`

#Frontend
###1. `npm run dev` - compile assets once 
###2. `npm run watch` - recompile assets automatically when files change
###3. `npm run build` - create a production build