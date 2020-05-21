<?php

declare(strict_types=1);

namespace Artesanik\SyliusEmployeePlugin\Repository\Employee;

use Artesanik\SyliusEmployeePlugin\Entity\Employee\Limit;
use Artesanik\SyliusEmployeePlugin\Entity\EmployeeLimitInterface;
use Artesanik\SyliusEmployeePlugin\Repository\Employee\LimitRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use RuntimeException;
use Doctrine\ORM\NonUniqueResultException;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @method Limit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Limit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Limit[]    findAll()
 * @method Limit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LimitRepository extends EntityRepository implements LimitRepositoryInterface
{
    public function findAllRemappedId(): ?Limit
    {
        return $this->createQueryBuilder('l')
            ->select('l.id as limitid')
            ->andWhere('l.isactive = :val')
            ->setParameter('val', true);
    }
}
