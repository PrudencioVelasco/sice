<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**


* CodeIgniter PDF Library
 *
 * Generate PDF's in your CodeIgniter applications.
 *
 * @package         CodeIgniter
 * @subpackage      Libraries
 * @category        Libraries
 * @author          Chris Harvey
 * @license         MIT License
 * @link            https://github.com/chrisnharvey/CodeIgniter-  PDF-Generator-Library



*/

require_once dirname(__FILE__) .'/dompdf/lib/Cpdf.php';

defined('BASEPATH') OR exit('No direct script access allowed');
// Dompdf namespace
use Dompdf\Dompdf;
class Pdfgenerator{
public function __construct(){
require_once dirname(__FILE__).'/dompdf/autoload.inc.php';
$pdf = new DOMPDF();
$CI = & get_instance();
$CI->dompdf = $pdf;
}
}
?>