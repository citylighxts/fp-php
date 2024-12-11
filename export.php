<?php
// Include the main TCPDF library
require_once('tcpdf/tcpdf.php');
include 'database.php';

// Create new PDF document
class MYPDF extends TCPDF {
    // Page header
    public function Header() {
        // Set font
        $this->SetFont('helvetica', 'B', 16);
        // Title
        $this->Cell(0, 15, 'Daftar Order - Shopatcreme', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Halaman '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Shopatcreme');
$pdf->SetTitle('Daftar Order');
$pdf->SetSubject('Daftar Order User');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage('L'); // Landscape orientation

// Set font
$pdf->SetFont('helvetica', '', 10);

// Get user ID and order type from URL parameters
$user_id = $_GET['user_id'];
$order_type = $_GET['order_type'];

// Choose query based on order type
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

// Fetch data
$result = mysqli_query($koneksi, $query);
if (mysqli_num_rows($result) == 0) {
    die("No orders found.");
}

// Create table header
$html = '<table border="1" cellpadding="4">';
$html .= '<thead>';
$html .= '<tr style="background-color:#a7097a; color:white;">';
$html .= '<th>Plan</th><th>Email</th><th>Transaction Proof</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

// Add rows to table
while ($row = mysqli_fetch_assoc($result)) {
    $image_path = 'upload/' . $row['proof_photo'];
    
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($row['plan_name']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
    
    // Add image to PDF if exists
    if (file_exists($image_path)) {
        $html .= '<td><img src="' . $image_path . '" width="100" height="auto"></td>';
    } else {
        $html .= '<td>Proof not available</td>';
    }
    
    $html .= '</tr>';
}

$html .= '</tbody>';
$html .= '</table>';

// Print text using writeHTMLCell()
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('order_' . $order_type . '_user_' . $user_id . '.pdf', 'I'); // 'I' means inline display
?>
