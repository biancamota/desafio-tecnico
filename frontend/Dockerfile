FROM node:18-alpine as develop-stage

WORKDIR /app

COPY package*.json ./

RUN yarn global add @quasar/cli

COPY . .

CMD ["sh", "-c", "yarn install && quasar dev"]