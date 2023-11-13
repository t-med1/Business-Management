<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
DETAILS COMMERCIAUX - PAGE
<?php $this->endsection() ?>

<?php $this->section('rapports') ?>
active
<?php $this->endsection() ?>
<?php $this->section('detail_comm') ?>
active
<?php $this->endsection() ?>

<?php $this->section("content") ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Détails de Commerciaux</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Acceuil</a></li>
                    <li class="breadcrumb-item active">Détails de Commerciaux</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header with-border">
                    <h3 class="card-title">Période</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form method="get"
                        action="<?= base_url('rapports/details_commerciaux/')?>">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Entre Le :</label>
                                    <input type="date" class="form-control" name="date_debut" value="<?= $debut?>"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Et Le :</label>
                                    <input type="date" class="form-control" name="date_fin" value="<?= $fin?>" required>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Commercial :</label>
                                    <select class="form-control" name="id_employe" id="user" required>
                                        <option value="">Séléctionner un Commerciale</option>
                                        <?php foreach($employes as $employe):?>
                                            <option value="<?= $employe['id_emp']?>">
                                                <?= $employe['nom']?> <?= $employe['prenom']?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <button class="btn btn-info" style="width:100%; card-shadow: 8px 8px 2px #ECF0EF;">
                                    <i class="fa fa-search"></i> &nbsp; Filtrer
                                </button>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="callout callout-success"
                style="margin-bottom: 10px ; background-color:  #7ECD04 !important; color: white; border-left: 5px solid #649E0A;">
                <h5 style="margin: 0px;">Nombre de Ventes :</h5>
                <h3 style="margin: 10px 0px 0px 0px;"><?= $totalVente != 0 ? $totalVente : '...' ?></h3>
                <br>
                <h5 style="margin: 0px;">Total de Ventes :</h5>
                <h2 id="total_ventes" style="margin: 10px 0px 0px 0px;">
                <?php if($totalVentesHT != 0):?>
                    <?= $totalVentesHT ?><small>DH</small>
                <?php else:?>
                    ...
                <?php endif;?>
                </h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="callout callout-info"
                style="margin-bottom: 10px; background-color: #DC8E24 !important; color: white; border-left: 5px solid #BD6D01;">
                <h5 style="margin: 0px;">Nombre de Clients :</h5>
                <h3 style="margin: 10px 0px 0px 0px;"><?= $totalClient != 0 ? $totalClient : '...' ?></h3>
                <br>
                <h5 style="margin: 0px;">Nombre Des Tâches :</h5>
                <h2 id="total_avoirs" style="margin: 10px 0px 0px 0px;"><?= $totalTache != 0 ? $totalTache : '...' ?></h2>
            </div>
        </div>
    </div>
    <?php if($totalVentesHT != 0):?>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default card-solid collapsed-card">
                <div class="card-header with-border">
                    <h3 class="card-title">Historique de Ventes (<b><?= $totalVente?></b>)</h3>
                    <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                </div>
                <div class="card-body" style="padding-top: 3px; display: none;">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="export_btns_6" style="float: right;margin: 8px 0px 12px 0px;"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table id="myDataTable_6" class="table myDataTable table-bordered table-striped">
                                <thead>
                                <th>N° de Vente</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Reste à payé</th>
                                </thead>
                                <tbody>
                                    <?php if($totalVente>0):?>
                                        <?php foreach($ventes as $vente):?>
                                            <tr>
                                                <td>
                                                    <a href="<?= base_url('vente/details/'.$vente['id_vente'])?>" data-toggle="tooltip" data-placement="top" title="Voir Cette Vente">
                                                        <strong><?= $vente['code_vente']?></strong>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('client/details/commande/'.$vente['id_client'])?>" data-toggle="tooltip" data-placement="top" title="Voir Ce Client">
                                                        <strong><?= $vente['societe']?></strong>
                                                    </a>
                                                </td>
                                                <td><?= $vente['date_vente']?></td>
                                                <td>
                                                    <strong><?= $vente['total_ht']?></strong> <small>DH</small>
                                                </td>
                                                <td <?= $vente['montant_rest'] != 0 ?"style=display:flex;justify-content:space-around;":"style=text-align:center"?> >
                                                    <span>
                                                        <strong class="text-danger"><?= $vente['montant_rest']?></strong> <small>DH</small>&nbsp;&nbsp;&nbsp;
                                                    </span>
                                                    <?php if($vente['montant_rest'] != 0 ):?>
                                                        <button class="btn btn-primary rounded btn-sm" data-toggle="modal" data-target="#exampleModal">
                                                            <i class="fa fa-money"></i> &nbsp; Paiements
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
                                                                            <input type="number" class="form-control" id="paiement" placeholder="Entrer un paiement" required>
                                                                        </div>
                                                                        <div class="row mb-2">
                                                                            <label for="reste" class="form-label"><span style="color:red;">*</span>Reste <small>DH</small></label>
                                                                            <input type="number" class="form-control" id="reste" data-initial="<?= $vente['montant_rest'] ?>" value="<?= $vente['montant_rest'] ?>" name="motant_rest" readonly>
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
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                    <?php else:?>
                                        <td colspan="5" style="text-align:center" class="bg-light">
                                            <p>Aucune Vente trouvée...</p>
                                        </td>
                                    <?php endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default card-solid collapsed-card">
                <div class="card-header with-border">
                    <h3 class="card-title">Historique de Commandes de clients (<b><?= $totalcommande ?></b>)</h3>
                    <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                </div>
                <div class="card-body" style="padding-top: 3px; display: none;">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="export_btns_11" style="float: right;margin: 8px 0px 12px 0px;"></div><br>
                        </div>
                    </div>
                    <div class="row">
    <div class="col-md-12 table-responsive">
        <table id="myDataTable_11" class="table myDataTable table-bordered table-striped text-center">
            <thead>
                <th>Code</th>
                <th>Client</th>
                <th>Date</th>
                <th>Services</th>
                <th>Vente</th>
            </thead>
            <tbody>
                <?php if ($commandes): ?>
                    <?php foreach ($commandes as $commande): ?>
                        <?php
                        $services = explode(',', $commande['service_titles']);
                        ?>
                        <?php foreach ($services as $index => $service): ?>
                            <tr>
                                <?php if ($index === 0): ?>
                                    <td rowspan="<?= count($services) ?>">
                                        <a href="<?= base_url('/commande/show/' . $commande['id_commande']) ?>" data-toggle="tooltip" data-placement="top" title="Voir Cette Comande">
                                            <strong><?= $commande['code_commande'] ?></strong>
                                        </a>
                                    </td>
                                    <td rowspan="<?= count($services) ?>">
                                        <a href="<?= base_url('client/details/commande/' . $commande['id_client']) ?>" data-toggle="tooltip" data-placement="top" title="Voir Ce Client">
                                            <strong><?= $commande['societe'] ?></strong>
                                        </a>
                                    </td>
                                    <td rowspan="<?= count($services) ?>"><?= $commande['date_D'] ?></td>
                                    <td><?= $service ?></td>
                                    <td rowspan="<?= count($services) ?>">
                                        <?php
                                        $commandHasSale = false;
                                        foreach ($ventecommande as $venteC) {
                                            if ($commande['id_commande'] == $venteC['id_commande']) {
                                                echo '<span class="text-success">' . $venteC['code_vente'] . '</span>';
                                                $commandHasSale = true;
                                                break;
                                            }
                                        }
                                        if (!$commandHasSale) {
                                            echo '<i class="fa fa-times text-danger" aria-hidden="true"></i>';
                                        }
                                        ?>
                                    </td>
                                <?php else: ?>
                                    <td><?= $service ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center" class="bg-light">
                            <p>Aucune Commande trouvée...</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
</section>

<?php $this->endsection() ?>
<?php $this->section('script') ?>
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
    });
</script>
<?php $this->endsection() ?>