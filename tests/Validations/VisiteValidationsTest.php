<?php

namespace App\Tests\Validations;

use App\Entity\Visite;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of VisiteValidationsTest
 *
 * @author AurelienSauzet <aurelien.sauzet@orange.fr>
 */
class VisiteValidationsTest extends KernelTestCase {
    
    /**
     * Utilisation du Kernel pour tester une règle de validation
     * @param Visite $visite
     * @param int $nbErreursAttendues
     * @param string $message
     */
    public function assertErrors(Visite $visite, int $nbErreursAttendues, string $message=""){
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($visite);
        $this->assertCount($nbErreursAttendues, $error, $message);
    }
    
    public function getVisite(): Visite {
        return (new Visite())
                ->setVille("New York")
                ->setPays("USA");
    }
    
    public function testValidNoteVisite() {
         // Note minimale possible
        $this->assertErrors($this->getVisite()->setNote(0), 0, "0 devrait être valide");
         // Note quelconque entre les bornes
        $this->assertErrors($this->getVisite()->setNote(10), 0, "10 devrait être valide");
         // Note maximale possible
        $this->assertErrors($this->getVisite()->setNote(20), 0, "20 devrait être valide");
    }
    
    public function testNonValidNoteVisite() {
         // Note quelconque invalide en dessous de la limite imposée
        $this->assertErrors($this->getVisite()->setNote(-413), 1, "-413 ne devrait pas être valide");
         // Note invalide juste en dessous de la limite imposée
        $this->assertErrors($this->getVisite()->setNote(-1), 1, "-1 ne devrait pas être valide");
         // Note invalide juste au dessus de la limite imposée
        $this->assertErrors($this->getVisite()->setNote(21), 1, "21 ne devrait pas être valide");
         // Note quelconque invalide au-delà de la limite imposée
        $this->assertErrors($this->getVisite()->setNote(43), 1, "43 ne devrait pas être valide");
    }
    
    public function testValideTempmaxVisite() {
         // Comparer deux températures valides qui se suivent
        $this->assertErrors($this->getVisite()
                ->setTempmin(20)
                ->setTempmax(21), 0, "min=20, max=21 devrait être valide");
         // Comparer deux températures valides éloignées
        $this->assertErrors($this->getVisite()
                ->setTempmin(0)
                ->setTempmax(200), 0, "min=0, max=200 devrait être valide");
    }
    
    public function testNonValideTempmaxVisite() {
         // Comparer deux températures inversées qui se suivent
        $this->assertErrors($this->getVisite()
                ->setTempmin(20)
                ->setTempmax(19), 1, "min=20, max=19 devrait échouer");
         // Comparer deux températures inversées éloignées
        $this->assertErrors($this->getVisite()
                ->setTempmin(200)
                ->setTempmax(0), 1, "min=202, max=0 devrait échouer");
    }
    
    public function testDateVisite() {
         // Date antérieure à aujourd'hui valide
        $this->assertErrors($this->getVisite()->setNote(0), 0, "0 devrait être valide");
         // Date égale à aujourd'hui valide
        $this->assertErrors($this->getVisite()->setNote(10), 0, "10 devrait être valide");
         // Date postérieure à aujourd'hui invalide
        $this->assertErrors($this->getVisite()->setNote(20), 0, "20 devrait être valide");
    }
}
