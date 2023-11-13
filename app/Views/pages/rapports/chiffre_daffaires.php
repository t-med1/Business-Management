<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
CHIFRE D'AFFIRE - PAGE
<?php $this->endsection() ?>

<?php $this->section('rapports') ?>
active
<?php $this->endsection() ?>
<?php $this->section('chiffre_daffaires') ?>
active
<?php $this->endsection() ?>

<?php $this->section("content") ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Chiffre d'affaires</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('/')?>">Acceuil</a></li>
                    <li class="breadcrumb-item active">Chiffre D'affires</li>
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
            <div class="col-12">
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
    <form method="get" action="">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Entre Le :</label>
                    <input type="date" class="form-control" name="date_debut"
                        value="<?= $debut ?>" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Et Le :</label>
                    <input type="date" class="form-control" name="date_fin"
                        value="<?= $fin ?>" required>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
            <button class="btn btn-info"
                                        style="width:100%; box-shadow: 8px 8px 2px #ECF0EF;">
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
    </div>
</section>
<!-- ------------------------------------------------------------------------------------------- -->

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
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
                        <div class="callout callout-default" style="margin-bottom: 10px; background-color: gray !important; color: white; border-left: 5px solid #555555;">
                            <h5 style="margin: 0px;">Nombre de Ventes :</h5>
                            <h3 style="margin: 10px 0px 0px 0px;"><span><?= $totalVentes ?></span></h3>
                        </div>
                        <div class="callout callout-info" style="margin-bottom: 10px; background-color: #33adff !important; color: white; border-left: 5px solid #555555;">
                            <h5 style="margin: 0px;">Chiffre d'affaires HT :</h5>
                            <h3 style="margin: 10px 0px 0px 0px;"><span></span> <?= number_format($chiffreAffairesHT, 2) ?> <span style="font-size: 16px;">DH</span></h3>
                        </div>
                        <div class="callout callout-success" style="margin-bottom: 10px; background-color:  #00b300 !important; color: white; border-left: 5px solid #555555;">
                            <h4 style="margin: 0px;">Chiffre d'affaires TTC :</h4>
                            <h2 style="margin: 10px 0px 0px 0px;"><span><?= number_format($chiffreAffairesTTC, 2) ?></span> <span style="font-size: 16px;">DH</span></h2>
                        </div>
                        <div class="callout callout-default" style="margin-bottom: 10px; background-color: gray !important; color: white; border-left: 5px solid #555555;">
                            <h5 style="margin: 0px;">TVA :</h5>
                            <h3 style="margin: 10px 0px 0px 0px;"><span><?= number_format($tva, 2) ?></span> <span style="font-size: 16px;">DH</span></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $this->endsection() ?>