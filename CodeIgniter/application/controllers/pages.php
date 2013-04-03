<?php

class Pages extends CI_Controller {
	
	public function view($page = 'home') {
		if ( ! file_exists('application/views/pages/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}

		$this->load->database();
		$this->load->model('User_manager');
		$this->load->model('Feature_manager');
		$this->load->model('Hotel_Feature_Manager');

		$data['title'] = ucfirst($page); // Capitalize the first letter
		$data['user'] = 'aa'; //$this->User_manager->get_user(1)->first_name;
    		$data['current_user'] = $this->ion_auth->user()->row();

 		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}

  public function search() {
    $location = isset($_GET['location']) ? $_GET['location'] : 'Singapore';
    $num_of_room = isset($_GET['room']) ? $_GET['room'] : 1;
    $start_date = $_GET['start'];
    $end_date = $_GET['end'];

		$this->load->model('Hotel_manager');
    $available_hotels = $this->Hotel_manager->search($location, $start_date, $end_date, $num_of_room);

		$this->load->model('Hotel_manager');
		$this->data['hotels'] = $available_hotels;
    $this->data['start_date'] = $start_date;
    $this->data['end_date'] = $end_date;

		$this->load->view('templates/header.php');
		$this->load->view('pages/search', $this->data);
		$this->load->view('templates/footer.php', $this->data);
  }
}
