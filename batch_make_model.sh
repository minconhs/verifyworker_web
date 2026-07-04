#!/bin/bash

# 数据库配置
DB_HOST="127.0.0.1"
DB_PORT="3306"
DB_USER="root"
DB_PASS="root"
DB_NAME="verifyworker"

# 获取所有表
tables=$(mysql -h${DB_HOST} -P${DB_PORT} -u${DB_USER} -p${DB_PASS} -D${DB_NAME} -N -e "SHOW TABLES;")

# 循环生成 model
for table in $tables
do
    echo "正在生成 Model: $table"

    php bin/hyperf.php gen:model $table
done

echo "全部生成完成"