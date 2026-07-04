<?php

namespace App\Service;


use Hyperf\Di\Annotation\Inject;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class EmailService
{
    protected Address $from;

    protected Mailer $mailer;

    #[Inject]
    protected SystemSettingService $systemSettingService;

    /**
     * 发送HTML邮件
     * @param string $to 收件人邮箱
     * @param string $subject 邮件标题
     * @param string $htmlContent HTML内容
     * @return void
     * @throws TransportExceptionInterface
     */
    public function send(string $to, string $subject, string $htmlContent) : void
    {
        // 获取系统设置中的邮件是否开启
        $mail_enabled = $this->systemSettingService->getSettingByKey('mail_enabled');
        if (!$mail_enabled) {
            return;
        }
        // 获取邮件发送名称
        $mail_from_name = $this->systemSettingService->getSettingByKey('mail_from_name');
        // 获取邮箱服务器
        $mail_smtp = $this->systemSettingService->getSettingByKey('mail_smtp');
        // 获取邮箱账号
        $mail_address = $this->systemSettingService->getSettingByKey('mail_address');
        // 获取邮箱密码
        $mail_password = $this->systemSettingService->getSettingByKey('mail_password');
        // 获取发送地址
        $this->from = new Address($mail_address, $mail_from_name);
        // 获取发送地址
        $transport = Transport::fromDsn("smtp://{$mail_address}:{$mail_password}@{$mail_smtp}");
        // 获取客户端
        $this->mailer = new Mailer($transport);
        $email = new Email();
        $email->from($this->from);
        $email->to(new Address($to, $to));
        $email->subject($subject);
        $email->html($htmlContent);
        $this->mailer->send($email);
    }
}