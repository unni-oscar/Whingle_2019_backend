FROM php:7.3-fpm
# Set working directories
# WORKDIR /var/www/app

# Install dependencies
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    build-essential \
    mysql-client \
    zip \    
    vim \
    unzip \
    git \
    curl
    #jpegoptim optipng pngquant gifsicle \
    
RUN apt-get update \
    && apt-get install -y nodejs \
    && apt-get install -y yarn

#Clear cache
RUN apt clean && rm -rf /var/lib/apt/lists/*

#Install extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring

#Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www/whingle

# Copy existing application directory permissions
COPY --chown=www:www . /var/www/whingle

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000