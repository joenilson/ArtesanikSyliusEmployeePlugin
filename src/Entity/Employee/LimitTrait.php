<?php

/*
 * Copyright (C) 2020 joenilson.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3.0 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 */

namespace Artesanik\SyliusEmployeePlugin\Entity\Employee;

use Sylius\Component\Channel\Model\ChannelInterface;

/**
 *
 * @author joenilson
 */
trait LimitTrait
{
    /**
     *
     * @var int $id
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @var string
     *
     * @ORM\Column(type="string", length=120)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=32)
     */
    private $limittype;

    /**
     * @var decimal
     * @ORM\Column(type="decimal", precision=18, scale=4, nullable=true)
     */
    private $limitvalue;

    /**
     * @ManyToOne(targetEntity="sylius_channel")
     * @JoinColumn(name="channel",               referencedColumnName="id")
     */
    private $channel;

    /**
     * @var string
     * @ORM\Column(type="string", length=32)
     */
    private $periodicity;
    
    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isactive;

    /**
     * @var datetime
     * @ORM\Column(type="datetime")
     */
    private $createdat;

    /**
     * @var datetime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modifiedat;
    
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

    public function setLimitvalue(string $limitvalue): self
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
        $this->createdat = $createat;

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
