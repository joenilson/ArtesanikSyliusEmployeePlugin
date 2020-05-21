<?php

namespace Artesanik\SyliusEmployeePlugin\Entity\Employee;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Sylius\Component\Channel\Model\ChannelInterface;

/**
 *
 * @package Artesanik\SyliusEmployeePlugin\Entity\Employee
 *
 * @ORM\Table(name="`sylius_employee_limit`")
 * @ORM\Entity
 *
 */
class Limit implements ResourceInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $limittype;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=4, nullable=true)
     */
    private $limitvalue;

    /**
    * @ManyToOne(targetEntity="Sylius\Component\Core\Model\Channel")
    * @JoinColumn(name="channel",                                    referencedColumnName="id")
    **/
    private $channel;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $periodicity;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isactive;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdat;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modifiedat;

    public function __toString()
    {
        return (string) $this->getDescription();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLimittype(): ?string
    {
        return $this->limittype;
    }

    public function setLimittype(string $limittype): self
    {
        $this->limittype = $limittype;

        return $this;
    }

    public function getLimitvalue(): ?string
    {
        return $this->limitvalue;
    }

    public function setLimitvalue(float $limitvalue): self
    {
        $this->limitvalue = $limitvalue;

        return $this;
    }

    public function getChannel(): ?ChannelInterface
    {
        return $this->channel;
    }

    public function setChannel(?ChannelInterface $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function getPeriodicity(): ?string
    {
        return $this->periodicity;
    }

    public function setPeriodicity(string $periodicity): self
    {
        $this->periodicity = $periodicity;

        return $this;
    }

    public function getIsactive(): ?bool
    {
        return $this->isactive;
    }

    public function setIsactive(bool $isactive): self
    {
        $this->isactive = $isactive;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;
        return $this;
    }

    public function getModifiedat(): ?\DateTimeInterface
    {
        return $this->modifiedat;
    }

    public function setModifiedat(?\DateTimeInterface $modifiedat): self
    {
        $this->modifiedat = $modifiedat;

        return $this;
    }
}
