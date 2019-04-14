<?php


namespace App\Model;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\Book;

class BookModel
{

    private $id;

    /**
     * @Assert\NotBlank
     *  min = 1,
     *  max = 100,
     *  minMessage = "Название должно содержать не менее {{limit}} символов",
     *  maxMessage = "Название не может быть длиннее {{limit}} символов"
     */
    private $title;

    /**
     * @Assert\NotBlank
     *  min = 5,
     *  max = 100,
     *  minMessage = "Описание должно содержать не менее {{limit}} символов",
     *  maxMessage = "Описание не может быть длиннее {{limit}} символов"
     */
    private $description;

    /**
     * @Assert\Type(
     *     type="integer",
     *     message="Значение {{value}} не является допустимым {{ type }}."
     * )
     */
    public $number_pages;

    /**
     * @Assert\NotBlank
     *   type="integer",
     *   message="The value {{ value }} is not a valid {{ type }}."
     */
    private $cover;

    /**
     * @Assert\NotBlank
     */
    private $writer;

    /**
     * @Assert\NotBlank
     */
    private $genreLists;
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
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getNumberPages()
    {
        return $this->number_pages;
    }

    /**
     * @param mixed $number_pages
     */
    public function setNumberPages($number_pages): void
    {
        $this->number_pages = $number_pages;
    }

    /**
     * @return mixed
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param mixed $cover
     */
    public function setCover($cover): void
    {
        $this->cover = $cover;
    }

    /**
     * @return mixed
     */
    public function getWriter()
    {
        return $this->writer;
    }

    /**
     * @param mixed $writer
     */
    public function setWriter($writer): void
    {
        $this->writer = $writer;
    }

    /**
     * @return mixed
     */
    public function getGenreLists()
    {
        return $this->genreLists;
    }

    /**
     * @param mixed $genreLists
     */
    public function setGenreLists($genreLists): void
    {
        $this->genreLists = $genreLists;
    }
}