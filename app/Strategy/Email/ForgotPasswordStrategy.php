<?php

declare(strict_types=1);

namespace App\Strategy\Email;

use App\Amqp\Producer\EmailProducer;
use App\Contract\EmailInterface;
use Hyperf\Amqp\Producer;
use Hyperf\Di\Annotation\Inject;

class ForgotPasswordStrategy implements EmailInterface
{
    #[Inject]
    protected Producer $producer;

    /**
     * @inheritDoc
     */
    public function send(string $email, array $data = []): bool
    {
        // 组装队列数据
        $queue_data = ['email' => $email, 'subject' => 'Reset Your Password', 'template' => $this->template($data)];
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
          <title>Reset Your Password</title>
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
                We received a request to reset your Verifyworker account password. Click the button below to proceed:
              </p>
        
              <!-- Button -->
              <p style="margin:25px 0;">
                <a href="{$data['link']}" target="_blank" style="display:inline-block; padding:12px 24px; font-size:15px; color:#ffffff; background-color:#06B6D4; border-radius:4px; text-decoration:none;">
                  Reset Password
                </a>
              </p>
        
              <p style="font-size:14px; color:#777777; margin:0 0 20px 0;">
                This reset link will expire in 5 minutes.
                If the link has expired, you can request a new password reset email from our website.
              </p>
        
              <!-- Copy Link -->
              <p style="font-size:14px; color:#777777; margin:0 0 10px 0;">
                If the button above does not work, copy and paste the link below into your browser:
              </p>
              <p style="font-size:13px; margin:0 0 30px 0; padding:12px 15px; background-color:#f7f7f7; border-radius:4px; word-break:break-all;">
                <a href="{$data['link']}" target="_blank" style="color:#06B6D4;">
                  {$data['link']}
                </a>
              </p>
        
              <p style="font-size:14px; color:#777777; margin:0 0 30px 0;">
                If you did not request a password reset, please ignore this email.
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