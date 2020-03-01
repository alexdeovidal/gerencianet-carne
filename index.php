<?php
require __DIR__ . "/vendor/autoload.php";

$Students = new \Source\Models\Students();
$student = $Students->find()->fetch();
$gn = new \Source\Helpers\Gerencianet();
//CRIANDO BOLETO
/*
$product = $gn->product("Mensalidade",1,5000);
$product2 = $gn->product("Mensalidade 2",1,1000);

$gn->find($student->id, [$product, $product2], "2020-03-10",12);
$gn->save();
*/
//ATUALIZANDO DATA DO BOLETO
//if(!$gn->updateParcel("47680", 12,"2022-11-11"))
//{
//    $gn->error();;
//}else{
//    echo "data alterada com sucesso";
//}

//if(!$gn->cancelParcel("47680", 12))
//{
//    $gn->error();;
//}else{
//    echo "parcela cancelada com sucesso";
//}

//if(!$gn->cancelCarnet("47680"))
//{
//    $gn->error();;
//}else{
//    echo "carne cancelado com sucesso";
//}
