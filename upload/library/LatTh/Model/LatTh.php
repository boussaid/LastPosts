<?php
class LatTh_Model_LatTh extends XenForo_Model
{
    public function getThreadsByForumIds($ids, $count, $displaypost)
    {

        return $this->_getDb()->fetchAll('
            SELECT thread.last_post_id as post_id,
       thread.user_id,
	   thread.last_post_user_id,
       thread.username,
	   thread.last_post_username,
       thread.post_date,
	   thread.last_post_date,
       thread.title,
       thread.thread_id, thread.reply_count, thread.view_count,
       user.avatar_date, user.display_style_group_id    
       FROM xf_thread as thread
       LEFT JOIN xf_user AS user ON (thread.user_id = user.user_id)
       WHERE discussion_open = ? AND discussion_state = ?
            AND node_id IN (' . $ids . ')
            ORDER BY '.$displaypost.' DESC
            LIMIT ?;', array(1, 'visible', $count));
    }
}