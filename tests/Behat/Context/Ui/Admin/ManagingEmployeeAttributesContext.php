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

namespace Tests\Artesanik\SyliusEmployeePlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;

/**
 * Description of ManagingEmployeeAttributesContext
 *
 * @author joenilson
 */
final class ManagingEmployeeAttributesContext implements Context 
{
    /** @var EmployeeAttributesUpdatePageInterface */
    private $employeeAttributesUpdatePage;

    public function __construct(EmployeeAttributesUpdatePageInterface $employeeAttributesUpdatePage)
    {
        $this->employeeAttributesUpdatePage = $employeeAttributesUpdatePage;
    }
    
    /**
     * @When I choose the customer is in the Employee Group
     */
    public function customerGroupIsEmployee(): void
    {
        $this->employeeAttributesUpdatePage->customerGroupIsEmployee();
    }
    
    /**
     * @Then /^(this customer) attributes must be filled$/
     */
    public function thisCustomerAttributesMustBeFilled(EmployeeAttributesUpdatePageInterface $employeeAttributesUpdatePage): void
    {
        $this->employeeAttributesUpdatePage->open([
            'id' => $productVariant->getId(),
            'productId' => $productVariant->getProduct()->getId(),
        ]);

        Assert::true($this->employeeAttributesUpdatePage->customerGroupIsEmployee());
    }
}
