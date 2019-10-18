<?php

namespace App\Helpers;

use \Image;

class ImageThumbnail
{
    private $width;
    private $height;
    private $quality;
    private $path;
    private $path_storage;

    public function setWidth($value = '')
    {
        $this->width = $value;
        return $this;
    }

    public function setHeight($value = '')
    {
        $this->height = $value;
        return $this;
    }

    public function setQuality($value = '')
    {
        $this->quality = $value;
        return $this;
    }

    public function setPath($value = '')
    {
        $this->path         = $value;
        $this->path_storage = public_path("storage/" . $this->path);
        return $this;
    }

    private function pathInfo()
    {
        $DirName   = pathinfo($this->path, PATHINFO_DIRNAME);
        $file_name = pathinfo($this->path, PATHINFO_FILENAME);
        $ext       = pathinfo($this->path, PATHINFO_EXTENSION);

        return [
            'dir'  => $DirName,
            'name' => $file_name,
            'ext'  => $ext,
            'full' => $DirName . '/' . $file_name . '.' . $ext,
        ];
    }

    public function run()
    {
        $PathInfo  = $this->pathInfo();
        $ThumbName = $PathInfo['name'] . '_' . $this->width . $this->height . '.' . $PathInfo['ext'];

        /**
         * Check exists
         */

        $DIR = public_path("storage/" . $PathInfo['dir']);

        if (is_file($DIR . '/' . $ThumbName)) {
            return $PathInfo['dir'] . '/' . $ThumbName;
        }

        /**
         * Resize, Crop, Save, Return
         */

        list($CurrentWidth, $CurrentHeight) = getimagesize($this->path_storage);
        $Image                              = Image::make($this->path_storage);

        if ($CurrentWidth < $CurrentHeight) {
            $Image->resize($this->width, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } else {
            $Image->resize(null, $this->height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $ResizedInfo = $Image->getSize();

        $Image->crop(
            $this->width > $ResizedInfo->width ? $ResizedInfo->width : $this->width,
            $this->height > $ResizedInfo->height ? $ResizedInfo->height : $this->height,
            0,
            0
        );

        $Image->save(public_path('storage/' . $PathInfo['dir'] . '/' . $ThumbName), $this->quality);
        $Image->destroy();
        return $PathInfo['dir'] . '/' . $ThumbName;
    }

    public function deleteThumbnails()
    {
        $PathInfo = $this->pathInfo();
        foreach (glob(public_path('storage/' . $PathInfo['dir'] . '/' . $PathInfo['name'] . '_*')) as $file) {
            @unlink($file);
        }
    }
}
