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

namespace Artesanik\SyliusEmployeePlugin\Entity;

/**
 *
 * @author joenilson
 */
trait CustomerEmployeeTrait
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", name="employeeid")
     */
    private $employeeid = '';
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", name="position")
     */
    private $position = '';
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", name="office")
     */
    private $office = '';
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", name="company")
     */
    private $company = '';

    public function setEmployeeid(string $employeeid): void
    {
        $this->employeeid = $employeeid;
    }

    public function getEmployeeid(): string
    {
        return $this->employeeid;
    }
    
    public function getPosition(): ?string
    {
        return $this->position;
    }
    
    public function setPosition(string $position): void
    {
        $this->position = $position;
    }
    
    public function getOffice(): ?string
    {
        return $this->office;
    }
    
    public function setOffice(string $office): void
    {
        $this->office = $office;
    }
    
    public function getCompany(): ?string
    {
        return $this->company;
    }
    
    public function setCompany(string $company): void
    {
        $this->company = $company;
    }
}
