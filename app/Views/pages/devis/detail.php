<?php $this->extend('templates/layout') ?>

<!-- titre du page -->
<?php $this->section('title') ?>
DETAIL DEVIS -- PAGE
<?php $this->endsection() ?>

<?php $this->section('devis') ?>
active
<?php $this->endsection() ?>

<!-- Le contenue du page home -->
<?php $this->section('content') ?>
<section class="content-header bg-light">
<div class="col-md-12">
    <div class="box">
        <h2 class="page-header" style="display:flex;justify-content:space-between">
        <img src="http://fms.dyndns.info/planing/uploads/logo-atlashost-1.png" alt="FES MARKETING SERVICE" />
            <small class="pull-right">Date: <?php echo date('d/m/Y'); ?></small>
        </h2>
    </div>
</div><!-- /.col -->
</section>

<section class="content" style="padding:30px;">
    <div class="col-md-12 row">
        
        <div class="col-sm-4 invoice-col ">
            <address class="">
                <strong class="">FES MARKETING SERVICE</strong><br>

                GSM: 06 61 52 57 40<br>
                Tel: 05 35 64 51 03<br>
                E-mail: commercial@fes-marketing.net<br>
                Site: www.fes-marketing.net
            </address>
        </div><!-- /.col -->
                <div class="col-sm-4 pull-left">
            <address class="">
                <br>
                <strong class=""><?= $client[0]['societe']?></strong><br>

                GSM: <?= $client[0]['numero_telephone']?><br>
                E-mail: <?php $client[0]['email_client']?><br>
                Ville: <?= $client[0]['ville']?>            </address>
        </div><!-- /.col -->
    </div>
    <div class="col-xs-12 table-responsive">
        <p> <h3  style="text-decoration: underline">Détails dU Devis</h3></p>
        <table class="table table-bordered table-striped" border="1">
            <tr>
                <th>Service/Projet</th>
                <td></td>
            </tr>
            <tr>
                <th>Responsable commercial</th>
                <td><strong class="badge bg-primary"><?= $client[0]['nom'].' '.$client[0]['prenom']?></strong></td>
            </tr>
            <tr>
                <th>Responsable technique</th>
                <td><?= $client[0]['nom'].' '.$client[0]['prenom']?></td>
            </tr>
            <tr>
                <th>Date Debut</th>
                <td><?= $devis['date_saisie']?></td>
            </tr>
            <tr>
                <th>Montant HT</th>
                <th><strong class="badge bg-yellow"><?= $devis['total_ht']?> Dh</strong></th>
            </tr>

                <tr>
                    <th>Montant TTC</th>
                    <th><strong class="badge bg-yellow"><?= $devis['total_ttc']?> Dh</strong></th>
                </tr>
                <tr>
                    <th>Remarque</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Mode de Paiement</th>
                    <td><?= $devis['modalite_paiement']?></td>
                </tr>
                <tr>
                    <th>Etat</th>
                    <td><?= $devis['etat']?></td>
                </tr>
                    </table>

    <div class="col-xs-12 no-print" style="display:flex;justify-content:space-between">
        <button class="btn btn-default " onclick="window.print();"><i class="fa fa-print"></i></button>
        <a href="http://fms.dyndns.info/planing/admin/regions" class="btn btn-default pull-right"><i
                    class="fa fa-reply"></i> Retour</a>
    </div>
    <div class="clear"></div>
</section>
<?php $this->endsection()?>