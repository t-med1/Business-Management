<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
AJOUTER VENTE - PAGE
<?php $this->endsection() ?>

<?php $this->section('Venteadd') ?>
active
<?php $this->endsection() ?>
<?php $this->section('vente') ?>
active
<?php $this->endsection() ?>

<?php $this->section("content") ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Vente</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Acceuil</a></li>
                    <li class="breadcrumb-item active">Ajouter Vente</li>
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
    <form method="post" action="<?= base_url('vente/store')?>">
    <?= csrf_field() ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Ajouter Vente </h3>
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
                                <input type="text" class="form-control" name="code_vente" id="code_vente"
                                    placeholder="N° de BL" value="<?= $venteCode ?>" readonly required>
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
                                <select class="form-control client-select select2" name="id_client" id="id_client" required>
                                    <option>Sélectionnez le client</option>
                                    <?php foreach ($clients as $client): ?>
                                        <option value="<?= $client['id_client'] ?>">
                                            <?= $client['societe'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-1"></div>
                            <div class="col-md-3">
                                <label style="float: right; margin-top: 8px;"><span class="text-red"
                                        data-toggle="tooltip" title="Obligatoire">*</span> Date de Vente :</label>
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="date_vente" value="<?= date('Y-m-d') ?>"
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
                <div class="card card-info card-solid">
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
                                <select list="id_service_datalist" class="form-control service-select select2" id="id_service"
                                    placeholder="Nom Service"
                                    style="border: 2px solid rgb(0, 192, 239); margin-bottom: 10px;">
                                    <option id="firstSelect">Sélectionnez un service</option>
                                    <?php foreach ($services as $service): ?>
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
                                    <tbody id="tbody_service"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header with-border">
                        <h3 class="card-title">Détails Client</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Client :</label>
                                    <input type="text" id="client" name="full_name" class="form-control" readonly>
                                    <small class="form-text text-success" id="ice"></small>
                                </div>

                                <div class="form-group">
                                    <label>Téléphone :</label>
                                    <input type="text" id="numero_telephone" name="telephone" class="form-control"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label>Email Client :</label>
                                    <input type="text" id="email_client" name="telephone" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Ville :</label>
                                    <input type="text" id="ville" name="telephone" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Source :</label>
                                    <input type="text" id="source" name="telephone" class="form-control" readonly>
                                </div>
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
                <div class="card card-info">
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
                                            <?php if($commande):?>
                                                <input type="hidden" name="id_commande" value="<?= $commande['id_commande']?>" id="">
                                            <?php endif; ?>
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
                                        <tr>
                                            <th style="vertical-align: middle;" class="current-width" id="1">Paiement
                                                <small>(DH)</small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                            <td>
                                                <input type="number" id="paiemant" class="form-control" name="montant_paye">
                                            </td>
                                        </tr>
                                        <tr class="warning">
                                            <th style="vertical-align: middle;" class="current-width" id="1">Reste
                                                <small>(DH)</small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                            <td>
                                                <input type="text" value="0" id="reste" class="form-control" name="montant_rest" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle;" class="current-width" id="1"><span
                                                    class="text-red" data-toggle="tooltip" title="Obligatoire">*</span>
                                                Mode de Paiement &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                            <td>
                                                <select class="form-control select2" name="mode_paiement" id="vente_methode"
                                                    required>
                                                    <option value="espece" selected>Espèce</option>
                                                    <option value="cheque">Chèque</option>
                                                    <option value="effet">Effet</option>
                                                    <option value="virement">Virement bancaire</option>
                                                    <option value="avance">À partir d'avance</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr id="cheque_div" >
                                            <td colspan="2">
                                                <table class="table table-bordered table-striped" style="margin-bottom:0px;">
                                                    <tbody>
                                                            <tr>
                                                                <td>
                                                                    <input type="number" step="any" min="0.1" id="cheque_montant" name="cheque_montant" class="form-control" placeholder="Montant">
                                                                </td>
                                                                <td>
                                                                    <input type="text" id="cheque_reference" name="reference_cheque" class="form-control" placeholder="Réference de Chèque">
                                                                </td>
                                                                <td>
                                                                    <input type="date" id="cheque_date" name="date_cheque" class="form-control" placeholder="Date">
                                                                </td>
                                                            </tr>
                                                        <tr>
                                                            <td colspan="3">
                                                                <input type="text" maxlength="200" id="cheque_remarque" name="cheque_remarque" class="form-control" placeholder="Remarque">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr id="avance_div">
                                            <th style="vertical-align: middle;" class="current-width">Avance de Client &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                            <td>
                                                <table class="table table-bordered" style="margin-bottom: 0px;">
                                                    <tr>
                                                        <td class="current-width"><input type="radio" name="type_avance" id="type_avance" value="1"></td>
                                                        <td class="current-width">Espèce</td>
                                                        <td><strong id="total_avance_1">...</strong> <small>DH</small></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="current-width"><input type="radio" name="type_avance" value="2" disabled></td>
                                                        <td class="current-width">Chèque/Effet</td>
                                                        <td><strong id="total_avance_2">...</strong> <small>DH</small></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="current-width"><input type="radio" name="type_avance" value="3"></td>
                                                        <td class="current-width">Virement bancaire</td>
                                                        <td><strong id="total_avance_3">...</strong> <small>DH</small></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr style="background-color:#F59D82">
                                            <th style="vertical-align: middle;" class="current-width"><span class="text-red" data-toggle="tooltip" title="Obligatoire">*</span> Frais <small>(DH)</small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                            <td><input type="number" step="any" min="0" value="0" name="frais" id="frais" class="form-control"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" style="text-align: center;">
                        <button type="submit" id="subButton" style="width: 50%;" class="btn btn-primary">
                            <i class="fa fa-save"></i> &nbsp; Enregistrer
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
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        })
    })
    $(document).ready(function () {
        $('#cheque_div').hide();
        $('#avance_div').hide();
        $(document).on('change', '.client-select', function () {
            var client_id = $(this).val();
            $.ajax({
                url: '/Controllers/generatedClient/' + client_id,
                type: 'GET',
                data: {
                    client_id: client_id
                },
                success: function (response) {
                    // Update the client details here
                    var data = response;
                    $('#client').val(data.societe);
                    $('#ice').html('ICE : ' + data.ice);
                    $('#numero_telephone').val(data.numero_telephone);
                    $('#email_client').val(data.email_client);
                    $('#ville').val(data.ville);
                    $('#source').val(data.source);
                    updateAvanceData(client_id);
                }
            });
        });

        function updateAvanceData(client_id) {
            $.ajax({
                url: "/client/getAvance/" + client_id,
                method: "GET",
                data: {
                    id_client: client_id
                },
                success: function (response) {
                    // Update the avance data in the table
                    $("#total_avance_1").html(response.total_espece);
                    $("#total_avance_2").html(response.total_cheque);
                    $("#total_avance_3").html(response.total_virement);
                    $("#id_client option:selected").attr('data-total_espece',response.total_espece);
                    $("#id_client option:selected").attr('data-total_cheque',response.total_cheque);
                    $("#id_client option:selected").attr('data-total_virement',response.total_virement);
                    $("#vente_methode, #paiemant, #type_avance").attr("required", "required");
                }
            });
            
        }

        $('#vente_methode').on('change' , function(){
            if( $(this).val() == "cheque"){
                $('#cheque_div').show();
                $('#cheque_montant').val($('#paiemant').val())
                $('#paiemant').attr('readonly' , 'readonly')

            }else if($(this).val() == 'avance'){
                initMethode();
                $("#avance_div").show();
                var id_client =  $(".client-select option:selected").val();
                $('#paiemant').attr('readonly' , 'readonly')
                updateAvanceData(id_client);
            }else{
                initMethode();
                $("#avance_div").hide();
            }
        }).change(); // to get attrs
        
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
                    $('#total_ttc').val("0.00");
                    reste = totalHT;
                    $('#reste').val(reste)
                } else {
                    $('#total_ttc').val(formatNumber(totalTTC));
                    reste = totalTTC;
                    $('#reste').val(reste)
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

        // Handle removal of selected services
        $(document).on('click', '.btn-remove-service', function () {
            $(this).closest('tr').remove();
            updateTotals();
        });
        $('#paiemant').on('input' ,function(){  
            updateTotals();
        });
        $("#cheque_montant").on("input", function ()
        {
            $("#paiemant").val( $(this).val() );
            $("#paiemant").trigger("input");
        });
        $("input[type=radio][name='type_avance']").on("change", function() {
            alert('3ndk atakel m3endkch wlh la klitih ohohohohooh')
            var avance_espece =  $(".client-select option:selected").data("total_espece");
            var avance_cheque =  $(".client-select option:selected").data("total_cheque");
            var avance_virement =  $(".client-select option:selected").data("total_virement");
            var max = 0;
            switch (this.value.toString()) {
                case "1" : max = avance_espece; break;
                case "2" : max = avance_cheque; break;
                case "3" : max = avance_virement; break;
                default: max = 0;
            }
            $("#paiemant").val(max);
            updateTotals();
        });
        function initMethode()
        {
            $("#cheque_div").hide();
            $("#vente_methode, #paiemant, #cheque_montant, #cheque_date, #cheque_reference").removeAttr("required");
            $("#paiemant").removeAttr("readonly");

            // $("#avance_div").hide();
            $("#paiemant").removeAttr("max");
            $("#type_avance").removeAttr("required");
            $("input[type=radio][name='type_avance']").each(function (i, el) {
                el.checked = false;
            });
        }
    });
</script>
<?php $this->endsection() ?>