FROM node:alpine

WORKDIR /app

COPY ./../frontend/package.json .
RUN npm install

RUN mkdir node_modules/.cache && chmod -R 777 node_modules/.cache

COPY ../../frontend .

RUN npm run build

CMD ["npm", "run", "serve"]
