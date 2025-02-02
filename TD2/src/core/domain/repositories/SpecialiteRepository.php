<?php

namespace iutnc\doctrine\src\core\domain\repositories;

use Doctrine\ORM\EntityRepository;

class SpecialiteRepository extends EntityRepository
{
    public function getSpecialtitesByKeyword(string $keyword): array
    {
        $dql = 'SELECT s FROM iutnc\doctrine\core\domain\entities\Specialite s 
                WHERE s.libelle LIKE :keyword 
                OR s.description LIKE :keyword';
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('keyword', '%' . $keyword . '%');
        return $query->getResult();
    }
}
