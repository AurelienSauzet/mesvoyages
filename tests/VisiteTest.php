<?php

namespace App\Tests;

use App\Entity\Environnement;
use App\Entity\Visite;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Description of VisiteTest
 *
 * @author AurelienSauzet <aurelien.sauzet@orange.fr>
 */
class VisiteTest extends TestCase {
    
    public function testGetDateCreationString() {
        $visite = new Visite();
        $visite->setDatecreation(new DateTime("2134-04-14"));
        $this->assertEquals("14/04/2134", $visite->getDatecreationString());
    }
    
    public function testAddSameEnvironnement() {
        $visite = new Visite();
        $environnement = new Environnement();
        $environnement->setNom("Plage");
         // Ajout d'environnement
        $visite->addEnvironnement($environnement);
        $this->assertCount(1, $visite->getEnvironnements(), "il manque l'environnement ajouté");
         // Impossibilité d'ajouter des doublons d'environnement
        $visite->addEnvironnement($environnement);
        $this->assertCount(1, $visite->getEnvironnements(), "il ne devrait pas y avoir de nouveau environnement");
    }
}
