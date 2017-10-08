FROM php:7.0-fpm

MAINTAINER doberbeatz

RUN mkdir /project
WORKDIR /project

RUN docker-php-ext-install pdo pdo_mysql

ADD . /project

EXPOSE 9000