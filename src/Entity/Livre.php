<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use App\Repository\LivreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('titre', message: "Ce titre existe déjà.")]
#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    #[Assert\NotBlank (message:"Le titre doit être rempli")]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le titre dépasse la limite autorisée',
    )]
    #[Assert\Regex(
        pattern: '/^[0-9a-zA-Z-_ áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]+$/i',
        match: true,
        message: 'Le titre peut comporter seulement des chiffres, des lettres, espace et tiret  ',
    )]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $titre = null;



    #[Assert\Regex(
        pattern: '/^[0-9a-zA-Z-_ áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]+$/i',
        match: true,
        message: 'Le genre peut comporter seulement des chiffres, des lettres, des espace et tiret  ',
    )]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le genre dépasse la limite autorisée',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $genre = null;



    #[Assert\Regex(
        pattern: '/^[0-9a-zA-Z-_ áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]+$/i',
        match: true,
        message: "Le nom de l'auteur peut comporter seulement des chiffres, des lettres, des espace et tirets ",
    )]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le nom de l'auteur dépasse la limite autorisée",
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $auteur = null;




    #[Assert\Regex(
        pattern: '/[0-5]/',
        match: true,
        message: 'La note doit être compris entre 0 et 5',
    )]
    #[ORM\Column(length: 3, nullable: true)]
    private ?string $note = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $create_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(?string $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->create_at;
    }

    public function setCreateAt(?\DateTimeImmutable $create_at): static
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    
}
