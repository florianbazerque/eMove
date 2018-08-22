<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $update_at;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alt;

    /**
     *
     * @Assert\File()
     * variable contenant le fichier
     */
    private $file;

    //Stocke le fichier temporaire
    private $tempFile;

    public function getId()
    {
        return $this->id;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeInterface $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        $this->update_at = new \DateTime();
        if($this->path != null){
            $this->tempFile = $this->getUploadDirPath().$this->path;
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */

    public function preUpload(){
        if($this->file == null){
            return;
        }else{
            $this->path = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload(){
        if($this->file === null) return;
        if($this->tempFile != null){
            $oldFile = $this->tempFile;
            unlink($oldFile);
        }
        $this->file->move($this->getUploadDirPath(), $this->path);
    }

    /**
     * @ORM\PreRemove()
     */
    public function  PreRemoveUpload(){
        $this->tempFile = $this->getAbsolutePath();
    }

    public function getAbsolutePath(){
        return __DIR__.$this->getUploadDirPath().$this->path;
    }

    public function getUploadDirPath(){
        return __DIR__.'/../../public/img/'.$this->getUploadDir();
    }

    public function getUploadDir(){
        return "vehicule/";
    }
}
