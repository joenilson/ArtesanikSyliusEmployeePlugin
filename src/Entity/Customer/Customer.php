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
use Sylius\Component\Customer\Model\Customer as BaseCustomer;
use Sylius\Component\Customer\Model\CustomerInterface;

/**
 * Description of Customer
 *
 * @author joenilson
 */
class Customer extends BaseCustomer implements CustomerInterface 
{
    /** @ORM\Column(type="string", nullable=true) */
    private $employeeid;
    
    /** @ORM\Column(type="string", nullable=true) */
    private $positionid;
    
    /** @ORM\Column(type="string", nullable=true) */
    private $officeid;
    

    public function getEmployeeid(): ?string
    {
        return $this->employeeid;
    }

    public function setEmployeeid(string $employeeid): void
    {
        $this->employeeid = $employeeid;
    }
    
    public function getPositionid(): ?string
    {
        return $this->positionid;
    }
    
    public function setPositionid(string $positionid): void
    {
        $this->positionid = $positionid;
    }
    
    public function getOfficeid(): ?string
    {
        return $this->officeid;
    }
    
    public function setOfficeid(string $officeid): void
    {
        $this->officeid = $officeid;
    }
}
