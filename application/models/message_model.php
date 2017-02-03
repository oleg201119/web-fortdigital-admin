<?php
/**
 * Created by PhpStorm.
 * User: boris
 * Date: 09/05/14
 * Time: 3:40 PM
 */
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Message_model extends CI_Model {



    /*******************************************************************************************************************
     *
     * Model function
     *
     ******************************************************************************************************************/
    function __construct()
    {
        parent::__construct();
    }

    public function get_message_config()
    {
        // Get message list
        $sql = "SELECT * FROM tbl_queue_ticker WHERE deleted=0";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        $message_count = $query->num_rows;

        $message_list = array();

        foreach($query->result() as $message_item)
        {
            $message_list[] = array(
                "message_id"    => $message_item->message_id,
                "phone_number"  => $message_item->phone_number,
                "message_txt"   => $message_item->message_txt,
                "message_date"  => $message_item->message_date,
                "display"       => $message_item->display,
                "freeze"        => $message_item->freeze,
            );
        }

        // Get message for display
        $sql = "SELECT * FROM tbl_queue_ticker WHERE display=1 AND deleted=0";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        $message = "";

        if ($query->num_rows() > 0)
        {
            $message = $query->row(0)->message_txt;
        }

        $message_config = array(
            "message"       => $message,
            "message_list"  => $message_list
        );

        return $message_config;
    }

    public function build_message_queue($reset)
    {
        $sql = "SELECT reset_timestamp, pickup_url FROM tbl_config_ticker";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        $reset_timestamp = 0;
        $pickup_url = '';
        $display_item = false;

        if ($query->num_rows() > 0)
        {
            $reset_timestamp = $query->row(0)->reset_timestamp;
            $pickup_url = $query->row(0)->pickup_url;
        }

        // get max message id
        $sql = "SELECT max(message_id) message_id FROM tbl_queue_ticker";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        if ($query->row(0)->message_id > 0)
            $message_id = $query->row(0)->message_id + 1;
        else
            $message_id = 1;

        if ($reset)
        {
            // empty queue
            /*
            $sql = "UPDATE tbl_queue_ticker SET deleted=1, display=0, freeze=0";
            $param_array = array();
            $this->db->query($sql, $param_array);
            */
        }
        else
        {
            // get display item
            $sql = "SELECT * FROM tbl_queue_ticker WHERE display=1 AND deleted=0";
            $param_array = array();
            $query = $this->db->query($sql, $param_array);

            if ($query->num_rows() > 0)
                $display_item = true;
        }

        // load message txt file
        $lines = file($pickup_url);

        // add new messages from timestamp
        $count = 0;
        foreach($lines as $line)
        {
            $msg_uniqid = substr($line, 0, 23);
            $msg_date = substr($line, 29, 26);
            $msg_part = substr($line, 56);

            $msg_date = date_create_from_format('d M Y H:i:s O', $msg_date);
            $msg_part = json_decode($msg_part, true);
            $timestamp = date_timestamp_get($msg_date);

            // check timestamp
            if ($timestamp < $reset_timestamp)
                continue;

            $from = "";
            $message = "";

            foreach($msg_part as $message_body => $dummy_body)
            {
                $msg_part_array = explode(",", $message_body);

                $from = $msg_part_array[0];

                for($i = 1; $i < (count($msg_part_array) - 2); $i++)
                {
                    if ($message != "")
                        $message .= ",";
                    $message .= $msg_part_array[$i];
                }

                $message = str_replace("_", " ", $message);
                $message = str_replace("\r\n", "<br>", $message);
            }

            // check black word
            if ($this->check_blackword($message))
                continue;

            $display = 0;

            if ($reset && $message_id == 1)
                $display = 1;

            if (! $display_item && $count == 0)
                $display = 1;

            // check queue
            $sql = "SELECT COUNT(*) AS count_uniq_message FROM tbl_queue_ticker WHERE message_uniqid=?";
            $param_array = array($msg_uniqid);
            $query = $this->db->query($sql, $param_array);

            if ($query->row(0)->count_uniq_message > 0)
                continue;

            // insert
            $sql = "INSERT INTO tbl_queue_ticker SET message_id=?, message_uniqid=?, phone_number=?, message_txt=?, message_date=?, display=?, deleted=0";
            $param_array = array($message_id, $msg_uniqid, $from, $message, date('Y-m-d H:i:s', $timestamp), $display);
            $this->db->query($sql, $param_array);

            $message_id++;
            $count++;
        }
    }

    public function check_blackword($message)
    {
        $sql = "SELECT * FROM tbl_blackword";
        $param_array = array();
        $query_blackword = $this->db->query($sql, $param_array);

        foreach($query_blackword->result() as $blackword_item)
        {
            $blackword = $blackword_item->blackword_str;

            if (stripos($message, $blackword) !== false)
                return true;
        }

        return false;
    }

    public function get_current_message()
    {
        $sql = "SELECT message_txt FROM tbl_queue_ticker WHERE display=1 AND deleted=0";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        if ($query->num_rows() > 0)
            $message_text = $query->row(0)->message_txt;
        else
            $message_text = "";

        return $message_text;
    }

    public function get_next_message()
    {
        // get config
        $sql = "SELECT auto_restart, paused FROM tbl_config_ticker";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        $auto_restart = 1;
        $paused = 0;

        if ($query->num_rows() > 0)
        {
            $auto_restart = $query->row(0)->auto_restart;
            $paused = $query->row(0)->paused;
        }

        if ($paused) // reseted
        {
            // reset paused flag
            $sql = "UPDATE tbl_config_ticker SET paused=0";
            $param_array = array();
            $this->db->query($sql, $param_array);

            return $this->get_current_message();
        }

        // get current display
        $sql = "SELECT message_id, freeze FROM tbl_queue_ticker WHERE display=1 AND deleted=0";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        $message_id = 0;
        $freeze = 0;
        $next_message_id = 0;

        if ($query->num_rows() > 0)
        {
            $message_id = $query->row(0)->message_id;
            $freeze = $query->row(0)->freeze;
            $query->free_result();

            if ($freeze == 1)
            {
                $next_message_id = $message_id;
            }
            else
            {
                // get next message_id
                $sql = "SELECT min(message_id) message_id FROM tbl_queue_ticker WHERE message_id>? AND deleted=0";
                $param_array = array($message_id);
                $query = $this->db->query($sql, $param_array);

                if ($query->row(0)->message_id > 0)
                {
                    $next_message_id = $query->row(0)->message_id;
                    $query->free_result();
                }
                else if ($auto_restart == 1)
                {
                    // get next message_id
                    $sql = "SELECT min(message_id) message_id FROM tbl_queue_ticker WHERE deleted=0";
                    $param_array = array();
                    $query = $this->db->query($sql, $param_array);

                    if ($query->row(0)->message_id > 0)
                    {
                        $next_message_id = $query->row(0)->message_id;
                        $query->free_result();
                    }
                }
                else
                {
                    $next_message_id = $message_id;
                }
            }
        }
        else
        {
            // get max message id
            $sql = "SELECT max(message_id) message_id FROM tbl_queue_ticker";
            $param_array = array();
            $query = $this->db->query($sql, $param_array);

            if ($query->row(0)->message_id > 0)
            {
                $message_id = $query->row(0)->message_id;
                $query->free_result();
            }

            $next_message_id = $message_id + 1;
        }

        // append new messages into queue
        $this->build_message_queue(false);

        // get message
        $sql = "SELECT message_txt FROM tbl_queue_ticker WHERE message_id=?";
        $param_array = array($next_message_id);
        $query = $this->db->query($sql, $param_array);

        $message_txt = "";

        if ($query->num_rows() > 0)
        {
            $message_txt = $query->row(0)->message_txt;

            // update display attr
            $sql = "UPDATE tbl_queue_ticker SET display=1 WHERE message_id=?";
            $param_array = array($next_message_id);
            $this->db->query($sql, $param_array);

            $sql = "UPDATE tbl_queue_ticker SET display=0, freeze=0 WHERE message_id<>?";
            $param_array = array($next_message_id);
            $this->db->query($sql, $param_array);
        }

        return $message_txt;
    }

    public function reset_begin()
    {
        // empty queue
        $sql = "DELETE FROM tbl_queue_ticker";
        $param_array = array();
        $this->db->query($sql, $param_array);

        // set timestamp
        $current_timestamp = 0;

        $sql = "UPDATE tbl_config_ticker SET reset_timestamp=?, paused=1";
        $param_array = array($current_timestamp);
        $this->db->query($sql, $param_array);

        $this->build_message_queue(true);

        // get message list
        $sql = "SELECT * FROM tbl_queue_ticker WHERE deleted=0";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        $message_list = array();

        foreach($query->result() as $message_item)
        {
            $message_list[] = array(
                "message_id"    => $message_item->message_id,
                "phone_number"  => $message_item->phone_number,
                "message_txt"   => $message_item->message_txt,
                "message_date"  => $message_item->message_date,
                "display"       => $message_item->display,
                "freeze"        => $message_item->freeze,
            );
        }

        return $message_list;
    }

    public function reset_queue()
    {
        // empty queue
        $sql = "DELETE FROM tbl_queue_ticker";
        $param_array = array();
        $this->db->query($sql, $param_array);

        // set timestamp
        $current_timestamp = date_timestamp_get(date_create());

        $sql = "UPDATE tbl_config_ticker SET reset_timestamp=?, paused=1";
        $param_array = array($current_timestamp);
        $this->db->query($sql, $param_array);

        $this->build_message_queue(true);

        // get message list
        $sql = "SELECT * FROM tbl_queue_ticker WHERE deleted=0";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        $message_list = array();

        foreach($query->result() as $message_item)
        {
            $message_list[] = array(
                "message_id"    => $message_item->message_id,
                "phone_number"  => $message_item->phone_number,
                "message_txt"   => $message_item->message_txt,
                "message_date"  => $message_item->message_date,
                "display"       => $message_item->display,
                "freeze"        => $message_item->freeze,
            );
        }

        return $message_list;
    }

    public function pause_rotating()
    {
        // get current display
        $sql = "SELECT message_id FROM tbl_queue_ticker WHERE display=1";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        $message_id = 0;

        if ($query->num_rows() > 0)
        {
            $message_id = $query->row(0)->message_id;
        }

        // stop and freeze
        $this->freeze($message_id);
    }

    public function resume_rotating()
    {
        // get current display
        $sql = "SELECT message_id FROM tbl_queue_ticker WHERE display=1";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        $message_id = 0;

        if ($query->num_rows() > 0)
        {
            $message_id = $query->row(0)->message_id;
        }

        // stop freeze
        $this->stop_freeze($message_id);
    }

    public function freeze($message_id)
    {
        $sql = "UPDATE tbl_queue_ticker SET display=1, freeze=1 WHERE message_id=?";
        $param_array = array($message_id);
        $this->db->query($sql, $param_array);

        $sql = "UPDATE tbl_queue_ticker SET display=0, freeze=0 WHERE message_id<>?";
        $param_array = array($message_id);
        $this->db->query($sql, $param_array);
    }

    public function display_freeze($message_id)
    {
        $sql = "UPDATE tbl_queue_ticker SET display=1, freeze=1 WHERE message_id=?";
        $param_array = array($message_id);
        $this->db->query($sql, $param_array);

        $sql = "UPDATE tbl_queue_ticker SET display=0, freeze=0 WHERE message_id<>?";
        $param_array = array($message_id);
        $this->db->query($sql, $param_array);
    }

    public function stop_freeze($message_id)
    {
        $sql = "UPDATE tbl_queue_ticker SET freeze=0 WHERE message_id=?";
        $param_array = array($message_id);
        $this->db->query($sql, $param_array);
    }

    public function delete_from_queue($message_id)
    {
        // Get ticker config
        $this->load->model('config_model');
        $ticker_config = $this->config_model->get_ticker_config();

        // Get current message status
        $sql = "SELECT message_id, display, freeze FROM tbl_queue_ticker WHERE display=1";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        $cur_message_id = 0;
        $cur_display = 0;
        $cur_freeze = 0;

        if ($query->num_rows() > 0)
        {
            $cur_message_id = $query->row(0)->message_id;
            $cur_display = $query->row(0)->display;
            $cur_freeze = $query->row(0)->freeze;
        }

        // Set deleted flag message
        /*
        $sql = "UPDATE tbl_queue_ticker SET deleted=1, display=0, freeze=0 WHERE message_id=?";
        $param_array = array($message_id);
        $this->db->query($sql, $param_array);
        */

        $sql = "DELETE FROM tbl_queue_ticker WHERE message_id=?";
        $param_array = array($message_id);
        $this->db->query($sql, $param_array);

        if ($cur_message_id == $message_id)
        {
            $next_message_id = 0;

            // Get next message id
            $sql = "SELECT min(message_id) AS next_message_id FROM tbl_queue_ticker WHERE message_id>? AND deleted=0";
            $param_array = array($message_id);
            $query = $this->db->query($sql, $param_array);

            if ($query->row(0)->next_message_id > 0)
            {
                $next_message_id = $query->row(0)->next_message_id;
            }
            else if ($ticker_config['auto_restart'] == 1)
            {
                $query->free_result();

                $sql = "SELECT min(message_id) AS next_message_id FROM tbl_queue_ticker WHERE message_id>0 AND deleted=0";
                $param_array = array($message_id);
                $query = $this->db->query($sql, $param_array);

                if ($query->row(0)->next_message_id > 0)
                {
                    $next_message_id = $query->row(0)->next_message_id;
                }
            }

            // Update message queue
            $sql = "UPDATE tbl_queue_ticker SET display=1 WHERE message_id=?";
            $param_array = array($next_message_id);
            $this->db->query($sql, $param_array);
        }

        // get message list
        $sql = "SELECT * FROM tbl_queue_ticker WHERE deleted=0";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        $message_list = array();

        foreach($query->result() as $message_item)
        {
            $message_list[] = array(
                "message_id"    => $message_item->message_id,
                "phone_number"  => $message_item->phone_number,
                "message_txt"   => $message_item->message_txt,
                "message_date"  => $message_item->message_date,
                "display"       => $message_item->display,
                "freeze"        => $message_item->freeze,
            );
        }

        return $message_list;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // Voting
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function voting_reset_begin()
    {
        // update reset timestamp
        $sql = "UPDATE tbl_config_voting SET reset_timestamp=0, paused=0";
        $param_array = array();
        $this->db->query($sql, $param_array);

        // reset deleted flag in queue
        $sql = "DELETE FROM tbl_queue_voting";
        $param_array = array();
        $this->db->query($sql, $param_array);

        $this->build_voting_queue(true);
    }

    function voting_reset_now()
    {
        // set timestamp
        $current_timestamp = date_timestamp_get(date_create());

        $sql = "UPDATE tbl_config_voting SET reset_timestamp=?, paused=0";
        $param_array = array($current_timestamp);
        $this->db->query($sql, $param_array);

        // reset deleted flag in queue
        $sql = "DELETE FROM tbl_queue_voting";
        $param_array = array();
        $this->db->query($sql, $param_array);

        $this->build_voting_queue(true);
    }

    function check_duplication($phone_number)
    {
        $sql = "SELECT COUNT(*) count_duplication FROM tbl_queue_voting WHERE phone_number=?";
        $param_array = array($phone_number);
        $query = $this->db->query($sql, $param_array);

        $count = $query->row(0)->count_duplication;

        if ($count > 0)
            return true;
        else
            return false;
    }

    function check_wrong($message)
    {
        $sql = "SELECT COUNT(*) count_wrong FROM tbl_contestant WHERE sms_code=?";
        $param_array = array($message);
        $query = $this->db->query($sql, $param_array);

        $count = $query->row(0)->count_wrong;

        if ($count > 0)
            return false;
        else
            return true;
    }

    function build_voting_queue($reset)
    {
        // get config
        $sql = "SELECT * FROM tbl_config_voting";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        $pickup_url = "";
        $paused = 0;
        $duplicated_entry = 1;
        $allow_wrong_entry = 1;
        $reset_timestamp = 0;

        if ($query->num_rows() > 0)
        {
            $pickup_url = $query->row(0)->pickup_url;
            $paused = $query->row(0)->paused;
            $duplicated_entry = $query->row(0)->duplicated_entry;
            $allow_wrong_entry = $query->row(0)->allow_wrong_entry;
            $reset_timestamp = $query->row(0)->reset_timestamp;
        }

        if ($paused == 1)
            return;

        // get max message id
        $sql = "SELECT max(message_id) message_id FROM tbl_queue_voting";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        if ($query->row(0)->message_id > 0)
            $message_id = $query->row(0)->message_id + 1;
        else
            $message_id = 1;

        // load message txt file
        $lines = file($pickup_url);

        // add new messages from timestamp
        $count = 0;
        foreach($lines as $line)
        {
            $msg_uniqid = substr($line, 0, 23);
            $msg_date = substr($line, 29, 26);
            $msg_part = substr($line, 56);

            $msg_date = date_create_from_format('d M Y H:i:s O', $msg_date);
            $msg_part = json_decode($msg_part, true);
            $timestamp = date_timestamp_get($msg_date);

            // check timestamp
            if ($timestamp < $reset_timestamp)
                continue;

            $from = "";
            $message = "";

            foreach($msg_part as $message_body => $dummy_body)
            {
                $msg_part_array = explode(",", $message_body);

                $from = $msg_part_array[0];

                for($i = 1; $i < (count($msg_part_array) - 2); $i++)
                {
                    if ($message != "")
                        $message .= ",";
                    $message .= $msg_part_array[$i];
                }

                $message = str_replace("_", " ", $message);
                $message = str_replace("\r\n", "<br>", $message);
            }

            // check duplication/wrong entry
            if ($this->check_duplication($from) && $duplicated_entry == 0)
                continue;

            if ($this->check_wrong($message) && $allow_wrong_entry == 0)
                continue;

            // check queue
            $sql = "SELECT COUNT(*) AS count_uniq_message FROM tbl_queue_voting WHERE message_uniqid=?";
            $param_array = array($msg_uniqid);
            $query = $this->db->query($sql, $param_array);

            if ($query->row(0)->count_uniq_message > 0)
                continue;

            // insert
            $sql = "INSERT INTO tbl_queue_voting SET message_id=?, message_uniqid=?, phone_number=?, message_txt=?, message_date=?, deleted=0";
            $param_array = array($message_id, $msg_uniqid, $from, $message, date('Y-m-d H:i:s', $timestamp));
            $this->db->query($sql, $param_array);

            $message_id++;
            $count++;
        }

    }

    function get_chart_data()
    {
        // Get config
        $sql = "SELECT * FROM tbl_config_voting";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        $show_valid_votes = 1;
        $show_invalid_votes = 1;
        $show_number_votes = 1;

        if ($query->num_rows() > 0)
        {
            $show_valid_votes = $query->row(0)->show_valid_votes;
            $show_invalid_votes = $query->row(0)->show_invalid_votes;
            $show_number_votes = $query->row(0)->show_number_votes;

            $query->free_result();
        }

        // Get contestant
        $sql = "SELECT * FROM tbl_contestant ORDER BY contestant_id DESC";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        $contestant_list = array();

        foreach($query->result() as $contestant_item)
        {
            $contestant_list[] = array(
                "contestant" => $contestant_item->contestant_label,
                "sms_code"  => $contestant_item->sms_code
            );
        }

        $chart_data = array();

        // Calc total number
        $sql = "SELECT COUNT(*) AS count_total FROM tbl_queue_voting WHERE deleted=0";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        if ($show_number_votes == 1)
            $chart_data[] = array((int)$query->row(0)->count_total, 'Total Number of Votes');

        // Calc valid number
        $sql = "SELECT COUNT(*) AS count_valid FROM tbl_queue_voting WHERE deleted=0 AND message_txt IN (SELECT sms_code FROM tbl_contestant)";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        if ($show_valid_votes == 1)
            $chart_data[] = array((int)$query->row(0)->count_valid, 'Total Valid Votes');

        // Calc invalid number
        $sql = "SELECT COUNT(*) AS count_invalid FROM tbl_queue_voting WHERE deleted=0 AND message_txt NOT IN (SELECT sms_code FROM tbl_contestant)";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        if ($show_invalid_votes == 1)
            $chart_data[] = array((int)$query->row(0)->count_invalid, 'Total Invalid Votes');

        // Calc contestant
        foreach($contestant_list as $contestant)
        {
            $sql = "SELECT COUNT(*) AS count_contestant FROM tbl_queue_voting WHERE message_txt=? AND deleted=0";
            $param_array = array($contestant['sms_code']);
            $query = $this->db->query($sql, $param_array);

            $count = $query->row(0)->count_contestant;
            $query->free_result();

            $chart_data[] = array((int)$count, $contestant['contestant']);
        }

        return $chart_data;
    }

}