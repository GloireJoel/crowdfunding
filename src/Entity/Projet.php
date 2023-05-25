<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @Vich\Uploadable()
 */
#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\Column(length: 255)]
    private ?string $objet = null;

    #[ORM\Column(length: 255)]
    private ?string $pourquoi = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $histoire = null;



    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: PlanFinancier::class)]
    private Collection $plan_financier;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: PlanAction::class)]
    private Collection $plan_action;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: PlanCommunication::class)]
    private Collection $plan_communication;


    #[ORM\Column(length: 255)]
    private ?string $image = null;

    /**
     * @Assert\File(maxSize="2M", mimeTypes={"image/png", "image/jpg", "image/jpeg"})
     * @Vich\UploadableField(mapping="projets", fileNameProperty="image")
     */
    private ?File $imageFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'projet')]
    private ?Financement $financement = null;


    public function __construct()
    {
        $this->plan_financier = new ArrayCollection();
        $this->plan_action = new ArrayCollection();
        $this->plan_communication = new ArrayCollection();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getPourquoi(): ?string
    {
        return $this->pourquoi;
    }

    public function setPourquoi(string $pourquoi): self
    {
        $this->pourquoi = $pourquoi;

        return $this;
    }

    public function getHistoire(): ?string
    {
        return $this->histoire;
    }

    public function setHistoire(string $histoire): self
    {
        $this->histoire = $histoire;

        return $this;
    }


    /**
     * @return Collection<int, PlanFinancier>
     */
    public function getPlanFinancier(): Collection
    {
        return $this->plan_financier;
    }

    public function addPlanFinancier(PlanFinancier $planFinancier): self
    {
        if (!$this->plan_financier->contains($planFinancier)) {
            $this->plan_financier->add($planFinancier);
            $planFinancier->setProjet($this);
        }

        return $this;
    }

    public function removePlanFinancier(PlanFinancier $planFinancier): self
    {
        if ($this->plan_financier->removeElement($planFinancier)) {
            // set the owning side to null (unless already changed)
            if ($planFinancier->getProjet() === $this) {
                $planFinancier->setProjet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PlanAction>
     */
    public function getPlanAction(): Collection
    {
        return $this->plan_action;
    }

    public function addPlanAction(PlanAction $planAction): self
    {
        if (!$this->plan_action->contains($planAction)) {
            $this->plan_action->add($planAction);
            $planAction->setProjet($this);
        }

        return $this;
    }

    public function removePlanAction(PlanAction $planAction): self
    {
        if ($this->plan_action->removeElement($planAction)) {
            // set the owning side to null (unless already changed)
            if ($planAction->getProjet() === $this) {
                $planAction->setProjet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PlanCommunication>
     */
    public function getPlanCommunication(): Collection
    {
        return $this->plan_communication;
    }

    public function addPlanCommunication(PlanCommunication $planCommunication): self
    {
        if (!$this->plan_communication->contains($planCommunication)) {
            $this->plan_communication->add($planCommunication);
            $planCommunication->setProjet($this);
        }

        return $this;
    }

    public function removePlanCommunication(PlanCommunication $planCommunication): self
    {
        if ($this->plan_communication->removeElement($planCommunication)) {
            // set the owning side to null (unless already changed)
            if ($planCommunication->getProjet() === $this) {
                $planCommunication->setProjet(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image instanceof UploadedFile) {
            $this->updatedAt = new DateTimeImmutable();
        }
        return $this;

    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getFinancement(): ?Financement
    {
        return $this->financement;
    }

    public function setFinancement(?Financement $financement): self
    {
        $this->financement = $financement;

        return $this;
    }

}
