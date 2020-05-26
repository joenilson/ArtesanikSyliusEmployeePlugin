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

namespace Artesanik\SyliusEmployeePlugin\EventListener;

use Artesanik\SyliusEmployeePlugin\Repository\Employee\LimitRepository;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Sylius\Component\Order\Model\OrderItemInterface;
use Sylius\Component\Order\Repository\OrderRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Description of LimitVerifyAfterAddingToCartListener
 *
 * @author joenilson
 */
final class LimitVerifyAfterAddingToCartListener
{
    private $router;
    
    private $session;
    
    private $translator;
    
    private $container;
    
    private $customer;
    
    private $customerLimit;
    
    public function __construct(
            RouterInterface $router, 
            SessionInterface $session, 
            TranslatorInterface $translator,
            ContainerInterface $container,
            CustomerContextInterface $customer,
            LimitRepository $customerLimit
    ) {
        $this->router = $router;
        $this->session = $session;
        $this->translator = $translator;
        $this->container = $container;
        $this->customer = $customer;
        $this->customerLimit = $customerLimit;
    }
    
    /**
     * @param ResourceControllerEvent $event
     */
    public function onSuccessfulAddToCart(ResourceControllerEvent $event)
    {
        $customer = $this->customer->getCustomer();
        $channel = $this->container->get('sylius.context.channel')->getChannel();
        $limit = $customer->getLimitid();

        if ($event->getSubject() instanceof OrderItemInterface and $limit !== null) {
            $cart = $this->container->get('sylius.context.cart');
            $limitBalance = $this->container
                            ->get('sylius.repository.customer')
                            ->countOrderItemsByLimit($channel, $customer->getId());
            $order = $cart->getCart();
            $orderItem = $event->getSubject();
            $this->container->get('sylius.order_processing.order_processor')->process($order);
            $this->processCartLimits($limitBalance, $order, $orderItem);
        }
    }
    
    public function onCartUpdate(GenericEvent $event)
    {
        $customer = $this->customer->getCustomer();
        $channel = $this->container->get('sylius.context.channel')->getChannel();
        $limitBalance = $this->container
                            ->get('sylius.repository.customer')
                            ->countOrderItemsByLimit($channel, $customer->getId());
        $order = $event->getSubject();
        $this->container->get('sylius.order_processing.order_processor')->process($order);
        $this->processCartLimits($limitBalance, $order);

    }
    
    public function processCartLimits(&$limitBalance, &$order, &$originalOrderItem = null)
    {
        if($originalOrderItem !== null) {
             $this->processItemCartLimits($limitBalance, $order, $originalOrderItem);
        } else {
            foreach ($order->getItems() as $orderItem) {
                $this->processItemCartLimits($limitBalance, $order, $orderItem);
            }
        }

        $this->container->get('sylius.order_processing.order_processor')->process($order);
        /** @var OrderRepositoryInterface $orderRepository */
        $orderRepository = $this->container->get('sylius.repository.order');
        $orderRepository->add($order);
    }
    
    public function processItemCartLimits(&$limitBalance, &$order, &$orderItem)
    {
        $newQuantity = $this->validateCustomerLimitBalance($limitBalance['result'], $order, $orderItem);
        if($newQuantity > 0) {
            $this->container->get('sylius.order_item_quantity_modifier')->modify($orderItem, $newQuantity);
            $order->addItem($orderItem);
            $limitBalance['result']-=$newQuantity;
        } else {
            $order->removeItem($orderItem);
        }
    }
    
    public function validateCustomerLimitBalance(&$limitBalance, $order, &$orderItem)
    {
        $customer = $this->customer->getCustomer();
        $channel = $this->container->get('sylius.context.channel')->getChannel();
        $limit = $customer->getLimitid();
        
        if($limit === null OR $limit === false) {
            return $orderItem->getQuantity();
        }
        
        if(strcmp($limit->getChannel(), $channel) == 0) {
            return $this->validateLimitTypeControl($limit, $limitBalance, $order, $orderItem);
        }
    }
    
    public function validateLimitTypeControl($limit, &$limitBalance, $order, &$orderItem)
    {
        $valueLimit = ($limit->getLimitvalue() - $limitBalance);
        if($limit->getLimittype() === 'quantity') {
            if($valueLimit < $order->getTotalQuantity()) {
                $value = $orderItem->getQuantity() - ($order->getTotalQuantity() - $valueLimit);
                return $value;
            } elseif ($valueLimit >= $order->getTotalQuantity()) {
                return $orderItem->getQuantity();
            }
        } elseif ($limit->getLimittype() === 'money') {
            if(($valueLimit * 100) < $order->getTotal()) {
                $amountDiff = $order->getTotal() - ($valueLimit * 100);
                $unitPrice = $orderItem->getFullDiscountedUnitPrice();                
                $minusQuantity = ($unitPrice > $amountDiff) ? 1 : \ceil($amountDiff/$unitPrice);
                $newQuantity = $orderItem->getQuantity() - $minusQuantity;
                return $newQuantity;
            } elseif ($limit->getLimitvalue() >= $order->getTotalQuantity()) {
                return $orderItem->getQuantity();
            }
        }
    }
}
