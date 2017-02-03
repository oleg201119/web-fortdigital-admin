<?php
/**
 * Web Site for SMS Voting system.
 * Created by
 * 		boris801117@hotmail.com	2014/09/04
 * Do not copy or use this module without boris's approval.
 * Contact email
 * 		boris801117@hotmail.com
 */
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');

        $this->load->model('config_model');
        $this->load->model('message_model');
    }

    // Default method
    public function index()
    {
        $this->view('site_ticker');
    }

    public function view($page = 'site_ticker')
    {
        if ( ! file_exists('application/views/pages/'.$page.'.php') )
        {
            // Whoops, we don't have a page for that!
            show_404();
        }

        if ($page == '')
        {
            show_404();
        }
        else if ($page == 'site_ticker')
        {
            // Get config and message config list
            $ticker_config = $this->config_model->get_ticker_config();
            $message_text = $this->message_model->get_current_message();

            $data['config_type'] = 'ticker';
            $data['ticker_config'] = $ticker_config;
            $data['message_text'] = $message_text;

            $this->load->view('pages/' . $page, $data);
        }
        else if ($page == 'site_voting')
        {
            // Get config and message config list
            $voting_config = $this->config_model->get_voting_config();


            $data['config_type'] = 'voting';
            $data['voting_config'] = $voting_config;

            $this->load->view('pages/' . $page, $data);
        }
    }

    public function get_ticker_content()
    {
        $ticker_config = $this->config_model->get_ticker_config();
        $message_text = $this->message_model->get_next_message();

        $config = array(
            "ticker_config"     => $ticker_config,
            "message_text"    => $message_text
        );

        echo json_encode($config);
    }

    public function get_chart_data()
    {
        $this->message_model->build_voting_queue(false);
        $chart_data = $this->message_model->get_chart_data();

        echo json_encode($chart_data);
    }
}