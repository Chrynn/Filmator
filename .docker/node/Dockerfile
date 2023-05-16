FROM node:16.9.1-alpine3.14

USER root

# Setup user docker
RUN adduser -S docker

WORKDIR /srv/

RUN rm -rf /srv/node_modules
RUN mkdir /srv/node_modules
RUN chown -R docker /srv/node_modules
RUN chown docker /srv/package.json

USER docker
