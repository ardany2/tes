<?php
use PhpOffice\PhpWord\Element\Field;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\Settings;

include_once 'Sample_Header.php';




// Template processor instance creation
echo date('H:i:s'), ' Creating new TemplateProcessor instance...', EOL;
$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('resources/Sample_00_Jajal.docx');

echo '<pre>';
$data = json_decode(json_encode($templateProcessor));
print_r($data);
echo '</pre>';
$title = new TextRun();
$title->addText('This title has been set ', array('bold' => true, 'italic' => true, 'color' => 'blue'));
$title->addText('dynamically', array('bold' => true, 'italic' => true, 'color' => 'red', 'underline' => 'single'));
$templateProcessor->setComplexBlock('title', $title);

$inline = new TextRun();
$inline->addText('by a red italic text', array('italic' => true, 'color' => 'red'));
$templateProcessor->setComplexValue('inline', $inline);

$table = new Table(array('borderSize' => 12, 'borderColor' => 'green', 'width' => 6000, 'unit' => TblWidth::TWIP));
$table->addRow();
$table->addCell(150)->addText('Cell A1');
$table->addCell(150)->addText('Cell A2');
$table->addCell(150)->addText('Cell A3');
$table->addRow();
$table->addCell(150)->addText('Cell B1');
$table->addCell(150)->addText('Cell B2');
$table->addCell(150)->addText('Cell B3');
$templateProcessor->setComplexBlock('table', $table);

$field = new Field('DATE', array('dateformat' => 'dddd d MMMM yyyy H:mm:ss'), array('PreserveFormat'));
$templateProcessor->setComplexValue('field', $field);

$text = 'tes leh';
$templateProcessor->setValue('jajal', $text);
$tes = new Settings;

?>
<ol>
	<li><?php echo $tes::getDefaultFontName(); ?> Bahwa Pemohon dengan Termohon telah menikah pada hari Rabu tanggal 22 September 2004 Masehi bertepatan dengan tanggal 7 Sya ban 1425 Hijriyah, yang dicatat oleh Kantor Urusan Agama Kecamatan Padangan, Kabupaten Bojonegoro Provinsi Jawa Timur, sesuai Kutipan Nomor 320/28/IX/2004, tanggal 22 September 2004;</li>
	<li>Bahwa sewaktu menikah Pemohon berstatus jejaka dan Termohon berstatus perawan;</li>
	<li>Bahwa setelah menikah Pemohon dan Termohon bertempat tinggal di rumah orang tua Pemohon selama 17 tahun 4 bulan;</li>
	<li>Bahwa semula rumah tangga Pemohon dengan Termohon berjalan rukun dan harmonis dan keduanya telah berhubungan sebagaimana layaknya suami istri;</li>
	<li>Bahwa selama menjalin rumah tangga tersebut Pemohon dengan Termohon telah dikaruniai 2 orang anak, anak pertama perempuan bernama Nafisa Aulia Septiani, umur 16 tahun, saat ini berada dalam asuhan Pemohon, anak kedua laki-laki bernama Rifai Hasyiem As'ari, umur 9 tahun, saat ini berada dalam asuhan Pemohon,;</li>
	<li>Bahwa sejak bulan Desember tahun 2021 rumah tangga Pemohon dengan Termohon mulai goyah karena sering terjadi perselisihan dan pertengkaran yang disebabkan antara lain karena Termohon selingkuh, menjalin hubungan cinta dengan laki-laki lain yang bernama Anwar, beralamat di kabupaten Bojonegoro;</li>
	<li>Bahwa puncak keretakan hubungan rumah tangga Pemohon dengan Termohon tersebut terjadi sekitar bulan Januari tahun 2022 yang akibatnya Termohon pergi meninggalkan tempat kediaman orang tua Pemohon sehingga antara Pemohon dengan Termohon telah berpisah tempat tinggal yang hingga saat ini telah berlangsung selama 5 bulan;</li>
	<li>Tes sek;<ol><li>Bahwa sejak saat itu antara Pemohon dan Termohon sudah tidak pernah ada komunikasi dan tidak pernah saling memedulikan satu sama lain;</li></ol></li>
	<li>Bahwa melihat kondisi rumah tangga yang demikian itu Pemohon masih tetap berusaha untuk memperbaiki hubungan antara Pemohon dengan Termohon, namun tidak berhasil;</li>
	<li>Bahwa dengan kejadian tersebut rumah tangga Pemohon dengan Termohon sudah tidak dapat dibina dengan baik sehingga tujuan perkawinan untuk membentuk rumah tangga yang <em>sakinah</em>, <em>mawaddah</em> dan <em>rahmah</em> sudah sulit dipertahankan lagi dan karenanya agar masing-masing pihak tidak melanggar norma hukum dan norma agama maka perceraian merupakan alternatif terakhir bagi Pemohon untuk menyelesaikan permasalahan Pemohon dengan Termohon karena sering terjadi perselisihan dan pertengkaran yang sudah tidak harapan lagi untuk rukun dalam rumah tangga;</li>
	<li>Bahwa Pemohon bersedia membayar biaya perkara ini sesuai dengan ketentuan yang berlaku;</li>
</ol>
<form method="post">
<textarea id="basic-example">
  <p><img style="display: block; margin-left: auto; margin-right: auto;" title="Tiny Logo" src="https://www.tiny.cloud/docs/images/logos/android-chrome-256x256.png" alt="TinyMCE Logo" width="128" height="128"></p>
  <h2 style="text-align: center;">Welcome to the TinyMCE editor demo!</h2>

  <h2>Got questions or need help?</h2>

  <ul>
    <li>Our <a href="https://www.tiny.cloud/docs/tinymce/6/">documentation</a> is a great resource for learning how to configure TinyMCE.</li>
    <li>Have a specific question? Try the <a href="https://stackoverflow.com/questions/tagged/tinymce" target="_blank" rel="noopener"><code>tinymce</code> tag at Stack Overflow</a>.</li>
    <li>We also offer enterprise grade support as part of <a href="https://www.tiny.cloud/pricing">TinyMCE premium plans</a>.</li>
  </ul>

  <h2>A simple table to play with</h2>

  <table style="border-collapse: collapse; width: 100%;" border="1">
    <thead>
      <tr>
        <th>Product</th>
        <th>Cost</th>
        <th>Really?</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>TinyMCE</td>
        <td>Free</td>
        <td>YES!</td>
      </tr>
      <tr>
        <td>Plupload</td>
        <td>Free</td>
        <td>YES!</td>
      </tr>
    </tbody>
  </table>

  <h2>Found a bug?</h2>

  <p>
    If you think you have found a bug please create an issue on the <a href="https://github.com/tinymce/tinymce/issues">GitHub repo</a> to report it to the developers.
  </p>

  <h2>Finally ...</h2>

  <p>
    Don't forget to check out our other product <a href="http://www.plupload.com" target="_blank">Plupload</a>, your ultimate upload solution featuring HTML5 upload support.
  </p>
  <p>
    Thanks for supporting TinyMCE! We hope it helps you and your users create great content.<br>All the best from the TinyMCE team.
  </p>
</textarea>
</form>

<?php



// $link = new Link('https://github.com/PHPOffice/PHPWord');
// $templateProcessor->setComplexValue('link', $link);

echo date('H:i:s'), ' Saving the result document...', EOL;
$templateProcessor->saveAs('results/Sample_00_Jajal.docx');

echo getEndingNotes(array('Word2007' => 'docx'), 'results/Sample_00_Jajal.docx');


if (!CLI) {
    include_once 'Sample_Footer.php';
}
?>

