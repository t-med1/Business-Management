<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
MODIFIER DEVIS - PAGE
<?php $this->endsection() ?>

<?php $this->section('Devisadd') ?>
active
<?php $this->endsection() ?>
<?php $this->section('devis') ?>
active
<?php $this->endsection() ?>

<?php $this->section("content") ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Devis</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Acceuil</a></li>
                    <li class="breadcrumb-item active">Modifier Devis</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<?php $successFlash = session()->getFlashdata('success'); ?>
<?php if (isset($successFlash)): ?>
    <div class="row" id="myDiv">
        <div class="alert alert-success">
            <?= $successFlash ?>
        </div>
    </div>
<?php endif; ?>
<?php $errorFlash = session()->getFlashdata('error'); ?>
<?php if (isset($errorFlash)): ?>
    <div class="row" id="myDiv">
        <div class="alert alert-danger">
            <?= $errorFlash ?>
        </div>
    </div>
<?php endif; ?>

<section class="content">
    <form method="post" action="<?= base_url('/devis/update/'. $devis['id_devis'])?>">
    <?= csrf_field() ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Modifier Vente </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-3">
                                <label style="float: right; margin-top: 8px;"><span class="text-red"
                                        data-toggle="tooltip" title="Obligatoire">*</span> N° de BL :</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="code_devis" id="code_devis"
                                    placeholder="N° de BL" value="<?= $devis['code_devis'] ?>" readonly required>
                                <span style="color: red; display: none;" id="code_vente_exists"></span>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-1"></div>
                            <div class="col-md-3">
                                <label style="float: right; margin-top: 8px;"><span class="text-red"
                                        data-toggle="tooltip" title="Obligatoire">*</span> Client :</label>
                            </div>
                            <div class="col-md-6">
                            <input type="text" class="form-control" type="text" placeholder="" name="id_client"
                              id="code" value="<?= $selectedClient['societe'] ?>" readonly>
                            </small>


                            </div>
                        </div>
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-1"></div>
                            <div class="col-md-3">
                                <label style="float: right; margin-top: 8px;"><span class="text-red"
                                        data-toggle="tooltip" title="Obligatoire">*</span> Date de Vente :</label>
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="date_saisie" value="<?= $devis['date_saisie'] ?>"
                                    placeholder="Date de Vente" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible" id="alert_produit" style="display:none;">
                    <h4><i class="icon fa fa-info-circle"></i> Alerte !</h4>
                    La liste des produits/services à sélectionné est vide.
                </div>
                <div class="card card-success card-solid">
                    <div class="card-header with-border">
                        <h3 class="card-title">Services</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-3" style="margin-top: 10px;">
                            <select list="id_service_datalist" class="form-control service-select" id="id_service"
                                placeholder="Nom Service"
                                style="border: 2px solid rgb(0, 192, 239); margin-bottom: 10px;">
                                <option id="firstSelect">Sélectionnez un service</option>
                                <?php foreach ($Allservices as $service): ?>
                                    <option value="<?= $service['id_service'] ?>"
                                        data-prix="<?= $service['prix_unitaire'] ?>">
                                        <?= $service['titre'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-9 table-responsive" style="margin-top: 10px; overflow-x: auto;">
                            <table class="table table-bordered table-striped myDataTable">
                                <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th class="current-width"><span class="text-red" data-toggle="tooltip"
                                                title="Obligatoire">*</span> P. vente <small>(DH)</small></th>
                                        <th class="current-width">Total HT</th>
                                        <th class="current-width"><i class="fa fa-fw fa-trash"></i></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_service">
                                        <?php if($services):?>
                                            <?php foreach($services as $service):?>
                                                <tr data-service-id="<?= $service['id_service']?>">
                                                    <td> <?= $service['titre']?><input type="hidden" value="<?= $service['id_service']?>" name="id_service[]"></td>
                                                    <td>  <?= $service['prix_unitaire']?>  </td>
                                                    <td>  <?= $service['prix_unitaire']?>  </td>
                                                    <td><button class="btn-remove-service" style="border:none;color:red;">
                                                    <i class="fa fa-fw fa-trash"></i></button></td>
                                                </tr>
                                            <?php endforeach;?>
                                        <?php endif?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-success">
                    <div class="card-header with-border">
                        <h3 class="card-title">Détails Client</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" id="client-details">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Client :</label>
                                    <input type="text" id="client" name="full_name" class="form-control" 
                                        value="<?= isset($selectedClient['societe']) ? $selectedClient['societe'] : '' ?>" readonly>
                                    <small class="form-text text-success" id="ice">
                                        <?= isset($selectedClient['ICE']) ? 'ICE : ' . $selectedClient['ICE'] : '' ?>
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label>Téléphone :</label>
                                    <input type="text" id="numero_telephone" name="telephone" class="form-control"
                                     value="<?= isset($selectedClient['numero_telephone']) ? $selectedClient['numero_telephone'] : '' ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Email Client :</label>
                                    <input type="text" id="email_client" name="email_client" class="form-control" 
                                    value="<?= isset($selectedClient['email_client']) ? $selectedClient['email_client'] : '' ?>" readonly>                                </div>
                                <div class="form-group">
                                    <label>Ville :</label>
                                    <input type="text" id="ville" name="ville" class="form-control" 
                                     value="<?= isset($selectedClient['ville']) ? $selectedClient['ville'] : '' ?>" readonly>                                </div>
                                <div class="form-group">
                                    <label>Source :</label>
                                    <input type="text" id="source" name="source" class="form-control" 
                                     value="<?= isset($selectedClient['source']) ? $selectedClient['source'] : '' ?>" readonly>                                </div>
                                <div class="form-group">
                                    <label>Remarque :</label>
                                    <textarea class="form-control" name="remarque" maxlength="200" rows="3"
                                        placeholder="Remarque"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-success">
                    <div class="card-header with-border">
                        <h3 class="card-title">Paiement</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered" style="margin-bottom: 0px;">
                                    <tbody>
                                        <tr>
                                            <th style="vertical-align: middle;" class="current-width" id="1">Total HT
                                                <small>(DH)</small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                            <td><input type="text" value="0" id="total_ht" class="form-control"
                                                name="total_ht" readonly></td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;" class="current-width" id="1"><span
                                                    class="text-red" data-toggle="tooltip" title="Obligatoire">*</span>
                                                TVA <small>(%)</small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                            <td>
                                                <select name="tva" id="tva" class="form-control tva" required>
                                                    <option value="20" selected>20 %</option>
                                                    <option value="0">0 %</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="success">
                                            <th style="vertical-align: middle;" class="current-width" id="1">Total TTC
                                                <small>(DH)</small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                            <td>
                                                <input type="text" value="0" id="total_ttc" class="form-control"
                                                name="total_ttc" readonly>
                                            </td>
                                        </tr>
										<tr class="success">
                                            <th style="vertical-align: middle;" class="current-width" id="1">Mode de Paiement
                                               
                                            <td>
											<select class="form-control" name="modalite_paiement">
												<option value="service prepaye">service prépayé</option>
												<option value="50% à la commande 50% àla livraison ">50% à la commande 50% àla livraison </option>
												<option value="bon de commande">Bon de commande</option>
											</select>
                                            </td>
                                        </tr>
                                        <tr class="success">
                                            <th style="vertical-align: middle;" class="current-width" id="1">Etat
                                                
                                            <td>
											<select class="form-control" name="etat">
												<option value="Non accorde">Non Accordé</option>
												<option value="Accorde">Accorde</option>
											</select>
                                            </td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" style="text-align: center;">
                        <button type="submit" id="subButton" style="width: 50%;" class="btn btn-outline-success">
                            <i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; Modifier
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
<?php $this->endsection() ?>

<?php $this->section("script") ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).on('change', '.client-select', function () {
            var client_id = $(this).val();
            $.ajax({
                url: '/Controllers/generatedClient/' + client_id,
                type: 'GET',
                data: {
                    client_id: client_id
                },
                success: function (response) {
                    var data = response;
                    $('#client').val(data.societe)
                    $('#ice').html('ICE : ' + data.ice)
                    $('#numero_telephone').val(data.numero_telephone)
                    $('#email_client').val(data.email_client)
                    $('#ville').val(data.ville)
                    $('#source').val(data.source)
                }
            });
        });
        
         // Function to format numbers to two decimal places
         function formatNumber(number) {
            if (!isNaN(number) && isFinite(number)) {
                return parseFloat(number).toFixed(2);
            } else {
                return "0.00";
            }
        }

        // Function to calculate the total HT
        function calculateTotalHT() {
            var totalHT = 0;
            $('#tbody_service tr').each(function () {
                var price = parseFloat($(this).find('td:eq(1)').text());
                if (!isNaN(price)) {
                    totalHT += price;
                }
            });
            return totalHT;
        }

        // Function to calculate the total TTC
        function calculateTotalTTC(totalHT, tvaPercentage) {
            var tva = (totalHT * tvaPercentage) / 100;
            var totalTTC = parseFloat(totalHT) + parseFloat(tva);
            return totalTTC.toFixed(2);
        }

        // Function to update the "Total HT," "Total TTC," and "Reste" inputs
        function updateTotals() {
            var totalHT = calculateTotalHT();
            var tvaPercentage = parseFloat($('#tva').val());
            var totalTTC = calculateTotalTTC(totalHT, tvaPercentage);
            var paiement = parseFloat($('#paiemant').val());
            var reste = 0;

            if (!isNaN(totalHT) && isFinite(totalHT)) {
                $('#total_ht').val(formatNumber(totalHT));
            } else {
                $('#total_ht').val(totalHT);
                totalHT = 0;
            }

            if (isNaN(totalTTC) || !isFinite(totalTTC)) {
                $('#total_ttc').val("0.00");
                reste = totalHT;
            } else {
                if (tvaPercentage === 0) {
                    $('#total_ttc').val(totalHT);
                    reste = totalHT;
                } else {
                    $('#total_ttc').val(formatNumber(totalTTC));
                    reste = totalTTC;
                }
            }

            if (isNaN(reste) || !isFinite(reste)) {
                $('#reste').val("0.00");
            } else {
                // Only update montant_rest if it's not manually entered by the user
                var montantPaye = parseFloat($('#paiemant').val());
                if (!isNaN(montantPaye) && isFinite(montantPaye)) {
                    $('#reste').val(formatNumber(reste - montantPaye));
                }
            }
        }

        // Initialize totals on page load
        updateTotals();

        // Handle changes in TVA and payment input
        $('#tva, #paiemant').on('change', function () {
            updateTotals();
        });

        var count = 0;
        // Handle service selection
        var service_id = $('.service-select').val();
        var existingServiceRow = $('#tbody_service tr[data-service-id="' + service_id + '"]');
        $('.service-select').on('change', function () {
            var service_id = $(this).val();
            var existingServiceRow = $('#tbody_service tr[data-service-id="' + service_id + '"]');
            if (!existingServiceRow.length) {
                $.ajax({
                    url: '/Controllers/ServiceController/generatedServis/' + service_id,
                    type: 'GET',
                    data: {
                        service_id: service_id
                    },
                    success: function (response) {
                        var data = response;
                        var newRow = '<tr data-service-id="' + service_id + '">' +
                            `<td>` + data.titre + `<input type="hidden" value="`+data.id_service+`" name="id_service[]"></td>` +
                            `<td>` + data.prix_unitaire + `</td>` +
                            `<td>` + data.prix_unitaire + `</td>` +
                            `<td><button class="btn-remove-service" style="border:none;color:red;">` +
                            `<i class="fa fa-fw fa-trash"></i></button></td>` +
                            `</tr>`;
                        $('#tbody_service').append(newRow);
                        $('#firstSelect').attr('selected', true);
                        updateTotals();
                        count++
                    }
                });
            }
        });
        $('.btn-remove-service').on('click' , function () {
            $(this).closest('tr').remove();
            updateTotals();
        });
        $('#paiemant').on('input', function () {
            updateTotals();
        });
    });
</script>
<?php $this->endsection() ?>