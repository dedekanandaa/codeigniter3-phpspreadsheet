<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model 
{
    var $tbl_transaction = 'tbl_transaction';

    /*
    |-------------------------------------------------------------------
    | Fetch All Transaction Data
    |-------------------------------------------------------------------
    | 
    */
    function fetch_transactions()
    {
        /* Filter */
        // $filter = $this->input->post('filter');
        // if($filter == 1) {
        //     $date = $this->input->post('date');
        //     $this->db->where('input_date', $date);
        // }

        /* Query */
        $this->db->select("*");
        
        $query = $this->db->get($this->tbl_transaction);
        return $query->result_array();
    }

    /*
    |-------------------------------------------------------------------
    | Insert Batch Transaction Data
    |-------------------------------------------------------------------
    |
    | @param $data  Transactions Array Data
    |
    */
    function insert_transaction_batch($data)
    {
      $this->db->insert_batch($this->tbl_transaction, $data);
    }

    function clear() {
        $this->db->truncate('tbl_transaction');
    }

    function count() {
        return $this->db
        ->select("
        count(if(A = 'A1', 1, null)) as A1, 
        count(if(A = 'A2', 1, null)) as A2, 
        count(if(A = 'A3', 1, null)) as A3, 
        count(if(B = 'B1', 1, null)) as B1,
        count(if(B = 'B2', 1, null)) as B2,
        count(if(B = 'B3', 1, null)) as B3,
        count(if(C = 'C1', 1, null)) as C1,
        count(if(C = 'C2', 1, null)) as C2,
        count(if(C = 'C3', 1, null)) as C3,
        count(if(D = 'D1', 1, null)) as D1,
        count(if(D = 'D2', 1, null)) as D2,
        count(if(D = 'D3', 1, null)) as D3,
        count(if(E = 'E1', 1, null)) as E1,
        count(if(E = 'E2', 1, null)) as E2,
        count(if(E = 'E3', 1, null)) as E3,
        count(if(F = 'F1', 1, null)) as F1,
        count(if(F = 'F2', 1, null)) as F2,
        count(if(F = 'F3', 1, null)) as F3,
        count(if(Z = 'Z1', 1, null)) as Z1,
        count(if(Z = 'Z2', 1, null)) as Z2,
        count(if(Z = 'Z3', 1, null)) as Z3,
        ")
        ->from("tbl_transaction")
        ->get()
        ->result_array();
    }


}