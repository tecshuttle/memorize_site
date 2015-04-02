<?php

class days_model extends CI_Model
{
    var $table = 'days';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //查询，统后用这个方法
    function get($options = array())
    {
        $options = array_merge(array('time' => 'DESC'), $options);

        // Add where clauses to query
        $qualificationArray = array('id');

        foreach ($qualificationArray as $qualifier) {
            if (isset($options[$qualifier]))
                $this->db->where($qualifier, $options[$qualifier]);
        }

        // If limit / offset are declared (usually for pagination) then we need to take them into account
        $total = $this->db->count_all_results($this->table);
        if (isset($options['limit'])) {

            //取得记录数据后，重新设置一下条件
            foreach ($qualificationArray as $qualifier) {
                if (isset($options[$qualifier]))
                    $this->db->where($qualifier, $options[$qualifier]);
            }

            if (isset($options['offset'])) {
                $this->db->limit($options['limit'], $options['offset']);
            } else if (isset($options['limit'])) {
                $this->db->limit($options['limit']);
            }
        }

        // sort
        if (isset($options['sortBy'])) {
            $this->db->order_by($options['sortBy'], $options['sortDirection']);
        }

        foreach ($qualificationArray as $qualifier) {
            if (isset($options[$qualifier]))
                $this->db->where($qualifier, $options[$qualifier]);
        }

        $query = $this->db->get($this->table);

        return array(
            'data' => $query->result(),
            'total' => $total
        );
    }

    function update($option)
    {
        $this->db->update($this->table, $option, array('id' => $option['id']));
    }


}

//end file
