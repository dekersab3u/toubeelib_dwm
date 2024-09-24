<?php
use PHPUnit\Framework\TestCase;
use toubeelib\infrastructure\repositories\ArrayRdvRepository;
use toubeelib\infrastructure\repositories\ArrayPraticienRepository;

class DisponibilitesPraticienTest extends TestCase
{
    public function testListeDisponibilitesPraticien()
    {
        // Créer les repositories de praticiens et rendez-vous
        $praticienRepo = new ArrayPraticienRepository();
        $rdvRepo = new ArrayRdvRepository();

        // Créer une instance du service Praticien avec les repositories
        $service = new \toubeelib\core\services\praticien\ServicePraticien($praticienRepo, $rdvRepo);

        // Dates de début et de fin pour les créneaux à vérifier
        $dateDebut = \DateTime::createFromFormat('Y-m-d H:i', '2024-09-02 08:00');
        $dateFin = \DateTime::createFromFormat('Y-m-d H:i', '2024-09-02 18:00');

        // Appel de la méthode pour obtenir les disponibilités du praticien 'p1'
        $dispos = $service->listeDisponibilitesPraticien('p1', $dateDebut, $dateFin);

        // Imprimer les créneaux de disponibilité pour inspection
        foreach ($dispos as $dispo) {
            echo $dispo->format('Y-m-d H:i') . PHP_EOL;
        }

        // Vérifier qu'on n'a pas les créneaux où le praticien "p1" a des rendez-vous (09:00 et 10:00)
        $this->assertNotContains(\DateTime::createFromFormat('Y-m-d H:i', '2024-09-02 09:00'), $dispos);
        $this->assertNotContains(\DateTime::createFromFormat('Y-m-d H:i', '2024-09-02 10:00'), $dispos);

        // Vérifier que les créneaux libres (08:00, 08:30, etc.) sont présents
        $this->assertContains(\DateTime::createFromFormat('Y-m-d H:i', '2024-09-02 08:00'), $dispos);
        $this->assertContains(\DateTime::createFromFormat('Y-m-d H:i', '2024-09-02 08:30'), $dispos);
    }
}
