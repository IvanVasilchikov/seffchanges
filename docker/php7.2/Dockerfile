FROM php:7.2-fpm-stretch
WORKDIR /var/www
RUN apt-get update && apt-get install -y \
    wget \
    git \
    unzip \
    nano \
    mailutils \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    cron \
    xvfb libfontconfig wkhtmltopdf \
    xfonts-75dpi \
    && wget https://downloads.wkhtmltopdf.org/0.12/0.12.5/wkhtmltox_0.12.5-1.stretch_amd64.deb \
    && dpkg -i wkhtmltox_0.12.5-1.stretch_amd64.deb \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo pdo_mysql zip \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && rm -r /var/lib/apt/lists/* \
    && chfn -f "Info" root \
    && chfn -f "Info" www-data \
    && crontab /etc/crontab
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN touch /etc/crontab-docker
RUN chmod 0644 /etc/crontab-docker
RUN echo 'SHELL=/bin/sh\nPATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin\n* * * * * php /var/www/htdocs/cron/sheduler.php'  >  /etc/crontab-docker
RUN crontab /etc/crontab-docker
COPY ./entrypoint.sh /
COPY ./morpher_install.sh /
RUN chmod +x /entrypoint.sh
RUN chmod +x /morpher_install.sh
RUN /morpher_install.sh
ENTRYPOINT /entrypoint.sh
