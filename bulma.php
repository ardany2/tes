<?php
include "component/header.php";
//$tahun = $_GET['tahun'];
$phpWord = new \PhpOffice\PhpWord\PhpWord();

use PhpOffice\PhpWord\Settings;

date_default_timezone_set('UTC');
error_reporting(E_ALL);
define('CLI', (PHP_SAPI == 'cli') ? true : false);
define('EOL', CLI ? PHP_EOL : '<br />');
define('SCRIPT_FILENAME', basename($_SERVER['SCRIPT_FILENAME'], '.php'));
define('IS_INDEX', SCRIPT_FILENAME == 'index');

Settings::loadConfig();
//$perkara_id = $_GET['perkara_id'];
//$perkara    = $db1->table('v_perkara')->find($perkara_id, 'perkara_id');


$template   = $db2->table('template_dokumen')->find(723);
//$source     = __DIR__ . "/doc/{$template->kode}.docx";
//$source     = __DIR__ . "/doc/tes_variabel_all_single.docx";
/* $source     = __DIR__ . "/doc/tes_variabel_all.docx";


$var        = new Variabel;
$content    = $var->getContentDocx($source);
$variabel   = $var->getVariabels($content); */



?>
<!DOCTYPE html>
<html lang="id-id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Hello Bulma!</title>
    <link rel="stylesheet" href="node_modules/bulma/css/bulma.min.css">
    <script src="src/js/jquery-3.6.0.min.js"></script>
    <script src="src/js/terbilang.js"></script>
    <script src="node_modules/ckeditor4/ckeditor.js"></script>
    <script src="node_modules/inputmask/dist/jquery.inputmask.min.js"></script>
    
    <script src="src/tinymce/tinymce.min.js"></script>
    <script src="src/tinymce-jquery/tinymce-jquery.min.js"></script>
</head>

<body>


    <div>

        <nav class="navbar is-primary" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href="https://bulma.io">
                    <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
                </a>

                <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbarBasicExample" class="navbar-menu">
                <div class="navbar-start">
                    <a class="navbar-item">
                        Home
                    </a>

                    <a class="navbar-item">
                        Documentation
                    </a>

                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">
                            More
                        </a>

                        <div class="navbar-dropdown">
                            <a class="navbar-item">
                                About
                            </a>
                            <a class="navbar-item">
                                Jobs
                            </a>
                            <a class="navbar-item">
                                Contact
                            </a>
                            <hr class="navbar-divider">
                            <a class="navbar-item">
                                Report an issue
                            </a>
                        </div>
                    </div>
                </div>

                <div class="navbar-end">
                    <div class="navbar-item">
                        <div class="buttons">
                            <a class="button is-primary">
                                <strong>Sign up</strong>
                            </a>
                            <a class="button is-light">
                                Log in
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>


    </div>

    <div class="container is-fluid">
        <div class="columns is-mobile">
            <div class="column is-one-quarter">
                <aside class="aside is-placed-left is-expanded">
                    <div class="aside-container">
                        <div class="image"></div>
                        <div class="menu is-menu-main fast">
                            <ul class="menu-list">
                                <li class=""><a href="#/" class="router-link-active has-icon" title="Dashboard"><span class="icon"><i class="mdi mdi-desktop-mac default"></i></span><span class="menu-item-label">Dashboard</span></a>
                                    <!---->
                                </li>
                                <li class=""><a href="#/tables" class="has-icon" title="Tables"><span class="icon has-update-mark"><i class="mdi mdi-table default"></i></span><span class="menu-item-label">Tables</span></a>
                                    <!---->
                                </li>
                                <li class=""><a href="#/forms" class="is-active router-link-active has-icon" title="Forms" aria-current="page"><span class="icon"><i class="mdi mdi-square-edit-outline default"></i></span><span class="menu-item-label">Forms</span></a>
                                    <!---->
                                </li>
                                <li class=""><a href="#/profile" class="has-icon" title="Profile"><span class="icon"><i class="mdi mdi-account-circle default"></i></span><span class="menu-item-label">Profile</span></a>
                                    <!---->
                                </li>
                                <li class=""><a href="#/login" class="has-icon" title="Login"><span class="icon"><i class="mdi mdi-lock default"></i></span><span class="menu-item-label">Login</span></a>
                                    <!---->
                                </li>
                                <li class=""><a href="#/error-in-card" class="has-icon" title="Error v.1"><span class="icon"><i class="mdi mdi-power-plug default"></i></span><span class="menu-item-label">Error v.1</span></a>
                                    <!---->
                                </li>
                                <li class=""><a href="#/error-simple" class="has-icon" title="Error v.2"><span class="icon"><i class="mdi mdi-alert-decagram default"></i></span><span class="menu-item-label">Error v.2</span></a>
                                    <!---->
                                </li>
                                <li class=""><a href="#/lock-screen" class="has-icon" title="Lock Screen"><span class="icon"><i class="mdi mdi-lock-reset default"></i></span><span class="menu-item-label">Lock Screen</span></a>
                                    <!---->
                                </li>
                                <li class=""><a href="https://justboil.me/bulma-admin-template/two" target="_blank" title="Buy theme" exact-active-class="is-active" class="has-icon"><span class="icon"><i class="mdi mdi-credit-card default"></i></span><span class="menu-item-label">Buy theme</span></a>
                                    <!---->
                                </li>
                                <li class=""><a title="Submenus" exact-active-class="is-active" class="has-icon"><span class="icon"><i class="mdi mdi-view-list default"></i></span><span class="menu-item-label">Submenus</span></a>
                                    <ul class="">
                                        <li class=""><a href="#void" title="Sub-item One" exact-active-class="is-active" class="has-icon"><span class="icon"><i class="mdi mdi-menu default"></i></span><span class="menu-item-label">Sub-item One</span></a>
                                            <!---->
                                        </li>
                                        <li class=""><a href="#void" title="Sub-item Two" exact-active-class="is-active" class="has-icon"><span class="icon"><i class="mdi mdi-menu default"></i></span><span class="menu-item-label">Sub-item Two</span></a>
                                            <!---->
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </aside>

            </div>
            <div class="column">
            <pre>
            <?php
            echo '<div id="variabel">';
            echo '[ "0000" , "0001" , "0098" , "9906" , "9907" , "0004" , "1007" , "0128" , "0007" , "0008" , "0010" , "0011" , "7225" , "5182"]';
            //print json_encode($variabel, JSON_PRETTY_PRINT);
            echo '</div>';
            //var_dump($perk);
            $jadwal_sidang = $db1->table('perkara_jadwal_sidang')->where('perkara_id', '21970')->get();
            
            ?>

            </pre>
            
      
    
            <input class="uangs input is-normal is-primary px-2" id="uangs" type='text' value='56000000'>
            <input class="uangs input is-normal is-primary px-2" id="uangs2" type='text' value='6854564'>
                <input type="number" class="" id="perkara_id" value = 21970>
                <select id="sidang_id">
                    <?php 
                    
                    foreach($jadwal_sidang as $v){
                        
                        echo "<option value='{$v->id}'>Sidang ke: {$v->urutan} dengan alasan: {$v->alasan_ditunda}</option>";
                    }
                    ?>

                    
                </select>                
                <button type="button" onClick="show_tabel()" class=""><i class="fa fa-pencil"></i> Post</button>
                <table class="table is-striped is-narrow is-hoverable is-fullwidth">

                    <thead>
                        <th style="width: 0px;text-align:center;">No.</th>
                        <th style="width: 0px">Variabel</th>
                        <th style="width: 200px;">Nama</th>
                        <th>Isi</th>
                    </thead>
                    <tbody id="tampilform">
                    </tbody>
                </table>
                <button type="button" onClick="tes2()">Tes</button>

            </div>

        </div>

    </div>
    <script>
        var mask_uang_options = {
            prefix: "Rp",
            //suffix: " (seratus lima ratus juga rupiah)",
            rightAlign: false,
            groupSeparator: ".",
            alias: "numeric",
            placeholder: "0",
            autoGroup: true,
            digits: 2,
            digitsOptional: false,            
            radixPoint: ",",
            clearMaskOnLostFocus: false   
            };

            var mask_tanggal_indo_option = {
                mask: "99-99-9999",
                alias: "datetime",
                inputformat:"dd-mm-yyyy",
                placeholder: "dd-mm-yyyy",
                inputmode:"numeric",
                insertMode: false
            };
            
/* (function() {
    var datepicker_options, inputmask_options;

    datepicker_options = {
        altFormat: "dd/mm/yyyy",
        // appendText: "(dd/mm/yyyy)"
        dateFormat: "dd/mm/yy",
        // defaultDate: +1
        yearRange: "1000:3000",
        changeMonth: true,
        changeYear: true
    };

    inputmask_options = {
        mask: "99/99/9999",
        alias: "date",
        placeholder: "dd/mm/yyyy",
        insertMode: false
    };
    $("#tanggal").inputmask("99/99/9999", inputmask_options);
    $("#tanggal").datepicker(datepicker_options);
    
}).call(this); */

        $(document).ready(function(){
            
            $("#tanggal").inputmask(mask_tanggal_indo_option); //specifying options
            
        });
/* obj = JSON.parse(v);
console.log( obj[0] ); */
function tes2(){
    
            //$("#uang-"+var_nomor).val(uang);
            $("#uang-"+var_nomor).inputmask(mask_uang_options); //specifying options  
    console.log(old);
    console.log(new_val);
    
}

        function show_tabel() {
            let perkara_id = $("#perkara_id").val();
            let sidang_id = $("#sidang_id").val();
            //console.log(sidang_id);
            const v = $("#variabel").text().trim();
            $.ajax({
                url: "doc_.php",
                type: "POST",
                data: 'variabel=' + v + '&perkara_id=' + perkara_id + '&sidang_id=' + sidang_id,
                success: function(data) {
                    $("#tampilform").html(data);
                    // mask_uang_options.suffix = terbilang(12456);  //bikin objek dulu
                    $(".uangrp").inputmask(mask_uang_options);
                    $(".terbilang").val(terbilang($(".terbilang").val()).toLowerCase() + ' rupiah');
                    
                    //console.log(data);
                    
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }

        function data_tanggal(){
            let v = $("#"+var_nomor).val();            
            $("#tanggal-"+var_nomor).text(tanggal);
            $("#tanggal-"+var_nomor).inputmask(mask_tanggal_indo_option); //specifying options            
            
        }



        function old_val(){
            return oldv;            
        }

        function post_data(){
            let perkara_id = $("#perkara_id").val();
            let sidang_id = $("#sidang_id").val();
            //let v = $("#"+var_nomor).val().trim();
            let v = old_val();
            console.log(v);
            console.log('isinya='+v+'isibaru: '+form_data);
            if (form_data == v){
                console.log('sama gaes');
            } else {           
            $.ajax({
                url: "doc_post.php",
                type: "POST",
                data: 'var_nomor=' + var_nomor + '&var_model=' + var_model + '&var_jenis=' + var_jenis + '&form_data=' + encodeURIComponent(form_data) + '&perkara_id=' + perkara_id + '&sidang_id=' + sidang_id,
                success: function(data) {
                    //console.log('var_nomor=' + var_nomor + '&var_model=' + var_model + '&var_jenis=' + var_jenis + '&form_data=' + form_data + '&perkara_id=' + perkara_id + '&sidang_id=' + sidang_id);
                    console.log(data);
                    show_tabel();
                }
            })
        }
        }

        show_tabel();

        function inline(var_nomor){
        //console.log(var_nomor);
          if (CKEDITOR.instances['form-'+var_nomor]) {
            CKEDITOR.remove(CKEDITOR.instances['form-'+var_nomor]);
            } else{
                CKEDITOR.inline( 'form-'+var_nomor, {
      extraPlugins: 'sourcedialog',
      removeButtons: 'Underline,Subscript,Scayt,Link,Unlink,Anchor,Image,HorizontalRule,Maximize,Strike,Blockquote,Styles,Format,About'
    } );
            }
        }

        var data = Array();

        function tes(){
            let arr = [];            
            $(".isi p").each(function(i,v){
        console.log(v); 
            })
           
           /*  $.each([ 52, 97 ], function( index, value ) {
  alert( index + ": " + value );
}); */
        }



    </script>



</body>

</html>