FROM node:alpine

WORKDIR /app

COPY . .

RUN npm install
# RUN npm ci --only=production

EXPOSE 3000

CMD npm run dev