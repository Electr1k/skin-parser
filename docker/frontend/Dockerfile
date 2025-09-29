FROM node:16-alpine

WORKDIR /app

COPY ../../frontend/package*.json ./
RUN npm install

COPY ../../frontend .
COPY ../../frontend/.env.example .env

RUN npm run build

