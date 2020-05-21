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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Sylius\Bundle\CustomerBundle\Form\Type\CustomerType;
use Symfony\Component\Form\FormBuilderInterface;
use Artesanik\SyliusEmployeePlugin\Form\Type\LimitType;

/**
 * Description of CustomerEmployeeTypeExtension
 *
 * @author joenilson
 */
final class CustomerEmployeeTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('employeeid', TextType::class, [
            'label' => 'artesanik_sylius_employee.ui.employee_id',
        ])->add('position', TextType::class, [
            'label' => 'artesanik_sylius_employee.ui.employee_position',
        ])->add('department', TextType::class, [
            'label' => 'artesanik_sylius_employee.ui.employee_department',
        ])->add('office', TextType::class, [
            'label' => 'artesanik_sylius_employee.ui.employee_office',
        ])->add('company', TextType::class, [
            'label' => 'artesanik_sylius_employee.ui.employee_company',
        ])->add('limitpurchase', CheckboxType::class, [
            'label' => 'artesanik_sylius_employee.ui.employee_limitpurchase',
        ])->add('limitid', LimitType::class, [
            'label' => 'artesanik_sylius_employee.ui.employee_limitid',
            'required' => false,
            'placeholder' => 'artesanik_sylius_employee.ui.employee_limitid_choose',
        ])
        ->add('limitexcluded', CheckboxType::class, [
            'label' => 'artesanik_sylius_employee.ui.employee_limitexcluded',
        ]);
    }

    public function getExtendedType(): string
    {
        return CustomerType::class;
    }
}
