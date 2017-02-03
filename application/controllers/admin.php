<?php
/**
 * Web Admin Panel for SMS Voting system.
 * Created by
 * 		boris801117@hotmail.com	2014/09/04
 * Do not copy or use this module without boris's approval.
 * Contact email
 * 		boris801117@hotmail.com
 */
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    define('ROWS_PER_PAGE',             10);

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('pagination');

        $this->load->helper('form');
        $this->load->helper('url');

        $this->load->model('config_model');
        $this->load->model('message_model');
    }

    // Default method
    public function index()
    {
        $this->view('admin_ticker');
    }

    public function view($page = 'admin_ticker')
    {
        if ( ! file_exists('application/views/pages/'.$page.'.php') )
        {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $data['page'] = $page;

        if ($page == '')
        {
            show_404();
        }
        else if ($page == 'admin_ticker')
        {
            // Get config and message config list
            $ticker_config = $this->config_model->get_ticker_config();
            $message_config = $this->message_model->get_message_config();

            $data['config_type'] = 'ticker';
            $data['ticker_config'] = $ticker_config;
            $data['message_config'] = $message_config;

            $data['main_menu_active'] = 'admin_ticker';
        }
        else if ($page == 'admin_voting')
        {
            // Get config and message config list
            $voting_config = $this->config_model->get_voting_config();
            $message_config = "";

            $data['config_type'] = 'voting';
            $data['voting_config'] = $voting_config;
            $data['message_config'] = $message_config;

            $data['main_menu_active'] = 'admin_voting';
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // Ticker Config
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function set_ticker_config()
    {
        // Get parameter
        $data['message_url'] = urldecode($this->input->post('message_url'));
        $data['page_title'] = urldecode($this->input->post('page_title'));
        $data['big_title'] = urldecode($this->input->post('big_title'));
        $data['small_title'] = urldecode($this->input->post('small_title'));
        $data['demo_version'] = urldecode($this->input->post('demo_version'));
        $data['show_footnote'] = urldecode($this->input->post('show_footnote'));
        $data['footnote_title'] = urldecode($this->input->post('footnote_title'));
        $data['refresh_time'] = urldecode($this->input->post('refresh_time'));
        $data['black_queue'] = urldecode($this->input->post('black_queue'));
        $data['auto_start'] = urldecode($this->input->post('auto_start'));

        $this->config_model->set_ticker_config($data);

        echo json_encode(array('error' => 0));
    }

    public function ticker_reset_begin()
    {
        $message_list = $this->message_model->reset_begin();

        echo json_encode($message_list);
    }

    public function ticker_reset_queue()
    {
        $message_list = $this->message_model->reset_queue();

        echo json_encode($message_list);
    }

    public function ticker_pause_rotating()
    {
        $this->message_model->pause_rotating();

        echo json_encode(array('error' => 0));
    }

    public function ticker_resume_rotating()
    {
        $this->message_model->resume_rotating();

        echo json_encode(array('error' => 0));
    }

    public function ticker_freeze()
    {
        // Get parameter
        $message_id = urldecode($this->input->post('message_id'));

        $this->message_model->freeze($message_id);

        echo json_encode(array('error' => 0));
    }

    public function ticker_display_freeze()
    {
        // Get parameter
        $message_id = urldecode($this->input->post('message_id'));

        $this->message_model->display_freeze($message_id);

        echo json_encode(array('error' => 0));
    }

    public function ticker_stop_freeze()
    {
        // Get parameter
        $message_id = urldecode($this->input->post('message_id'));

        $this->message_model->stop_freeze($message_id);

        echo json_encode(array('error' => 0));
    }

    public function ticker_delete_from_queue()
    {
        // Get parameter
        $message_id = urldecode($this->input->post('message_id'));

        $message_list = $this->message_model->delete_from_queue($message_id);

        echo json_encode($message_list);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // Voting Config
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function set_voting_config()
    {
        // Get parameter
        $data['message_url'] = urldecode($this->input->post('message_url'));
        $data['page_title'] = urldecode($this->input->post('page_title'));
        $data['big_title'] = urldecode($this->input->post('big_title'));
        $data['small_title'] = urldecode($this->input->post('small_title'));
        $data['demo_version'] = urldecode($this->input->post('demo_version'));
        $data['show_footnote'] = urldecode($this->input->post('show_footnote'));
        $data['footnote_title'] = urldecode($this->input->post('footnote_title'));

        $data['allow_duplicate'] = urldecode($this->input->post('allow_duplicate'));
        $data['allow_wrong_entry'] = urldecode($this->input->post('allow_wrong_entry'));
        $data['show_valid_votes'] = urldecode($this->input->post('show_valid_votes'));
        $data['show_invalid_votes'] = urldecode($this->input->post('show_invalid_votes'));
        $data['show_number_votes'] = urldecode($this->input->post('show_number_votes'));

        $this->config_model->set_voting_config($data);

        echo json_encode(array('error' => 0));
    }

    public function voting_reset_begin()
    {
        $this->message_model->voting_reset_begin();

        echo json_encode(array('error' => 0));
    }

    public function voting_reset_now()
    {
        $this->message_model->voting_reset_now();

        echo json_encode(array('error' => 0));
    }

    public function voting_pause_calc()
    {
        $this->config_model->voting_pause_calc();

        echo json_encode(array('error' => 0));
    }

    public function voting_resume_calc()
    {
        $this->config_model->voting_resume_calc();

        echo json_encode(array('error' => 0));
    }

    public function voting_add_contestant()
    {
        // Get parameter
        $contestant = urldecode($this->input->post('contestant'));
        $sms_code = urldecode($this->input->post('sms_code'));

        $contestant_list = $this->config_model->add_contestant($contestant, $sms_code);

        echo json_encode($contestant_list);
    }

    public function voting_delete_contestant()
    {
        // Get parameter
        $id = urldecode($this->input->post('id'));

        $contestant_list = $this->config_model->delete_contestant($id);

        echo json_encode($contestant_list);
    }

    public function voting_update_contestant()
    {
        // Get parameter
        $id = urldecode($this->input->post('id'));
        $label = urldecode($this->input->post('label'));
        $code = urldecode($this->input->post('code'));

        $contestant_list = $this->config_model->update_contestant($id, $label, $code);

        echo json_encode($contestant_list);
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */