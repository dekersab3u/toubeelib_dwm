<?php

namespace rdv\core\repositoryInterfaces;

use rdv\core\domain\entities\Patient\Patient;

interface PatientRepositoryInterface {

    public function getPatientById(string $id): Patient;

}