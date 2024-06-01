<?php

namespace Fluid\Line;

class FileConverter {

    public const ENCODINGS = ['ASCII', 'Windows-1251', 'KOI8-R', 'ISO-8859-5', 'ISO-8859-7', 'ISO-8859-6', 'EUC-JP', 'Shift_JIS', 'GB2312', 'Big5'];

    protected const utf8 = 'UTF-8';

    public function __construct(
        protected string $filePath
    )
    {
        $this->filePath = __DIR__ . "/../$filePath";
    }

    protected function fromEncodings(string $typeEncoding): bool 
    {
        $result = array_search($typeEncoding, FileConverter::ENCODINGS);

        if($result === false) {
            return false;
        }

        return true;
    }

    protected function checkEncoding(string $data): string
    {
        $typeEncoding = mb_detect_encoding($data, FileConverter::ENCODINGS, true);

        return $typeEncoding;
    }

    public function converter(): string | bool
    {
        
        if(!file_exists($this->filePath)) {

            return false;
        }

        $data = file_get_contents($this->filePath);

        $typeFile = $this->checkEncoding($data);

        if(!$this->fromEncodings($typeFile)) {

            return false;

        }

        if($typeFile != FileConverter::utf8) {

            $encodinfData = mb_convert_encoding($data, FileConverter::utf8, $typeFile);

            file_put_contents('UTF-8_'.basename($this->filePath), $encodinfData);

            return 'UTF-8_'.basename($this->filePath);

        } else {

            return basename($this->filePath);
        }
    }
}