<?php $this->extend('templates/layout') ?>

<?php $this->section("title") ?>
COMMANDE LIST - PAGE
<?php $this->endsection() ?>
<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
<?php $this->endsection() ?>
<?php $this->section("commandel") ?>
active
<?php $this->endsection() ?>
<?php $this->section("commande") ?>
active
<?php $this->endsection() ?>

<?php $this->section("content") ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Commandes</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
                    <li class="breadcrumb-item active">Liste Commandes</li>
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
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="card-title">Filtrer Les Commandes</h3>
                    </div>
                    <div class="card-body">

                        <form method="get" action="">

                            <div class="row">

                                <div class="col-md-3"></div>

                                <div class="col-md-3">

                                    <div class="form-group">

                                        <label>Entre Le :</label>

                                        <input type="date" class="form-control" name="date_debut" value="<?= $debut ?>"
                                            required>

                                    </div>
                                </div>

                                <div class="col-md-3">

                                    <div class="form-group">

                                        <label>Et Le :</label>

                                        <input type="date" class="form-control" name="date_fin" value="<?= $fin ?>"
                                            required>

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
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="card-title">Liste Des Commandes</h3>
                    </div>
                    <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover text-center">
    <thead>
        <tr>
            <th>Code</th>
            <th>Commerciale</th>
            <th>Client</th>
            <th>Service</th>
            <th>Date Début</th>
            <th>Vente</th>
            <th style="width: 150px" class="text-center">Options</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($commandes_non_annulees): ?>
            <?php foreach ($commandes_non_annulees as $commande): ?>
                <?php
                $services = explode(',', $commande['service_titles']);
                $firstService = true;
                ?>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <?php if ($firstService): ?>
                            <td rowspan="<?= count($services) ?>">
                                <a href="<?= base_url('/commande/show/' . $commande['id_commande']) ?>" data-toggle="tooltip" data-placement="top" title="Voir Cette Comande">
                                    <strong><?= $commande['code_commande'] ?></strong>
                                </a>
                            </td>
                            <td rowspan="<?= count($services) ?>">
                                <span class="badge <?= $commande['role'] == 'admin' ? 'bg-success' : 'bg-warning' ?> custom-tooltip" data-toggle="tooltip" data-placement="top" title="<?= $commande['role'] ?>">
                                    <?= $commande['id_emp'] == session('id_employe') ? "VOUS" : $commande['nom'].' '.$commande['prenom'] ?>
                                </span>
                            </td>
                            <td rowspan="<?= count($services) ?>">
                                <a href="<?= base_url('client/details/commande/' . $commande['id_client']) ?>" data-toggle="tooltip" data-placement="top" title="Voir Ce Client">
                                    <strong><?= $commande['societe'] ?></strong>
                                </a>
                            </td>
                            <td><?= $service ?></td>
                            <td rowspan="<?= count($services) ?>"><?= $commande['dateCommande'] ?></td>
                            <td rowspan="<?= count($services) ?>">
                                <?php if (isset($salesByCommandId[$commande['id_commande']])): ?>
                                    <span class="text-success"><?= $salesByCommandId[$commande['id_commande']]['code_vente'] ?></span>
                                <?php else: ?>
                                    <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                <?php endif; ?>
                            </td>
                            <td class="text-center" rowspan="<?= count($services) ?>">
                                <div class="btn-container" style="display:flex;justify-content:center;gap:5px">
                                    <a href="<?= base_url('/commande/show/' . $commande['id_commande']) ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Détails">
                                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                                    </a>
                                    <a href="<?= base_url('/commande/modifier/' . $commande['id_commande']) ?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier">
                                        <i class="fa fa-wrench" aria-hidden="true"></i>
                                    </a>
                                    <a href="<?= base_url('commande/annuler/' . $commande['id_commande']) ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Annuler" onclick="return confirmSwalAnnuler(<?= $commande['id_commande'] ?>);">
                                        <i class="fa fa-ban" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </td>
                        <?php else: ?>
                            <td><?= $service ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php $firstService = false; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align:center" class="bg-light">
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
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="card-title">Liste Des Commandes (Annulées)</h3>
                    </div>
                    <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover text-center">
    <thead>
        <tr>
            <th>Code</th>
            <th>Commerciale</th>
            <th>Client</th>
            <th>Service</th>
            <th>Date Début</th>
            <th>Vente</th>
            <th style="width: 150px" class="text-center">Options</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($commandes_annulees): ?>
            <?php foreach ($commandes_annulees as $commande): ?>
                <?php
                $services = explode(',', $commande['service_titles']);
                $firstService = true;
                ?>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <?php if ($firstService): ?>
                            <td rowspan="<?= count($services) ?>">
                                <a href="<?= base_url('/commande/show/' . $commande['id_commande']) ?>" data-toggle="tooltip" data-placement="top" title="Voir Cette Comande">
                                    <strong><?= $commande['code_commande'] ?></strong>
                                </a>
                            </td>
                            <td rowspan="<?= count($services) ?>">
                                <span class="badge <?= $commande['role'] == 'admin' ? 'bg-success' : 'bg-warning' ?> custom-tooltip" data-toggle="tooltip" data-placement="top" title="<?= $commande['role'] ?>">
                                    <?= $commande['nom'] ?> <?= $commande['prenom'] ?>
                                </span>
                            </td>
                            <td rowspan="<?= count($services) ?>">
                                <a href="<?= base_url('client/details/commande/' . $commande['id_client']) ?>" data-toggle="tooltip" data-placement="top" title="Voir Ce Client">
                                    <strong><?= $commande['societe'] ?></strong>
                                </a>
                            </td>
                            <td><?= $service ?></td>
                            <td rowspan="<?= count($services) ?>"><?= $commande['dateCommande'] ?></td>
                            <td rowspan="<?= count($services) ?>">
                                <?php if (isset($salesByCommandId[$commande['id_commande']])): ?>
                                    <span class="text-success"><?= $salesByCommandId[$commande['id_commande']]['code_vente'] ?></span>
                                <?php else: ?>
                                    <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                <?php endif; ?>
                            </td>
                            <td class="text-center" rowspan="<?= count($services) ?>">
                            <div class="btn-container" style="display:flex;justify-content:center;gap:5px">
                                                <a href="<?= base_url('/commande/show/' . $commande['id_commande']) ?>"
                                                    class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                    data-placement="top" title="Détails">
                                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                </a>

                                                    <a href="<?= base_url('/commande/modifier/' . $commande['id_commande']) ?>"
                                                        class="btn btn-success btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="Modifier">
                                                        <i class="fa fa-wrench" aria-hidden="true"></i>
                                                    </a>
                                                    <a href="<?= base_url('commande/update_annuler/' . $commande['id_commande']) ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Retenir" >
                                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                                    </a>



                                                </div>
                            </td>
                        <?php else: ?>
                            <td><?= $service ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php $firstService = false; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align:center" class="bg-light">
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
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmSwalAnnuler(id_commande) {
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: 'Cela va annuler cette commande!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= site_url('commande/annuler/') ?>' + id_commande;
            }
        });
        return false;
    }
</script>

<?php $this->endsection() ?>

<?php $this->section('script') ?>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });
</script>
<?php $this->endsection() ?>