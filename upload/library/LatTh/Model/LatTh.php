<?php
class LatTh_Model_LatTh extends XenForo_Model
{
    public function getThreadsByForumIds($ids, $count)
    {

        return $this->_getDb()->fetchAll('
            SELECT *
            FROM xf_thread
            WHERE node_id IN (' . $ids . ')
            ORDER BY last_post_date DESC
            LIMIT ' . $count . ';
            ');
    }
}