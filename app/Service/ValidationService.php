<?php

namespace App\Service;

use Hyperf\Contract\ValidatorInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\ValidationException;
use function Hyperf\Support\make;

class ValidationService
{
    #[Inject]
    protected ValidatorFactoryInterface $validationFactory;

    /**
     * 验证数据
     * @param array $data 待验证的数据
     * @param string $validationRule 验证规则对象，必须实现 ValidationRuleInterface 接口
     * @return ValidatorInterface
     */
    public function validate(array $data, string $validationRule): ValidatorInterface
    {
        try {
            $validationRule = make($validationRule);
            // 返回结果
            return $this->validationFactory->make($data, $validationRule->rules(), $validationRule->messages());
        } catch (ValidationException $e) {

        }
    }
}