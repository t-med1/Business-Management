<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
MODIFIER COMMANDE - PAGE
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
                        <li class="breadcrumb-item active">Modifier Commandes</li>
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
<form method="post" action="<?= base_url('/commande/update/'. $commande['id_commande'])?>">
    <?= csrf_field()?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-success card-solid">
                    <div class="card-header">
                        <h3 class="card-title">Modifier Commande</h3>
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
                            <input type="text" class="form-control" name="code_commade" id="code_commade"
                                    placeholder="N° de BL" value="<?= $commande['code_commande'] ?>" readonly required>
                                <span style="color: red; display: none;" id="code_vente_exists"></span>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-1"></div>
                            <div class="col-md-3">
                                <label style="float: right; margin-top: 8px;"><span class="text-red"
                                        data-toggle="tooltip" title="Obligatoire">*</span> Commeriale :</label>
                            </div>
                            <div class="col-md-6">
                            <input type="text" class="form-control" type="text" placeholder="" name="id_emp"
                              id="code" value="<?= $commande['nom'] ?> <?= $commande['prenom'] ?>" readonly>
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
                            <input type="text" class="form-control" type="text" placeholder="" name="id_emp"
                              id="code" value="<?= $commande['nom'] ?> <?= $commande['prenom'] ?>" readonly>
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
                                                title="Obligatoire">*</span> Titre <small>(DH)</small></th>
                                        <th class="current-width">Total HT</th>
                                        <th class="current-width"><i class="fa fa-fw fa-trash"></i></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_service">
                                        <?php if($services):?>
                                            <?php foreach($services as $service):?>
                                                <tr data-service-id="<?= $service['id_service']?>">
                                                    <td> <?= $service['code_service']?><input type="hidden" value="<?= $service['id_service']?>" name="id_service[]"></td>
                                                    <td>  <?= $service['titre']?>  </td>
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
                <div class="card card-success card-solid">
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
                                        <input type="text" id="client" name="full_name" class="form-control" 
                                        value="<?= isset($selectedClient['societe']) ? $selectedClient['societe'] : '' ?>" readonly>
                                    <small class="form-text text-success" id="ice">
                                        <?= isset($selectedClient['ICE']) ? 'ICE : ' . $selectedClient['ICE'] : '' ?>
                                    </small>
                                </div>
                                <div class="form-group">
                                    <label>Code de Client :</label>
                                    <input type="text" id="ville" name="code_client" class="form-control" 
                                     value="<?= isset($selectedClient['code_client']) ? $selectedClient['code_client'] : '' ?>" readonly>  
                                    <small class="form-text text-success" id="code_client_cmd_exists"></small>
                                </div>
                                <div class="form-group">
                                <label>Ville :</label>
                                    <input type="text" id="ville" name="ville" class="form-control" 
                                     value="<?= isset($selectedClient['ville']) ? $selectedClient['ville'] : '' ?>" readonly>  
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
                <div class="card card-success card-solid">
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
                                            <td><input type="number"  id="prix_total" name="prix_total" value="<?= $commande['prix_total'] ?>"
                                                    class="form-control" readonly></td>
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