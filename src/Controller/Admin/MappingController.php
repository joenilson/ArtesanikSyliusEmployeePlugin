<?php
/**
 * PHP version 7
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
 * Description of MappingController
 *
 * @category    Controller
 * @package     Artesanik\SyliusEmployeePlugin\Controller\Admin
 * @author      Joe Nilson <joenilson@gmail.com>
 * @license     lgpl3 https://www.gnu.org/licenses/lgpl-3.0.html
 * @link        http://www.sylius.com
 * @PHP_VERSION 70404
 **/
declare(strict_types=1);

namespace Artesanik\SyliusEmployeePlugin\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Artesanik\SyliusEmployeePlugin\Repository\Employee\LimitRepositoryInterface;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Mapping Controller for Limits
 *
 * @category Controller
 * @package  Artesanik\SyliusEmployeePlugin\Controller\Admin
 * @author   Joe Nilson <joenilson@gmail.com>
 * @license  lgpl3 https://www.gnu.org/licenses/lgpl-3.0.html
 * @link     http://www.sylius.com
 */
final class MappingController extends AbstractController
{
    /** @var Enviroment */
    private $twig;

    /** @var CustomerRepositoryInterface */
    private $customerRepository;

    /** @var LimitRepositoryInterface */
    private $limitRepository;

    /** @var TranslatorInterface */
    private $translator;

    /** @var SessionInterface */
    private $session;

    /**
     * @param Environment $twig
     *
     * @return void
     */
    public function __construct(
        Environment $twig,
        CustomerRepositoryInterface $customerRepository,
        LimitRepositoryInterface $limitRepository,
        TranslatorInterface $translator,
        SessionInterface $session
    ) {
        $this->twig = $twig;
        $this->customerRepository = $customerRepository;
        $this->limitRepository = $limitRepository;
        $this->translator = $translator;
        $this->session = $session;
    }
    /**
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $limitid = $request->get('limitid');
        $limit = $this->limitRepository->find($limitid);
        $customerIds = $request->get('ids');
        $methodMapping = $request->get('_methodMapping');
        $countCustomers = 0;

        foreach ($customerIds as $customerId) {
            $customer = $this->customerRepository->find($customerId);
            if ($customer and $methodMapping === 'ASSIGN') {
                $customer->setLimitid($limit);
                $customer->setLimitpurchase(true);
                $customer->setLimitexcluded(false);
            } elseif ($customer and $methodMapping === 'UNASSIGN') {
                $customer->setLimitid(false);
                $customer->setLimitpurchase(false);
                $customer->setLimitexcluded(false);
            }
            $countCustomers++;
            $this->customerRepository->add($customer);
        }

        $limits = $this->customerRepository->findBy(['limitid' => $limit]);

        if (empty($limits) === true) {
            $this->session->getFlashBag()->add(
                'info',
                $this->translator->trans('artesanik_sylius_employee.ui.info_empty_mapping')
            );
        } else {
            $this->session->getFlashBag()->add(
                'success',
                $this->translator->trans('artesanik_sylius_employee.ui.info_success_mapping')
            );
        }

        return $this->redirectToRoute('artesanik_sylius_employee_admin_mapping_index', [
            'id' => $limitid
        ]);
    }
}
