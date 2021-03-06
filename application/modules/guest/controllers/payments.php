<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * FusionInvoice
 * 
 * A free and open source web based invoicing system
 *
 * @package		FusionInvoice
 * @author		Jesse Terry
 * @copyright	Copyright (c) 2012 - 2013, Jesse Terry
 * @license		http://www.fusioninvoice.com/license.txt
 * @link		http://www.fusioninvoice.
 * 
 */

class Payments extends Guest_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('payments/mdl_payments');
	}

	public function index()
	{
		$this->layout->set(
			array(
				'payments'			 => $this->mdl_payments->where('(fi_payments.invoice_id IN (SELECT invoice_id FROM fi_invoices WHERE client_id IN (' . implode(',', $this->user_clients) . ')))')->paginate()->result(),
				'filter_display'	 => TRUE,
				'filter_placeholder' => lang('filter_payments'),
				'filter_method'		 => 'filter_payments'
			)
		);
        
		$this->layout->buffer('content', 'guest/payments_index');
		$this->layout->render('layout_guest');
	}

}

?>