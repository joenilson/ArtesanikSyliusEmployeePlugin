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

namespace Artesanik\SyliusEmployeePlugin\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Sylius\Bundle\CustomerBundle\Form\Type\CustomerType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of CustomerEmployeeTypeExtension
 *
 * @author joenilson
 */
final class CustomerEmployeeTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('employee', CollectionType::class, [
            'label' => 'artesanik_sylius_employee_plugin.ui.employee_id',
        ])->add('positionid', CollectionType::class, [
            'label' => 'artesanik_sylius_employee_plugin.ui.employee_position',
        ])->add('officeid', CollectionType::class, [
            'label' => 'artesanik_sylius_employee_plugin.ui.employee_office',
        ]);
    }

    public function getExtendedType(): string
    {
        return CustomerEmployeeType::class;
    }
}
