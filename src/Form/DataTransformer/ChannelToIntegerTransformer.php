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
 * Created on Wed Apr 29 2020
 *
 * Copyright (c) 2020 Artesanik
 * author Joe Nilson <joenilson@gmail.com>
 */

declare(strict_types=1);

namespace Artesanik\SyliusEmployeePlugin\Form\DataTransformer;

use Sylius\Bundle\ChannelBundle\Doctrine\ORM\ChannelRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ChannelToIntegerTransformer implements DataTransformerInterface
{
    protected $limitRepository;
    
    public function __construct(ChannelRepository $channelRepository)
    {
        $this->limitRepository = $channelRepository;
    }

    public function transform($channel)
    {
        if (null === $channel) {
            return '';
        }

        return $channel;
    }

    /**
     * Change the Channel name for id
     */
    public function reverseTransform($channelValue)
    {
        if (!$channelValue) {
            return;
        }

        $channel = $this->limitRepository->find($channelValue);
        if (null === $channel) {
            throw new TransformationFailedException(
                sprintf(
                    'A channel with id "%s" does not exist!',
                    $channelValue
                )
            );
        }

        return $channel;
    }
}
