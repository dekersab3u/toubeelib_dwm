<?php

namespace praticien\core\services\praticien;

use Respect\Validation\Exceptions\NestedValidationException;
use praticien\core\domain\entities\praticien\Praticien;
use praticien\core\dto\InputPraticienDTO;
use praticien\core\dto\PraticienDTO;
use praticien\core\dto\SpecialiteDTO;
use praticien\core\repositoryInterfaces\PraticienRepositoryInterface;
use praticien\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class ServicePraticien implements ServicePraticienInterface
{
    private PraticienRepositoryInterface $praticienRepository;

    public function __construct(PraticienRepositoryInterface $praticienRepository)
    {
        $this->praticienRepository = $praticienRepository;
    }

    public function createPraticien(InputPraticienDTO $p): PraticienDTO
    {
        // TODO : valider les données et créer l'entité
        return new PraticienDTO($praticien);


    }

    public function getPraticienById(string $id): PraticienDTO
    {
        try {
            $praticien = $this->praticienRepository->getPraticienById($id);
            return new PraticienDTO($praticien);
        } catch(RepositoryEntityNotFoundException $e) {
            throw new ServicePraticienInvalidDataException('invalid Praticien ID');
        }
    }

    public function getSpecialiteById(string $id): SpecialiteDTO
    {
        try {
            $specialite = $this->praticienRepository->getSpecialiteById($id);
            return $specialite->toDTO();
        } catch(RepositoryEntityNotFoundException $e) {
            throw new ServicePraticienInvalidDataException('invalid Specialite ID');
        }
    }

    public function getPraticiens(): array
    {
        $praticiensDTO = [];
        $praticiens = $this->praticienRepository->getPraticiens();
        foreach ($praticiens as $p){
            $praticiensDTO[] = new PraticienDTO($p);
    }
        return $praticiensDTO;
    }
}