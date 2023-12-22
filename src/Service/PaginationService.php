<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Pagination;
use Doctrine\ORM\EntityRepository;

class PaginationService
{
    public function __construct()
    {
    }

    public function createPagination(?string          $page,
                                     EntityRepository $entityRepository,
                                     array            $criteria = [],
                                     array            $orderBy = [],
                                     int              $itemsPerPage = 9,
    ): Pagination
    {
        $pagination = new Pagination();
        $pagination
            ->setPage($this->validatePage($page))
            ->setItems($this->findItems($entityRepository, $criteria, $orderBy, $itemsPerPage, $pagination))
            ->setNumPages((int)ceil($entityRepository->count($criteria) / $itemsPerPage));

        return $pagination;
    }

    /**
     * @param string|null $page
     * @return int
     */
    public function validatePage(?string $page): int
    {
        return (int)$page === 0 ? 1 : (int)$page;
    }

    /**
     * @param EntityRepository $entityRepository
     * @param array $criteria
     * @param array $orderBy
     * @param int $itemsPerPage
     * @param Pagination $pagination
     * @return array|object[]
     */
    public function findItems(EntityRepository $entityRepository, array $criteria, array $orderBy, int $itemsPerPage, Pagination $pagination): array
    {
        return $entityRepository->findBy($criteria,
            $orderBy,
            $itemsPerPage,
            $itemsPerPage * ($pagination->getPage() - 1));
    }
}