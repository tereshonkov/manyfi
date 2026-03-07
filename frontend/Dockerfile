FROM node:20-alpine

WORKDIR /src

COPY package*.json ./

RUN npm install

COPY . .

RUN npm run build

ENV HOST=0.0.0.0
ENV PORT=3000

ENV NUXT_PUBLIC_API_BASE=http://localhost:8000/api

EXPOSE 3000

CMD ["node", ".output/server/index.mjs"]