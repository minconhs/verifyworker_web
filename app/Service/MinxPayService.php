<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\Di\Annotation\Inject;

class MinxPayService
{
    #[Inject]
    protected SystemSettingService $systemSettingService;

    /**
     * 创建MixPay支付订单
     * @param string $amount 金额
     * @param string $order_id 订单ID
     * @return ResultService
     */
    public function create(string $amount, string $order_id): ResultService
    {
        // 获取系统站点URL
        $site_url = $this->systemSettingService->getSettingByKey('site_url');
        // 获取MinxPay 密钥
        $other_minx_pay_key = $this->systemSettingService->getSettingByKey('other_minx_pay_key');

        try {
            $client = new Client([
                'timeout' => 10,
                'connect_timeout' => 5,
            ]);

            $response = $client->post('https://api.mixpay.me/v1/one_time_payment', [
                'form_params' => [
                    'payeeId' => $other_minx_pay_key,
                    'settlementAssetId' => 'b91e18ff-a9ae-3dc7-8679-e935d9a4b34b',
                    'quoteAssetId' => 'usd',
                    'quoteAmount' => $amount,
                    'isTemp' => '1',
                    'orderId' => $order_id,
                    'remark' => 'Deposits Order ' . $order_id,
                    'returnTo' => $site_url . '/wallet/deposits',
                    'failedReturnTo' => $site_url . '/wallet/deposits',
                    'callbackUrl' => $site_url . '/callback/recharge/minx',
                    'expiredTimestamp' => time() + 12 * 60 * 60,
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                return ResultService::failure('Failed to create recharge order.');
            }

            $data = json_decode($response->getBody()->getContents(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return ResultService::failure('Invalid recharge response.');
            }

            if (!isset($data['success']) || $data['success'] !== true) {
                return ResultService::failure($data['message'] ?? 'Recharge request was not successful.');
            }

            if (empty($data['data']['code'])) {
                return ResultService::failure('Recharge payment code is missing.');
            }

            $pay_code = $data['data']['code'];

            $pay_link = "https://mixpay.me/code/{$pay_code}";

            return ResultService::success("Recharge request successful.", ['code' => $pay_code, 'link' => $pay_link]);

        } catch (GuzzleException $e) {
            return ResultService::failure('Recharge request failed: ' . $e->getMessage());
        }
    }

    /**
     * 查询MixPay支付订单状态
     * @param string $traceId 跟踪ID
     * @return ResultService
     */
    public function query(string $traceId): ResultService
    {
        try {
            $client = new Client([
                'timeout' => 10,
                'connect_timeout' => 5,
            ]);

            $response = $client->get('https://api.mixpay.me/v1/payments_result', [
                'query' => [
                    'traceId' => $traceId,
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                return ResultService::failure('Failed to query payment status.');
            }

            $data = json_decode($response->getBody()->getContents(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return ResultService::failure('Invalid payment status response.');
            }

            if (!isset($data['success']) || $data['success'] !== true) {
                return ResultService::failure($data['message'] ?? 'Payment status query was not successful.');
            }

            if (!isset($data['data']) || !is_array($data['data'])) {
                return ResultService::failure('Payment status data is missing.');
            }

            return ResultService::success("Payment status query successful.", $data['data']);

        } catch (GuzzleException $e) {
            return ResultService::failure('Payment status query failed: ' . $e->getMessage());
        }
    }
}