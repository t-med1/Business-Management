<?php $this->extend('templates/layout') ?>

<!-- titre du page -->
<?php $this->section('title') ?>
DETAIL COMMANDE -- PAGE
<?php $this->endsection() ?>
<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
<?php $this->endsection() ?>
<?php $this->section('commande') ?>
active
<?php $this->endsection() ?>

<!-- Le contenue du page home -->
<?php $this->section('content') ?>
<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Commandes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Acceuil</a></li>
                        <li class="breadcrumb-item active">Détails Commandes</li>
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
                    <div class="col-md-12" style="overflow-x: auto;">
                        <table class="table">
                            <thead>
                            <tr>
                                <th colspan="3" style="text-align: center; font-size: 2.5rem;"><?= $commande['code_commande']?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="current-width">Commercial</td>
                                <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                <td><span class="label label-info" data-toggle="tooltip" data-placement="top" title="<?= $employee['role']?>"><?= $employee['nom']?> <?= $employee['prenom']?></span></td>
                            </tr>
                            <tr>
                                <td class="current-width">Client</td>
                                <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                <td><strong><a href="<?= base_url('client/details/commande/'.$employee['id_emp'])?>" data-toggle="tooltip" data-placement="top" title="Voir Détails De Ce Client"><?= $client['societe']?></a></strong></td>
                            </tr>
                            <tr>
                                <td class="current-width">Date Commande <br>de Client</td>
                                <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                <td><strong><?= $commande['date_debut']?></strong></td>
                            </tr>
                            <tr>
                                <td class="current-width">Vente</td>
                                <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                <td>
                                    <?php if($vente):?>
                                        <strong><a href="<?= base_url('vente/details/'.$vente['id_vente'])?>"><?= $vente['code_vente']?></a></strong>
                                    <?php else:?>
                                        <a href="<?= base_url('Vente/ajouter/'.$commande['id_commande'])?>" class="btn btn-primary btn-xs" style="width: 100%;" data-toggle="tooltip" data-placement="top" title="Créer vente"><i class="fa fa-shopping-cart"></i>&nbsp; Créer</a>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <tr>
                                <td class="current-width">Remarque</td>
                                <td class="current-width">&nbsp; : &nbsp;&nbsp;</td>
                                <td><strong><?= $commande['remarque']?></strong></td>
                            </tr>
                            </tbody>
                        </table>
                        <a href="<?= base_url('commande/modifier/'.$commande['id_commande'])?>" class="btn btn-success btn-xs" style="width: 100%;" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fa fa-wrench"></i>&nbsp; Modifier</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info card-solid">
                    <div class="card-header with-border">
                        <h3 class="card-title">Détails de Commande <?= $commande['code_commande']?> </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="export_btns" style="float: right;margin: 8px 0px 12px 0px;"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table id="myDataTable" class="table myDataTable table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>Code Service</th>
                                        <th>Service</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($services):?>
                                        <?php foreach($services as $service):?>
                                            <tr>
                                                <td>
                                                    <a href="<?= base_url('/service')?>" data-toggle="tooltip" data-placement="top" title="Voir La Liste">
                                                        <strong><?= $service['code_service']?></strong>
                                                    </a>
                                                    
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('/service')?>" data-toggle="tooltip" data-placement="top" title="Voir La Liste">
                                                        <strong><?= $service['titre']?></strong>
                                                    </a>
                                                    
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="2" style="text-align:center" class="bg-light">
                                                    <p>Aucun Service trouvée...</p>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
</section>
<?php $this->endsection()?>