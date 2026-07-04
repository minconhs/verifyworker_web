<?php

declare(strict_types=1);

namespace App\Service;

use Hyperf\Contract\SessionInterface;
use Hyperf\Di\Annotation\Inject;

class FlashService
{
    #[Inject]
    protected SessionInterface $session;

    /**
     * 获取闪存数据，并在获取后立即删除
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $flashKey = "_flash_{$key}";

        if ($this->session->has($flashKey)) {
            $value = $this->session->get($flashKey);
            $this->session->forget($flashKey);
            return $value;
        }

        return $default;
    }


    /**
     * 设置闪存数据, 并在获取后立即删除
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $this->session->set("_flash_{$key}", $value);
    }


    /**
     * 设置闪存旧数据
     * @param array $data
     * @return void
     */
    public function old(array $data): void
    {
        $flash_data = array_filter($data, fn ($value) => $value !== '' && $value !== null);
        $this->set("old", $flash_data);
    }
}