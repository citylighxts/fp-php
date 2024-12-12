<?php
require_once('tcpdf/tcpdf.php');
include 'database.php';

class MYPDF extends TCPDF {
    public function Header() {
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 15, 'Daftar Order - Shopatcreme', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Halaman '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Shopatcreme');
$pdf->SetTitle('Daftar Order');
$pdf->SetSubject('Daftar Order User');

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->AddPage('L');

$pdf->SetFont('helvetica', '', 10);

$user_id = $_GET['user_id'];
$order_type = $_GET['order_type'];

switch ($order_type) {
    case 'canva':
        $query = "SELECT * FROM canvaOrders WHERE user_id = '$user_id'";
        break;
    case 'gpt':
        $query = "SELECT * FROM gptOrders WHERE user_id = '$user_id'";
        break;
    case 'appleMusic':
        $query = "SELECT * FROM appleMusicOrders WHERE user_id = '$user_id'";
        break;
    default:
        die("Invalid order type.");
}

$result = mysqli_query($koneksi, $query);
if (mysqli_num_rows($result) == 0) {
    die("No orders found.");
}

$html = '<table border="1" cellpadding="4">';
$html .= '<thead>';
$html .= '<tr style="background-color:#a7097a; color:white;">';
$html .= '<th>Plan</th><th>Email</th><th>Transaction Proof</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $image_path = 'upload/' . $row['proof_photo'];
    
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($row['plan_name']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
    
    if (file_exists($image_path)) {
        $html .= '<td><img src="' . $image_path . '" width="100" height="auto"></td>';
    } else {
        $html .= '<td>Proof not available</td>';
    }
    
    $html .= '</tr>';
}

$html .= '</tbody>';
$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('order_' . $order_type . '_user_' . $user_id . '.pdf', 'I');
?>
