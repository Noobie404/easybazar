<?php
namespace App\Traits;

use \Statickidz\GoogleTranslate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

trait CommonTrait {

    public function getVariantNo($request)
    {
        $product_variant_arr = [];
        $query  = $request->all();
        $result = array_intersect_key($query, array_flip(preg_grep("/^product_no_/", array_keys($query))));
        if(!empty($result)){
            $product_nos = implode(',', $result);
            $product_variant_arr = explode(',', $product_nos);
        }
        return $product_variant_arr;
    }
    public function getMyRole()
    {
        return DB::table('SA_USER_GROUP_USERS')->select('SA_USER_GROUP_ROLE.F_ROLE_NO as ROLE_NO','SA_ROLE.NAME as ROLE_NAME','SA_USER_GROUP.GROUP_NAME')->where('F_USER_NO', Auth::user()->PK_NO)->leftJoin('SA_USER_GROUP', 'SA_USER_GROUP.PK_NO','SA_USER_GROUP_USERS.F_GROUP_NO')
        ->leftJoin('SA_USER_GROUP_ROLE', 'SA_USER_GROUP_ROLE.F_USER_GROUP_NO','SA_USER_GROUP.PK_NO')
        ->leftJoin('SA_ROLE', 'SA_ROLE.PK_NO','SA_USER_GROUP_ROLE.F_ROLE_NO')
        ->first();
    }
    public function trnaslate($target,$text) {
        try{
            $source = 'en';
            $target = $target;
            $trans = new GoogleTranslate();
            $result = $trans->translate($source, $target, $text);
        } catch (\Exception $e) {
            return $text;
        }
        return $result;
    }
	 
    function common_insert($data,$table_name)
    {
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }
	function common_insert_batch($data,$table_name)
    {
        $this->db->insert_batch($table_name, $data);
        return $this->db->insert_id();
    }
   function common_delete($data,$table_name)
    {
        $this->db->delete($table_name, $data);
		$return = $this->db->affected_rows();

		return $return; 
    }
    
   /*
    function condition_delete($data,$condition_id_value,$condition_id,$table_name)
    {
        $this->db->where($condition_id, $condition_id_value);
        $this->db->delete($table_name, $data);
		$return = $this->db->affected_rows();

		return $return;
    }
    
	
    function delete_condition($tableName,$tableId,$value)
    {
        //delete employee record
        $this->db->where("$tableId", $value);
        $this->db->delete("$tableName");
		$return = $this->db->affected_rows();

		return $return;
    }
*/
    
    function common_update($data,$condition_id_value,$condition_id,$table_name)
    {
        $this->db->where($condition_id, $condition_id_value);
        $this->db->update($table_name, $data);
		$return = $this->db->affected_rows();
		return $return;
    }

    function common_update_multicondition($data,$multi_condition,$table_name)
    {
        $this->db->where($multi_condition);
        $this->db->update($table_name, $data);
        $return = $this->db->affected_rows();
        return $return;
    }
	
	/*
		*Generates an update string based on the data you supply, and runs the query. You can either pass an array or an object to the function.
	*/
	function common_batch_update($table_name,$data,$condition_id)
    {
        $this->db->trans_start();
		$this->db->update_batch($table_name, $data, $condition_id);
		$this->db->trans_complete();        
    	return ($this->db->trans_status() === FALSE)? FALSE:TRUE;
    }
	
	function common_update_bulk($data,$condition_id_value,$condition_id,$table_name)
    {
        $this->db->where_in($condition_id, $condition_id_value);
        $this->db->update($table_name, $data);
		$return = $this->db->affected_rows();
		return $return;
    }
	
    function common_row_array($table_name)
    {
        $sql="SELECT * FROM $table_name WHERE status = 1";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result;   
    }

    function common_result_array_orderby($table_name,$order_by)
    {
        $sql="SELECT * FROM $table_name order by $order_by ASC";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    function common_result_array($table_name)
    {
        $sql="SELECT * FROM $table_name";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;   
    }
    function common_row_by_condition($condition_id_value,$condition_id,$table_name)
    {
        $sql="SELECT * FROM $table_name WHERE $condition_id = $condition_id_value";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result;   
    }
	function common_select_by_condition($condition_id_value,$condition_id,$table_name)
    {
		$this->db->where($condition_id, $condition_id_value);
		$this->db->from($table_name);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;   
    }
	function common_select_by_multycondition($data,$table_name)
    {
		$this->db->from($table_name);
        $this->db->where($data);
		//$this->db->order_by($order_field, $order_condition);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;   
    }
	
	public function common_select_field($table,$order_field,$sort,$select_field)
	{
		$this->db->select($select_field);
		$this->db->order_by($order_field,$sort);
		$query = $this->db->get($table);
		if($query->num_rows() > 0)
			{
				foreach($query->result() as $row)
				{
					$data[] = $row;
				}
				return $data;
			}
			else
			{
				return 0;
			}
    }
	
}
