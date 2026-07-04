#!/bin/bash

# 数据库配置
DB_HOST="127.0.0.1"
DB_PORT="3306"
DB_USER="root"
DB_PASS="root"
DB_NAME="verifyworker"

# 获取所有表
tables=$(mysql -h${DB_HOST} -P${DB_PORT} -u${DB_USER} -p${DB_PASS} -D${DB_NAME} -N -e "SHOW TABLES;")

# 循环生成 service
for table in $tables
do
    # 转驼峰
    model=$(echo "$table" | perl -pe 's/(^|_)([a-z])/\U$2/g')

    echo "正在生成 AdminService: ${model}Service"

    cat > app/Service/${model}Service.php <<EOF
<?php

declare(strict_types=1);

namespace App\\Service;

use App\\Model\\${model};

class ${model}Service extends AbstractService
{
    public function __construct()
    {
        \$this->model = new ${model}();
    }
}
EOF

done

echo "全部生成完成"