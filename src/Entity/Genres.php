<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GenresRepository")
 */
class Genres
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GenreList", mappedBy="ganre_id")
     */
    private $genreLists;

    public function __construct()
    {
        $this->genreLists = new ArrayCollection();
    }


    /**
     * @return Collection|GenreList[]
     */
    public function getGenreLists(): Collection
    {
        return $this->genreLists;
    }

    public function addGenreList(GenreList $genreList): self
    {
        if (!$this->genreLists->contains($genreList)) {
            $this->genreLists[] = $genreList;
            $genreList->setGanreId($this);
        }

        return $this;
    }

    public function removeGenreList(GenreList $genreList): self
    {
        if ($this->genreLists->contains($genreList)) {
            $this->genreLists->removeElement($genreList);
            // set the owning side to null (unless already changed)
            if ($genreList->getGanreId() === $this) {
                $genreList->setGanreId(null);
            }
        }

        return $this;
    }
}
