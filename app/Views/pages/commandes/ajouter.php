<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
AJOUTER COMMANDE - PAGE
<?php $this->endsection() ?>
<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
<?php $this->endsection() ?>
<?php $this->section('commandeadd') ?>
active
<?php $this->endsection() ?>
<?php $this->section('commande') ?>
active
<?php $this->endsection() ?>

<?php $this->section("content") ?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Commandes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Acceuil</a></li>
                        <li class="breadcrumb-item active">Ajouter Commandes</li>
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
<input type="hidden" name="selected_services" id="selected_services" value="">
    <form method="post" action="<?= base_url('commande/store')?>">
    <?= csrf_field()?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Ajouter Commande</h3>
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
                                        data-toggle="tooltip" title="Obligatoire">*</span> N° de Commande :</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="code_commande" id="code_commande"
                                    placeholder="N° de commande" value="<?= $commande_code ?>" readonly required>
                                <span style="color: red; display: none;" id="code_vente_exists"></span>
                            </div>
                        </div>
                        
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-1"></div>
                            <div class="col-md-3">
                                <label style="float: right; margin-top: 8px;"><span class="text-red"
                                        data-toggle="tooltip" title="Obligatoire">*</span> Responsable Technique
                                    :</label>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control select2" name="responsable" id="responsable"
                                    required>
                                    <option>Sélectionnez le Responsable</option>
                                    <?php foreach ($commercials as $commercial): ?>
                                        <option value="<?= $commercial['nom'] ?> <?= $commercial['prenom'] ?>">
                                            <?= $commercial['nom'] ?>
                                            <?= $commercial['prenom'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-1"></div>
                            <div class="col-md-3">
                                <label style="float: right; margin-top: 8px;"><span class="text-red"
                                        data-toggle="tooltip" title="Obligatoire">*</span> Date de Commande :</label>
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="date_debut" value="<?= date('Y-m-d') ?>"
                                    placeholder="Date de Vente" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info card-solid">
                    <div class="card-header with-border">
                        <h3 class="card-title">Ajouter Service</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3" style="margin-top: 10px;">
                                <select class="form-control select2 service-select" style="width: 100%;">
                                    <option selected="selected">Séléctionner Un Service</option>
                                    <?php foreach ($services as $service): ?>
                                        <option value="<?= $service['id_service'] ?>">
                                            <?= $service['titre'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                            <div class="col-md-9 table-responsive" style="margin-top: 10px;">
                                <table class="table table-bordered table-striped myDataTable">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>
                                                <span class="text-red" data-toggle="tooltip" title="Obligatoire">*
                                                </span> Service
                                            </th>
                                            <th>
                                                <span class="text-red" data-toggle="tooltip" title="Obligatoire">*
                                                </span> P. vente <small>(DH)</small>
                                            </th>
                                            <th class="current-width"><i class="fa fa-fw fa-trash"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_service">
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
                <div class="card card-info card-solid">
                    <div class="card-header with-border">
                        <h3 class="card-title">Client</h3>
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
                                    <label><span class="text-red" data-toggle="tooltip" title="Obligatoire">*</span>
                                        Client :</label>
                                    <select class="form-control select2 client-select" name="id_client" id="id_client" required>
                                        <option selected="selected">Séléctionner Un Client</option>
                                        <?php foreach ($clients as $client): ?>
                                            <option value="<?= $client['id_client'] ?>">
                                                <?= $client['societe'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Code de Client :</label>
                                    <input type="text" class="form-control" name="code_commande" id="code_client_cmd"
                                        value="" placeholder="Code Commande de Client" readonly required>
                                    <small class="form-text text-success" id="code_client_cmd_exists"></small>
                                </div>
                                <div class="form-group">
                                    <label>Ville :</label>
                                    <input type="text" class="form-control" name="ville" id="ville" value=""
                                        placeholder="Code Commande de Client" readonly required>
                                    <small class="form-text text-success" id="numero_telephone"></small>
                                    <small class="form-text text-success" id="email_client"></small>
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
                <div class="card card-info card-solid">
                    <div class="card-header with-border">
                        <h3 class="card-title">Détails</h3>
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
                                            <th style="vertical-align: middle; white-space: nowrap; width: 1%;">Services
                                            </th>
                                            <td><input type="text" value="0" id="client_cmd_total_service"
                                                    class="form-control" readonly></td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle; white-space: nowrap; width: 1%;">
                                                <span class="text-red" data-toggle="tooltip" title="Obligatoire">*</span> Prix Total <small>DH</small>
                                            </th>
                                            <td><input type="number" value="0" id="prix_total" name="prix_total"
                                                    class="form-control" readonly></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" style="text-align: center;">
                        <button type="submit" style="width: 50%;" class="btn btn-primary">
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
        var selectedServices = [];
        $('.client-select').on('change', function () {
            var client_id = $(this).val();
            $.ajax({
                url: '/Controllers/generatedClient/' + client_id,
                type: 'GET',
                data: {
                    client_id: client_id
                },
                success: function (response) {
                    var data = response;
                    $('#code_client_cmd').val(data.code_client)
                    $('#code_client_cmd_exists').html('ICE : ' + data.ice)
                    $('#numero_telephone').val("Numéro du Téléphone : " + data.numero_telephone)
                    $('#email_client').val("Email : " + data.email_client)
                    $('#ville').val(data.ville)
                }
            });
        });
         // Function to update the row count
    function updateRowCount() {
        var rowCount = $("#tbody_service tr").length;
        $("#client_cmd_total_service").val(rowCount);
    }

    // Function to calculate and update the total prix_unitaire
    function updateTotal() {
        var total = 0;
        // Iterate through each row in the table and sum up the prix_unitaire
        $('#tbody_service tr').each(function () {
            var prixUnitaire = parseFloat($(this).find('td:nth-child(3)').text());
            total += prixUnitaire;
        });
        // Update the "Prix Total" input field
        $('#prix_total').val(total);
    }

    // Call the updateRowCount function when the page loads
    updateRowCount();

    // Handle service selection
    var count = 0;
    $('.service-select').on('change', function () {
        var selectedValue = $(this).val();

        // Check if the selected value is not empty (not the default option)
        if (selectedValue !== "Séléctionner Un Service") {
            var service_id = $('.service-select option:selected').val();

            // Check if the service_id is not in the selectedServices list
            if (!selectedServices.includes(service_id)) {
                selectedServices.push(service_id);
                
                $.ajax({
                    url: '/Controllers/ServiceController/generatedServis/' + service_id,
                    type: 'GET',
                    data: {
                        service_id: service_id
                    },
                    success: function (response) {
                        var data = response;
                        var newRow = `<tr data-service-id="' + service_id + '">` +
                            `<td>` + data.code_service + `<input type="hidden" value="` + data.id_service + `" name="id_service[]"></td>` +
                            `<td>` + data.titre + `</td>` +
                            `<td>` + data.prix_unitaire + `</td>` +
                            `<td><button class="btn-remove-service" style="border:none;color:red;">` +
                            `<i class="fa fa-fw fa-trash"></i></button></td>'`+
                            `</tr>`;
                        $('#tbody_service').append(newRow);
                        updateRowCount();
                        updateTotal();
                        count++;
                    }
                });
                count++;
                $('#selected_services').val(selectedServices.join(','));
            }
        }
    });

    // Handle row removal
    $(document).on('click', '.btn-remove-service', function () {
        var service_id = $(this).closest('tr').data('service-id');

        // Remove the service_id from the selectedServices list
        var index = selectedServices.indexOf(service_id);
        if (index !== -1) {
            selectedServices.splice(index, 1);
        }

        $(this).closest('tr').remove();

        // After removing the row, call updateRowCount and updateTotal
        updateRowCount();
        updateTotal();
    });
});

</script>
<?php $this->endsection() ?>