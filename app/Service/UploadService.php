<?php

namespace App\Service;

use Hyperf\HttpMessage\Upload\UploadedFile;

class UploadService
{
    /**
     * 上传图片
     * @param UploadedFile $file
     * @return ResultService
     */
    public function upload_image(UploadedFile $file): ResultService
    {
        echo "上传文件: " . $file->getFilename() . "\n";

        // 检查文件大小
        $max_size = 5 * 1024 * 1024; // 5MB
        if ($file->getSize() > $max_size) {
            return ResultService::failure('文件大小超过限制');
        }
        // 验证文件类型
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        // 获取文件扩展名
        $extension = $file->getExtension();
        // 检查扩展名是否在允许的列表中
        if (!in_array(strtolower($extension), $allowed_extensions)) {
            return ResultService::failure('不允许的文件类型');
        }
        // 验证MIME类型
        $allowed_mime_types = ['image/jpeg', 'image/png', 'image/gif'];
        $mime_type = $file->getMimeType();
        if (!in_array($mime_type, $allowed_mime_types)) {
            return ResultService::failure('不允许的文件类型');
        }
        // 生成唯一文件名
        $filename = uniqid() . '.' . $extension;
        // 定义上传目录
        $directory = 'public/uploads/images/' . date('Y/m/d');
        // 创建上传目录
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        // 保存文件到指定路径
        $file_path = $directory . '/' . $filename;

        $file->moveTo($file_path);

        // 返回文件访问路径
        $file_url = str_replace('public', '', $file_path);
        return ResultService::success("上传成功", ['url' => $file_url]);
    }
}