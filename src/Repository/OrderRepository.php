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

use Sylius\Component\Core\Model\Channel;
use Artesanik\SyliusEmployeePlugin\Entity\Customer\Customer;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\OrderRepository as BaseOrderRepository;

final class OrderRepository extends BaseOrderRepository
{
    public function countOrderItemsByLimit(
        Channel $channel,
        Customer $customer
    ) {
        $limits = $customer->getLimitid();
        $limittype = $limits->getLimittype();
        $limitperiodicity = $limits->getLimitperiodicity();

        $orders = $this->findBy(['channel' => $channel, 'customer' => $customer]);
        $dateRange = $this->generateRangeDate($limitperiodicity);
        $query = $this->createQueryBuilder('o')
            // ->addSelect('oi.quantity')
            // ->addSelect('sel.limittype')
            // ->addSelect('sel.limitvalue')
            ->leftJoin(
                'Sylius\Component\Order\Model\OrderItem',
                'oi',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'o.id = oi.order_id'
            )
            ->where('o.customer_id = :customerid')
            ->where('o.channel_id = :channelid')
            ->where('o.checkout_completed_at between :startdate and :enddate')
            ->where('o.state != :state')
            ->setParameter('customerid', $customer->getId())
            ->setParameter('channelid', $channel->getId())
            ->setParameter('startdate', \date('Y-m-d H:i:s', strtotime($dateRange['startDate'])))
            ->setParameter('enddate', \date('Y-m-d H:i:s', strtotime($dateRange['endDate'])))
            ->setParameter('state', 'canceled')
            ->addOrderBy('o.checkout_completed_at', 'ASC')
            ->getQuery();
        var_dump($query);
    }
}
