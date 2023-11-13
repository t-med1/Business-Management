<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Facture;
use App\Models\Relancement;
use App\Models\Client;

class RelanceController extends BaseController
{

    public function updateRelancement($id_facture)
{
    $factureModel = new Facture();
    $factureModel->where('id_facture', $id_facture)->set('relance_faite' , 1)->update();
}


}
