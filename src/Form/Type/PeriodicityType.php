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
 * Created on Tue Apr 28 2020
 *
 * Copyright (c) 2020 Artesanik
 * author Joe Nilson <joenilson@gmail.com>
 */

declare(strict_types=1);

namespace Artesanik\SyliusEmployeePlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Artesanik\SyliusEmployeePlugin\Entity\Employee\LimitInterface;

final class PeriodicityType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => [
                'artesanik_sylius_employee.ui.periodicity.daily'     => LimitInterface::PERIODICITY_DAILY,
                'artesanik_sylius_employee.ui.periodicity.weekly'    => LimitInterface::PERIODICITY_WEEKLY,
                'artesanik_sylius_employee.ui.periodicity.biweekly'  => LimitInterface::PERIODICITY_BIWEEKLY,
                'artesanik_sylius_employee.ui.periodicity.monthly'   => LimitInterface::PERIODICITY_MONTHLY,
                'artesanik_sylius_employee.ui.periodicity.bimonthly' => LimitInterface::PERIODICITY_BIMONTHLY,
                'artesanik_sylius_employee.ui.periodicity.quarterly' => LimitInterface::PERIODICITY_QUARTERLY,
                'artesanik_sylius_employee.ui.periodicity.biannual'  => LimitInterface::PERIODICITY_BIANNUAL,
                'artesanik_sylius_employee.ui.periodicity.annual'    => LimitInterface::PERIODICITY_ANNUAL,
            ],
            'empty_data' => LimitInterface::PERIODICITY_MONTHLY,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return ChoiceType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'artesanik_sylius_employee_periodicity';
    }
}
