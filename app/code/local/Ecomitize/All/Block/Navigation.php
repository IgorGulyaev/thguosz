<?php

class Ecomitize_All_Block_Navigation extends Mage_Catalog_Block_Navigation
{
    public function cropImage( $location , $image, $heigth, $width = false, $enable = true )
    {

        if(!$width){
            $width = $heigth;
        }
        $arrayLocation = explode('/', $location);
        $baseDir = Mage::getBaseDir($arrayLocation['0']);
        $unshifted = $arrayLocation['0'];

        array_shift($arrayLocation);
        $implodedArrayLocation = implode('/',$arrayLocation);
        $baseDir = $baseDir.DS.implode('/',$arrayLocation);

        if($enable){
            $imageToResize = $baseDir.$image;
            $imageResized = $baseDir.$heigth.'x'.$width.$image;

            if (!file_exists($imageResized) && file_exists($imageToResize)){
                $imageObj = new Varien_Image($imageToResize);
                $originalWidth = $imageObj->getOriginalWidth();
                $originalHeigth = $imageObj->getOriginalHeight();

                if($originalWidth<=$width){
                    $widthToCrop = 0;
                }else{
                    $widthToCrop = ($originalWidth-$width)/2;
                }

                if($originalHeigth<=$heigth){
                    $heigthToCrop = 0;
                }else{
                    $heigthToCrop = ($originalHeigth-$heigth)/2;
                }

                $imageObj->constrainOnly(TRUE);
                $imageObj->keepAspectRatio(TRUE);
                $imageObj->keepFrame(FALSE);

                $imageObj->crop($heigthToCrop, $widthToCrop, $widthToCrop, $heigthToCrop);

                $imageObj->save($imageResized);

            }

            return $this->getUrl($unshifted.DS.$implodedArrayLocation).$heigth.'x'.$width.$image;
        }else{
            return $this->getUrl($unshifted.DS.$implodedArrayLocation).$image;
        }

    }
}