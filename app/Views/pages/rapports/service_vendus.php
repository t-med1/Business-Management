<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
SERVICES VENDUS - PAGE
<?php $this->endsection() ?>

<?php $this->section('rapports') ?>
active
<?php $this->endsection() ?>
<?php $this->section('service_vendus') ?>
active
<?php $this->endsection() ?>

<?php $this->section("content") ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Service Vendus</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Acceuil</a></li>
                    <li class="breadcrumb-item active">Service Vendus</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info card-solid">
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
                        action="<?= base_url('rapports/service_vendus')?>">
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
        <div class="col-md-12">
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
                        <div class="col-md-6">
                            <div class="callout callout-success" style="margin-bottom: 5px; background-color:  #7ECD04 !important; color: white; border-left: 5px solid #649E0A;">
                                <h5 style="margin: 0px;">Total de Ventes :</h5>
                                <h3 style="margin: 10px 0px 0px 0px;"><span id="span_vente"><?= $totalVente?></span> <span
                                        style="font-size: 16px;">DH</span></h3>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="callout callout-info" style="margin-bottom: 5px; background-color: #DC8E24 !important; color: white; border-left: 5px solid #BD6D01;"">
                                <h5 style="margin: 0px;">Bénéfice :</h5>
                                <h3 style="margin: 10px 0px 0px 0px;"><span id="span_benefice"><?= $totalProfit ?></span> <span
                                        style="font-size: 16px;">DH</span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="export_btns" style="float: right;margin: 8px 0px 12px 0px;"></div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table id="myDataTable" class="table myDataTable table-bordered table-striped">
                                <thead>
                                    <th>Code Vente</th>
                                    <th>Service</th>
                                    <th>Quantité Vendue</th>
                                    <th>Total de Ventes</th>
                                </thead>
                                <tbody>
                                    <?php if($serviceVendus):?>
                                        <?php foreach($serviceVendus as $vente):?>
                                        <tr>
                                            <td>
                                                <a href="" rel="popover" data-img="" data-toggle="tooltip" data-placement="top" title="Voir Cette Vente">
                                                    <strong><?= $vente['code_vente']?></strong>
                                                </a>
                                            </td>

                                            <td class="info">
                                                <a href="" rel="popover" data-img="" data-toggle="tooltip" data-placement="top" title="Voir Ce service">
                                                    <strong><?= $vente['titre']?></strong>
                                                </a>
                                                
                                            </td>
                                            <td>
                                                <strong><?= $vente['quantity_sold']?></strong>
                                            </td>
                                            <td>
                                                <strong><?= $vente['total_ht_sold'] ?></strong> <small>DH</small>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </tbody>
                            </table>
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
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<?php $this->endsection() ?>