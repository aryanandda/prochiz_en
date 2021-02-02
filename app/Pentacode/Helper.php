<?php
	
namespace App\Pentacode;

/**
* Helper Class
*/
use Session;

class Helper
{
	
	function __construct()
	{

	}

	public function invoiceNum($invoice_id)
	{
		$invoice = Invoice::find($invoice_id);
		$fcount = Fish::where('invoice_id', '=', $invoice->id)->count();
		$vcount = Vat::where('invoice_id', '=', $invoice->id)->count();

		$num = $invoice->id.'/'.$invoice->user_id.'/'.$fcount.'/'.$vcount.'/'.date('Y/m/d', strtotime($invoice->created_at));

		return $num;
	}

	public function throwMessage($session, $messages, $type)
	{
		$title = 'Success!';

		if($type=='danger')
			$title = 'Sorry..';

		if(empty($messages))
			$messages = \Session::get($session);

		if(!empty($messages)){
			$html = '<div role="alert" class="alert alert-'.$type.' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
		                '<span aria-hidden="true">×</span>'.
		                '<span class="sr-only">Close</span>'.
		            '</button><ul>';

			if(is_object($messages)){

				foreach ($messages->all(
					'<li>:message</li>'
				) as $message):
					$html = $html.$message;
				endforeach;
				return $html.'</ul></div>';
			}
			if(is_array($messages)){
				foreach ($messages as $message):
					$html = $html.'<li>'.$message.'</li>';
				endforeach;
				return $html.'</ul></div>';
			} 

			return	'<div role="alert" class="alert alert-'.$type.' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
		                '<span aria-hidden="true">×</span>'.
		                '<span class="sr-only">Close</span>'.
	            	'</button>'.$messages.'</div>';
		}

	}
}