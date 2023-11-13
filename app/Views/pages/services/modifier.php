<?php $this->extend('templates/layout') ?>

<!-- titre du page -->
<?php $this->section('title') ?>
MODIFIER SERVICE - PAGE
<?php $this->endsection() ?>
<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
<?php $this->endsection() ?>
<?php $this->section("service")?>
active
<?php $this->endsection()?>

<!-- Le contenue du page home -->
<?php $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Service</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= base_url('/service')?>">Acceuil</a></li>
					<li class="breadcrumb-item active">Modifier Service</li>
				</ol>
			</div>
		</div>
	</div>
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
    <div class="card card-info">
        <div class="card-header bg-success">
            <h3 class="card-title">Modifier Service</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form method="post" action="/service/update/<?= $service['id_service']?>">
                <?= csrf_field() ?>
                <!-- les champs des services -->
                <span class="services-add">
                    
                    <div class="service">
                        <div class="row">
                            <div class="mb-3 col-sm-7">
                                <label for="desc" class="form-label">Titre  du service <font color="red">*</font></label>
                                <input type="text" class="form-control desc_0" id="desc" name="titre" value="<?= $service['titre']?>" placeholder="entrer un service ...">
                            </div>
                            <div class="mb-3 col-sm-2">
                                <label for="pu" class="form-label">Prix Unitaire</label>
                                <input type="number" class="form-control prices" id="pu" name="prix_unitaire" value="<?= $service['prix_unitaire']?>" placeholder="entrer un prix ..." onInput="updateTotal(0)">
                            </div>
                            <div class="mb-3 col-sm-2">
                            <label for="pu" class="form-label"></label>
                            
                            </div>
                        </div>
                        <div class="row" style="display:flex;justify-content:space-around">
                            <a href="/retour" class="btn btn-default pull-right"><i
                                class="fa fa-reply"></i> Retour</a>
                            <button class="btn btn-outline-success btn-flat"
                                style="border-radius: 15px;">
                                <i class="fa fa-wrench" aria-hidden="true"></i>
                                Modifier
                            </button>
                        </div>
                    </div>
                </span>
                
            </form>

<script src="../../css/home.js"></script>
<script src="../jquery-3.6.4.min.js"></script>
<?php $this->endsection() ?>