<?php
/*
 *  This library is free software; you can redistribute it and/or
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
 *
 * Created on Fri May 01 2020
 *
 * Copyright (c) 2020 Artesanik
 * author Joe Nilson <joenilson@gmail.com>
 */

declare(strict_types=1);

namespace Artesanik\SyliusEmployeePlugin\Repository;

use Sylius\Component\Channel\Model\ChannelInterface;
//use Sylius\Component\Core\Model\CustomerInterface;
use Artesanik\SyliusEmployeePlugin\Entity\Customer\CustomerInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface as BaseOrderRepositoryInterface;

interface OrderRepositoryInterface extends BaseOrderRepositoryInterface
{
    public function countOrderItemsByLimit(
        ChannelInterface $channel,
        CustomerInterface $customer
    );

    public function generateRangeDate(string $limitperiodicity);
}
