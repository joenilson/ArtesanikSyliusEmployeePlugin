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

namespace Artesanik\SyliusEmployeePlugin\Entity\Customer;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Customer as BaseCustomer;
use Sylius\Component\Core\Model\CustomerInterface;
use Artesanik\SyliusEmployeePlugin\Entity\Employee\Limit;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Class Customer
 * @package Artesanik\SyliusEmployeePlugin\Entity\Customer
 * @ORM\Table(name="`sylius_customer`")
 * @ORM\Entity
 */
class Customer extends BaseCustomer implements CustomerInterface
{
    /** @ORM\Column(type="string", length=32, nullable=true) */
    protected $employeeid;
    
    /** @ORM\Column(type="string", length=120, nullable=true) */
    protected $position;
    
    /** @ORM\Column(type="string", length=120, nullable=true) */
    protected $department;
    
    /** @ORM\Column(type="string", length=120, nullable=true) */
    protected $office;
    
    /** @ORM\Column(type="string", length=120, nullable=true) */
    protected $company;

    /** @ORM\Column(type="boolean", options={"default":"0"}) */
    protected $limitpurchase;

    /**
    * @ManyToOne(targetEntity="Artesanik\SyliusEmployeePlugin\Entity\Employee\Limit")
    * @JoinColumn(name="limitid",                                                     referencedColumnName="id")
    **/
    protected $limitid;
    
    /** @ORM\Column(type="boolean", options={"default":"0"}) */
    protected $limitexcluded;

    public function getEmployeeid(): ?string
    {
        return $this->employeeid;
    }

    public function setEmployeeid(string $employeeid): self
    {
        $this->employeeid = $employeeid;

        return $this;
    }
    
    public function getPosition(): ?string
    {
        return $this->position;
    }
    
    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }
    
    public function getDepartment(): ?string
    {
        return $this->department;
    }
    
    public function setDepartment(string $department): self
    {
        $this->department = $department;

        return $this;
    }
    
    public function getOffice(): ?string
    {
        return $this->office;
    }
    
    public function setOffice(string $office): self
    {
        $this->office = $office;

        return $this;
    }
    
    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }
 
    public function getLimitpurchase(): ?bool
    {
        return $this->limitpurchase;
    }
    
    public function setLimitpurchase(bool $limitpurchase): self
    {
        $this->limitpurchase = $limitpurchase;

        return $this;
    }
    
    public function getLimitid(): ?Limit
    {
        return $this->limitid;
    }
    
    public function setLimitid(?Limit $limitid): self
    {
        $this->limitid = $limitid;

        return $this;
    }
    
    public function getLimitExcluded(): ?bool
    {
        return $this->limitexcluded;
    }
    
    public function setLimitExcluded(bool $limitexcluded): self
    {
        $this->limitexcluded = $limitexcluded;

        return $this;
    }
}
