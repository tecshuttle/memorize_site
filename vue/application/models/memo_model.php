<?php
/**
 * Class articles_model
 * 这个类和products类是一样的，如果有修改，请同步更新到这里，有时间，重构时，合并成一个类。
 *
 */
class memo_model extends CI_Model
{
    var $table = 'questions';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    //查询，统后用这个方法
    function get($options = array())
    {
        $options = $this->_default(array('sortDirection' => 'DESC'), $options);

        // Add where clauses to query
        $qualificationArray = array('uid', 'id');

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

        $query = $this->db->get($this->table);

        if ($query->num_rows() == 0) return false;

        if (isset($options['id'])) {
            return $query->row(0);
        } else {
            return array(
                'data' => $query->result(),
                'total' => $total
            );
        }
    }

    function getMemo($option)
    {
        $today = date("Y-m-d", time());
        $week_before = time() - (7 * 24 * 3600);
        $uid = $option['uid'];

        $sql = "SELECT t.name AS type, t.priority, q.* FROM questions AS q LEFT JOIN item_type AS t ON (q.type_id = t.id) "
            . "WHERE q.uid = $uid AND ((t.priority = 0 AND next_play_date <= '$today') OR (t.priority > 0 AND mtime > $week_before)) "
            . "ORDER BY t.priority ASC, _id ASC";

        $query = $this->db->query($sql);

        return $query->result();
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($option)
    {
        $this->db->update($this->table, $option, array('id' => $option['id']));
    }

    function deleteByID($id)
    {
        $this->db->delete($this->table, array('id' => $id));
    }

    /**
     * _default method combines the options array with a set of defaults giving the values
     * in the options array priority.
     *
     * @param array $defaults
     * @param array $options
     * @return array
     */
    function _default($defaults, $options)
    {
        return array_merge($defaults, $options);
    }
}

//end file