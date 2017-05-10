FROM quay.io/continuouspipe/symfony-php7.1-nginx:latest
ARG GITHUB_TOKEN=
ARG SYMFONY_ENV=prod
ENV SYMFONY_ENV $SYMFONY_ENV

COPY . /app
RUN container build
