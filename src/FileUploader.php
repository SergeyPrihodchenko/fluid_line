<?php

namespace Fluid\Line;

class FileUploader {

    private const UPLOAD_DIR = __DIR__. '/..//';

    public function __construct(
        private $file
    )
    {
        $this->file = $file;
    }

    public function upload()
    {
        $uploadFile = self::UPLOAD_DIR . basename($this->file['name']);

        if (move_uploaded_file($this->file['tmp_name'], $uploadFile)) {

            return  basename($this->file['name']);

        } else {

            echo "Ошибка при загрузке файла.";

        }
    }
}