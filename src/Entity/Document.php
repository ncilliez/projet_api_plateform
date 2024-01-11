<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pathDocument = null;

    #[ORM\OneToMany(mappedBy: 'document', targetEntity: Profile::class)]
    private Collection $Profile;

    #[ORM\OneToMany(mappedBy: 'document', targetEntity: Article::class)]
    private Collection $article;

    public function __construct()
    {
        $this->Profile = new ArrayCollection();
        $this->article = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPathDocument(): ?string
    {
        return $this->pathDocument;
    }

    public function setPathDocument(?string $pathDocument): static
    {
        $this->pathDocument = $pathDocument;

        return $this;
    }

    /**
     * @return Collection<int, Profile>
     */
    public function getProfile(): Collection
    {
        return $this->Profile;
    }

    public function addProfile(Profile $profile): static
    {
        if (!$this->Profile->contains($profile)) {
            $this->Profile->add($profile);
            $profile->setDocument($this);
        }

        return $this;
    }

    public function removeProfile(Profile $profile): static
    {
        if ($this->Profile->removeElement($profile)) {
            // set the owning side to null (unless already changed)
            if ($profile->getDocument() === $this) {
                $profile->setDocument(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->article->contains($article)) {
            $this->article->add($article);
            $article->setDocument($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->article->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getDocument() === $this) {
                $article->setDocument(null);
            }
        }

        return $this;
    }
}
