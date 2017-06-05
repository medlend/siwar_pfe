<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/11/16
 * Time: 15:51
 */

namespace Medical\MedecinBundle\EventsListener;

use Medical\HopitaleBundle\Entity\Hopitale;
use Medical\MedecinBundle\Entity\Medecin;
use Medical\MedecinBundle\Services\FileUploader;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;



class DoctrineListener
{


    private $uploader;

    private $targetPath;

    private $ancienImgName;

    public function __construct(FileUploader $uploader,$targetPath)
    {
        $this->uploader = $uploader;
        $this->targetPath=$targetPath;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
       // dump($entity);die;
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {

        $entity = $args->getEntity();
        $this->uploadFile($entity);
       if( file_exists($this->ancienImgName))
           unlink($this->ancienImgName);

    }



    public function postLoad(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();
//dump($entity);
        if (!$entity instanceof Medecin && !$entity instanceof Hopitale ) {
            return;
        }

        $fileName = $entity->getImage();

        if(!$fileName) return;

        $this->ancienImgName=$this->targetPath.'/'.$fileName;
        //dump(file_exists($this->targetPath.'/'.$fileName));die;
        $entity->setImage(new File($this->ancienImgName));

    }


    private function uploadFile($entity)
    {
        // upload only works for Product entities
        if (!$entity instanceof Medecin && !$entity instanceof Hopitale) {
            return;
        }

        $file = $entity->getImage();

        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file);

        $entity->setImage($fileName);

    }



}