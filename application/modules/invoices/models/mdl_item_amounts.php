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

class Mdl_Item_Amounts extends CI_Model {
	
	/**
	 * item_amount_id
	 * item_id
	 * item_subtotal (item_quantity * item_price)
	 * item_tax_total
	 * item_total ((item_quantity * item_price) + item_tax_total)
	 */
	
	public function calculate($item_id)
	{
		$this->load->model('invoices/mdl_items');
		$item = $this->mdl_items->get_by_id($item_id);
		
		$tax_rate_percent = 0;

		$item_subtotal = $item->item_quantity * $item->item_price;
		$item_tax_total = $item_subtotal * ($item->item_tax_rate_percent / 100);
		$item_total = $item_subtotal + $item_tax_total;
		
		$db_array = array(
			'item_id' => $item_id,
			'item_subtotal' => $item_subtotal,
			'item_tax_total' => $item_tax_total,
			'item_total' => $item_total
		);
		
		$this->db->where('item_id', $item_id);
		if ($this->db->get('fi_invoice_item_amounts')->num_rows())
		{
			$this->db->where('item_id', $item_id);
			$this->db->update('fi_invoice_item_amounts', $db_array);
		}
		else
		{
			$this->db->insert('fi_invoice_item_amounts', $db_array);
		}
	}
	
}

?>