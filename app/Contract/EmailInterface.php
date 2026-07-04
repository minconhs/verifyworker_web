<?php

namespace App\Contract;

interface EmailInterface
{
    /**
     * 发送邮件
     * @param string $email 邮箱地址
     * @param array $data 模板数据
     * @return bool
     */
    public function send(string $email, array $data = []): bool;


    /**
     * 获取邮件模板
     * @param array $data 模板数据
     * @return string
     */
    public function template(array $data = []) : string;
}