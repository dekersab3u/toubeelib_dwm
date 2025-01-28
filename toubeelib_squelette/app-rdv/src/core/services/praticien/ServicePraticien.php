<?php

namespace rdv\core\services\praticien;

use Respect\Validation\Exceptions\NestedValidationException;
use rdv\core\domain\entities\praticien\Praticien;
use rdv\core\dto\InputPraticienDTO;
use rdv\core\dto\PraticienDTO;
use rdv\core\dto\SpecialiteDTO;
use rdv\core\repositoryInterfaces\PraticienRepositoryInterface;
use rdv\core\repositoryInterfaces\RepositoryEntityNotFoundException;

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