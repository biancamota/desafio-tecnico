FROM node:18 as develop-stage

WORKDIR /app

COPY package*.json ./

RUN yarn global add @quasar/cli

COPY . .

CMD ["quasar", "dev"]