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

use Artesanik\SyliusEmployeePlugin\Repository\Employee\LimitRepositoryInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class LimitToIntegerTransformer implements DataTransformerInterface
{
    protected $limitRepository;
    
    public function __construct(LimitRepositoryInterface $limitRepository)
    {
        $this->limitRepository = $limitRepository;
    }

    public function transform($limit)
    {
        if (null === $limit) {
            return '';
        }
        return $limit;
    }

    /**
     * Change the Limit object for id
     */
    public function reverseTransform($limitValue)
    {
        if (!$limitValue) {
            return;
        }

        $limit = $this->limitRepository->find($limitValue);
        if (null === $limit) {
            throw new TransformationFailedException(
                sprintf(
                    'A channel with id "%s" does not exist!',
                    $limitValue
                )
            );
        }
        return $limit;
    }
}
