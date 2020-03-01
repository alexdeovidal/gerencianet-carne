<?php


namespace Source\Helpers;


use Gerencianet\Exception\GerencianetException;
use Source\Models\Carnets;
use Source\Models\Students;
use Source\Models\Tickets;

/**
 * Class Gerencianet
 * @package Source\Helpers
 */
class Gerencianet
{
    /**
     * @var \Gerencianet\Gerencianet
     */
    private $api;
    private $metadata;
    private $body;
    private $id_students;
    private $code;
    private $error;
    private $errorDescription;
    private $message;

    public function __construct()
    {
        $this->api = new \Gerencianet\Gerencianet(CONF_GN_OPTIONS);
        $this->metadata = ['notification_url'=> CONF_URL_GN_NOTIFICATION];
    }

    public function product(string $product, int $amount, int $value): array
    {
        return [
            'name' => $product, // nome do item, produto ou serviço
            'amount' => $amount, // quantidade
            'value' => $value // valor (1000 = R$ 10,00) (Obs: É possível a criação de itens com valores negativos. Porém, o valor total da fatura deve ser superior ao valor mínimo para geração de transações.)
        ];
    }

    public function find(int $id, array $products, string $expire_at, int $repeats): bool
    {
        $this->id_students = $id;
        $this->body = [
            'items' => $products,
            'customer' => $this->customer($id),
            'expire_at' => $expire_at, // data de vencimento da primeira parcela do carnê
            'repeats' => $repeats, // número de parcelas do carnê
            'split_items' => false,
            "metadata" => $this->metadata
        ];
        return true;
    }

    public function save(): bool
    {
        try {
            $carnet = $this->api->createCarnet([], $this->body);

            $Carnets = new Carnets();
            $Carnets->id_students = $this->id_students;
            $Carnets->carnet_id = $carnet["data"]["carnet_id"];
            $Carnets->link = $carnet["data"]["link"];
            $Carnets->status = $carnet["data"]["status"];
            $Carnets->save();

            foreach ($carnet["data"]["charges"] as $value)
            {
                $Tickets = new Tickets();
                $Tickets->id_carnets = $Carnets->data()->id;
                $Tickets->charge_id = $value["charge_id"];
                $Tickets->parcel = $value["parcel"];
                $Tickets->status = $value["status"];
                $Tickets->value = $value["value"];
                $Tickets->expire_at = $value["expire_at"];
                $Tickets->url = $value["url"];
                $Tickets->save();

            }
            return true;
        } catch (GerencianetException $e) {
           $this->code =  $e->code;
           $this->error = $e->error;
           $this->errorDescription = $e->errorDescription;
           return false;
        } catch (Exception $e) {
           $this->message = $e->getMessage();
            return false;
        }
    }

    public function updateParcel(int $carnet_id, int $parcel, string $expire_at): bool
    {
        $params = ['id' => $carnet_id, 'parcel' => $parcel];
        $body = [
            'expire_at' => $expire_at
        ];
        try {
            $carnet = $this->api->updateParcel($params, $body);
            $this->return($carnet_id);
            return true;
        } catch (GerencianetException $e) {
            $this->code =  $e->code;
            $this->error = $e->error;
            $this->errorDescription = $e->errorDescription;
            return false;
        } catch (Exception $e) {
            $this->message = $e->getMessage();
            return false;
        }
    }

    public function cancelCarnet(int $carnet_id): bool
    {
        $params = ['id' => $carnet_id];

        try {
            $carnet = $this->api->cancelCarnet($params, []);
            $this->return($carnet_id);
            return true;
        } catch (GerencianetException $e) {
            $this->code =  $e->code;
            $this->error = $e->error;
            $this->errorDescription = $e->errorDescription;
            return false;
        } catch (Exception $e) {
            $this->message = $e->getMessage();
            return false;
        }
    }

    public function cancelParcel(int $carnet_id, int $parcel): bool
    {
        $params = ['id' => $carnet_id, 'parcel' => $parcel];

        try {
            $carnet = $this->api->cancelParcel($params, []);
            $this->return($carnet_id);
            return true;
        } catch (GerencianetException $e) {
            $this->code =  $e->code;
            $this->error = $e->error;
            $this->errorDescription = $e->errorDescription;
            return false;
        } catch (Exception $e) {
            $this->message = $e->getMessage();
            return false;
        }
    }

    public function error(): void
    {
        echo "
        Cod: {$this->code}<br>
        Erro: {$this->error}<br>
        Descrição: {$this->errorDescription}<br>
        Menssagem: {$this->message}
        ";
    }

    private function customer($id): array
    {
        $Students = new Students();
        $stundent = $Students->findById($id);
        return [
            'name' => $stundent->guardian_name, // nome do cliente
            'cpf' => $stundent->guardian_cpf, // cpf do cliente
            'phone_number' => $stundent->guardian_phone // telefone do cliente
        ];
    }

    private function return(int $carnet_id): bool
    {
        $params = [
            'id' => $carnet_id
        ];

        try {
            $carnet = $this->api->detailCarnet($params, []);
            $Carnets = new Carnets();
            $carnetDB = $Carnets->find("carnet_id=:carnet_id", "carnet_id={$carnet["data"]["carnet_id"]}")->fetch();
            $carnetDB->status = $carnet["data"]["status"];
            $carnetDB->save();

            foreach ($carnet["data"]["charges"] as $value) {
                $Tickets = new Tickets();
                $ticket = $Tickets->find("charge_id=:charge_id", "charge_id={$value["charge_id"]}")->fetch();
                $ticket->status = $value["status"];
                $ticket->expire_at = $value["expire_at"];
                $ticket->save();
            }
            return true;
        } catch (GerencianetException $e) {
            $this->code =  $e->code;
            $this->error = $e->error;
            $this->errorDescription = $e->errorDescription;
            return false;
        } catch (Exception $e) {
            $this->message = $e->getMessage();
            return false;
        }
    }
}