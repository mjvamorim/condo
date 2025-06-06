FROM php:7.4-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt update && apt upgrade -y
RUN apt-get install -y \
    sudo \
    build-essential \
    default-mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    zlib1g-dev libicu-dev g++



# # Clear cache
RUN apt clean && rm -rf /var/lib/apt/lists/*

# # Install extensions
# RUN docker-php-ext-install mbstring zip exif pcntl
RUN docker-php-ext-install  exif pcntl

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN docker-php-ext-configure gd
# --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

# Install xdebug
# ARG XDEBUG_VERSION="xdebug-2.9.0"
# RUN yes | pecl install ${XDEBUG_VERSION} \
#     && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
#     && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
#     && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini 
# RUN  docker-php-ext-enable ${XDEBUG_VERSION}



# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node
ENV NODE_VERSION=16.13.0
RUN apt install -y curl
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
ENV NVM_DIR=/root/.nvm
RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"
RUN node --version
RUN npm --version
RUN chmod go+rwx /root -R

# Install php-cs-fixer
RUN composer global require friendsofphp/php-cs-fixer
RUN export PATH="$PATH:/root/.composer/vendor/bin"

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
RUN echo "www:www" | chpasswd && adduser www sudo
RUN  npm install -g npm@9.1.1

# # Copy existing application directory permissions
COPY --chown=www:www . /var/www/html

# # Change current user to www
USER www


RUN php artisan route:clear
RUN php artisan config:clear
RUN php artisan cache:clear

RUN php artisan config:cache

# # Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
