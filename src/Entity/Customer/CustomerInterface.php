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
declare(strict_types=1);

namespace Artesanik\SyliusEmployeePlugin\Entity\Customer;

/**
 * Description of CustomerInterface
 *
 * @author joenilson
 */
interface CustomerInterface
{
    public function setEmployeeid(string $employeeid): void;

    public function hasEmployeeid(): bool;
    
    public function setPosition(string $position): void;

    public function hasPosition(): bool;
    
    public function setDepartment(string $department): void;

    public function hasDepartment(): bool;
    
    public function setOffice(string $office): void;

    public function hasOffice(): bool;
    
    public function setCompany(string $company): void;

    public function hasCompany(): bool;

    public function setLimitpurchase(bool $limitpurchase): void;

    public function hasLimitpurchase(): bool;

    public function setLimitid(?int $limitid): void;

    public function hasLimitid(): bool;
    
    public function setLimitExcluded(bool $limitexcluded): void;

    public function hasLimitExcluded(): bool;
}
