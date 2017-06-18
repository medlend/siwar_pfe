<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/11/16
 * Time: 15:51
 */

namespace Medical\MedecinBundle\EventsListener;

use Medical\HopitaleBundle\Entity\Hopitale;
use Medical\LaboratoireBundle\Entity\Laboratoire;
use Medical\MedecinBundle\Entity\Conseil;
use Medical\MedecinBundle\Entity\Medecin;
use Medical\MedecinBundle\Entity\Specialite;
use Medical\MedecinBundle\Services\FileUploader;
use Medical\PharmacieBundle\Entity\Pharmacie;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;



class DoctrineListener
{


    private $uploader;

    private $targetPath;

    private $ancienImgName;
    private $ancienImgName2;

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
        if (!$entity instanceof Medecin && !$entity instanceof Hopitale && !$entity instanceof Laboratoire && !$entity instanceof Pharmacie && !$entity instanceof Specialite && !$entity instanceof Conseil) {
            return;
        }

        $fileName = $entity->getImage();

        if(!$fileName) return;

        $this->ancienImgName=$this->targetPath.'/'.$fileName;
        //dump(file_exists($this->targetPath.'/'.$fileName));die;
        $entity->setImage(new File($this->ancienImgName));

        if (!$entity instanceof Medecin )
            return;

        $fileName2 = $entity->getImage2();
        if(!$fileName2) return;

        $this->ancienImgName2=$this->targetPath.'/'.$fileName2;
        //dump(file_exists($this->targetPath.'/'.$fileName));die;
        $entity->setImage2(new File($this->ancienImgName2));


    }


    private function uploadFile($entity)
    {
        // upload only works for Product entities
        if (!$entity instanceof Medecin && !$entity instanceof Hopitale && !$entity instanceof Laboratoire && !$entity instanceof Pharmacie && !$entity instanceof Specialite && !$entity instanceof Conseil ) {
            return;
        }

        $file = $entity->getImage();
        if (!$file instanceof UploadedFile)
            return;
        $fileName = $this->uploader->upload($file);
        $entity->setImage($fileName);


        if (!$entity instanceof Medecin )
            return;

        $file2 = $entity->getImage2();
        if (!$file2 instanceof UploadedFile)
            return;
        $fileName2 = $this->uploader->upload($file2);
        $entity->setImage2($fileName2);

    }



}