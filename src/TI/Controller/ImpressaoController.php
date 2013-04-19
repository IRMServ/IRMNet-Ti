<?php

namespace TI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Config\Config;
use Zend\Debug\Debug;

class ImpressaoController extends AbstractActionController {

    protected $em;
    protected $aCount = array();

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function indexAction() {
//
//        $file = file("C:\Program Files (x86)\PaperCut Print Logger\logs\csv\daily\papercut-print-log-2013-04-17.csv");
//        $count = array();
//        $aCount = array();
//        for ($i = 2; $i <= count($file); $i++) {
//            @list($Time, $User, $Pages, $Copies, $Printer, $DocumentName, $Client, $PaperSize, $Language, $Height, $Width, $Duplex, $Grayscale, $Size) = explode(',', $file[$i]);
//            if (isset($count[$User])) {
//                $count[$User] += $Pages * $Copies;
//            } else {
//                $count[$User] = $Pages * $Copies;
//            }
//            if (empty($count[$User])) {
//                unset($count[$User]);
//            }
//        }
//        arsort($count);
//        $ldapconfig = $this->getServiceLocator()->get('Config');
//        $ldap = $this->getServiceLocator()->get('Ldap');
//        $config = new Config($ldapconfig['ldap-config'], true);
//        foreach ($count as $key => $value) {
//            $result = $ldap->search("(samaccountname={$key})", $config->server->baseDn, \Zend\Ldap\Ldap::SEARCH_SCOPE_SUB);
//            foreach ($result as $item) {
//                $aCount[$item['displayname'][0]] = $value;
//            }
//        }
//
//
//        return new ViewModel(array('prints' => $aCount));
        
        
        
        $file = file("C:\Program Files (x86)\PaperCut Print Logger\logs\csv\daily\papercut-print-log-2013-04-17.csv");
        $count = array();
        $aCount = array();
        for ($i = 2; $i <= count($file); $i++) {
            @list($Time, $User, $Pages, $Copies, $Printer, $DocumentName, $Client, $PaperSize, $Language, $Height, $Width, $Duplex, $Grayscale, $Size) = explode(',', $file[$i]);
            if (isset($count[$User])) {
                $count[$User] += $Pages * $Copies;
            } else {
                $count[$User] = $Pages * $Copies;
            }
            if (empty($count[$User])) {
                unset($count[$User]);
            }
        }
        arsort($count);
        $ldapconfig = $this->getServiceLocator()->get('Config');
        $ldap = $this->getServiceLocator()->get('Ldap');
        $config = new Config($ldapconfig['ldap-config'], true);
        $lugares = array();
        $old = 0;
        foreach ($count as $key => $value) {
            $result = $ldap->search("(samaccountname={$key})", $config->server->baseDn, \Zend\Ldap\Ldap::SEARCH_SCOPE_SUB);
            $item = $result->toArray();
            if ($value == $old) {

                @$lugares[$value] .= ', ' . $item[0]['displayname'][0];
            } else {

                $old = $value;
                @$lugares[$value] .= ', ' . $item[0]['displayname'][0];
            }
        }

        return new ViewModel(array('prints' => $lugares));
    }

    public function ordemdescAction() {

        $file = file("C:\Program Files (x86)\PaperCut Print Logger\logs\csv\daily\papercut-print-log-2013-04-17.csv");
        $count = array();
        $aCount = array();
        for ($i = 2; $i <= count($file); $i++) {
            @list($Time, $User, $Pages, $Copies, $Printer, $DocumentName, $Client, $PaperSize, $Language, $Height, $Width, $Duplex, $Grayscale, $Size) = explode(',', $file[$i]);
            if (isset($count[$User])) {
                $count[$User] += $Pages * $Copies;
            } else {
                $count[$User] = $Pages * $Copies;
            }
            if (empty($count[$User])) {
                unset($count[$User]);
            }
        }
        arsort($count);
        $ldapconfig = $this->getServiceLocator()->get('Config');
        $ldap = $this->getServiceLocator()->get('Ldap');
        $config = new Config($ldapconfig['ldap-config'], true);
        foreach ($count as $key => $value) {
            $result = $ldap->search("(samaccountname={$key})", $config->server->baseDn, \Zend\Ldap\Ldap::SEARCH_SCOPE_SUB);
            foreach ($result as $item) {
                $aCount[$item['displayname'][0]] = $value;
            }
        }


        return new ViewModel(array('prints' => $aCount));
    }

    public function ordemcresAction() {


        $file = file("C:\Program Files (x86)\PaperCut Print Logger\logs\csv\daily\papercut-print-log-2013-04-17.csv");
        $count = array();
        $aCount = array();
        for ($i = 2; $i <= count($file); $i++) {
            @list($Time, $User, $Pages, $Copies, $Printer, $DocumentName, $Client, $PaperSize, $Language, $Height, $Width, $Duplex, $Grayscale, $Size) = explode(',', $file[$i]);
            if (isset($count[$User])) {
                $count[$User] += $Pages * $Copies;
            } else {
                $count[$User] = $Pages * $Copies;
            }
            if (empty($count[$User])) {
                unset($count[$User]);
            }
        }
        asort($count);
        $ldapconfig = $this->getServiceLocator()->get('Config');
        $ldap = $this->getServiceLocator()->get('Ldap');
        $config = new Config($ldapconfig['ldap-config'], true);
        $lugares = array();
        $old = 0;
        foreach ($count as $key => $value) {
            $result = $ldap->search("(samaccountname={$key})", $config->server->baseDn, \Zend\Ldap\Ldap::SEARCH_SCOPE_SUB);
            $item = $result->toArray();
            if ($value == $old) {

                @$lugares[$value] .= ', ' . $item[0]['displayname'][0];
            } else {

                $old = $value;
                @$lugares[$value] .= ', ' . $item[0]['displayname'][0];
            }
        }

        return new ViewModel(array('prints' => $lugares));
    }

}