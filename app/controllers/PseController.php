<?php
/***********************************************************/
//Autor: Arley Mauricio Santana Vargas
//Email: arleysantana18@gmail.com
//Descripción: Controlador para la consulta y creación de transacciones
//por medio de PSE.
/***********************************************************/
class PseController extends BaseController {

    /*
     * Página de inicio
     * Muestra el listado de las transacciones realizadas
     * y permite crear una nueva transacción
     */
    public function home() {
        $transactions = TransactionResult::orderBy('created_at', 'DESC')->get();
        return View::make('home', compact('transactions'));
    }

    /*
     * Crea la vista que muestra el formulario para una
     * nueva transacción
     */
    public function formPayment() {
        $message = Session::get('message');
        $banks = $this->getAndUpdateBankList();
        $objPse = new Pse();
        $documenTypes = $objPse->getDocumentTypes();
        $bank_interfaces = $objPse->getBankInterfaces();
        return View::make('createPayment', compact('banks', 'documenTypes', 'message', 'bank_interfaces'));
    }

    /*
     * Recibe la información del formulario de crear pago y 
     * crea la transacción por medio del web service de pse
     * en caso de realizarse correctamente la transacción
     * el método redirige a la url del banco, en caso contrario
     * muestra el error por el cual no se pudo crear la transacción
     */
    public function createPayment() {
        if (Request::isMethod('post')) {
            $ip = $_SERVER['REMOTE_ADDR'];
            $agent = substr($_SERVER['HTTP_USER_AGENT'], 0, 254);
            $returnURL = url('/endPayment');
            $objPse = new Pse();
            $result = $objPse->createTransaction(Request::all(), $ip, $agent, $returnURL);
            if ($result['result']) {
                $response = $result['response'];
                Session::put('PSETransactionID', $response->createTransactionResult->transactionID);
                if (isset($response->createTransactionResult->returnCode) && $response->createTransactionResult->returnCode == 'SUCCESS') {
                    $this->saveResponse($response->createTransactionResult, 'create', $result['xml_request'], $result['xml_response']);
                    return Redirect::to($response->createTransactionResult->bankURL);
                } else {
                    $message = 'La transacción no se realizó correctamente.';
                }
            } else {
                $message = $result['message'];
            }
            return Redirect::to('/createPayment')->with('message', $message);
        }
        return Redirect::to('/createPayment');
    }
    
    /*
     * Es el punto de llegada cuando finaliza el proceso en el banco
     * aquí se consulta la información sobre la transacción 
     * y se muestra un mensaje con el resultado de la misma
     */

    public function endPayment() {
        $transactionID = Session::get('PSETransactionID');
        $transactionID = 1442838501;
        if (empty($transactionID)) {
            $message = 'No se tiene la información necesaria para terminar la acción';
            return View::make('endPayment', compact('message'));
        }
        $objPse = new Pse();
        $result = $objPse->getTransactionInfo($transactionID);
        if (!$result['result']) {
            $message = $result['message'];
            return View::make('endPayment', compact('message'));
        }
        Session::forget('PSETransactionID');
        $info = $result['response']->getTransactionInformationResult;
        $this->saveResponse($info, 'finish', $result['xml_request'], $result['xml_response']);
        switch ($info->transactionState) {
            case 'OK':
                $message = 'La transacción se realizó satisfactoriamente';
                break;
            case 'NOT_AUTHORIZED':
                $message = 'La transacción no ha sido autorizada, motivo: ' . $info->responseReasonText;
                break;
            case 'PENDING':
                $message = 'La transacción se encuentra pendiente, motivo: ' . $info->responseReasonText;
                break;
            case 'FAILED':
                $message = 'La transacción falló, motivo: ' . $info->responseReasonText;
                break;
        }
        return View::make('endPayment', compact('message'));
    }

    /*
     * Método para consultar los bancos de la BD
     * los bancos se actualizan una vez al día por
     * medio del web service
     */
    private function getAndUpdateBankList() {
        $last_update = Bank::get()->max('updated_at');
        $toDay = date('Y-m-d 00:00:00');
        if (empty($last_update) || $last_update < $toDay) {
            $objPse = new Pse();
            $arrBaks = $objPse->getBankList();
            if (!empty($arrBaks) && isset($arrBaks->getBankListResult->item)) {
                Bank::whereNotNull('id')->delete();
                foreach ($arrBaks->getBankListResult->item as $bank) {
                    $newBank = new Bank();
                    $newBank->bank_code = $bank->bankCode;
                    $newBank->bank_name = $bank->bankName;
                    $newBank->save();
                }
            }
        }

        $banks = Bank::all()->lists('bank_name', 'bank_code');
        return $banks;
    }

    /*
     * Guarda la respuesta de la transaacción en base de datos
     */
    private function saveResponse($response, $type, $xmlRequest, $xmlResponse) {
        $newResult = new TransactionResult();
        $newResult->type = $type;
        $newResult->xml_request = $xmlRequest;
        $newResult->xml_response = $xmlResponse;
        foreach ($response as $key => $value) {
            $newResult->$key = $value;
        }
        return $newResult->save();
    }

}
