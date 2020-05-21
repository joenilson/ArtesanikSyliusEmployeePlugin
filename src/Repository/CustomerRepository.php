<?php

/**
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
 *
 * Created on Sun Apr 26 2020
 *
 * Copyright (c) 2020 Artesanik
 * author Joe Nilson <joenilson@gmail.com>
 **/

declare(strict_types=1);

namespace Artesanik\SyliusEmployeePlugin\Repository;

use InvalidArgumentException;
use RuntimeException;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\CustomerRepository as BaseCustomerRepository;
use Sylius\Component\Channel\Model\Channel;
use Artesanik\SyliusEmployeePlugin\Entity\Customer\Customer;
use Artesanik\SyliusEmployeePlugin\Entity\Customer\CustomerInterface;
use Artesanik\SyliusEmployeePlugin\Repository\OrderRepository;
use Sylius\Component\Order\Model\OrderItem;
use Doctrine\ORM\QueryBuilder;

/**
 * Extended CustomerRepository
 *
 * @package Artesanik\SyliusEmployeePlugin\Repository
 *
 */
class CustomerRepository extends BaseCustomerRepository
{
    /**
     * Find Customers by the limit mapped
     *
     * @param string $limit
     *
     * @return CustomerInterface[]
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function findAllByLimitid(string $limitid)
    {
        $query = $this->createQueryBuilder('o')
            ->leftJoin(
                'Artesanik\SyliusEmployeePlugin\Entity\Employee\Limit',
                'sel',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'o.limitid = sel.id'
            )
            ->where('o.limitid = :limitid')
            ->setParameter('limitid', $limitid)
            ->addOrderBy('o.email', 'ASC');
        return $query;
    }

    /**
     * Select customers without an limit assigned
     *
     * @return QueryBuilder
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function findAllByNoLimitid()
    {
        $query = $this->createQueryBuilder('o')
            ->where('o.limitid is NULL')
            ->andWhere('o.limitexcluded = :excluded')
            ->setParameter('excluded', false)
            ->addOrderBy('o.email', 'ASC');
        return $query;
    }

    public function countOrderItemsByLimit(
        Channel $channel,
        string $customer
    ) {
        $customer = $this->findBy(['id'=> $customer])[0];
        $limits = $customer->getLimitid();
        $limittype = $limits->getLimittype();
        $periodicity = $limits->getPeriodicity();
        $dateRange = $this->generateRangeDate($periodicity);
        $selectFields = ($limittype == 'quantity') ? 'SUM(poi.quantity) as result' : 'sum(poi.total) as result';
        $query = $this->createQueryBuilder('o')
            ->select($selectFields)
            ->leftJoin(
                'Sylius\Component\Core\Model\Order',
                'po',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'o.id = po.customer'
            )
            ->leftJoin(
                'Sylius\Component\Core\Model\OrderItem',
                'poi',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'po.id = poi.order'
            )
            ->where('o.id = :customerid')
            ->andWhere('po.channel = :channelid')
            ->andWhere('po.checkoutCompletedAt between :startdate and :enddate')
            ->andWhere('po.state != :state')
            ->setParameter('customerid', $customer->getId())
            ->setParameter('channelid', $channel->getId())
            ->setParameter('startdate', \date('Y-m-d H:i:s', strtotime($dateRange['startDate'])))
            ->setParameter('enddate', \date('Y-m-d H:i:s', strtotime($dateRange['endDate'])))
            ->setParameter('state', 'cancelled')
            ->addOrderBy('po.checkoutCompletedAt', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        if ($query === '') {
            $query[0]['result'] = 0;
        }
        $expenses = $this->infoExpense($query[0]['result'], $limits->getLimitvalue(), $limits->getLimittype());
        return ['result' => $expenses['orderItems'], 
            'color' => $expenses['color'],
            'limitvalue' => $limits->getLimitvalue()];
    }

    private function infoExpense($orderItems, $limit, $limittype)
    {
        $orderItems = ($limittype == 'quantity') ? $orderItems : ($orderItems / 100);
        
        $expense = ($orderItems / $limit)*100;
        $color = 'black';
        switch (true) {
            case $expense >= 98:
                $color = 'red';
            break;
            case ($expense > 75 and $expense < 98):
                $color = 'orange';
            break;
            case ($expense > 45 and $expense < 75):
                $color = 'yellow';
            break;
            case $expense < 45:
                $color = 'green';
            break;
            default:
                $color = 'black';
            break;
        }
        return ['orderItems' => $orderItems, 'color' => $color];
    }

    /**
     * Function to get the date range for the periodicity limits
     *
     * The limitperiodicity value
     * @param string $limitperiodicity
     *
     * @return array
     */
    private function generateRangeDate(string $limitperiodicity): array
    {
        switch ($limitperiodicity) {
            case "monthly":
                $startDate = \date('Y-m-01');
                $endDate = \date('Y-m-t');
            break;
            case "weekly":
                $monday = new \DateTime();
                $sunday = new \DateTime();
                $monday->modify('Last Monday');
                $sunday->modify('Next Sunday');
                $startDate = $monday->format('Y-m-d');
                $endDate = $sunday->format('Y-m-d');
            break;
            case "bimonthly":
                if ((\date('n')/2) === 0) {
                    $startDate = \date("Y-n-j", strtotime("first day of previous month"));
                    $endDate = \date("Y-m-t");
                } else {
                    $startDate = \date("Y-m-01");
                    $endDate = \date("Y-n-j", strtotime("last day of next month"));
                }
            break;
            case "quarterly":
                $month = \date("n", strtotime(\date('Y-m-d')));
                $quarter = ceil($month / 3);
                $startDate = \date('Y-m-d', strtotime(\date('Y') . '-' . (($quarter * 3) - 2). '-1'));
                $endDate = \date('Y-m-d', strtotime(\date('Y-m-d', strtotime($startDate)) . '+3 month - 1 day'));
            break;
            case "biannual":
                $month = \date("n", strtotime(\date('Y-m-d')));
                $startDate = ($month > 6) ? \date('Y-07-01') : \date('Y-01-01');
                $endDate = ($month > 6) ? \date('Y-06-30') : \date('Y-12-31');
            break;
            case "annual":
                $startDate = \date('Y-01-01');
                $endDate = \date('Y-12-31');
            break;
            case "daily":
            default:
                $startDate = \date('Y-m-d');
                $endDate = \date('Y-m-d');
            break;
        }
        return ['startDate' => $startDate , 'endDate' => $endDate];
    }
}
