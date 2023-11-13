<?php $this->extend('templates/layout') ?>

<!-- titre du page -->
<?php $this->section('title') ?>
DETAIL VENTE -- PAGE
<?php $this->endsection() ?>
<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
<?php $this->endsection() ?>
<?php $this->section('vente') ?>
active
<?php $this->endsection() ?>

<!-- Le contenue du page home -->
<?php $this->section('content') ?>
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
    <div class="row">
        <div class="col-md-4">
            <div class="card card-info">
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
                        <div class="col-md-12" style="overflow-x: auto;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center; font-size: 2.5rem;">
                                            <?= $vente['code_vente'] ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="current-width">Commerciale</td>
                                        <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                        <td>
                                            <span class="badge <?= $employe['role']=='admin'?'bg-success':'bg-warning'?> custom-tooltip"  data-toggle="tooltip" data-placement="top"
                                                title="<?= $employe['role']?>">
                                                <?= $employe['nom'] . ' ' . $employe['prenom'] ?>
                                            </span></td>
                                    </tr>

                                    <tr>
                                        <td class="current-width">Commande <br>de Client</td>
                                        <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                        <td>
                                            <?php if ($commande): ?>
                                                <span class="label label-warning" data-toggle="tooltip" data-placement="top"
                                                    title="Commande Du Client">
                                                    <?= $commande['code_commande'] ?>
                                                </span>
                                        <?php else: ?>
                                            <i class="fa fa-times text-warning"></i>
                                        <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="current-width">Client</td>
                                        <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                        <td>
                                            <strong data-toggle="tooltip" data-placement="top"
                                                title="Voir Ce Client">
                                                <a href="<?= base_url('client/details/commande/' . $client['id_client']) ?>">
                                                    <?= $client['societe'] ?>
                                                </a>
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="current-width" style="vertical-align: top !important;">Ville</td>
                                        <td class="current-width" style="vertical-align: top !important;">&nbsp; :
                                            &nbsp;&nbsp;</td>
                                        <td style="vertical-align: top !important;">
                                            <strong>
                                                <?= $client['ville'] ?>
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="current-width">Date Vente</td>
                                        <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                        <td><strong>
                                                <?= $vente['date_vente'] ?>
                                            </strong></td>
                                    </tr>
                                    <tr>
                                        <td class="current-width">TVA</td>
                                        <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                        <td>
                                            <strong>
                                                <?= $vente['tva'] ?>
                                            </strong> <small>%</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="current-width">Montant</td>
                                        <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                        <td>
                                            <?php if ($vente['tva'] == 20): ?>
                                                <strong>
                                                    <?= $vente['total_ttc'] ?>
                                                </strong> <small>DH</small>
                                            <?php elseif ($vente['tva'] == 0): ?>
                                                <strong>
                                                    <?= $vente['total_ht'] ?>
                                                </strong> <small>DH</small>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                    <tr>
                                        <td class="current-width">Paiements</td>
                                        <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                        <td><strong class="">
                                                <?= $montant_paye['montant_pay'] ?>
                                            </strong> <small>DH</small></td>
                                    </tr>
                                    <tr>
                                        <td class="current-width">Reste à payé</td>
                                        <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                        <td>
                                            <?php if($vente['montant_rest'] == 0) : ?>
                                                <strong style="color: #00CC00">Payé</strong>
                                            <?php else:?>
                                                <strong style="color: #e9322d"><?= $vente['montant_rest'] ?></strong> <small>DH</small>
                                            <?php endif;?>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="current-width">Facture</td>
                                        <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                        <td>
                                        <?php if($existsFacture):?>
                                            <a href="<?= base_url('/facture')?>" data-toggle="tooltip" data-placement="top"
                                                title="Voir Liste Facture">
                                                <strong style="color: #e9322d"><?= $existsFacture['code_facture'] ?></strong>
                                            </a>
                                        <?php else:?>
                                            <a href="<?= base_url('facture/ajouter/'.$vente['id_vente'])?>"
                                                class="btn btn-warning btn-sm" style="width: 100%;"
                                                data-toggle="tooltip" title="Créer Facture"><i class="fa fa-plus"></i>&nbsp;
                                                Créer Facture</a>
                                            <br><br>
                                        <?php endif;?>
                                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php if ($vente['montant_rest'] > 0): ?>
                                <button class="btn btn-primary btn-sm" style="width: 100%;" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fa fa-money"></i>&nbsp; Paiements
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Ajouter Paiement</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="<?= base_url('rest/update/'.$vente['id_vente'])?>" method="post">
                                                <?= csrf_field() ?>
                                                <div class="row mb-2">
                                                    <label for="paiement" class="form-label"><span style="color:red;">*</span>Paiement <small>DH</small></label>
                                                                            <input type="number" class="form-control" id="paiement" placeholder="Entrer un paiement" name="montant_pay" required>
                                                                        </div>
                                                                        <div class="row mb-2">
                                                                            <label for="reste" class="form-label"><span style="color:red;">*</span>Reste <small>DH</small></label>
                                                                            <input type="number" class="form-control" id="reste" data-initial="<?= $vente['montant_rest'] ?>" value="<?= $vente['montant_rest'] ?>" name="motant_rest" readonly>
                                                                            <input type="hidden" class="form-control" value="<?= date('Y-m-d') ?>" name="date_dernier_paiment" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Annuler</button>
                                                                        <button type="submit" class="btn btn-info"><i class="fa fa-floppy-o" aria-hidden="true"></i> Enregistrer</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        </div>
                            <?php endif; ?>
                            <br><br>
                            <a href="<?= base_url('vente/modifier/' . $vente['id_vente']) ?>"
                                class="btn btn-success btn-xs" style="width: 100%;" data-toggle="tooltip" title="Modifier"><i class="fa fa-wrench"></i>&nbsp;
                                Modifier</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header with-border">
                            <h3 class="card-title">Détails de Vente
                                <?= $vente['code_vente'] ?> &nbsp; ( Services )
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="export_btns_2" style="float: right;margin: 8px 0px 12px 0px;"></div><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table id="myDataTable_2" class="table myDataTable table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Service</th>
                                                <th>Prix vente</th>
                                                <th>Total TTC</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($services as $service): ?>
                                                <tr>
                                                    <td><?= $service['titre'] ?></td>
                                                    <td><?= $service['prix_unitaire'] ?></td>
                                                    <td><?= $vente['total_ttc'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<?php $this->endsection() ?>

<?php $this->section('script')?>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        // Function to update the remaining amount
        function updateReste() {
            var paiement = parseFloat($('#paiement').val());
            var initialReste = parseFloat($('#reste').data('initial'));

            if (isNaN(paiement)) {
                // If paiement is not a valid number, reset to the initial value
                $('#reste').val(initialReste);
            } else {
                var MontantReste = initialReste - paiement;
                $('#reste').val(MontantReste);
            }
        }

        // Call the updateReste function on input change
        $('#paiement').on('input', function () {
            updateReste();
        });

        // Call the updateReste function when the input loses focus (e.g., when clicking outside)
        $('#paiement').on('blur', function () {
            updateReste();
        });

        // Call the updateReste function when the Backspace key is pressed
        $('#paiement').on('keydown', function (e) {
            if (e.keyCode === 8) { // Backspace key code
                updateReste();
            }
        });
        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus')
        })
    });
</script>
<script>
    function confirmAction(form) {
        Swal.fire({
            title: 'Confirmation!',
            html: "Voulez-vous vraiment Créer une Facture?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2a5d7d',
            confirmButtonText: ' &nbsp; Créer &nbsp;',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.value) {
                $("#" + form).submit();
            }
        });
    }
</script>

<?php $this->endsection()?>