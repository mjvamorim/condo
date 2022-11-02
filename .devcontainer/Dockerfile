FROM php:7.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt update && apt-get install -y \
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
    zlib1g-dev libicu-dev g++ \
    nodejs npm



# # Clear cache
RUN apt clean && rm -rf /var/lib/apt/lists/*

# # Install extensions
RUN docker-php-ext-install mbstring zip exif pcntl

RUN docker-php-ext-install pdo pdo_mysql 
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

# Install xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www 
RUN echo "www:www" | chpasswd && adduser www sudo

# # Copy existing application directory contents
COPY .. /var/www

# # Copy existing application directory permissions
COPY --chown=www:www .. /var/www

# # Change current user to www
USER www

# # Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]