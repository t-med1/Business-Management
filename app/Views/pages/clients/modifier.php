<?php $this->extend('templates/layout') ?>

<!-- titre du page -->
<?php $this->section('title') ?>
MODIFIER CLIENT - PAGE
<?php $this->endsection() ?>
<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
<?php $this->endsection() ?>
<!-- Le contenue du page home -->
<?php $this->section('content') ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Client</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
                    <li class="breadcrumb-item active">Modifier Client</li>
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
        <div class="card-header bg-success">
            <h3 class="card-title">Modifier Client</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form  class="form-horizontal" method="post" action="<?= base_url('client/update/' . $client['id_client']) ?>">
                <?= csrf_field() ?>
					<div class="row justify-content-center">
                <div class="col-md-8">
                    
                    <div class="form-group">
                        <label for="societe" class="col-sm-2 control-label">ICE</label>

                        <div class="col-sm-9">
                            <input type="text" name="ICE" value="<?= $client['ICE']?>" class="form-control" id="ice" placeholder="Société"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="societe" class="col-sm-2 control-label">Société</label>

                        <div class="col-sm-9">
                            <input type="text" name="societe" value="<?= $client['societe']?>" class="form-control" id="societe" placeholder="Société"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ville" class="col-sm-2 control-label">Ville</label>

                        <div class="col-sm-9">
                            <input type="text" name="ville" value="<?= $client['ville']?>" class="form-control"  placeholder="Ville"/>
                            <span style="color: red;"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="designation" class="col-sm-2 control-label">Contact</label>

                        <div class="col-sm-9">
                            <input type="text" name="contact" value="<?= $client['contact']?>" class="form-control"  placeholder="Nom"/>
                            <span style="color: red;"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="designation" class="col-sm-2 control-label">Téléphone</label>

                        <div class="col-sm-9">
                            <input type="text" name="numero_telephone" value="<?= $client['numero_telephone']?>" class="form-control"  placeholder="Tel"/>
                            <span style="color: red;"></span>
						</div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>

                        <div class="col-sm-9">
                            <input type="text" name="email_client" value="<?= $client['email_client']?>" class="form-control"  placeholder="Email"/>
                            <span style="color: red;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Adresse</label>

                        <div class="col-sm-9">
                            <input type="text" name="adresse" value="<?= $client['adresse']?>" class="form-control"  placeholder="Adresse"/>
                            <span style="color: red;"></span>
						</div>
                    </div>
                    <div class="form-group">
                        <label for="commercial" class="col-sm-2 control-label">Commercial</label>
                        <div class="col-sm-9">
						<select class="form-control" name="code_emp" id="code_emp" required>
                            <?php foreach($employes as $employe):?>
                                <option <?= $employe['id_emp'] == $client['id_emp'] ? "selected" : "" ?> value="<?= $employe['id_emp']?>"><?=$employe['nom']?> <?=$employe['prenom']?></option>
                            <?php endforeach; ?>
                        </select>
                            <span style="color: red;"></span>
						 </div>
                    </div>

                    <div class="form-group">
                        <label for="source" class="col-sm-2 control-label">Source</label>
                        <div class="col-sm-9">
                            <select name="source" id="source" class="form-control js-example-basic-single">
                                <?php
                                $options = ['Par Tel', 'Facebook', 'Site internet', 'Publicite'];
                                foreach ($options as $option) {
                                    $selected = ($client['source'] === $option) ? 'selected' : '';
                                    echo '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
                                }
                                ?>
                            </select>
                            <span style="color: red;"></span>
						</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="remarque" class="col-sm-2 control-label">Remarque</label>

                        <div class="col-sm-9">
                            <input type="text" name="remarque" value="<?= $client['remarque'] ?>" class="form-control"  placeholder="Remarque">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-11" style="display:flex;justify-content:space-around">
                            <a href="/client" class="btn btn-default pull-left"><i
                                class="fa fa-reply"></i> Retour</a>
								<button type="submit" class="btn btn-outline-success btn-flat" style="border-radius:10px;"><i
                                class="fa fa-wrench"></i> Modifier</button>
                        </div>
                    </div>
                    </form>
				</div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

</section>
<?php $this->endsection() ?>
