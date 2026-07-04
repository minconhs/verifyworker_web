<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Exception\BusinessException;
use App\Model\MemberCheckinStat;
use App\Model\MemberOauth;
use App\Model\MemberProfile;
use App\Model\MemberSecret;
use App\Model\MemberSetting;
use App\Model\WalletCommission;
use App\Model\WalletRecharge;
use App\Model\WalletTask;
use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

#[Consumer(exchange: 'member_signup_init', routingKey: 'member_signup_init', queue: 'member_signup_init_queue', name: "MemberSignupInitConsumer", nums: 1)]
class MemberSignupInitConsumer extends ConsumerMessage
{
    #[Inject]
    protected LoggerInterface $logger;

    public function consumeMessage($data, AMQPMessage $message): Result
    {
        // 解析数据
        $data = json_decode($data, true);
        // 获取会员ID
        $member_id = $data['member_id'];
        Db::beginTransaction();
        try {
            // 创建Oauth
            $memberOauth = new MemberOauth();
            $memberOauth->member_id = $member_id;
            if (!$memberOauth->save()) {
                throw new BusinessException('Failed to create member oauth record for member_id: ' . $member_id);
            }

            // 创建会员资料
            $memberProfile = new MemberProfile();
            $memberProfile->member_id = $member_id;
            if (!$memberProfile->save()) {
                throw new BusinessException('Failed to create member profile record for member_id: ' . $member_id);
            }

            // 创建会员密钥
            $memberSecret = new MemberSecret();
            $memberSecret->member_id = $member_id;
            $memberSecret->code = "sk_".bin2hex(random_bytes(24));
            if (!$memberSecret->save()) {
                throw new BusinessException('Failed to create member secret record for member_id: ' . $member_id);
            }

            // 创建会员设置
            $memberSetting = new MemberSetting();
            $memberSetting->member_id = $member_id;
            $memberSetting->channel_email = 1;
            $memberSetting->notice_security = 1;
            $memberSetting->notice_product = 1;
            $memberSetting->notice_policy = 1;
            $memberSetting->notice_event = 1;
            if (!$memberSetting->save()) {
                throw new BusinessException('Failed to create member setting record for member_id: ' . $member_id);
            }
            // 创建会员签到统计
            $memberCheckinStats = new MemberCheckinStat();
            $memberCheckinStats->member_id = $member_id;
            if (!$memberCheckinStats->save()) {
                throw new BusinessException('Failed to create member checkin stats record for member_id: ' . $member_id);
            }

            // 创建会员充值钱包
            $walletRecharge = new WalletRecharge();
            $walletRecharge->member_id = $member_id;
            if (!$walletRecharge->save()) {
                throw new BusinessException('Failed to create member recharge wallet record for member_id: ' . $member_id);
            }

            // 创建会员任务钱包
            $walletTask = new WalletTask();
            $walletTask->member_id = $member_id;
            if (!$walletTask->save()) {
                throw new BusinessException('Failed to create member task wallet record for member_id: ' . $member_id);
            }

            // 创建会员佣金钱包
            $walletCommission = new WalletCommission();
            $walletCommission->member_id = $member_id;
            if (!$walletCommission->save()) {
                throw new BusinessException('Failed to create member commission wallet record for member_id: ' . $member_id);
            }
            // 提交事物
            Db::commit();

            return Result::ACK;
        } catch (\Throwable $e) {
            Db::rollBack();
            $this->logger->error("会员注册初始化队列异常", ['message' => $e->getMessage(), 'data' => $data]);
            return Result::ACK;
        }
    }
}
