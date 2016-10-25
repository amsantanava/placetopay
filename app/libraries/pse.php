<?php

/***********************************************************/
//Autor: Arley Mauricio Santana Vargas
//Email: arleysantana18@gmail.com
//Descripción: Linbrería para consumir los web services de PSE.
/***********************************************************/


class Pse {

    private $wsdl = null;
    private $tranKey = null;

    public function __construct() {
        $this->wsdl = 'https://test.placetopay.com/soap/pse/?wsdl';
        $this->tranKey = '024h1IlD';
    }

    /*
     * Consulta la lista de bancos
     */
    public function getBankList() {
        $client = new SoapClient($this->wsdl, array("trace" => 1));
        
        try {
            $arrBanks = $client->getBankList(array('auth' => $this->getAuth()));
            
        } catch (Exception $ex) {
            $arrBanks = array();
        }
        return $arrBanks;
    }

    /*
     * Crea una transacción en PSE para iniciar el proceso de pago
     */
    public function createTransaction($data, $ip, $agent, $returnUrl){
        $parameters = $this->createParamsTransaction($data, $ip, $agent, $returnUrl);
        $client = new SoapClient($this->wsdl, array("trace" => 1));
        $result = array(
            'result' => false,
        );
        try{
            $result['response'] = $client->createTransaction($parameters);
            $result['xml_request'] = htmlentities(str_ireplace('><', ">\n<", $client->__getLastRequest()));
            $result['xml_response'] = htmlentities(str_ireplace('><', ">\n<", $client->__getLastResponse()));
            $result['result'] = true;
        } catch (Exception $ex) {
            $result['message'] = $ex->getMessage();
        }
        return $result;
    }
    
    /*
     * Consulta la información de una transacción usando
     * el transactionID devuelto en la respuesta de
     * createTransaction
     */
    public function getTransactionInfo($transactionID){
        $client = new SoapClient($this->wsdl, array("trace" => 1));
        $result = array(
            'result' => false,
        );
        try {
            $result['response'] = $client->getTransactionInformation(array('auth' => $this->getAuth(), 'transactionID' => $transactionID));
            $result['xml_request'] = htmlentities(str_ireplace('><', ">\n<", $client->__getLastRequest()));
            $result['xml_response'] = htmlentities(str_ireplace('><', ">\n<", $client->__getLastResponse()));
            $result['result'] = true;
        } catch (Exception $ex) {
            $result['message'] = $ex->getMessage();
        }
        return $result;
    }

    /*
     * Devuelve las interfaces bancarias disponibles
     */
    public function getBankInterfaces(){
        return array(0 => 'Persona', 1 => 'Empresa');
    }
    
    /*
     * Devuelve un listado de tipos de documentos disponibles
     */
    public function getDocumentTypes(){
        return array(
                'CC' => 'Cédula de ciudanía colombiana', 
                'CE' => 'Cédula de extranjería',
                'TI' => 'Tarjeta de identidad',
                'PPN' => 'Pasaporte',
                'NIT' => 'Número de identificación tributaria',
                'SSN' => 'Social Security Number'
            );
    }
    
    
    /*
     * Arma la información necesaria para la autenticación
     * en el web service
     */
    private function getAuth() {
        $seed = date('c');
        $hash = sha1($seed . $this->tranKey, false);
        $arrCredentials = array(
            'login' => '6dd490faf9cb87a9862245da41170ff2',
            'tranKey' => $hash,
            'seed' => $seed
        );
        return (object) $arrCredentials;
    }
    
    /*
     * Arma la información necesario para 
     * crear una nueva transacción
     */
    
    private function createParamsTransaction($data, $ip, $agent, $returnUrl) {
        $transaction = array(
            'bankCode' => $data['bankCode'],
            'bankInterface' => $data['bankInterface'],
            'returnURL' => $returnUrl,
            'reference' => md5(date('YmdHis')),
            'description' => 'Prueba pago',
            'language' => 'ES',
            'currency' => 'COP',
            'totalAmount' => 100,
            'taxAmount' => 0,
            'devolutionBase' => 0,
            'tipAmount' => 0,
            'payer' => $this->getPayer($data['payer']),
            'buyer' => $this->getBuyer(),
            'shipping' => $this->getShipping(),
            'ipAddress' => $ip,
            'userAgent' => $agent,
        );
        $authorization = $this->getAuth();
        return array(
            'transaction' => $transaction,
            'auth' => $authorization
        );
    }

    /*
     * Devuelve la información del pagador
     */
    private function getPayer($data) {
        $payer = $data;
        $payer['country'] = 'CO';
        return $payer;
    }

    /*
     * Devuelve la información del comprador
     */
    private function getBuyer() {
        $buyer = array(
            'documentType' => 'CC',
            'document' => '1128439296',
            'firstName' => 'Arley',
            'lastName' => 'Santana',
            'company' => 'Prueba',
            'emailAddress' => 'arleysantana18@gmail.com',
            'address' => 'CL 23',
            'city' => 'Medellín',
            'province' => 'Antioquia',
            'country' => 'CO',
            'phone' => '2127361',
            'mobile' => '3155422003'
        );
        return $buyer;
    }
    
    /*
     * Devuelve la información de quien envía
     */

    private function getShipping() {
        $shipping = array(
            'documentType' => 'CC',
            'document' => '1128439296',
            'firstName' => 'Arley',
            'lastName' => 'Santana',
            'company' => 'Prueba',
            'emailAddress' => 'arleysantana18@gmail.com',
            'address' => 'CL 23',
            'city' => 'Medellín',
            'province' => 'Antioquia',
            'country' => 'CO',
            'phone' => '2127361',
            'mobile' => '3155422003'
        );
        return $shipping;
    }

}
