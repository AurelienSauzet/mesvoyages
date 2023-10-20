<?php

namespace App\Tests;

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
        $visite->setDatecreation(new \DateTime("2134-04-14"));
        $this->assertEquals("14/04/2134", $visite->getDatecreationString());
    }
}
