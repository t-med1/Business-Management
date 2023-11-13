<?php $this->extend('templates/layout') ?>

<?php $this->section('title') ?>
EMPLOYE - LIST - PAGE
<?php $this->endsection() ?>
<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
<?php $this->endsection() ?>
<?php $this->section('Commeciale') ?>
active
<?php $this->endsection() ?>
<?php $this->section('Commecialel') ?>
active
<?php $this->endsection() ?>

<?php $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Commerciales</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Acceuil</a></li>
                    <li class="breadcrumb-item active">Liste Commerciales</li>
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
    <div class="row">
        <div class="col-md-12">

            <div class="card card-info card-solid">
                <div class="card-header with-border">
                    <h3 class="card-title">Liste de Commerciaux</h3>
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
                            <table id="example1" class="table myDataTable table-bordered table-striped">
                                <thead>
                                    <th>Commercial</th>
                                    <th>Email</th>
                                    <th>Numéro téléphone</th>
                                    <th style="width: 50%;">Dernière Activité</th>
                                    <th class="current-width no-export">Options</th>
                                </thead>
                                <tbody>
                                    <?php if ($listes_emp): ?>
                                        <?php foreach ($listes_emp as $employe): ?>
                                            <?php if(session('id_employe') !== $employe['id_emp']):?>
                                            <tr>
                                                <td>
                                                    <span
                                                        class="badge <?= $employe['role'] == 'admin' ? 'bg-success' : 'bg-warning' ?> custom-tooltip"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="<?= $employe['role'] ?>">
                                                        <?= $employe['nom']?> <?= $employe['prenom'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?= $employe['email'] ?>
                                                </td>
                                                <td>
                                                    <?= $employe['telephone'] ?>
                                                </td>
                                                <?php if ($employe['last_activity']): ?>
                                                    <td>
                                                        <?= $employe['last_activity'] ?>&nbsp;&nbsp;<b>
                                                            <?= $employe['description'] ?>
                                                        </b>
                                                    </td>
                                                <?php else: ?>
                                                    <td style="text-align:center" class="bg-light">
                                                        <p>Aucune Activitée Trouvée...</p>
                                                    </td>
                                                <?php endif; ?>
                                                <td class="text-center">
                                                    <div class="btn-container"
                                                        style="display:flex;justify-content:center;gap:5px">
                                                        
                                                        <a href="<?= base_url('Commerciale/details/' . $employe['id_emp']) ?>"
                                                            class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="Détails">
                                                            <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                        </a>
                                                        <?php if($employe['role'] != 'admin'):?>
                                                        <a href="<?= base_url('Commeciale/edit/' . $employe['id_emp']) ?>"
                                                            class="btn btn-success btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="Modifier">
                                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                                        </a>
                                                            <a href="<?= base_url('Commeciale/delete/' . $employe['id_emp']) ?>"
                                                                class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                                data-placement="top" title="Supprimer"
                                                                onclick="return confirmSwalDelete(<?= $employe['id_emp'] ?>);">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endif;?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" style="text-align:center" class="bg-light">
                                                <p>Aucun Commerciale trouvé...</p>
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
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmSwalDelete(id_emp) {
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: 'Cela va supprimer cet employé et ses tâches et congés associés !',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= site_url('Commeciale/detele/') ?>' + id_emp;
            }
        });
        return false;
    }
</script>
<?php $this->endsection() ?>

<?php $this->section('script') ?>

<script>
    function hideDivAfterTimeout() {
        var myDiv = document.getElementById("myDiv");
        if (myDiv) {
            setTimeout(function () {
                myDiv.style.display = "none";
            }, 3000);
        }
    }
    hideDivAfterTimeout();
</script>

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