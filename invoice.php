<?php
require ('fpdf182/fpdf.php');

//decode the input with base64 and then convert JSON string to object
if(isset($_GET["q"]))
  $input = json_decode(base64_decode($_GET["q"]));


class EvolvusPDF extends FPDF {
  public $headerimg;
  public $footerimg;

  public function SetHeader($headerimg) {
    $this->headerimg = $headerimg;
  }

  public function SetFooter($footerimg) {
    $this->footerimg = $footerimg;
  }
	/* Page header */
	function Header() {
		/* Logo */
		$this->Image($this->headerimg,2,2,210);

	}

  /* Page footer */
	function Footer() {
		/* Logo */
		$this->Image($this->footerimg,2,263,210);

	}
  function plot_table($widths, $lineheight, $table, $border=1, $aligns=array(), $fills=array(), $links=array()){
       $func = function($text, $c_width){
           $len=strlen($text);
           $twidth = $this->GetStringWidth($text);
           $split = floor($c_width * $len / $twidth);
           $w_text = explode( "\n", wordwrap( $text, $split, "\n", true));
           return $w_text;
       };
       foreach ($table as $line){
           $line = array_map($func, $line, $widths);
           $maxlines = max(array_map("count", $line));
           foreach ($line as $key => $cell){
               $x_axis = $this->getx();
               $height = $lineheight * $maxlines / count($cell);
               $len = count($line);
               $width = (isset($widths[$key]) === TRUE ? $widths[$key] : $widths / count($line));
               $align = (isset($aligns[$key]) === TRUE ? $aligns[$key] : '');
               $fill = (isset($fills[$key]) === TRUE ? $fills[$key] : false);
               $link = (isset($links[$key]) === TRUE ? $links[$key] : '');
               foreach ($cell as $textline){
                   $this->cell($widths[$key],$height,$textline,0,0,$align,$fill,$link);
                   $height += 2 * $lineheight * $maxlines / count($cell);
                   $this->SetX($x_axis);
               }
               if($key == $len - 1){
                   $lbreak=1;
               }
               else{
                   $lbreak = 0;
               }
               $this->cell($widths[$key],$lineheight * $maxlines, '',$border,$lbreak);
           }
       }
   }


}

 class Invoice {
  public $invoiceno;
  public $invoicedate;
  public $jobname;

  public $vendor;
  public $venaddr1;
  public $venaddr2;
  public $venaddr3;

  public $customer;
  public $custaddr1;
  public $custaddr2;
  public $custaddr3;

  public $custshipaddr1;
  public $custshipaddr2;
  public $custshipaddr3;

  public $tax1 = 0;
  public $tax2 = 0;
  public $tax3 = 0;

  public $units = array();
  public $currency;
  public $custtrn;
  public $custgst;

  public $vendtrn;
  public $vendgst;
  public $vendpan;

  public $projdet;
  public $ssn;

  public $bank_name;
  public $branch_name;
  public $ifsc;
  public $acct_no;
  public $iban;
  public $swift;

  public $amt_format;



  private $pdf;

  private function AmountFormat($fmt,$amt){
    $num = 0;
    setlocale(LC_MONETARY,$fmt);

    if($fmt == "en_IN"){
      $num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amt);
    }
    else{
      $num = money_format('%!i', $amt);
    }
    return $num;
  }

  public function generateInvoice() {
    /*A4 width : 219mm*/
    $pdf = new EvolvusPDF('P','mm','A4');

    if($this->format == 1 || $this->format == 2 ){
      $pdf->SetFooter('images/evolfooter-A.png');
    }
    else {
      $pdf->SetFooter('images/evolfooter-B.png');
    }
    $pdf->SetHeader('images/evol.png');

    $pdf->AddPage();
    /*set font to arial, bold, 14pt*/
    $pdf->SetFont('Arial','B',18);

    /*Cell(width , height , text , border , end line , [align] )*/

    $pdf->Cell(71 ,15,' ',0,1);
    $pdf->Cell(120 ,5,'TAX INVOICE',0,1,'R');

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(120 ,5,' ',0,0,'R');
    $pdf->Cell(70 ,5,'INVOICE # '.$this->invoiceno,0,1,'R');
    $pdf->Cell(120 ,5,' ',0,0,'R');
    $pdf->Cell(70 ,5,'DATE: '.$this->invoicedate,0,1,'R');


    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(71 ,5,'FROM',0,1);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(2 ,5,'',0,0);
    $pdf->Cell(81 ,5,$this->vendor,0,1);
    if(!empty($this->venaddr1))
    {
      $pdf->Cell(2 ,5,'',0,0);
      $pdf->Cell(81 ,5,$this->venaddr1,0,1);
    }
    if(!empty($this->venaddr2))
    {
      $pdf->Cell(2 ,5,'',0,0);
      $pdf->Cell(81 ,5,$this->venaddr2,0,1);
    }
    if(!empty($this->venaddr3))
    {
      $pdf->Cell(2 ,5,'',0,0);
      $pdf->Cell(81 ,5,$this->venaddr3,0,1);
    }
    if(!empty($this->vendtrn))
    {
      $pdf->Cell(2 ,5,'',0,0);
      $pdf->Cell(81 ,5,'Tax Registration No: '.$this->vendtrn,0,1);
    }

    if(!empty($this->vendgst))
    {
      $pdf->Cell(2 ,5,'',0,0);
      $pdf->Cell(81 ,5,'GST No: '.$this->vendgst,0,1);
    }

    if(!empty($this->vendpan))
    {
      $pdf->Cell(2 ,5,'',0,0);
      $pdf->Cell(81 ,5,'PAN No: '.$this->vendpan,0,1);
    }



    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(71 ,5,'TO',0,1);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(2 ,5,'',0,0);
    $pdf->Cell(81 ,5,$this->customer,0,1);
    if(!empty($this->custaddr1))
    {
      $pdf->Cell(2 ,5,'',0,0);
      $pdf->Cell(81 ,5,$this->custaddr1,0,1);
    }
    if(!empty($this->custaddr2))
    {
      $pdf->Cell(2 ,5,'',0,0);
      $pdf->Cell(81 ,5,$this->custaddr2,0,1);
    }
    if(!empty($this->custaddr3))
    {
      $pdf->Cell(2 ,5,'',0,0);
      $pdf->Cell(81 ,5,$this->custaddr3,0,1);
    }
    if(!empty($this->custtrn))
    {
      $pdf->Cell(2 ,5,'',0,0);
      $pdf->Cell(81 ,5,'Tax Registration No: '.$this->custtrn,0,1);
    }
    if(!empty($this->custgst))
    {
      $pdf->Cell(2 ,5,'',0,0);
      $pdf->Cell(81 ,5,'GST No: '.$this->custgst,0,1);
    }

    $pdf->Cell(65 ,5,'',0,1,'C');

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(65 ,5,'JOB',0,0,'C');
    $pdf->Cell(65 ,5,'PAYMENT TERMS',0,0,'C');
    $pdf->Cell(65 ,5,'DUE DATE',0,1,'C');

    $pdf->SetFont('Arial','',8);
    $pdf->Cell(65 ,5,$this->jobname,0,0,'C');
    $pdf->Cell(65 ,5,'Payment - Due on receipt',0,0,'C');
    $pdf->Cell(65 ,5,'Due on receipt',0,1,'C');


    // $pdf->Cell(189 ,10,'',0,1);

    $pdf->Cell(50 ,4,'',0,1);

    $pdf->SetFont('Arial','B',10);
    if(empty($this->projdet)){
      $this->projdet = "   ";
    }
    if(empty($this->ssn)){
      $this->ssn = "   ";
    }
    if($this->format == 1 || $this->format == 2 ){
      $table = array(array('PROJECT DETAILS','SAC/HSN CODE'));
      $widths = array(150,35);
      $pdf->plot_table($widths, 5, $table,1,array('C','C'));
      $pdf->SetFont('Arial','',10);
      $table = array(array($this->projdet,$this->ssn));
      $widths = array(150,35);
      $pdf->plot_table($widths, 5, $table,1,array('L','C'));
    }
    else{
      $table = array(array('PROJECT DETAILS'));
      $widths = array(185);
      $pdf->plot_table($widths, 5, $table,1,array('C'));
      $pdf->SetFont('Arial','',10);
      $table = array(array($this->projdet));
      $widths = array(185);
      $pdf->plot_table($widths, 5, $table,1,array('L'));
    }



    $pdf->SetFont('Arial','B',10);
    $table = array(array('NO', 'DESCRIPTION','LINE UNIT'));
    $widths = array(15,135,35);
    $pdf->plot_table($widths, 5, $table,1,array('C','C','C'));
    $pdf->SetFont('Arial','',10);

    $ar = array();
    $ctr=1;
    $tot=0;

    foreach($this->units as $unit)
    {



      array_push($ar , array($ctr,$unit->desc,$this->AmountFormat($this->amt_format,$unit->line_unit)));
      $tot+=$unit->line_unit;
      $ctr += 1;
    }
    $widths = array(15,135,35);
    $pdf->plot_table($widths, 5, $ar,1,array('C','L','R') );




    $pdf->Cell(115 ,6,'Sub Total ('.$this->currency.')',1,0,'R');
    $pdf->Cell(35 ,6,' ',1,0,'C');
    $pdf->Cell(35 ,6,$this->AmountFormat($this->amt_format,$tot),1,1,'R');

    $tax = 0;
    if($this->format == 1) {
      if(is_numeric($this->tax1)) {
        $pdf->Cell(115 ,6,'CGST '.$this->tax1.'%('.$this->currency.')',1,0,'R');
        $pdf->Cell(35 ,6,' ',1,0,'C');
        $pdf->Cell(35 ,6,$this->AmountFormat($this->amt_format,$tot*$this->tax1/100),1,1,'R');
        $tax +=$tot*$this->tax1/100;
      }
      if(is_numeric($this->tax2)) {
        $pdf->Cell(115 ,6,'SGST '.$this->tax2.'%('.$this->currency.')',1,0,'R');
        $pdf->Cell(35 ,6,' ',1,0,'C');
        $pdf->Cell(35 ,6,$this->AmountFormat($this->amt_format,$tot*$this->tax2/100),1,1,'R');
        $tax +=$tot*$this->tax2/100;
      }

    }

    if($this->format == 2) {
      $pdf->Cell(115 ,6,'GST '.$this->tax1.'%('.$this->currency.')',1,0,'R');
      $pdf->Cell(35 ,6,' ',1,0,'C');
      $pdf->Cell(35 ,6,$this->AmountFormat($this->amt_format,$tot*$this->tax1/100),1,1,'R');
      $tax +=$tot*$this->tax1/100;
    }

    if($this->format == 3 || $this->format == 4) {
      $pdf->Cell(115 ,6,'VAT '.$this->tax1.'%('.$this->currency.')',1,0,'R');
      $pdf->Cell(35 ,6,' ',1,0,'C');
      $pdf->Cell(35 ,6,$this->AmountFormat($this->amt_format,$tot*$this->tax1/100),1,1,'R');
      $tax +=$tot*$this->tax1/100;
    }



    $finaltot=$tot+$tax;

    $pdf->Cell(115 ,6,'Total ('.$this->currency.')',1,0,'R');
    $pdf->Cell(35 ,6,' ',1,0,'C');
    $pdf->Cell(35 ,6,$this->AmountFormat($this->amt_format,$finaltot),1,1,'R');

    $pdf->Cell(100 ,3,' ',0,1,'C');
    $pdf->Cell(100 ,6,' ',0,0,'C');
    $pdf->Cell(100 ,6,'For '.$this->vendor,0,1,'C');

    $pdf->Cell(100 ,10,' ',0,1,'C');
    $pdf->Cell(100 ,10,' ',0,0,'C');

    $pdf->Cell(100 ,10,'AUTHORISED SIGNATORY ',0,1,'C');

    //$pdf->Line(10,193,195,193);
    // $pdf->Cell(50 ,1,' ',0,1,'C');

    $pdf->SetFont('Arial','B',10);

    $pdf->Cell(200 ,10,'Please transfer '.$this->currency.' '.$finaltot.' to the '.$this->currency.' account mentioned below ',0,1);
    $pdf->SetFont('Arial','',10);

    $pdf->Cell(50 ,1,' ',0,1,'L');
    $pdf->Cell(50 ,5,'In Favour Of',1,0,'L');
    $pdf->Cell(115 ,5,$this->vendor,1,1,'L');

    $pdf->Cell(50 ,5,'Bank Name',1,0,'L');
    $pdf->Cell(115 ,5,$this->bank_name,1,1,'L');

    $pdf->Cell(50 ,5,'Branch',1,0,'L');
    $pdf->Cell(115 ,5,$this->branch_name,1,1,'L');

    if(!empty($this->ifsc)){
      $pdf->Cell(50 ,5,'IFSC CODE :',1,0,'L');
      $pdf->Cell(115 ,5,$this->ifsc,1,1,'L');
    }

    $pdf->Cell(50 ,5,'Account Number',1,0,'L');
    $pdf->Cell(115 ,5,$this->acct_no,1,1,'L');

    if(!empty($this->iban)){
      $pdf->Cell(50 ,5,'IBAN',1,0,'L');
      $pdf->Cell(115 ,5,$this->iban,1,1,'L');
    }

    if(!empty($this->swift)){
      $pdf->Cell(50 ,5,'SWIFT',1,0,'L');
      $pdf->Cell(115 ,5,$this->swift,1,1,'L');
    }



    $pdfString = $pdf->Output('S');
    $pdfBase64 = base64_encode($pdfString);
    echo 'data:application/pdf;base64,' . $pdfBase64;

    


  }

}
class InvoiceUAEUnit {
    public $desc;
    public $unit_price;
    public $line_unit;

    public function __construct($desc,$unit_price,$line_unit) {
        $this->desc = $desc;
        $this->unit_price = $unit_price;
        $this->line_unit = $line_unit;
    }
}


$inv = new Invoice();
$inv->currency = $input->invCur;
$inv->invoiceno = $input->invNO;
$inv->invoicedate = $input->invDate;
$inv->vendtrn = $input->venTRN;
$inv->custtrn = $input->custTRN;

$inv->vendgst = $input->venGST;
$inv->vendpan = $input->venPAN;

$inv->custgst = $input->custGST;


$inv->vendor = $input->venName;
$inv->venaddr1 = $input->venAdd1;
$inv->venaddr2 = $input->venAdd2;
$inv->venaddr3 = $input->venAdd3;

$inv->customer = $input->custName;
$inv->custaddr1 = $input->custAdd1;
$inv->custaddr2 = $input->custAdd2;
$inv->custaddr3 = $input->custAdd3;


$inv->custshipadd1 = $input->custShipAdd1;
$inv->custshipadd2 = $input->custShipAdd2;
$inv->custshipadd3 = $input->custShipAdd3;

$inv->jobname = $input->invJob;
$inv->format  =  $input->invFormat;
$inv->tax1 = $input->tax1;
$inv->tax2 = $input->tax2;
$inv->tax3 = $input->tax3;
$inv->projdet = $input->projDet;
$inv->ssn = $input->projSSN;

 $inv->bank_name = $input->bankName;
 $inv->branch_name = $input->branchName;
 $inv->ifsc = $input->ifsc;
 $inv->acct_no = $input->acctNO;
 $inv->iban = $input->iban;
 $inv->swift = $input->swift;
 $inv->amt_format = $input->amtFormat;


foreach($input->invList as $invl){
  $inv->units[]=new InvoiceUAEUnit($invl->desc,0,$invl->amt);
}

$inv->generateInvoice();



?>
