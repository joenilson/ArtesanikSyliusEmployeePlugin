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

namespace Artesanik\SyliusEmployeePlugin\Entity\Employee;

/**
 *
 * @author joenilson
 */
interface LimitInterface
{
    public const PERIODICITY_DAILY = 'dayly';
    public const PERIODICITY_WEEKLY = 'weekly';
    public const PERIODICITY_BIWEEKLY = 'biweekly';
    public const PERIODICITY_MONTHLY = 'monthly';
    public const PERIODICITY_BIMONTHLY = 'bimonthly';
    public const PERIODICITY_QUARTERLY = 'quarterly';
    public const PERIODICITY_BIANNUAL = 'biannual';
    public const PERIODICITY_ANNUAL = 'annual';
    public const UNKNOWN_PERIODICITY = '';

    public function getId(int $id): void;

    public function getDescription(string $description): void;
    public function setDescription(string $description): void;

    public function getLimittype(string $limittype): void;
    public function hasLimittype(string $limittype): void;

    public function getLimitvalue(string $limitvalue): void;
    public function hasLimitvalue(string $limitvalue): void;

    public function getChannel(string $channel): void;
    public function hasChannel(string $channel): void;

    public function setPeriodicity(string $periodicity): void;
    public function hasPeriodicity(string $periodicity): void;
    
    public function getIsactive(bool $isactive): void;
    public function hasIsactive(bool $isactive): void;

    public function getCreatedat(string $createat): void;
    public function hasCreatedat(string $createdat): void;
    
    public function getModifiedat(string $modifiedat): void;
    public function setModifiedat(string $modifiedat): void;
}
