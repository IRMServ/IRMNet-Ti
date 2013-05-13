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

        $file = "C:\Program Files (x86)\PaperCut Print Logger\logs\csv\monthly\papercut-print-log-{$ano}-{$mes}.csv";

        $dia = array();
        $lines = file($file);

        for ($i = 2; $i <= count($lines) - 1; $i++) {
            @list($Time, $User, $Pages, $Copies, $Printer, $DocumentName, $Client, $PaperSize, $Language, $Height, $Width, $Duplex, $Grayscale, $Size) = explode(',', $lines[$i]);
            $d = explode(' ', $Time);

            $d = implode('/', array_reverse(explode('-', $d[0])));
            if (isset($dia[$d])) {
                $dia[$d] += $Pages * $Copies;
            } else {
                $dia[$d] = $Pages * $Copies;
            }
        }




        return new ViewModel(array('dia' => $dia, 'mes' => $mes, 'ano' => $ano));
    }

    public function detalhediaAction() {
        $data = $this->params()->fromRoute('data');
        list($dia, $mes, $ano) = explode('-', $data);

        $file = file("C:\Program Files (x86)\PaperCut Print Logger\logs\csv\monthly\papercut-print-log-{$ano}-{$mes}.csv");
        $count = array();
        $aCount = array();
        for ($i = 2; $i <= count($file); $i++) {
            @list($Time, $User, $Pages, $Copies, $Printer, $DocumentName, $Client, $PaperSize, $Language, $Height, $Width, $Duplex, $Grayscale, $Size) = explode(',', $file[$i]);
            $ext = explode(' ', $Time);
            $datac = implode('-', array_reverse(explode('-', $ext[0])));
            
            if ($datac == $data) {
                if (isset($count[$User])) {
                   
                    $count[$User] += $Pages * $Copies;
                } else {
                    $count[$User] = $Pages * $Copies;
                }
                if (empty($count[$User])) {
                    unset($count[$User]);
                }
            }
        }


        arsort($count);
        $ldapconfig = $this->getServiceLocator()->get('Config');
        $ldap = $this->getServiceLocator()->get('Ldap');
        $config = new Config($ldapconfig['ldap-config'], true);
        $user = array();
        foreach ($count as $key => $value) {
            $result = $ldap->search("(samaccountname={$key})", $config->server->baseDn, \Zend\Ldap\Ldap::SEARCH_SCOPE_SUB);
            foreach ($result as $item) {
                if (isset($item['displayname'])) {
                    $aCount[$item['displayname'][0]] = $value;
                    $user[] = $key;
                }
            }
        }
        return new ViewModel(array('dados' => $aCount, 'user' => $user, 'periodo' => $data,'mes'=>$mes,'ano'=>$ano));
    }
    public function detalhediaprinterAction() {
        $data = $this->params()->fromRoute('data');
     
        list($dia, $mes, $ano) = explode('-', $data);

        $file = file("C:\Program Files (x86)\PaperCut Print Logger\logs\csv\monthly\papercut-print-log-{$ano}-{$mes}.csv");
        $count = array();
        $aCount = array();
        for ($i = 2; $i <= count($file); $i++) {
            @list($Time, $User, $Pages, $Copies, $Printer, $DocumentName, $Client, $PaperSize, $Language, $Height, $Width, $Duplex, $Grayscale, $Size) = explode(',', $file[$i]);
            $ext = explode(' ', $Time);
            $datac = implode('-', array_reverse(explode('-', $ext[0])));
            
            if ($datac == $data) {
                if (isset($count[$Printer])) {
                   
                    $count[$Printer] += $Pages * $Copies;
                } else {
                    $count[$Printer] = $Pages * $Copies;
                }
                if (empty($count[$Printer])) {
                    unset($count[$Printer]);
                }
            }
        }


        arsort($count);
        
       
        return new ViewModel(array('dados' => $count,  'periodo' => $data,'mes'=>$mes,'ano'=>$ano));
    }

    public function detalheusuarioAction() {
        $data = $this->params()->fromRoute('periodo');
        $usuario = $this->params()->fromRoute('usuario');
        list($dia, $mes, $ano) = explode('-', $data);

        $file = file("C:\Program Files (x86)\PaperCut Print Logger\logs\csv\monthly\papercut-print-log-{$ano}-{$mes}.csv");

        $documentos = array();

        for ($i = 2; $i <= count($file); $i++) {
            @list($Time, $User, $Pages, $Copies, $Printer, $DocumentName, $Client, $PaperSize, $Language, $Height, $Width, $Duplex, $Grayscale, $Size) = explode(',', $file[$i]);
            $datac = explode(' ', $Time);
           
            if (($usuario == $User) && (implode('-', array_reverse(explode('-', $datac[0]))) == $data )) {

                if (!array_key_exists($DocumentName, $documentos)) {
                    $documentos[$DocumentName] = $Pages * $Copies;
                }
                else
                {
                     $documentos[$DocumentName] += $Pages * $Copies;
                }
            }
        }




        $ldapconfig = $this->getServiceLocator()->get('Config');
        $ldap = $this->getServiceLocator()->get('Ldap');
        $config = new Config($ldapconfig['ldap-config'], true);
        $nome = '';

        $result = $ldap->search("(samaccountname={$usuario})", $config->server->baseDn, \Zend\Ldap\Ldap::SEARCH_SCOPE_SUB);
        foreach ($result as $item) {
            $nome = $item['displayname'][0];
        }

        return new ViewModel(array('dados' => $documentos, 'user' => $nome, 'periodo' => $data));
    }
    public function detalheprinterAction() {
        $data = $this->params()->fromRoute('periodo');
        $usuario = $this->params()->fromRoute('printer');
        
        list($dia, $mes, $ano) = explode('-', $data);

        $file = file("C:\Program Files (x86)\PaperCut Print Logger\logs\csv\monthly\papercut-print-log-{$ano}-{$mes}.csv");

        $documentos = array();

        for ($i = 2; $i <= count($file); $i++) {
            @list($Time, $User, $Pages, $Copies, $Printer, $DocumentName, $Client, $PaperSize, $Language, $Height, $Width, $Duplex, $Grayscale, $Size) = explode(',', $file[$i]);
            $datac = explode(' ', $Time);
           
            if ((urldecode($usuario) == $Printer) && (implode('-', array_reverse(explode('-', $datac[0]))) == $data )) {

                if (!array_key_exists($DocumentName, $documentos)) {
                    $documentos[$DocumentName] = $Pages * $Copies;
                }
                else
                {
                     $documentos[$DocumentName] += $Pages * $Copies;
                }
            }
        }




        

        return new ViewModel(array('dados' => $documentos, 'user' => $usuario, 'periodo' => $data));
    }

}