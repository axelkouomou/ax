<?php

namespace App\Entity;

use App\Repository\UserActionRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: UserActionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class UserAction
{
    public const ACTION_CREATE = 'create';
    public const ACTION_UPLOAD = 'upload';
    public const ACTION_DELETE = 'delete';
    public const ACTION_RESTORE = 'restore';
    public const ACTION_VIEW = 'view';
    public const ACTION_EDIT = 'edit';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;


    #[ORM\Column(length: 20)]
    private ?string $action = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $actionAt = null;

    #[ORM\ManyToOne(inversedBy: 'userActions')]
    private ?File $file = null;

    #[ORM\ManyToOne(inversedBy: 'userActions')]
    private ?Folder $folder = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $details = null;

    #[ORM\PrePersist]
    public function setActionAtValue(): void
    {
        $this->actionAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function getActionAt(): ?\DateTimeImmutable
    {
        return $this->actionAt;
    }

    public function setActionAt(\DateTimeImmutable $actionAt): static
    {
        $this->actionAt = $actionAt;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): static
    {
        $this->file = $file;

        return $this;
    }

    public function getFolder(): ?Folder
    {
        return $this->folder;
    }

    public function setFolder(?Folder $folder): static
    {
        $this->folder = $folder;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getActionDescription(): string
    {
        $actionDescriptions = [
            self::ACTION_CREATE => 'Created',
            self::ACTION_UPLOAD => 'Uploaded',
            self::ACTION_DELETE => 'Deleted',
            self::ACTION_RESTORE => 'Restored',
            self::ACTION_VIEW => 'Viewed',
            self::ACTION_EDIT => 'Edited',
        ];

        return $actionDescriptions[$this->action] ?? ucfirst($this->action);
    }

    public function getTargetName(): string
    {
        if ($this->file) {
            return $this->file->getName();
        } elseif ($this->folder) {
            return $this->folder->getName();
        }
        
        return 'Unknown';
    }

    public function getTargetType(): string
    {
        if ($this->file) {
            return 'File';
        } elseif ($this->folder) {
            return 'Folder';
        }
        
        return 'Unknown';
    }
}