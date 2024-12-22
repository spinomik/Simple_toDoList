FROM php:8.2-fpm

# Install PHP extensions and dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libonig-dev \
    zip \
    unzip \
    git \
    libmariadb-dev-compat \
    cron \
    supervisor \
    && docker-php-ext-install pdo_mysql intl mbstring

    RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm@latest

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy the cron tasks, supervisor configuration, entrypoint
COPY ./docker/cron_tasks /etc/cron.d/cron_tasks
COPY ./docker/supervisord.conf /etc/supervisord.conf
COPY ./docker/entrypoint.sh /usr/local/bin/entrypoint.sh

# Set the correct permissions
RUN chmod +x /usr/local/bin/entrypoint.sh
RUN chmod 0644 /etc/cron.d/cron_tasks /etc/supervisord.conf

# Set up cron jobs
RUN crontab /etc/cron.d/cron_tasks

# Copy composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html

CMD ["supervisord", "-c", "/etc/supervisord.conf"]