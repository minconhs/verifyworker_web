FROM ghcr.io/sudo-mincon/php-webman:8.2

# 设置工作目录
WORKDIR /app

# 复制项目到容器
COPY . /app

# 更改.env.example文件名
RUN mv .env.example .env

# 启动命令

CMD ["php", "bin/hyperf.php","start"]