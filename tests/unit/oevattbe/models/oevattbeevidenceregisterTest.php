<?php
/**
 * This file is part of OXID eSales VAT TBE module.
 *
 * OXID eSales PayPal module is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eSales PayPal module is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eSales VAT TBE module.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2014T
 */

/**
 * Test class for oeVATTBEEvidenceRegister.
 *
 * @covers oeVATTBEEvidenceRegister
 */
class Unit_oeVATTBE_Models_oeVATTBEEvidenceRegisterTest extends OxidTestCase
{

    /**
     * No evidences are registered;
     * New evidence is passed for registration;
     * Evidence should get registered.
     *
     * @return oeVATTBEEvidenceRegister
     */
    public function testRegisteringEvidenceWhenNoEvidencesRegistered()
    {
        $oConfig = oxRegistry::getConfig();
        $oConfig->setConfigParam('aOeVATTBECountryEvidences', array());
        $oConfig->setConfigParam('aOeVATTBECountryEvidenceClasses', array());

        /** @var oeVATTBEEvidenceRegister $oCollector */
        $oRegister = oxNew('oeVATTBEEvidenceRegister', $oConfig);
        $oRegister->registerEvidence('oeVATTBEBillingCountryEvidence');

        $this->assertEquals(array('oeVATTBEBillingCountryEvidence'), $oRegister->getRegisteredEvidences());

        return $oRegister;
    }

    /**
     * No evidences are registered;
     * New evidence is passed for registration with default activation value;
     * Evidence should be added to active evidences list, but be inactive.
     *
     * @param oeVATTBEEvidenceRegister $oRegister
     *
     * @depends testRegisteringEvidenceWhenNoEvidencesRegistered
     */
    public function testActivatingEvidenceAfterSuccessfulRegistration($oRegister)
    {
        $this->assertEquals(array('billing_country' => 0), $oRegister->getActiveEvidences());
    }

    /**
     * Default evidences are registered;
     * New evidence is passed for registration;
     * Evidence should get registered without removing default evidences.
     */
    public function testRegisteringEvidenceWhenDefaultEvidencesRegistered()
    {
        $oConfig = oxRegistry::getConfig();
        $oConfig->setConfigParam('aOeVATTBECountryEvidences', array());
        $oConfig->setConfigParam('aOeVATTBECountryEvidenceClasses', array('oeDefaultEvidence1', 'oeDefaultEvidence2'));

        /** @var oeVATTBEEvidenceRegister $oCollector */
        $oRegister = oxNew('oeVATTBEEvidenceRegister', $oConfig);
        $oRegister->registerEvidence('oeVATTBEBillingCountryEvidence');

        $aExpectedEvidences = array('oeDefaultEvidence1', 'oeDefaultEvidence2', 'oeVATTBEBillingCountryEvidence');
        $this->assertEquals($aExpectedEvidences, $oRegister->getRegisteredEvidences());
    }

    /**
     * Inactive evidence exist;
     * Inactive evidence id is passed;
     * Evidence should be activated.
     */
    public function testActivatingEvidenceWhenItIsRegistered()
    {
        $oConfig = oxRegistry::getConfig();
        $oConfig->setConfigParam('aOeVATTBECountryEvidences', array('InactiveEvidenceId' => 0));

        /** @var oeVATTBEEvidenceRegister $oCollector */
        $oRegister = oxNew('oeVATTBEEvidenceRegister', $oConfig);
        $oRegister->activateEvidence('InactiveEvidenceId');

        $this->assertEquals(array('InactiveEvidenceId' => 1), $oRegister->getActiveEvidences());
    }

    /**
     * Active evidence exist;
     * Active evidence id is passed;
     * Evidence should be deactivated.
     */
    public function testDeactivatingEvidenceWhenItIsRegistered()
    {
        $oConfig = oxRegistry::getConfig();
        $oConfig->setConfigParam('aOeVATTBECountryEvidences', array('InactiveEvidenceId' => 1));

        /** @var oeVATTBEEvidenceRegister $oCollector */
        $oRegister = oxNew('oeVATTBEEvidenceRegister', $oConfig);
        $oRegister->deactivateEvidence('InactiveEvidenceId');

        $this->assertEquals(array('InactiveEvidenceId' => 0), $oRegister->getActiveEvidences());
    }

    /**
     * No evidences are registered;
     * Non existing evidence id is passed;
     * Nothing should be changed.
     */
    public function testDeactivatingEvidenceWhenItIsNotRegistered()
    {
        $oConfig = oxRegistry::getConfig();
        $oConfig->setConfigParam('aOeVATTBECountryEvidences', array());

        /** @var oeVATTBEEvidenceRegister $oCollector */
        $oRegister = oxNew('oeVATTBEEvidenceRegister', $oConfig);
        $oRegister->activateEvidence('NonExistingEvidenceId');

        $this->assertEquals(array(), $oRegister->getActiveEvidences());
    }
}
