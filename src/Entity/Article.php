<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $CreationDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ImgSrcs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Slug;

    /**
     * @ORM\Column(type="text")
     */
    private $Preview;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Header;

    /**
     * @ORM\Column(type="text")
     */
    private $Content;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $CommentsNum;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ReadTime;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $Hardness;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $Author;

    public function getId()
    {
        return $this->id;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->CreationDate;
    }

    public function setCreationDate(\DateTimeInterface $CreationDate): self
    {
        $this->CreationDate = $CreationDate;

        return $this;
    }

    public function getImgSrcs(): ?string
    {
        return $this->ImgSrcs;
    }

    public function setImgSrcs (string $ImgSrcs): self
    {
        $this->ImgSrcs = $ImgSrcs;

        return $this;
    }

    public function getHeader(): ?string
    {
        return $this->Header;
    }

    public function setHeader(string $Header): self
    {
        $this->Header = $Header;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(string $Content): self
    {
        $this->Content = $Content;

        return $this;
    }

    public function getCommentsNum(): ?int
    {
        return $this->CommentsNum;
    }

    public function setCommentsNum(?int $CommentsNum): self
    {
        $this->CommentsNum = $CommentsNum;

        return $this;
    }

    public function getReadTime(): ?int
    {
        return $this->ReadTime;
    }

    public function setReadTime(?int $ReadTime): self
    {
        $this->ReadTime = $ReadTime;

        return $this;
    }

    public function getHardness(): ?float
    {
        return $this->Hardness;
    }

    public function setHardness(?float $Hardness): self
    {
        $this->Hardness = $Hardness;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->Author;
    }

    public function setAuthor(?string $Author): self
    {
        $this->Author = $Author;

        return $this;
    }

    /**
     * Get the value of Preview
     */ 
    public function getPreview()
    {
        return $this->Preview;
    }

    /**
     * Set the value of Preview
     *
     * @return  self
     */ 
    public function setPreview($Preview)
    {
        $this->Preview = $Preview;

        return $this;
    }

    /**
     * Get the value of Slug
     */ 
    public function getSlug()
    {
        return $this->Slug;
    }

    /**
     * Set the value of Slug
     *
     * @return  self
     */ 
    public function setSlug($Slug)
    {
        $this->Slug = $Slug;

        return $this;
    }
}
