<?php

/**
 * @author Amasty Team
 * @copyright Copyright (c) 2018 Amasty (https://www.amasty.com)
 * @package Amasty_Geoip
 */
class Amasty_Geoip_Model_Geolocation extends Varien_Object
{
    public function locate($ip)
    {
        if (!empty($ip)) {
            $ip = str_replace(' ', '', $ip);
            $ip = explode(',', $ip);
            $ip = $ip[0];

            //$ip = '213.184.225.37';//Minsk
            $ip = substr($ip, 0, strrpos($ip, ".")) . '.0'; // Mask IP according to EU GDPR law

            /* @var Amasty_Geoip_Model_Import $geoIpModel */
            $geoIpModel = Mage::getModel('amgeoip/import');
            if ($geoIpModel->isDone()) {
                $db = Mage::getSingleton('core/resource')->getConnection('core_read');
                $longIP = sprintf("%u", ip2long($ip));
                $select = $db->select()
                    ->from(array('l' => Mage::getSingleton('core/resource')->getTableName('amgeoip/location')))
                    ->join(
                        array('b' => Mage::getSingleton('core/resource')->getTableName('amgeoip/block')),
                        'b.geoip_loc_id = l.geoip_loc_id',
                        array('postal_code', 'longitude', 'latitude')
                    )
                    ->where("$longIP between b.start_ip_num and b.end_ip_num")
                    ->limit(1);

                if ($res = $db->fetchRow($select))
                    $this->setData($res);
            }
        }

        return $this;
    }
}