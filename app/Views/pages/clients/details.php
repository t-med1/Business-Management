<?php $this->extend('templates/layout') ?>

<!-- titre du page -->
<?php $this->section('title') ?>
DETAILS CLIENT - PAGE
<?php $this->endsection() ?>
<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
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
                    <li class="breadcrumb-item active">Details Client</li>
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
            <div class="card card-info  ">
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
                                        <th colspan="3" style="text-align: center; font-size: 2.5rem;"><?= $clients['societe']?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="current-width">Code Client</td>
                                        <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                        <td><strong><?= $clients['code_client']?></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="current-width">Commercial</td>
                                        <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                        <td><span class="label label-warning" data-toggle="tooltip" data-placement="top"
                                                title="<?= $employee['role'] ?>"><?= $employee['nom'].' '.$employee['prenom']?></span></td>
                                    </tr>
                                    <tr>
                                        <td class="current-width">Contact</td>
                                        <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                        <td><strong><?= $clients['contact']?></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="current-width">Ville</td>
                                        <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                        <td><strong><?= $clients['ville']?></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="current-width">Téléphone</td>
                                        <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                        <td><strong><?= $clients['numero_telephone']?></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="current-width">Email</td>
                                        <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                        <td><strong><?= $clients['email_client']?></strong></td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            
                            <a href="<?= base_url('client/modifier/'.$clients['id_client'])?>"
                                class="btn btn-success btn-sm" style="width: 100%;"><i class="fa fa-wrench"></i>&nbsp;
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
                            <h3 class="card-title">Liste de ventes de <?= $clients['societe']?> </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table id="example1" class="table myDataTable table-bordered table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th>N° de Vente</th>
                                                <th>Date</th>
                                                <th>Montant Ht</th>
                                                <th>Reste à payé</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($ventes):?>
                                                <?php foreach($ventes as $vente):?>
                                                    <tr>
                                                        <td>
                                                            <strong>
                                                                <a href="<?= base_url('vente/details/'.$vente['id_vente'])?>" style="text-decoration:none;" data-toggle='tooltip' data-placement='top' title="Voir Cette Vente">
                                                                    <?= $vente['code_vente']?>
                                                                </a>
                                                            </strong>
                                                        </td>
                                                        <td>
                                                            <?= $vente['date_vente']?>
                                                        </td>
                                                        <td>
                                                            <strong><?= $vente['total_ht']?></strong> <small>DH</small>
                                                        </td>
                                                        <td>
                                                            <strong><?= $vente['montant_rest']?></strong> <small>DH</small>
                                                        </td>
                                                    </tr>
                                                <?php endforeach;?>
                                            <?php else:?>
                                                <tr>
                                                    <td colspan="4" style="text-align:center" class="bg-light">
                                                        <p>Aucune vente trouvée...</p>
                                                    </td>
                                                </tr>
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
                    <div class="card card-info">
                        <div class="card-header with-border">
                            <h3 class="card-title">Liste de factures de <?= $clients['societe']?> </h3>
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
                                    <table id="myDataTable_2" class="table myDataTable table-bordered table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th>N° de Facture</th>
                                                <th>Date</th>
                                                <th>Montant à payé</th>
                                                <th>Reste à payé</th>
                                                <th class="current-width no-export">Options</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($factures):?>
                                            <?php foreach( $factures as $facture ):?>
                                            <tr>
                                                <td>
                                                    <a href="<?= base_url('/facture')?>" style="text-decoration:none;"><strong><?= $facture['id_facture']?></strong></a>
                                                </td>
                                                <td><?= $facture['date_saisie']?></td>
                                                <td><strong><?= $facture['montant_pay']?></strong> <small>DH</small></td>
                                                <td><strong><?= $facture['montant_rest']?></strong> <small>DH</small></td>
                                                <td><a href="#"
                                                        target="_blank" class="btn btn-warning btn-xs"
                                                        style="width: 100%;" data-toggle="tooltip" title="Imprimer"><i class="fa fa-print"></i>&nbsp; Imprimer</a>
                                                </td>
                                            </tr>
                                            <?php endforeach;?>
                                            <?php else:?>
                                                <tr>
                                                    <td colspan="5" style="text-align:center" class="bg-light">
                                                        <p>Aucune Facture trouvée...</p>
                                                    </td>
                                                </tr>
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
                    <div class="card card-info">
                        <div class="card-header with-border">
                            <h3 class="card-title">Liste de commandes de <?= $clients['societe'] ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="export_btns_5" style="float: right;margin: 8px 0px 12px 0px;"></div><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                <table id="example1" class="table myDataTable table-bordered table-striped text-center">
    <thead>
        <tr>
            <th>Code</th>
            <th>Date</th>
            <th>Services</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($commandesWithServices)): ?>
            <?php foreach ($commandesWithServices as $item): ?>
                <tr>
                    <td>
                        <a href="<?= base_url('commande/' . $item['commande']['id_commande']) ?>" style="text-decoration:none;">
                            <strong><?= $item['commande']['code_commande'] ?></strong>
                        </a>
                    </td>
                    <td><?= $item['commande']['date_debut'] ?></td>
                    <td>
                        <?php if (!empty($item['services'])): ?>
                            <ul>
                                <?php foreach ($item['services'] as $service): ?>
                                    <li><?= $service['titre'] ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            No services
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="#" target="_blank" class="btn btn-warning btn-xs" style="width: 100%;">
                            <i class="fa fa-print"></i>&nbsp; Imprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" style="text-align:center" class="bg-light">
                    <p>Aucune commande trouvée...</p>
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
        </div>
    </div>
</section>
<?php $this->endsection() ?>
<?php $this->section('script') ?>
<script>
    $(document).ready(() => {
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>
<?php $this->endsection() ?>