<?php

namespace App\Factory;

use App\Contract\EmailInterface;
use App\Strategy\Email\EmailChangeStrategy;
use App\Strategy\Email\ForgotPasswordStrategy;
use App\Strategy\Email\ForgotPaymentPasswordStrategy;
use App\Strategy\Email\RegisterStrategy;

class EmailFactory
{
    /**
     * 创建发送邮件的实例
     * @param string $type 邮件发送类型
     * @return EmailInterface
     */
    public static function create(string $type): EmailInterface
    {
        return match ($type) {
            // 注册验证邮件
            'register' => new RegisterStrategy(),
            // 忘记密码邮件
            'forgot_password' => new ForgotPasswordStrategy(),
            // 重置支付密码邮件
            'forgot_payment_password' => new ForgotPaymentPasswordStrategy(),
            // 更改邮箱地址验证邮件
            'email_change' => new EmailChangeStrategy(),
        };
    }
}