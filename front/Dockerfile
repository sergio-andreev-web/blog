# Используем официальный Node.js образ
FROM node:14

# Устанавливаем рабочую директорию
WORKDIR /src

# Копируем package.json и package-lock.json
COPY package*.json ./

# Устанавливаем зависимости
RUN npm install

# Копируем исходный код
COPY . .

# Строим проект
RUN npm run build

# Открываем порт
EXPOSE 8080

# Команда по умолчанию
CMD ["npm", "run", "serve"]
