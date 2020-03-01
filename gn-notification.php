<?php
require __DIR__ . "/vendor/autoload.php";

//$postData = file_get_contents("php://input");
//$name = 'retornoboletosimples.txt';
//$text = var_export($postData, true);
//$file = fopen($name, 'a');
//fwrite($file, $text);
//fclose($file);

$token = $_POST["notification"];

$params = [
    'token' => $token
];

try {
    $api = new \Gerencianet\Gerencianet(CONF_GN_OPTIONS);
    $chargeNotification = $api->getNotification($params, []);

    foreach ($chargeNotification["data"] as $value) {

        if (empty($value["identifiers"]["charge_id"])) {
            $Carnets = new \Source\Models\Carnets();
            $carnet = $Carnets->find("carnet_id=:carnet_id", "carnet_id={$value["identifiers"]["carnet_id"]}")->fetch();
            $carnet->status = $value["status"]["current"];
            $carnet->save();
        }else{
            $Tickets = new \Source\Models\Tickets();
            $ticket = $Tickets->find("charge_id=:charge_id","charge_id={$value["identifiers"]["charge_id"]}")->fetch();
            $ticket->status = $value["status"]["current"];
            $ticket->save();
        }
    }

} catch (\Gerencianet\Exception\GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}