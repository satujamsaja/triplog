<?php


namespace TriplogBundle\Doctrine;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use TriplogBundle\Entity\TripCategory;
use TriplogBundle\Entity\User;
use TriplogBundle\Service\FileUploader;

class FileUploadListener
{
    private $fileUploader;

    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function uploadFile($entity)
    {
        if (!$entity instanceof User || !$entity instanceof TripCategory) {
            return;
        }

        if($entity instanceof User) {
            $file = $entity->getProfilePicture();

            if (!empty($file)) {
                $fileName = $this->fileUploader->upload($file);
                $entity->setProfilePicture($fileName);
            }
        }

        if($entity instanceof TripCategory) {
            $file = $entity->getTripCatImage();
            dump($file);

            if (!empty($file)) {
                $fileName = $this->fileUploader->upload($file);
                $entity->setTripCatImage($fileName);
            }
        }

    }
}