<?php

namespace TI\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Config\Config;

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

        $file = file("C:\Program Files (x86)\PaperCut Print Logger\logs\csv\daily\papercut-print-log-2013-04-17.csv");
        $count = array();
        $aCount = array();
        for ($i = 2; $i <= count($file); $i++) {
            @list($Time, $User, $Pages, $Copies, $Printer, $DocumentName, $Client, $PaperSize, $Language, $Height, $Width, $Duplex, $Grayscale, $Size) = explode(',', $file[$i]);
            if (isset($count[$User])) {
                $count[$User] += $Pages;
            } else {
                $count[$User] = $Pages;
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
        

        return new ViewModel(array('prints'=>$aCount));
    }
    public function ordemdescAction() {

        $file = file("C:\Program Files (x86)\PaperCut Print Logger\logs\csv\daily\papercut-print-log-2013-04-17.csv");
        $count = array();
        $aCount = array();
        for ($i = 2; $i <= count($file); $i++) {
            @list($Time, $User, $Pages, $Copies, $Printer, $DocumentName, $Client, $PaperSize, $Language, $Height, $Width, $Duplex, $Grayscale, $Size) = explode(',', $file[$i]);
            if (isset($count[$User])) {
                $count[$User] += $Pages;
            } else {
                $count[$User] = $Pages;
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
        

        return new ViewModel(array('prints'=>$aCount));
    }
    public function ordemcresAction() {

        $file = file("C:\Program Files (x86)\PaperCut Print Logger\logs\csv\daily\papercut-print-log-2013-04-17.csv");
        $count = array();
        $aCount = array();
        for ($i = 2; $i <= count($file); $i++) {
            @list($Time, $User, $Pages, $Copies, $Printer, $DocumentName, $Client, $PaperSize, $Language, $Height, $Width, $Duplex, $Grayscale, $Size) = explode(',', $file[$i]);
            if (isset($count[$User])) {
                $count[$User] += $Pages;
            } else {
                $count[$User] = $Pages;
            }
            if (empty($count[$User])) {
                unset($count[$User]);
            }
        }
        sort($count);
        $ldapconfig = $this->getServiceLocator()->get('Config');
        $ldap = $this->getServiceLocator()->get('Ldap');
        $config = new Config($ldapconfig['ldap-config'], true);
        foreach ($count as $key => $value) {
            $result = $ldap->search("(samaccountname={$key})", $config->server->baseDn, \Zend\Ldap\Ldap::SEARCH_SCOPE_SUB);
            foreach ($result as $item) {
                $aCount[$item['displayname'][0]] = $value;
            }
        }
        

        return new ViewModel(array('prints'=>$aCount));
    }

}