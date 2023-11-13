<?php $this->extend('templates/layout') ?>

<!-- titre du page -->
<?php $this->section('title') ?>
AJOUTER AVANCE - PAGE
<?php $this->endsection() ?>

<?php $this->section('client') ?>
active
<?php $this->endsection() ?>

<?php $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Client</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Acceuil</a></li>
                    <li class="breadcrumb-item active">Ajouter Retour</li>
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
<div class="container-fluid">
		<div class="row">
            <div class="col-3"></div>
			<div class="col-6">
                <form method="post" action="<?= base_url('avance/save') ?>">
                <?= csrf_field() ?>
				<div class="card">
					<div class="card-header" style="background-color:#74C1FD">
						<h3 class="card-title">Ajouter Un Retour</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
					</div>
					<div class="card-body">
                            <div class="form-group">
                                <label><span class="text-red" data-toggle="tooltip" title="Obligatoire">*</span> Date
                                    :</label>
                                <input type="date" class="form-control" name="date_avance" value="<?= date('Y-m-d')?>"
                                    placeholder="Date Avance" required>
                            </div>
                            <div class="form-group">
                                <label><span class="text-red" data-toggle="tooltip" title="Obligatoire">*</span> Client
                                    :</label>
                                <input type="hidden" name="status" value='retour'>
                                <select class="form-control select2" name="id_client" id="id_client" required>
                                    <option>Séléctionner un Client</option>
                                    <?php foreach($clients as $client):?>
                                        <option value="<?= $client['id_client']?>">
                                            <?= $client['societe']?>
                                        </option>
                                    <?php endforeach ; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><span class="text-red" data-toggle="tooltip" title="Obligatoire">*</span> Montant
                                    :</label>
                                <input type="number" step="any" min="0.1" class="form-control" name="montant"
                                    id="montant" placeholder="Montant" required>
                            </div>
                            <div class="form-group">
                                <label><span class="text-red" data-toggle="tooltip" title="Obligatoire">*</span> Mode de
                                    Paiement :</label>
                                <select class="form-control select2" name="mode_pay" id="avance_methode" required>
                                    <option value="espece" selected>Espèce</option>
                                    <option value="cheque">Chèque</option>
                                    <option value="effet">Effet</option>
                                    <option value="virement">Virement bancaire</option>
                                </select>
                            </div>
                            <div class="form-group" id="cheque_div">
                                <table class="table table-bordered table-striped" style="margin-bottom:0px;">
                                    <tbody>
                                        <tr>
                                            <td><input type="number" step="any" min="0.1" id="cheque_montant"
                                                     class="form-control" placeholder="Montant">
                                            </td>
                                            <td><input type="text" id="cheque_reference" name="reference"
                                                    class="form-control" placeholder="Réference"></td>
                                            <td><input type="date" id="cheque_date" name="date_pay"
                                                    class="form-control" placeholder="Date"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><input type="text" maxlength="200" id="cheque_remarque"
                                                     class="form-control" placeholder="Remarque">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <label>Description :</label>
                                <textarea class="form-control" name="description" placeholder="Description"
                                    maxlength="200" rows="3"></textarea>
                            </div>DHFDHFDHHDHFDHDHHDHHDDA
                        </div>
                        <div class="card-footer" style="text-align: center;">
                            <button type="submit" style="width: 50%;" class="btn btn-primary">
                                <i class="fa fa-save"></i> &nbsp; Enregistrer
                            </button><i class="fas fa-cloud-showers-heavy    "></i>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</section>
<section class="content">
            <div class="col-xs-12 no-print" style="display:flex;justify-content:space-between">
                <a href="<?= base_url('/client/avance')?>" class="btn btn-default pull-right">
                    <i class="fa fa-reply"></i> Retour
                </a>
            </div>
</section>
<?php $this->endsection() ?>

<?php $this->section('script') ?>
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
        $("#cheque_div").hide();
        $('#id_client').select2({ placeholder: "Selectionner un client" });
        $("#id_client").val('').trigger("change");
        $("#avance_methode").on("change", function () {
            if ($(this).val() != undefined && $(this).val() != null) {
                if ($(this).val() == 'cheque' || $(this).val() == 'effet') {
                    var completePlaceHolder = $(this).val() == 'cheque' ? "de chèque" : "d'effet";
                    initMethode();

                    $("#cheque_div").show();
                    $("#cheque_montant, #cheque_date, #cheque_reference").attr("required", "required");
                    $("#montant").attr("readonly", "readonly");

                    $("#cheque_montant").attr("placeholder", "Montant " + completePlaceHolder);
                    $("#cheque_date").attr("placeholder", "Date " + completePlaceHolder);
                    $("#cheque_reference").attr("placeholder", "Réference " + completePlaceHolder);
                    $("#cheque_remarque").attr("placeholder", "Remarque " + completePlaceHolder);
                }
                else { initMethode(); }
            }
            else { initMethode(); }
        }).change(); // to get attrs

        $("#cheque_montant").on("input", function () {
            $("#montant").val($(this).val());
        });
    });

    function initMethode() {
        $("#cheque_div").hide();
        $("#cheque_montant, #cheque_date, #cheque_reference").removeAttr("required");
        $("#montant").removeAttr("readonly");
    }
</script>
<?php $this->endsection() ?>