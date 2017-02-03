<?php
/**
 * Created by PhpStorm.
 * User: boris
 * Date: 09/05/14
 * Time: 3:40 PM
 */
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Config_model extends CI_Model {


    /*******************************************************************************************************************
     *
     * Model function
     *
     ******************************************************************************************************************/
    function __construct()
    {
        parent::__construct();
    }

    public function get_ticker_config()
    {
        $sql = "SELECT * FROM tbl_config_ticker";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        $sql = "SELECT * FROM tbl_blackword";
        $param_array = array();
        $query_blackword = $this->db->query($sql, $param_array);

        $blackword_list = "";
        foreach($query_blackword->result() as $blackword_item)
        {
            if (strlen($blackword_list) > 0)
                $blackword_list .= "\n";

            $blackword_list .= $blackword_item->blackword_str;
        }

        $config = array();

        if ($query->num_rows() > 0)
        {
            $config = array(
                "pickup_url"        => $query->row(0)->pickup_url,
                "page_title"        => $query->row(0)->page_title,
                "big_title"         => $query->row(0)->big_title,
                "small_title"       => $query->row(0)->small_title,
                "demo_version"      => $query->row(0)->demo_version,
                "show_footnote"     => $query->row(0)->show_footnote,
                "footnote_title"    => $query->row(0)->footnote_title,
                "rotating_inteval"  => $query->row(0)->rotating_inteval,
                "auto_restart"      => $query->row(0)->auto_restart,
                "paused"            => $query->row(0)->paused,
                "blackword_list"    => $blackword_list
            );
        }

        return $config;
    }

    public function set_ticker_config($data)
    {
        $sql = "SELECT * FROM tbl_config_ticker";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        if ($query->num_rows() > 0)
        {
            $sql = "UPDATE tbl_config_ticker
                    SET
                        pickup_url=?,
                        page_title=?,
                        big_title=?,
                        small_title=?,
                        demo_version=?,
                        show_footnote=?,
                        footnote_title=?,
                        rotating_inteval=?,
                        auto_restart=?
                    ";
        }
        else
        {
            $sql = "INSERT INTO tbl_config_ticker
                    SET
                        pickup_url=?,
                        page_title=?,
                        big_title=?,
                        small_title=?,
                        demo_version=?,
                        show_footnote=?,
                        footnote_title=?,
                        rotating_inteval=?,
                        auto_restart=?
                    ";
        }

        $param_array = array(
            $data['message_url'],
            $data['page_title'],
            $data['big_title'],
            $data['small_title'],
            $data['demo_version'],
            $data['show_footnote'],
            $data['footnote_title'],
            $data['refresh_time'],
            $data['auto_start']
        );
        $this->db->query($sql, $param_array);

        // black word
        $sql = "DELETE FROM tbl_blackword";
        $param_array = array();
        $this->db->query($sql, $param_array);

        $words = explode("\n", $data['black_queue']);

        foreach($words as $blackword)
        {
            if (strlen($blackword) > 0)
            {
                $sql = "INSERT INTO tbl_blackword SET blackword_str=?";
                $param_array = array($blackword);
                $this->db->query($sql, $param_array);

                $this->delete_blackword_message($blackword);
            }
        }
    }

    public function get_voting_config()
    {
        $sql = "SELECT * FROM tbl_config_voting";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        $sql = "SELECT * FROM tbl_contestant";
        $param_array = array();
        $query_contestant = $this->db->query($sql, $param_array);

        $contestant_list = array();
        foreach($query_contestant->result() as $contestant_item)
        {
            $contestant_list[] = array(
                "contestant_id"     => $contestant_item->contestant_id,
                "contestant_label"  => $contestant_item->contestant_label,
                "sms_code"          => $contestant_item->sms_code
            );
        }

        $config = array();

        if ($query->num_rows() > 0)
        {
            $config = array(
                "pickup_url"        => $query->row(0)->pickup_url,
                "page_title"        => $query->row(0)->page_title,
                "big_title"         => $query->row(0)->big_title,
                "small_title"       => $query->row(0)->small_title,
                "demo_version"      => $query->row(0)->demo_version,
                "show_footnote"     => $query->row(0)->show_footnote,
                "footnote_title"    => $query->row(0)->footnote_title,
                "paused"            => $query->row(0)->paused,
                "duplicated_entry"  => $query->row(0)->duplicated_entry,
                "allow_wrong_entry" => $query->row(0)->allow_wrong_entry,
                "show_valid_votes"  => $query->row(0)->show_valid_votes,
                "show_invalid_votes" => $query->row(0)->show_invalid_votes,
                "show_number_votes"  => $query->row(0)->show_number_votes,
                "contestant_list"   => $contestant_list
            );
        }

        return $config;
    }

    public function add_contestant($contestant, $sms_code)
    {
        // insert new contestant
        $sql = "INSERT INTO tbl_contestant SET contestant_label=?, sms_code=?";
        $param_array = array($contestant, $sms_code);
        $this->db->query($sql, $param_array);

        // select contestant
        $sql = "SELECT * FROM tbl_contestant";
        $param_array = array();
        $query_contestant = $this->db->query($sql, $param_array);

        $contestant_list = array();
        foreach($query_contestant->result() as $contestant_item)
        {
            $contestant_list[] = array(
                "contestant_id"     => $contestant_item->contestant_id,
                "contestant_label"  => $contestant_item->contestant_label,
                "sms_code"          => $contestant_item->sms_code
            );
        }

        return $contestant_list;
    }

    public function delete_contestant($id)
    {
        // delete
        $sql = "DELETE FROM tbl_contestant WHERE contestant_id=?";
        $param_array = array($id);
        $this->db->query($sql, $param_array);

        // select contestant
        $sql = "SELECT * FROM tbl_contestant";
        $param_array = array();
        $query_contestant = $this->db->query($sql, $param_array);

        $contestant_list = array();
        foreach($query_contestant->result() as $contestant_item)
        {
            $contestant_list[] = array(
                "contestant_id"     => $contestant_item->contestant_id,
                "contestant_label"  => $contestant_item->contestant_label,
                "sms_code"          => $contestant_item->sms_code
            );
        }

        return $contestant_list;
    }

    public function update_contestant($id, $label, $code)
    {
        // update
        $sql = "UPDATE tbl_contestant SET contestant_label=?, sms_code=? WHERE contestant_id=?";
        $param_array = array($label, $code, $id);
        $this->db->query($sql, $param_array);

        // select contestant
        $sql = "SELECT * FROM tbl_contestant";
        $param_array = array();
        $query_contestant = $this->db->query($sql, $param_array);

        $contestant_list = array();
        foreach($query_contestant->result() as $contestant_item)
        {
            $contestant_list[] = array(
                "contestant_id"     => $contestant_item->contestant_id,
                "contestant_label"  => $contestant_item->contestant_label,
                "sms_code"          => $contestant_item->sms_code
            );
        }

        return $contestant_list;
    }

    public function set_voting_config($data)
    {
        $sql = "SELECT * FROM tbl_config_voting";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        if ($query->num_rows() > 0)
        {
            $sql = "UPDATE tbl_config_voting
                    SET
                        pickup_url=?,
                        page_title=?,
                        big_title=?,
                        small_title=?,
                        demo_version=?,
                        show_footnote=?,
                        footnote_title=?,

                        duplicated_entry=?,
                        allow_wrong_entry=?,
                        show_valid_votes=?,
                        show_invalid_votes=?,
                        show_number_votes=?
                    ";
        }
        else
        {
            $sql = "INSERT INTO tbl_config_voting
                    SET
                        pickup_url=?,
                        page_title=?,
                        big_title=?,
                        small_title=?,
                        demo_version=?,
                        show_footnote=?,
                        footnote_title=?,

                        duplicated_entry=?,
                        allow_wrong_entry=?,
                        show_valid_votes=?,
                        show_invalid_votes=?,
                        show_number_votes=?
                    ";
        }

        $param_array = array(
            $data['message_url'],
            $data['page_title'],
            $data['big_title'],
            $data['small_title'],
            $data['demo_version'],
            $data['show_footnote'],
            $data['footnote_title'],

            $data['allow_duplicate'],
            $data['allow_wrong_entry'],
            $data['show_valid_votes'],
            $data['show_invalid_votes'],
            $data['show_number_votes']
        );
        $this->db->query($sql, $param_array);
    }

    public function voting_pause_calc()
    {
        $sql = "UPDATE tbl_config_voting SET paused=1";
        $param_array = array();
        $this->db->query($sql, $param_array);
    }

    public function voting_resume_calc()
    {
        $sql = "UPDATE tbl_config_voting SET paused=0";
        $param_array = array();
        $this->db->query($sql, $param_array);
    }

    public function delete_blackword_message($blackword)
    {
        $sql = "SELECT message_id, message_txt FROM tbl_queue_ticker";
        $param_array = array();
        $query = $this->db->query($sql, $param_array);

        foreach($query->result() as $message_item)
        {
            $message_id = $message_item->message_id;
            $message_txt = $message_item->message_txt;

            if (stripos($message_txt, $blackword) !== false)
            {
                $sql = "DELETE FROM tbl_queue_ticker WHERE message_id=?";
                $param_array = array($message_id);
                $this->db->query($sql, $param_array);
            }
        }
    }
}