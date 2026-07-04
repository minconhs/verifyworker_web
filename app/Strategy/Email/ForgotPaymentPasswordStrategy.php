<?php

declare(strict_types=1);

namespace App\Strategy\Email;

use App\Amqp\Producer\EmailProducer;
use App\Contract\EmailInterface;
use Hyperf\Amqp\Producer;
use Hyperf\Di\Annotation\Inject;

class ForgotPaymentPasswordStrategy implements EmailInterface
{

    #[Inject]
    protected Producer $producer;

    /**
     * @inheritDoc
     */
    public function send(string $email, array $data = []): bool
    {
        // 组装队列数据
        $queue_data = ['email' => $email, 'subject' => 'Reset Your Payment Password', 'template' => $this->template($data)];
        // 获取发送邮件生产者
        $sendEmailProducer = new EmailProducer(json_encode($queue_data));
        // 发送消息到队列
        return $this->producer->produce($sendEmailProducer);
    }

    public function template(array $data = []): string
    {
        return <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Reset Your Payment Password</title>
          <style>
            body {
              margin: 0;
              padding: 0;
              font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto,
              'Helvetica Neue', Arial, sans-serif;
              color: #333333;
              background-color: #ffffff;
            }
        
            a {
              color: #06B6D4;
              text-decoration: none;
            }
        
            a:hover {
              text-decoration: underline;
            }
        
            @media only screen and (max-width: 600px) {
              .wrapper {
                width: 100% !important;
                padding: 20px !important;
              }
            }
          </style>
        </head>
        <body style="margin:0; padding:0; background-color:#ffffff;">
        
        <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" border="0"
               style="background-color:#ffffff; width:100%; max-width:600px; margin:0 auto;">
          <tr>
            <td style="padding:30px 20px;">
        
              <!-- Header -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="border-bottom:1px solid #f0f0f0; margin-bottom:30px;">
                <tr>
                  <td style="padding-bottom:15px;">
                    <a href="https://www.verifyworker.com" target="_blank" style="font-size:20px; font-weight:bold; color:#333333; text-decoration:none;">
                      Verifyworker
                    </a>
                  </td>
                </tr>
              </table>
        
              <!-- Content -->
              <p style="font-size:15px; line-height:1.6; color:#555555; margin:0 0 15px 0;">
                Dear User,
              </p>
        
              <p style="font-size:15px; line-height:1.6; color:#555555; margin:0 0 20px 0;">
                We received a request to reset your Verifyworker payment password.
                Please use the verification code below to proceed:
              </p>
        
              <!-- Code Block -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:25px 0;">
                <tr>
                  <td>
                    <p style="font-size:13px; color:#777777; margin:0 0 8px 0;">Your verification code:</p>
                    <p style="font-size:24px; font-weight:bold; color:#333333; letter-spacing:6px; margin:0;">
                      {$data['code']}
                    </p>
                  </td>
                </tr>
              </table>
        
              <p style="font-size:14px; color:#777777; margin:0 0 20px 0;">
                This verification code will expire in <strong style="color:#333333;">5 minutes</strong>.
                If the code has expired, you can request a new one from our website.
              </p>
        
              <p style="font-size:14px; color:#777777; margin:0 0 10px 0;">
                For your security, please note:
              </p>
              <ul style="font-size:14px; color:#777777; margin:0 0 30px 0; padding-left:20px; line-height:2;">
                <li>Do not share this code with anyone.</li>
                <li>Verifyworker staff will never ask for this code.</li>
                <li>This code can only be used once.</li>
              </ul>
        
              <p style="font-size:14px; color:#777777; margin:0 0 30px 0;">
                If you did not request a payment password reset, please ignore this email.
                No further action is required. Your account remains secure.
              </p>
        
              <!-- Footer -->
              <div style="border-top:1px solid #f0f0f0; padding-top:20px;">
                <p style="font-size:12px; color:#999999; line-height:1.5; margin:0;">
                  &copy; 2026 Verifyworker<br>
                  <a href="https://www.verifyworker.com" style="color:#999999;">www.verifyworker.com</a>
                </p>
              </div>
        
            </td>
          </tr>
        </table>
        </body>
        </html>
        HTML;
    }
}