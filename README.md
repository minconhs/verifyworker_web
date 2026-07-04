### 验证工人后台管理系统

#### 环境
```text
PHP >= 8.2
Mysql >= 8.0.45
Redis >= 7.0
Rabbitmq >= 3.0
```

#### 安装依赖
```bash
composer install
```
#### 配置
```text
复制 .env.example 为 .env 并修改配置
```

#### 启动

```bash
php bin/hyperf.php start
```

### Docker

#### 编译
```bash
docker build --platform linux/amd64 -t ghcr.io/minconhs/verifyworker_web:tag .
```
#### 推送
```bash
docker push ghcr.io/minconhs/verifyworker_web:tag
```
#### 启动
```bash
docker run -d --name script_api -p 9601:9601 ghcr.io/minconhs/verifyworker_web:tag
```