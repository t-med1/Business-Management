<?php $this->extend('templates/layout')?>

<!-- titre du page -->
<?php $this->section('title')?>
AJOUTER SERVICE - PAGE
<?php $this->endsection()?>
<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
<?php $this->endsection() ?>
<?php $this->section("sevice")?>
active
<?php $this->endsection()?>

<?php $this->section("seviceadd")?>
active
<?php $this->endsection()?>


<!-- Le contenue du page home -->
<?php $this->section('content')?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Service</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
                    <li class="breadcrumb-item active">Ajouter Service</li>
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
	<!-- general form elements disabled -->
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Ajouter Service</h3>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<form method="post" action="<?= base_url('service/save')?>">
				<?= csrf_field()?>
				<!-- les champs des services -->
				<span class="services-add">
					<div class="service">
                        <div class="row">
							<div class="mb-3 col-sm-2">
								<label for="code" class="form-label">Code Service</label>
								<input type="text" class="form-control prices" id="code" name="code_service" value="<?= $serviceCode?>" readonly required>
							</div>
                            <div class="mb-3 col-sm-7">
								<label for="desc" class="form-label">Titre  du service <font color="red">*</font></label>
								<input type="text" class="form-control desc_0" id="desc" name="titre" placeholder="entrer un service ..." required>
							</div>
							<div class="mb-3 col-sm-2">
								<label for="pu" class="form-label">Prix Unitaire</label>
								<input type="number" class="form-control prices" id="pu" name="prix_unitaire" placeholder="entrer un prix ..." onInput="updateTotal(0)">
							</div>
                        </div>
					</div>
				</span>
				<div class="row" style="display:flex; justify-content:center">
					<div class="col-sm-3">
						<button type="submit" class="btn btn-outline-info btn-block btn-flat" style="border-radius:10px;"><i
							class="fa fa-book"></i> Enregistrer</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<?php $this->endsection()?>