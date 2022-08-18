<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Common_model','common');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('category');
	}

	public function ajax_list()
	{
		$list = $this->common->get_datatables();

		

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $category) {
			
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $category->category_name;
			$row[] = ($category->status == 1) ? 'Active':'Inactive';
			$row[] = date( 'jS M Y', strtotime($category->created_at));
			$row[] = '<a href="CategoryController/edit/'.$category->id.'" class="btn btn-info btn-sm">Edit</a> <a href="CategoryController/delete/'.$category->id.'" class="btn btn-danger btn-sm">Delete</a>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->common->count_all(),
						"recordsFiltered" => $this->common->count_filtered(),
						"data" => $data,
				);

		// echo "<pre>";
		// print_r($output);
		// exit();
		
		//output to json format
		echo json_encode($output);
	}

}

?>
