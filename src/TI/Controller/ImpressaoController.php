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
//        $lugares = array();
//        $old = 0;
//        foreach ($count as $key => $value) {
//            $result = $ldap->search("(samaccountname={$key})", $config->server->baseDn, \Zend\Ldap\Ldap::SEARCH_SCOPE_SUB);
//            $item = $result->toArray();
//            if ($value == $old) {
//
//                @$lugares[$value] .= ', ' . $item[0]['displayname'][0];
//            } else {
//
//                $old = $value;
//                @$lugares[$value] .= ', ' . $item[0]['displayname'][0];
//            }
//        }
        $pattern = "C:\Program Files (x86)\PaperCut Print Logger\logs\csv\monthly\*.csv";
        $periodo = array();
        $total = 0;
        foreach (glob($pattern) as $file) {
            $arq = file($file);

            for ($i = 2; $i <= count($arq); $i++) {
                @list($Time, $User, $Pages, $Copies, $Printer, $DocumentName, $Client, $PaperSize, $Language, $Height, $Width, $Duplex, $Grayscale, $Size) = explode(',', $arq[$i]);
                $total += $Pages * $Copies;
            }

            $extract = explode('\\', $file);
            $slices = explode('-', end($extract));
            $mes = $slices[count($slices) - 1];
            $ano = $slices[count($slices) - 2];
            $periodo['mes'][] = str_replace('.csv', '', $mes);
            $periodo['ano'][] = $ano;
            $periodo['total'][] = $total;
        }


        return new ViewModel(array('periodos' => $periodo));
    }

    public function periodoAction() {
        $mes = $this->params()->fromRoute('mes');
        $ano = $this->params()->fromRoute('ano');
        
        $file= "C:\Program Files (x86)\PaperCut Print Logger\logs\csv\monthly\papercut-print-log-{$mes}-{$ano}.csv";
       
        $dia = array();
        $lines = file($file);

        for ($i = 2; $i <= count($lines)-1; $i++) {
            @list($Time, $User, $Pages, $Copies, $Printer, $DocumentName, $Client, $PaperSize, $Language, $Height, $Width, $Duplex, $Grayscale, $Size) = explode(',', $lines[$i]);
            $d = explode(' ', $Time);
         
            $d = implode('/', array_reverse(explode('-', $d[0])));
            if (isset($dia[$d])) {
                $dia[$d] += $Pages * $Copies;
            } else {
                $dia[$d] = $Pages * $Copies;
            }
        }




        return new ViewModel(array('dia' => $dia,'mes'=>$ano,'ano'=>$mes));
    }
    
    public function detalhediaAction()
    {
          $data = $this->params()->fromRoute('data');
        
    }

}