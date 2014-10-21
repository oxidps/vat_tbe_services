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
 * @copyright (C) OXID eSales AG 2003-2014
 */

/**
 * VAT TBE oxArticle class
 */
class oeVATTBEOxCountry extends oeVATTBEOxCountry_parent
{
    /**
     * Return if TBE VAT is used in this country
     *
     * @return bool
     */
    public function appliesTBEVAT()
    {
        return (bool) $this->oxcountry__oevattbe_appliestbevat->value;
    }

    /**
     * Return true if at least one TBE VAT group configured for this country.
     *
     * @return bool
     */
    public function OEVATTBEIsAtLeastOneGroupConfigured()
    {
        return (bool) $this->oxcountry__oevattbe_istbevatconfigured->value;
    }
}