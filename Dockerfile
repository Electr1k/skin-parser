FROM node:20.6.0-alpine
WORKDIR /app
COPY ./package*.json ./
RUN npm install
COPY . .
CMD ["node", "index.js"]
