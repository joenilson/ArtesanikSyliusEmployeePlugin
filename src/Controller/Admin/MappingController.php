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

        // return new Response(
        //     $this->twig->render(
        //         '@ArtesanikSyliusEmployeePlugin/Admin/mapping.html.twig',
        //         [
        //             'message' => 'This is the mapping the id ' . $limitid,
        //             'limit_list' => $limits
        //         ]
        //     )
        // );
    }
}

//   public function bulkDeleteAction(Request $request): Response
//     {
//         $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

//         $this->isGrantedOr403($configuration, ResourceActions::BULK_DELETE);
//         $resources = $this->resourcesCollectionProvider->get($configuration, $this->repository);

//         if (
//             $configuration->isCsrfProtectionEnabled() &&
//             !$this->isCsrfTokenValid(ResourceActions::BULK_DELETE, $request->request->get('_csrf_token'))
//         ) {
//             throw new HttpException(Response::HTTP_FORBIDDEN, 'Invalid csrf token.');
//         }

//         $this->eventDispatcher->dispatchMultiple(ResourceActions::BULK_DELETE, $configuration, $resources);

//         foreach ($resources as $resource) {
//             $event = $this->eventDispatcher->dispatchPreEvent(ResourceActions::DELETE, $configuration, $resource);

//             if ($event->isStopped() && !$configuration->isHtmlRequest()) {
//                 throw new HttpException($event->getErrorCode(), $event->getMessage());
//             }
//             if ($event->isStopped()) {
//                 $this->flashHelper->addFlashFromEvent($configuration, $event);

//                 $eventResponse = $event->getResponse();
//                 if (null !== $eventResponse) {
//                     return $eventResponse;
//                 }

//                 return $this->redirectHandler->redirectToIndex($configuration, $resource);
//             }

//             try {
//                 $this->resourceDeleteHandler->handle($resource, $this->repository);
//             } catch (DeleteHandlingException $exception) {
//                 if (!$configuration->isHtmlRequest()) {
//                     return $this->viewHandler->handle(
//                         $configuration,
//                         View::create(null, $exception->getApiResponseCode())
//                     );
//                 }

//                 $this->flashHelper->addErrorFlash($configuration, $exception->getFlash());

//                 return $this->redirectHandler->redirectToReferer($configuration);
//             }

//             $postEvent = $this->eventDispatcher->dispatchPostEvent(ResourceActions::DELETE, $configuration, $resource);
//         }

//         if (!$configuration->isHtmlRequest()) {
//             return $this->viewHandler->handle($configuration, View::create(null, Response::HTTP_NO_CONTENT));
//         }

//         $this->flashHelper->addSuccessFlash($configuration, ResourceActions::BULK_DELETE);

//         if (isset($postEvent)) {
//             $postEventResponse = $postEvent->getResponse();
//             if (null !== $postEventResponse) {
//                 return $postEventResponse;
//             }
//         }

//         return $this->redirectHandler->redirectToIndex($configuration);
//     }
