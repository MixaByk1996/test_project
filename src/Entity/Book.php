<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="blob")
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $year_public;


    /**
     * @ORM\ManyToMany(targetEntity="Author")
     * @ORM\JoinTable(name="author_books",
     *     joinColumns={@ORM\JoinColumn (name="book_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn (name="author_id", referencedColumnName="id")} )
     */
    protected \Doctrine\Common\Collections\Collection $authorBooks;


    /**
     * @return mixed
     */
    public function getAuthorBooks()
    {
        return $this->authorBooks;
    }

    public function getAuthorsList(){
        $str = '';

        foreach ($this->authorBooks as $authorBook){
            $str .= $authorBook->getName() . ';';
        }

        return $str;
    }
    /**
     * @param $authorBooks
     */
    public function setAuthorBooks($authorBooks): void
    {
        $this->authorBooks = $authorBooks;
    }
    public function addBook(Book $book): self
    {
        if (!$this->authorBooks->contains($book)) {
            $this->authorBooks->add($book) ;
        }
        $this->authorBooks[] = $book;
        return $this;
    }
    public function removeBook(Book $book): self
    {
        $this->authorBooks->removeElement($book);
        return $this;
    }


//    public function getAuthors(): Collection
//    {
//        return $this->authors;
//    }
//
//    public function addAuthor(Author $author): self
//    {
//        if (!$this->authors->contains($author)) {
//            $this->authors->add($author) ;
//        }
//        return $this;
//    }
//    public function removeAuthor(Author $author): self
//    {
//        $this->authors->removeElement($author);
//        return $this;
//    }
//    /**
//     * @param ArrayCollection $authors
//     */
//    public function setAuthors(ArrayCollection $authors): void
//    {
//        $this->authors = $authors;
//    }
//
//    public function __construct()
//    {
//        $this->authors = new ArrayCollection();
//    }
//
//    /**
//     * @return Collection|Author[]
//     */
//

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        $imageBase64 = '';
        if (null === $this->image) {
            return null;
        }
            $data = stream_get_contents($this->image);
            fclose($this->image);
        return base64_encode($data);

    }

    public function setImage($image): self
    {
        $this->image = $image;


        return $this;
    }

    public function getYearPublic(): ?int
    {
        return $this->year_public;
    }

    public function setYearPublic(int $year_public): self
    {
        $this->year_public = $year_public;

        return $this;
    }

}
