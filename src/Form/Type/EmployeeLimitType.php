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

namespace Artesanik\SyliusEmployeePlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Artesanik\SyliusEmployeePlugin\Form\Type\PeriodicityType;
use Artesanik\SyliusEmployeePlugin\Form\Type\ChannelChoiceType;

/**
 * Description of EmployeeLimitType
 *
 * @author joenilson
 */
final class EmployeeLimitType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextType::class, [
                'label' => 'artesanik_sylius_employee.ui.employee_limitdescription'
            ])
            ->add('limittype', ChoiceType::class, [
                'label' =>  'artesanik_sylius_employee.ui.employee_limittype',
                'choices'  => [
                    'artesanik_sylius_employee.ui.limittype_money' => 'money',
                    'artesanik_sylius_employee.ui.limittype_quantity' => 'quantity'
                ]
            ])
            ->add('limitvalue', NumberType::class, [
                'label' =>  'artesanik_sylius_employee.ui.employee_limitvalue'
            ])
            ->add('channel', ChannelChoiceType::class, [
                'label' =>  'artesanik_sylius_employee.ui.employee_limitchannel',
                'required'   => true,
            ])
            ->add('periodicity', PeriodicityType::class, [
                'label' =>  'artesanik_sylius_employee.ui.employee_limitperiodicity',
                'required'   => true,
            ])
            ->add('isactive', CheckboxType::class, [
                'attr' => array('checked'   => 'checked'),
            ])
            ->add(
                'createdat',
                DateTimeType::class,
                [
                'label' =>  'artesanik_sylius_employee.ui.employee_limitcreatedat',
                'widget' => 'single_text',
                'date_format' => 'yyyy-MM-dd H:i:s',
                'html5' => false,
                'data' => new \DateTime('now'),
                'attr' => [ 'readonly' => 'true' ]
                ]
            );
    }
}
