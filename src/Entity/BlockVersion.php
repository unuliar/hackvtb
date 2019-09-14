<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BlockVersionRepository")
 */
class BlockVersion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $parent_block;

    /**
     * @ORM\Column(type="integer")
     */
    private $version_block;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParentBlock(): ?int
    {
        return $this->parent_block;
    }

    public function setParentBlock(int $parent_block): self
    {
        $this->parent_block = $parent_block;

        return $this;
    }

    public function getVersionBlock(): ?int
    {
        return $this->version_block;
    }

    public function setVersionBlock(int $version_block): self
    {
        $this->version_block = $version_block;

        return $this;
    }
}
