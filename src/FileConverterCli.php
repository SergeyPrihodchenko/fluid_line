<?php

namespace Fluid\Line;

class FileConverterCli extends FileConverter {

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