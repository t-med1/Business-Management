<?php $this->extend('templates/layout') ?>

<?php $this->section('title') ?>
EMPLOYE - LIST - PAGE
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
            <h1>Commerciale</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Acceuil</a></li>
              <li class="breadcrumb-item active">Liste Permissions</li>
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
    <div class="col-md-3">
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
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th colspan="3" style="text-align: center; font-size: 2.5rem;"><?= $employee['nom']?> <?= $employee['prenom']?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><b>Role</b></td>
                                <td>&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td><span class="label label-warning" data-toggle="tooltip" data-placement="top" title="Géstionnaire"><?= $employee['role']?></span></td>
                            </tr>
                            </tbody>
                        </table>
                        <a href="<?= base_url('Commeciale/edit/'.$employee['id_emp'])?>" class="btn btn-success btn-xs" style="width: 100%;"><i class="fa fa-wrench"></i>&nbsp; Modifier</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info card-solid">
                    <div class="card-header with-border">
                        <h3 class="card-title">Liste de permissions</h3>
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
                                <table id="myDataTable_2" class="table myDataTable table-bordered table-striped">
                                    <tbody>

                                        <tr>
                                            <td style="width: 40%;"><h5><b>Clients</b></h5></td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="checkbox[]" value="1" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="9679-1" >
                                                    <label for="9679-1" class="custom-control-label"> Lire</label>
                                                </div>
                                            </td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                        <input name="checkbox[]" value="2" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="9679-2"  >
                                                        <label for="9679-2" class="custom-control-label"> Ajouter</label>
                                                </div>
                                            </td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="checkbox[]" value="3" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="9679-3"  >
                                                    <label for="9679-3" class="custom-control-label"> Modifier</label>
                                                </div>
                                            </td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="checkbox[]" value="4" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="9679-4" >
                                                    <label for="9679-4" class="custom-control-label"> Supprimer</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;"><h5><b>Services</b></h5></td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="checkbox[]" value="1" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="9979-1" >
                                                    <label for="9979-1" class="custom-control-label"> Lire</label>
                                                </div>
                                            </td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                        <input name="checkbox[]" value="2" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="9979-2"  >
                                                        <label for="9979-2" class="custom-control-label"> Ajouter</label>
                                                </div>
                                            </td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="checkbox[]" value="3" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="9979-3"  >
                                                    <label for="9979-3" class="custom-control-label"> Modifier</label>
                                                </div>
                                            </td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="checkbox[]" value="4" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="9979-4" >
                                                    <label for="9979-4" class="custom-control-label"> Supprimer</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;"><h5><b>Ventes</b></h5></td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="checkbox[]" value="1" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="3654-1" >
                                                    <label for="3654-1" class="custom-control-label"> Lire</label>
                                                </div>
                                            </td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                        <input name="checkbox[]" value="2" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="3654-2"  >
                                                        <label for="3654-2" class="custom-control-label"> Ajouter</label>
                                                </div>
                                            </td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="checkbox[]" value="3" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="3654-3"  >
                                                    <label for="3654-3" class="custom-control-label"> Modifier</label>
                                                </div>
                                            </td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="checkbox[]" value="4" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="3654-4" >
                                                    <label for="3654-4" class="custom-control-label"> Supprimer</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;"><h5><b>Devis</b></h5></td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="checkbox[]" value="1" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="5020-1" >
                                                    <label for="5020-1" class="custom-control-label"> Lire</label>
                                                </div>
                                            </td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                        <input name="checkbox[]" value="2" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="5020-2"  >
                                                        <label for="5020-2" class="custom-control-label"> Ajouter</label>
                                                </div>
                                            </td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="checkbox[]" value="3" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="5020-3"  >
                                                    <label for="5020-3" class="custom-control-label"> Modifier</label>
                                                </div>
                                            </td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="checkbox[]" value="4" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="5020-4" >
                                                    <label for="5020-4" class="custom-control-label"> Supprimer</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;"><h5><b>Commande Client</b></h5></td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="checkbox[]" value="1" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="9151-1">
                                                    <label for="9151-1" class="custom-control-label"> Lire</label>
                                                </div>
                                            </td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                        <input name="checkbox[]" value="2" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="9151-2" >
                                                        <label for="9151-2" class="custom-control-label"> Ajouter</label>
                                                </div>
                                            </td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="checkbox[]" value="3" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="9151-3" >
                                                    <label for="9151-3" class="custom-control-label"> Modifier</label>
                                                </div>
                                            </td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="checkbox[]" value="4" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="9151-4">
                                                    <label for="9151-4" class="custom-control-label"> Supprimer</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;">
                                                <h5>
                                                    <b>Rapports</b>
                                                </h5>
                                            </td>
                                            <td style="width: 15%;">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="checkbox[]" value="1" class="custom-control-input custom-control-input-success sms checkB" type="checkbox" id="9426-1" >
                                                    <label for="9426-1" class="custom-control-label"> Lire</label>
                                                </div>
                                            </td>
                                            <td style="width: 15%;">
 
                                            </td>
                                            <td style="width: 15%;">

                                            </td>
                                            <td style="width: 15%;">

                                            </td>
                                        </tr>
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
<?php $this->endsection()?>

<?php $this->section('script')?>
<script>
    $('.checkB').change(function () {
        // var ggg = $(this).val();
        const id = $(this).attr('id').split("-")
        let counter = id[1];
        if (this.checked) {
            for (let index = counter; index >= 0; index--) {
                let new_id = id[0]+`-${index}`;
                $('#'+new_id).prop('checked', true)
            }
        } else {
            for (let index = counter; index < 5; index++) {
                let new_id = id[0]+`-${index}`;
                $('#'+new_id).prop('checked', false)
            }
            counter -= 1;
        }
        $.ajax({
    url: '<?= base_url('updatePermission/' . $employee['id_emp']) ?>' + '/' + id[0] + '/' + counter,
    type: "GET",
    data: {
        id_emp: <?= $employee['id_emp'] ?>,
        pageNom: id[0],
        numeroMethod: counter
    },
    success: function (data) {
        if (data.success) {
            Swal.fire(
                'Success!', // Change this message as needed
                data.message, // Display the message from the response
                'success'
            );
        } else {
            Swal.fire(
                'Error!',
                "Permissions not modified",
                'danger'
            );
        }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
        Swal.fire(
            'Error!',
            "Permissions not modified",
            'danger'
        );
    }
});

        // alert(id[0]);
        // alert(id[1]);
        // alert(<?= $employee['id_emp'] ?>);
        // const sms = ['BA','CA', 'FA', 'NA'];
        // const email = ['BB','CB', 'FB', 'EA'];
        // const client = ['CC','OC', 'OE'];
        // if (!this.checked) {
        //     $(this).attr('checked', false)
        //     if (sms.includes(id[0])) {
        //         $('#sms').prop('checked', false)
        //     } else if(email.includes(id[0])){
        //         $('#email').prop('checked', false)
        //     } else if(client.includes(id[0])){
        //         $('#client').prop('checked', false)
        //     }
        // }
        // else {
        //     let i = id[1];
        //     if (id[1]>0) {
        //         while(i > 1, i--) $(`#${id[0]}-${i}`).prop('checked', true);
        //     }

        //     if (sms.includes(id[0])) {
        //         let cond = true;
        //         $('.sms').each(function(){
        //           if (!this.checked) {
        //               cond = false;
        //           }  
        //         })

        //         cond ? $('#sms').prop('checked', true) : '';

        //     } else if(email.includes(id[0])){
        //         let cond = true;
        //         $('.email').each(function(){
        //           if (!this.checked) {
        //               cond = false;
        //           }  
        //         })

        //         cond ? $('#email').prop('checked', true) : '';

        //     } else if(client.includes(id[0])){
        //         let cond = true;
        //         $('.client').each(function(){
        //           if (!this.checked) {
        //               cond = false;
        //           }  
        //         })

        //         cond ? $('#client').prop('checked', true) : '';

        //     }
        // }
    });
</script>
<?php $this->endsection()?>