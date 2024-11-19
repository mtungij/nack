<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//include APPPATH . 'third_party/sendgrid-php/sendgrid-php.php';
class Admin extends CI_Controller {
	public function index()
	{
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
    $receivable_total = $this->queries->get_total_recevable($comp_id);
    $total_received = $this->queries->get_sumReceived_amount($comp_id);
    $total_loan_pending = $this->queries->get_sun_loanPending($comp_id);
    $total_loanWithdrawal = $this->queries->get_today_withdrawal_loan($comp_id);
    $today_penart = $this->queries->get_total_penartToday($comp_id);
    $prepaid_today = $this->queries->prepaid_pay($comp_id);

     $total_received = $this->queries->get_sumReceived_amount($comp_id);
     $prepaid_today = $this->queries->prepaid_pay($comp_id);
     $total_loan_fee = $this->queries->get_total_loanFeereconce($comp_id);
     $today_income = $this->queries->get_today_income($comp_id);
     $toay_expences = $this->queries->get_today_expences($comp_id);
     $total_expect = $this->queries->get_loanExpectation($comp_id);


     $total_capital = $this->queries->get_total_capital($comp_id);
     $out_float = $this->queries->get_with_done_principal($comp_id);
     $cash_bank = $this->queries->get_sum_cashInHandcomp($comp_id);
     $principal_loan = $this->queries->get_total_principal($comp_id);
     $done_loan = $this->queries->get_totalLoanRepayment($comp_id);
     $total_receved = $this->queries->get_sumReceived_amount($comp_id);
     
     //new code 
     $cash_depost = $this->queries->get_today_chashData_Comp($comp_id);
     $cash_income = $this->queries->get_today_incomeBlanchDataComp($comp_id);
     $cash_expences = $this->queries->get_today_expencesDataComp($comp_id);
     $blanch = $this->queries->get_blanch($comp_id);
     $total_remain = $this->queries->total_outstand_loan($comp_id);
     $today_total_loan_pend = $this->queries->get_sum_loanpend($comp_id);

     //new code captal income
     $loanAprove = $this->queries->get_loan_aprove($comp_id);
     $withdrawal = $this->queries->get_total_withAmount($comp_id);
     $loan_depost = $this->queries->get_totalDepost($comp_id);
     $receive_Amount = $this->queries->get_sumReceve($comp_id);
     $loan_fee = $this->queries->get_total_loanFee($comp_id);
     $request_expences = $this->queries->get_expencesData($comp_id);

     $sum_comp_capital = $this->queries->get_sum_companyBalance($comp_id);


     $total_deducted_balance = $this->queries->getTotal_deducted($comp_id);
	 $total_non = $this->queries->getTotal_deductednon($comp_id);

	 $blanch_capital_circle = $this->queries->get_total_blanch_capital($comp_id);

	 $account_capital = $this->queries->get_total_sumaryAccount($comp_id);


	      // print_r($blanch_capital_circle);
	      //         exit();
	$this->load->view('admin/index',['receivable_total'=>$receivable_total,'total_received'=>$total_received,'total_loan_pending'=>$total_loan_pending,'total_loanWithdrawal'=>$total_loanWithdrawal,'today_penart'=>$today_penart,'prepaid_today'=>$prepaid_today,'total_received'=>$total_received,'prepaid_today'=>$prepaid_today,'total_loan_fee'=>$total_loan_fee,'today_income'=>$today_income,'toay_expences'=>$toay_expences,'total_capital'=>$total_capital,'out_float'=>$out_float,'cash_bank'=>$cash_bank,'principal_loan'=>$principal_loan,'done_loan'=>$done_loan,'total_expect'=>$total_expect,'total_receved'=>$total_receved,'cash_depost'=>$cash_depost,'cash_income'=>$cash_income,'cash_expences'=>$cash_expences,'blanch'=>$blanch,'total_remain'=>$total_remain,'today_total_loan_pend'=>$today_total_loan_pend,'loanAprove'=>$loanAprove,'withdrawal'=>$withdrawal,'loan_depost'=>$loan_depost,'receive_Amount'=>$receive_Amount,'loan_fee'=>$loan_fee,'request_expences'=>$request_expences,'sum_comp_capital'=>$sum_comp_capital,'total_deducted_balance'=>$total_deducted_balance,'total_non'=>$total_non,'blanch_capital_circle'=>$blanch_capital_circle,'account_capital'=>$account_capital]);
	}



	public function setting(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$compdata = $this->queries->get_companyDataProfile($comp_id);
		$region = $this->queries->get_region();
		//    echo "<pre>";
		// print_r($compdata);
		//         exit();

		$this->load->view('admin/setting',['compdata'=>$compdata,'region'=>$region]);
	}


	public function sub_admin(){
		$this->load->model('queries');
		$this->load->view('admin/sub_admin');
	}

	public function start_penart($loan_id){
    $this->load->model('queries');
    $penat_status = $this->queries->get_loan_start_penart($loan_id);
    if ($penat_status->penat_status ='YES'){
        $this->queries->update_penart($loan_id,$penat_status);
        $this->session->set_flashdata('massage','Start Penalt successfully');
    }
    return redirect('admin/loan_withdrawal');
 }


	public function stop_penart($loan_id){
	   $this->form_validation->set_rules('comp_id','company','required');
	   $this->form_validation->set_rules('loan_id','Loan','required');
	   $this->form_validation->set_rules('blanch_id','blanch','required');
	   $this->form_validation->set_rules('description','Reason','required');
	   //$this->form_validation->set_rules('penat_status','Penat','required');
	   $this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
	   if ($this->form_validation->run()) {
	   	    $data = $this->input->post();
	   	    $penat_status = 'NO';
	   	    $loan_id = $data['loan_id'];
	   	      // print_r($penat_status);
	   	      //    echo "<pre>";
	   	      // print_r($loan_id);
	   	      //      exit();
	   	    $this->load->model('queries');
	   	    if ($this->queries->insert_penalt_reason($data)) {
                $this->update_penart_status($loan_id,$penat_status);
	   	    	$this->session->set_flashdata('massage','Stop Penart Successfully');
	   	    }else{
	   	    	$this->session->set_flashdata('error','Failed');

	   	    }

	   	    return redirect('admin/loan_withdrawal');
	   }
	   $this->loan_withdrawal();
	}

	//update  penat status

  public function update_penart_status($loan_id,$penat_status){
  $sqldata="UPDATE `tbl_loans` SET `penat_status`= '$penat_status' WHERE `loan_id`= '$loan_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
  return true;
}


	public function print_branch(){
     $this->load->model('queries');
	 $comp_id = $this->session->userdata('comp_id');
     $compdata = $this->queries->get_companyData($comp_id);
     $blanch = $this->queries->get_blanch($comp_id);
	 $mpdf = new \Mpdf\Mpdf();
     $html = $this->load->view('admin/blanch_report',['compdata'=>$compdata,'blanch'=>$blanch],true);
     $mpdf->SetFooter('Generated By Brainsoft Technology');
     $mpdf->WriteHTML($html);
     $mpdf->Output();
		//$this->load->view('admin/blanch_report');
	}

	public function company_profile(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$comp_data = $this->queries->get_companyDataProfile($comp_id);
		$region = $this->queries->get_region();
		  //  echo "<pre>";
		  // print_r($region);
		  //     exit();
		$this->load->view('admin/company_profile',['comp_data'=>$comp_data,'region'=>$region]);
	}


	public function update_company_profile($comp_id){
            //Prepare array of user data
            $data = array(
            'region_id'=> $this->input->post('region_id'),
            'comp_name'=> $this->input->post('comp_name'),
            'comp_phone'=> $this->input->post('comp_phone'),
            'adress'=> $this->input->post('adress'),
            'comp_number'=> $this->input->post('comp_number'),
            'comp_email'=> $this->input->post('comp_email'),
            );
            //   echo "<pre>";
            // print_r($data);
            //  echo "</pre>";
            //   exit();

           $this->load->model('queries'); 
           $data = $this->queries->update_company_Data($data,$comp_id);
            //Storing insertion status message.
            if($data){
            	$this->session->set_flashdata('massage','Company profile Updated successfully');
               }else{
                $this->session->set_flashdata('error','Data failed!!');
            }
            return redirect('admin/setting');

	}
	//chnage password 

	public function change_password(){
      $this->load->model('queries');
      $comp_id = $this->session->userdata('comp_id');
      $my = $this->queries->get_companyDataProfile($comp_id);
      $old = $my->password;
        $this->form_validation->set_rules('oldpass', 'old password', 'required');
        $this->form_validation->set_rules('newpass', 'new password', 'required');
        $this->form_validation->set_rules('passconf', 'confirm password', 'required|matches[newpass]');

        $this->form_validation->set_error_delimiters('<strong><div class="text-danger">', '</div></strong>');

        if($this->form_validation->run()) {
        	$data = $this->input->post();
        	$oldpass = $data['oldpass'];
        	$newpass = $data['newpass'];
        	$passconf = $data['passconf'];
        	    //print_r(sha1($newpass));
        	       // echo "<br>";
        	       // print_r($oldpass);
        	       //  echo "<br>";
        	       // print_r($old);
        	       //    exit();
           if($old !== sha1($oldpass)){
           $this->session->set_flashdata('error','Old Password not Match') ; 
             return redirect('admin/setting');
         }elseif($old == sha1($oldpass)){
         $this->queries->update_password_data($comp_id, array('password' => sha1($newpass)));
         $this->session->set_flashdata('massage','Password changed successfully'); 
        $compdata = $this->queries->get_companyDataProfile($comp_id);
        $this->load->view("admin/setting",['compdata'=>$compdata]);
        
          }else{
          	$compdata = $this->queries->get_companyDataProfile($comp_id);
        $this->load->view("admin/setting",['compdata'=>$compdata]);
          }
        }
        }
// check old password is match
        public function password_check($oldpass)
    {
        $this->load->model('queries');
        $comp_id = $this->session->userdata('comp_id');
        $user = $this->queries->get_user_data($comp_id);
          
        if($user->password !== sha1($oldpass)) {
            $this->form_validation->set_message('error', 'Old Password not Match');
            //return false;
        }

        return redirect("admin/setting");
    }


    public function update_comp_logo($comp_id){
	if(!empty($_FILES['comp_logo']['name'])){
                $config['upload_path'] = 'assets/img/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
                $config['file_name'] = $_FILES['comp_logo']['name'];
                    //die($config);
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('comp_logo')){
                    $uploadData = $this->upload->data();
                    $comp_logo = $uploadData['file_name'];
                }else{
                    $comp_logo = '';
                }
            }else{
                $comp_logo = '';
            }
            
            //Prepare array of user data
            $data = array(
            'comp_logo' => $comp_logo,
            );
            //   echo "<pre>";
            // print_r($data);
            //  echo "</pre>";
            //   exit();

           $this->load->model('queries'); 
           $data = $this->queries->update_company_Data($data,$comp_id);
            //Storing insertion status message.
            if($data){
            	$this->session->set_flashdata('massage','Company Logo Updated successfully');
               }else{
                $this->session->set_flashdata('error','Data failed!!');
            }
            return redirect('admin/setting/');	
	}


	public function change_password_oficer(){
        $this->load->model('queries');
        $blanch_id = $this->session->userdata('blanch_id');
        $empl_id = $this->session->userdata('empl_id');
        $manager_data = $this->queries->get_manager_data($empl_id);
        $comp_id = $manager_data->comp_id;
        $company_data = $this->queries->get_companyData($comp_id);
        $blanch_data = $this->queries->get_blanchData($blanch_id);
        $empl_data = $this->queries->get_employee_data($empl_id);
        $old = $empl_data->password;
        $this->form_validation->set_rules('oldpass', 'old password', 'required');
        $this->form_validation->set_rules('newpass', 'new password', 'required');
        $this->form_validation->set_rules('passconf', 'confirm password', 'required|matches[newpass]');
        $this->form_validation->set_error_delimiters('<strong><div class="text-danger">', '</div></strong>');

        if($this->form_validation->run()) {
          $data = $this->input->post();
          $oldpass = $data['oldpass'];
          $newpass = $data['newpass'];
          $passconf = $data['passconf'];
             // print_r(sha1($newpass));
                 // echo "<br>";
                 // print_r($oldpass);
                 //  echo "<br>";
                 // print_r($old);
                 //    exit();
           if($old !== sha1($oldpass)){
           $this->session->set_flashdata('error','Old Password not Match') ; 
             return redirect('admin/setting');
         }elseif($old == sha1($oldpass)){
         $this->queries->update_password_dataEmployee($empl_id, array('password' => sha1($newpass)));
         $this->session->set_flashdata('massage','Password changed successfully'); 
        $empl_data = $this->queries->get_employee_data($empl_id);
        $privillage = $this->queries->get_position_empl($empl_id);
        $manager = $this->queries->get_position_manager($empl_id);
        $this->load->view("admin/setting",['empl_data'=>$empl_data,'privillage'=>$privillage,'manager'=>$manager]);
        
          }else{
           $empl_data = $this->queries->get_employee_data($empl_id);
           $privillage = $this->queries->get_position_empl($empl_id);
           $manager = $this->queries->get_position_manager($empl_id);
        $this->load->view("admin/setting",['empl_data'=>$empl_data,'privillage'=>$privillage,'manager'=>$manager]);
          }
        }
        }


	public function region(){
		$this->load->model('queries');
		$region = $this->queries->get_region();
		$this->load->view('admin/region',['region'=>$region]);
	}

	public function create_region(){
		$this->form_validation->set_rules('region_name','Reion','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run() ) {
			  $data = $this->input->post();
			  
			  $this->load->model('queries');
			  if ($this->queries->insert_region($data)) {
			  	 $this->session->set_flashdata('massage','Region Saved successfully');
			  }else{
			  	$this->session->set_flashdata('error','Data failed');
			  }
			  return redirect('admin/region');
		}
		$this->region();
	}

	public function table(){
		//echo "hallooooooo";
		$this->load->view('admin/table');
	}

	public function blanch(){
		$this->load->model('queries');
		 $comp_id = $this->session->userdata('comp_id');
		 $blanch = $this->queries->get_blanch($comp_id);
		 $region = $this->queries->get_region();
		  // print_r($region);
		  //    exit();
		$this->load->view('admin/blanch',['blanch'=>$blanch,'region'=>$region]);
	}

	public function  create_blanch(){
		$this->form_validation->set_rules('comp_id','company','required');
		$this->form_validation->set_rules('region_id','Region','required');
		$this->form_validation->set_rules('blanch_name','blanch name','required');
		$this->form_validation->set_rules('blanch_no','blanch','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			$data = $this->input->post();
			 // print_r($data);
			 //   exit();
			$this->load->model('queries');
			if ($this->queries->insert_blanch($data)) {
				 $this->session->set_flashdata('massage','Blanch Registered successfully');
			}else{
				 $this->session->set_flashdata('error','Failed');

			}
			return redirect('admin/blanch');
		}
		$this->blanch();
	}

	public function shareHolder(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$share = $this->queries->get_shareHolder($comp_id);
		 // print_r($share);
		 //        exit();
		$this->load->view('admin/share',['share'=>$share]);
	}

	public function create_shareHolder(){
		$this->form_validation->set_rules('comp_id','company','required');
		$this->form_validation->set_rules('share_name','full name','required');
		$this->form_validation->set_rules('share_mobile','number','required');
		$this->form_validation->set_rules('share_email','email','required');
		$this->form_validation->set_rules('share_sex','Gender','required');
		$this->form_validation->set_rules('share_dob','DOB','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			$data = $this->input->post();
			  // print_r($data);
			  //       exit();
			$this->load->model('queries');
			if ($this->queries->insert_shareHolder($data)) {
				$this->session->set_flashdata('massage','Share Holder saved successfully');
			}else{
				$this->session->set_flashdata('error','Failed');
			}
			return redirect('admin/shareHolder');
		}
		$this->shareHolder();
	}

	


	


	public function capital(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$share = $this->queries->get_shareHolder($comp_id);
		$capital = $this->queries->get_capital($comp_id);
        $account = $this->queries->get_account_transaction($comp_id);
        $total_capital_company = $this->queries->get_sumTotalCapital($comp_id);
        $account_capital = $this->queries->get_total_sumaryAccount($comp_id);
		  //      echo "<pre>";
		  // print_r($account_capital);
		  //         exit();
		$this->load->view('admin/capital',['share'=>$share,'capital'=>$capital,'account'=>$account,'total_capital_company'=>$total_capital_company,'account_capital'=>$account_capital]);
	}


	public function remove_capital_share($capital_id){
		$this->load->model('queries');
		$share_lecod = $this->queries->get_capital_share_list($capital_id);
		$payment_method = $share_lecod->pay_method;
		$amount = $share_lecod->amount;
		$comp_id = $share_lecod->comp_id;

		$comp_balance = $this->queries->get_total_comp_capital($comp_id,$payment_method);
        $account_balance = $comp_balance->comp_balance;

        $removed_balance = $account_balance - $amount;

        $this->update_remain_account_balance($comp_id,$payment_method,$removed_balance);
		// echo "<pre>";
		// print_r($removed_balance);
		         //exit();
		if($this->queries->remove_share_capital($capital_id));
		$this->session->set_flashdata("massage",'Deleted successfully');
		return redirect('admin/capital');
	}

	public function update_remain_account_balance($comp_id,$payment_method,$removed_balance){
	 $sqldata="UPDATE `tbl_ac_company` SET `comp_balance`= '$removed_balance' WHERE  `comp_id` = '$comp_id' AND `trans_id`='$payment_method'";
    // print_r($sqldata);
    //    exit();
     $query = $this->db->query($sqldata);
     return true;
	}


	public function create_capital(){
		$this->form_validation->set_rules('comp_id','company','required');
		$this->form_validation->set_rules('share_id','share name','required');
		$this->form_validation->set_rules('amount','Amount','required');
		$this->form_validation->set_rules('recept','recept');
		$this->form_validation->set_rules('chaque_no','chaque');
		$this->form_validation->set_rules('pay_method','pay method','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			  $data = $this->input->post();
			  $amount = $data['amount'];
			  $comp_id = $data['comp_id'];
			  $pay_method = $data['pay_method'];
			  $trans_id = $pay_method;
			     // print_r($pay_method);
			     //     exit();
			  $this->load->model('queries');
			  if ($this->queries->insert_capital($data)) {
			  	$acount = $this->queries->get_remain_company_balance($trans_id);
			  	$old_comp_balance = $acount->comp_balance;
			  	$total_remain = $old_comp_balance + $amount;
			  	   if ($acount->comp_id == $comp_id and $acount->trans_id == $pay_method) {
			  	  $this->update_company_balance($comp_id,$total_remain,$pay_method); 
			  	   }else{
			  	$this->insert_company_balance($comp_id,$amount,$pay_method);
			  	   }
			  	   $this->session->set_flashdata('massage','capital Added successfully');
			  }else{
			  	$this->session->set_flashdata('error','Failed');
			  }
			  return redirect('admin/capital');
		}
		$this->capital();
	}


   //insert company balance
	  public function insert_company_balance($comp_id,$amount,$pay_method){
      $this->db->query("INSERT INTO tbl_ac_company (`comp_id`,`comp_balance`,`trans_id`) VALUES ('$comp_id','$amount','$pay_method')");
      }

      //update company balance
public function update_company_balance($comp_id,$total_remain,$pay_method){
$sqldata="UPDATE `tbl_ac_company` SET `comp_balance`= '$total_remain' WHERE  `trans_id`='$pay_method'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}



	public function edit_capital($capital_id,$pay_method){
		$trans_id = $pay_method;
		$this->form_validation->set_rules('share_id','share name','required');
		//$this->form_validation->set_rules('amount','Amount','required');
		$this->form_validation->set_rules('recept','recept');
		$this->form_validation->set_rules('chaque_no','chaque');
		$this->form_validation->set_rules('pay_method','pay method','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			  $data = $this->input->post();
			  //$amount = $data['amount'];
			     // print_r($amount);
			     //     exit();
			  $this->load->model('queries');
			  if ($this->queries->update_capital($data,$capital_id)) {
			  	//$this->update_newAccount_balance($comp_id,$trans_id,$amount);
			  	   $this->session->set_flashdata('massage','Capital Updated successfully');
			  }else{
			  	$this->session->set_flashdata('error','Failed');
			  }
			  return redirect('admin/capital');
		}
		$this->capital();

	}





	// public function update_newAccount_balance($comp_id,$trans_id,$amount){
 //   $sqldata="UPDATE `tbl_ac_company` SET `comp_balance`= '$amount' WHERE `trans_id`= '$trans_id'";
 //    // print_r($sqldata);
 //    //    exit();
 //   $query = $this->db->query($sqldata);
 //   return true; 
	// }




	public function position(){
		$this->load->model('queries');
		$position = $this->queries->get_position();
		 // print_r($position);
		 //     exit();
		$this->load->view('admin/position',['position'=>$position]);
	}

	public function create_position(){
		$this->form_validation->set_rules('position','position','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			  $data = $this->input->post();
			  // print_r($data);
			  // exit();
			  $this->load->model('queries');
			  if ($this->queries->insert_position($data)) {
			  	 $this->session->set_flashdata('massage','position saved successfully');
			  }else{
			  	 $this->session->set_flashdata('error','Failed');
			  }
			  return redirect('admin/position');
		}
		$this->position();
	}


	public function modify_position($position_id){
		$this->form_validation->set_rules('position','position','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			  $data = $this->input->post();
			  // print_r($data);
			  //     exit();
			  $this->load->model('queries');
			  if ($this->queries->update_position($data,$position_id)) {
			  	 $this->session->set_flashdata('massage','position Updated successfully');
			  }else{
			  	 $this->session->set_flashdata('error','Failed');
			  }
			  return redirect('admin/position');
		}
		$this->position();

	}


	public function delete_position($position_id){
		$this->load->model('queries');
		if($this->queries->remove_position($position_id));
		 $this->session->set_flashdata('massage','Data Deleted successfully');
		 return redirect('admin/position');
	}


	public function modify_blanch($blanch_id){
		$this->form_validation->set_rules('region_id','Region','required');
		$this->form_validation->set_rules('blanch_name','blanch name','required');
		$this->form_validation->set_rules('blanch_no','blanch','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			$data = $this->input->post();
			 // print_r($data);
			 //   exit();
			$this->load->model('queries');
			if ($this->queries->update_blanch($data,$blanch_id)) {
				 $this->session->set_flashdata('massage','Blanch Updated successfully');
			}else{
				 $this->session->set_flashdata('error','Failed');

			}
			return redirect('admin/blanch');
		}
		$this->blanch();


	}

	public function delete_blanch($blanch_id){
		$this->load->model('queries');
		if($this->queries->remove_blanch($blanch_id));
		  $this->session->set_flashdata('massage','Data Deleted successfully');
		     return redirect('admin/blanch');
	}

	public function modify_shareholder($share_id){
		$this->form_validation->set_rules('share_name','full name','required');
		$this->form_validation->set_rules('share_mobile','number','required');
		$this->form_validation->set_rules('share_email','email','required');
		$this->form_validation->set_rules('share_sex','Gender','required');
		$this->form_validation->set_rules('share_dob','DOB','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			$data = $this->input->post();
			  // print_r($data);
			  //       exit();
			$this->load->model('queries');
			if ($this->queries->update_shareHolder($data,$share_id)) {
				$this->session->set_flashdata('massage','Share Holder Updated successfully');
			}else{
				$this->session->set_flashdata('error','Failed');
			}
			return redirect('admin/shareHolder');
		}
		$this->shareHolder();
	}


	public function delete_share($share_id){
		$this->load->model('queries');
		if($this->queries->remove_shareHolder($share_id));
		$this->session->set_flashdata('massage','Data Deleted successfully');
		return redirect('admin/shareHolder');
	}


	public function employee(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$blanch = $this->queries->get_blanch($comp_id);
		$position = $this->queries->get_position();
		$employee = $this->queries->get_employee($comp_id);
		 //  echo "<pre>";
		 // print_r($employee);
		 // echo "</pre>";
		 //   exit();
		$this->load->view('admin/employee',['blanch'=>$blanch,'position'=>$position,'employee'=>$employee]);
	}

	public function create_employee(){
		$this->form_validation->set_rules('comp_id','company','required');
		$this->form_validation->set_rules('blanch_id','blanch','required');
		$this->form_validation->set_rules('ac_status','Acount status','required');
		$this->form_validation->set_rules('empl_name','Empl name','required');
		$this->form_validation->set_rules('empl_no','phone number','required');
		$this->form_validation->set_rules('empl_email','Email','required');
		$this->form_validation->set_rules('position_id','position','required');
		$this->form_validation->set_rules('salary','salary','required');
		$this->form_validation->set_rules('pays','pays','required');
		$this->form_validation->set_rules('username','username','required');
		$this->form_validation->set_rules('pay_nssf','pay nssf','required');
		$this->form_validation->set_rules('bank_account','bank account','required');
		$this->form_validation->set_rules('account_no','account no','required');
		$this->form_validation->set_rules('password','password','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$data['password'] = sha1($this->input->post('password'));
			  //  echo "<pre>";
			  // print_r($data);
			  // echo "</pre>";
			  //    exit();
			$this->load->model('queries');
			if ($this->queries->insert_employee($data)) {
				 $this->session->set_flashdata('massage','Eployee Registered successfully Password = 1234');
			}else{
				$this->session->set_flashdata('error','Failed');
			}
			return redirect('admin/employee');
		}
		$this->employee();
	}


	public function modify_employee($empl_id){
		$this->form_validation->set_rules('blanch_id','blanch','required');
		$this->form_validation->set_rules('empl_name','Empl name','required');
		$this->form_validation->set_rules('empl_no','phone number','required');
		$this->form_validation->set_rules('empl_email','email','required');
		$this->form_validation->set_rules('position_id','position','required');
		$this->form_validation->set_rules('salary','salary','required');
		$this->form_validation->set_rules('pays','pays','required');
		$this->form_validation->set_rules('username','username','required');
		$this->form_validation->set_rules('pay_nssf','pay nssf','required');
		$this->form_validation->set_rules('bank_account','bank account','required');
		$this->form_validation->set_rules('account_no','account no','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			$data = $this->input->post();
			  //  echo "<pre>";
			  // print_r($data);
			  // echo "</pre>";
			  //    exit();
			$this->load->model('queries');
			if ($this->queries->update_employee($empl_id,$data)) {
				 $this->session->set_flashdata('massage','Eployee updated successfully');
			}else{
				$this->session->set_flashdata('error','Failed');
			}
			return redirect('admin/all_employee');
		}
		$this->employee();
	}

	public function delete_employee($empl_id){
		$this->load->model('queries');
		if($this->queries->remove_employee($empl_id));
		 $this->session->set_flashdata('massage','Data Deleted successfully');
		 return redirect('admin/all_employee');
	}



	public function all_employee(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$all_employee = $this->queries->get_Allemployee($comp_id);
		$blanch = $this->queries->get_blanch($comp_id);
		$position = $this->queries->get_position();
		  //    echo "<pre>";
		  // print_r($data);
		  //  echo "</pre>";
		  //      exit();
		$this->load->view('admin/all_employee',['all_employee'=>$all_employee,'blanch'=>$blanch,'position'=>$position]);
	}




	public function block_employee($empl_id){
	$this->load->model('queries');
    $data = $this->queries->get_emplBlock($empl_id);
    if ($data->empl_status = 'close') {
    	 // echo "<pre>";
      //   print_r($data);
      //     exit();
        $this->queries->block_empl_data($empl_id,$data);
        $this->session->set_flashdata('massage','Employee blocked successfully');
    }
    return redirect('admin/all_employee');
     
	}


	public function block_allEmployee(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$all_employee = $this->queries->get_allEmployee_Block($comp_id);
	if ($all_employee->empl_status = 'close') {
        $this->queries->block_empl_allData($comp_id,$all_employee);
        $this->session->set_flashdata('massage','Employee blocked successfully');
    }
    return redirect('admin/all_employee');
	}

	public function unblock_allEmployee(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$all_employee = $this->queries->get_allEmployee_Block($comp_id);
	if ($all_employee->empl_status = 'open') {
        $this->queries->block_empl_allData($comp_id,$all_employee);
        $this->session->set_flashdata('massage','Employee Un-blocked successfully');
    }
    return redirect('admin/all_employee');	
	}



	public function Unblock_employee($empl_id){
	$this->load->model('queries');
    $data = $this->queries->get_emplBlock($empl_id);
    if ($data->empl_status = 'open') {
    	 // echo "<pre>";
      //   print_r($data);
      //     exit();
        $this->queries->block_empl_data($empl_id,$data);
        $this->session->set_flashdata('massage','Employee Un blocked successfully');
    }
    return redirect('admin/all_employee');
     
	}



  

        
   

	public function view_blanchEmployee(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$blanch = $this->queries->get_blanch($comp_id);
		$position = $this->queries->get_position();
		 // print_r($blanch);
		 //     exit();
		$this->load->view('admin/blanch_employee',['blanch'=>$blanch,'position'=>$position]);
	}

	public function view_allEmployee($blanch_id){
		$this->load->model('queries');
		$all_employee = $this->queries->get_blanchEmployee($blanch_id);
		$position = $this->queries->get_position();
		  // print_r($empl);
		  //       exit();
		$this->load->view('admin/all_employee',['all_employee'=>$all_employee,'position'=>$position]);
	}

	public function leave(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$employee = $this->queries->get_Allemployee($comp_id);
		$blanch = $this->queries->get_blanch($comp_id);
		$leave = $this->queries->get_all_leave($comp_id);
		  //   echo "<pre>";
		  // print_r($leave);
		  // echo "</pre>";
		  //    exit();
		$this->load->view('admin/employe_leave',['employee'=>$employee,'blanch'=>$blanch,'leave'=>$leave]);
	}

	public function create_leave(){
		$this->form_validation->set_rules('comp_id','company','required');
		$this->form_validation->set_rules('empl_id','Employee','required');
		$this->form_validation->set_rules('stat_date','stat date','required');
		$this->form_validation->set_rules('end_date','end date','required');
		$this->form_validation->set_rules('remaks','remaks','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			 $data = $this->input->post();
			  // print_r($data);
			  //     exit();
			 $this->load->model('queries');
			 if ($this->queries->insert_leave($data)) {
			 	  $this->session->set_flashdata('massage','Leave saved successfully');
			 }else{
			 	  $this->session->set_flashdata('error','Failed');

			 }
			 return redirect('admin/leave');
		}
		 $this->leave();
	}

	public function riba(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$riba = $this->queries->get_riba($comp_id);
		$data_riba = $this->queries->get_ribaData($comp_id);
		  // print_r($riba);
		  //         exit();
		$this->load->view('admin/riba',['riba'=>$riba,'data_riba'=>$data_riba]);
	}

	
	public function loan_category(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$loan_category = $this->queries->get_loancategory($comp_id);
		   // print_r($loan_category);
		   //      exit();
		$this->load->view('admin/loan_category',['loan_category'=>$loan_category]);
	}

	public function create_loanCategory(){
		$this->form_validation->set_rules('comp_id','company','required');
		$this->form_validation->set_rules('loan_name','Loan name','required');
		$this->form_validation->set_rules('loan_price','price','required');
		 $this->form_validation->set_rules('loan_perday','loan perday','required');
		$this->form_validation->set_rules('interest_formular','interest formular','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			 $data = $this->input->post();
			   // print_r($data);
			   //    exit();
			 $this->load->model('queries');
			 if ($this->queries->insert_loanCategory($data)) {
			 	 $this->session->set_flashdata('massage','Loan Product saved successfully');
			 }else{
			 $this->session->set_flashdata('error','Failed');
			 }
			 return redirect('admin/loan_category');
		}
		$this->loan_category();
	}

		public function update_loanCategory($category_id){
		$this->form_validation->set_rules('loan_name','Loan name','required');
		$this->form_validation->set_rules('loan_price','price','required');
		 $this->form_validation->set_rules('loan_perday','loan perday','required');
		$this->form_validation->set_rules('interest_formular','interest formular','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			 $data = $this->input->post();
			   // print_r($data);
			   //    exit();
			 $this->load->model('queries');
			 if ($this->queries->update_loanCategory($category_id,$data)) {
			 	 $this->session->set_flashdata('massage','Loan category updated successfully');
			 }else{
			 $this->session->set_flashdata('error','Failed');
			 }
			 return redirect('admin/loan_category');
		}
		$this->loan_category();
	}


		public function update_loanCategory_loanfee($category_id){
		$this->form_validation->set_rules('loan_name','Loan name','required');
		$this->form_validation->set_rules('loan_price','price','required');
		 $this->form_validation->set_rules('loan_perday','loan perday','required');
		$this->form_validation->set_rules('interest_formular','interest formular','required');
		$this->form_validation->set_rules('fee_category_type','Fee type','required');
		$this->form_validation->set_rules('fee_value','Fee value','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			 $data = $this->input->post();
			 // echo "<pre>";
			 //   print_r($data);
			 //      exit();
			 $this->load->model('queries');
			 if ($this->queries->update_loanCategory($category_id,$data)) {
			 	 $this->session->set_flashdata('massage','Loan category updated successfully');
			 }else{
			 $this->session->set_flashdata('error','Failed');
			 }
			 return redirect('admin/loan_fee');
		}
		$this->loan_fee();
	}





	public function delete_loancategory($category_id){
		$this->load->model('queries');
		if($this->queries->remove_loacategory($category_id));
		$this->session->set_flashdata('massage','Data Deleted successfully');
		 return redirect('admin/loan_category');
	}

	public function customer(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$region = $this->queries->get_region();
		$blanch = $this->queries->get_blanch($comp_id);
		  //  echo "<pre>";
		  // print_r($blanch);
		  // echo "</pre>";
		  //      exit();
		$this->load->view('admin/customer',['region'=>$region,'blanch'=>$blanch]);
	}


	public function create_customer(){
        $this->form_validation->set_rules('comp_id','company','required');
        $this->form_validation->set_rules('blanch_id','blanch','required');
        $this->form_validation->set_rules('f_name','First name','required');
        $this->form_validation->set_rules('m_name','Middle name','required');
        $this->form_validation->set_rules('l_name','Last name','required');
        $this->form_validation->set_rules('gender','gender','required');
        $this->form_validation->set_rules('date_birth','date_birth','required');
        $this->form_validation->set_rules('phone_no','phone number','required');
        $this->form_validation->set_rules('region_id','region','required');
        $this->form_validation->set_rules('district','district','required');
        $this->form_validation->set_rules('ward','ward','required');
        $this->form_validation->set_rules('street','street','required');
        $this->form_validation->set_rules('age','age','required');
        $this->form_validation->set_rules('reg_date','reg_date','required');
        $this->form_validation->set_rules('empl_id','Employee','required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
             $f_name = $data['f_name'];
             $m_name = $data['m_name'];
             $l_name = $data['l_name'];
             $comp_id = $data['comp_id'];
             $blanch_id = $data['blanch_id'];
             $gender = $data['gender'];
             $district = $data['district'];
             $region_id = $data['region_id'];
             $date_birth = $data['date_birth'];
             $ward = $data['ward'];
             $street = $data['street'];
             $age = $data['age'];
             $empl_id = $data['empl_id'];
             $phone = $data['phone_no'];
             $date_reg = $data['reg_date'];
             $phone = '255'.$phone;

              // print_r($phone);
              //     exit();

             $this->load->model('queries');
             $check = $this->queries->check_name($f_name,$m_name,$l_name,$phone);
             if ($check == TRUE) {
             $this->session->set_flashdata('error','This customer Aledy Registered');
              return redirect('admin/customer');
             }elseif($check == FALSE){
              $date = date("Y-m-d");
             $customer_id = $customer_id = $this->insert_customer_detail($comp_id,$blanch_id,$empl_id,$f_name,$m_name,$l_name,$gender,$date_birth,$age,$phone,$region_id,$district,$ward,$street,$date_reg);;
             $number = 'C'.substr($date ,0, 4).substr($date ,5, 2).$customer_id;
             $this->update_customer_number($customer_id,$number);
             $this->insert_sub_customer_data($customer_id);
                //print_r($customer_id);
                 //exit();
             if ($customer_id > 0){
                    $this->session->set_flashdata('massage','');
             }else{
                    $this->session->set_flashdata('error','');
                }
            return redirect('admin/customer_details/'.$customer_id);
             }
                  //      echo "<pre>";
                  // print_r($check);
                          //exit();
             }
             $this->customer_details();
        }


    public function insert_customer_detail($comp_id,$blanch_id,$empl_id,$f_name,$m_name,$l_name,$gender,$date_birth,$age,$phone,$region_id,$district,$ward,$street,$date_reg){
     $this->db->query("INSERT INTO   tbl_customer (`comp_id`,`blanch_id`,`empl_id`,`f_name`,`m_name`,`l_name`,`gender`,`date_birth`,`age`,`phone_no`,`region_id`,`district`,`ward`,`street`,`reg_date`) 
      VALUES ('$comp_id','$blanch_id','$empl_id','$f_name','$m_name','$l_name','$gender','$date_birth','$age','$phone','$region_id','$district','$ward','$street','$date_reg')");
     return $this->db->insert_id();
     }


        public function update_customer_number($customer_id,$number){
        $sqldata="UPDATE `tbl_customer` SET `customer_code`= '$number',`customer_status`='pending' WHERE `customer_id`= '$customer_id'";
       // print_r($sqldata);
        //    exit();
       $query = $this->db->query($sqldata);
        return true;    
        }

        public function insert_sub_customer_data($customer_id){
         $this->db->query("INSERT INTO  tbl_sub_customer (`customer_id`) VALUES ('$customer_id')");
        }



		public function update_customer_info($customer_id){
		$this->form_validation->set_rules('blanch_id','blanch','required');
		$this->form_validation->set_rules('f_name','First name','required');
		$this->form_validation->set_rules('m_name','Middle name','required');
		$this->form_validation->set_rules('l_name','Last name','required');
		$this->form_validation->set_rules('gender','gender','required');
		$this->form_validation->set_rules('date_birth','date_birth','required');
		$this->form_validation->set_rules('phone_no','phone number','required');
		$this->form_validation->set_rules('region_id','region','required');
		$this->form_validation->set_rules('district','district','required');
		$this->form_validation->set_rules('ward','ward','required');
		$this->form_validation->set_rules('street','street','required');
		$this->form_validation->set_rules('empl_id','empl','required');
		$this->form_validation->set_rules('age','age','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			 $data = $this->input->post();
			 // echo "<pre>";
			 // print_r($data);
			 //     exit();
			 $this->load->model('queries');
			 if ($this->queries->update_customer_info($data,$customer_id)) {
			 	$this->session->set_flashdata('massage','Customer Updated Successfully');
			 }else{
			 $this->session->set_flashdata('error','Failed');	
			 }
			 return redirect('admin/customer_profile/'.$customer_id);
			}
            $this->customer_profile();
		}



		public function customer_details($customer_id){
			$this->load->model('queries');
			$customer = $this->queries->get_customer_data($customer_id);
			$account = $this->queries->get_accountTYpe();
			  // print_r($customer);
			  //    exit();
			$this->load->view('admin/detail',['customer'=>$customer,'account'=>$account]);
		}


     public function update_customerID(){
     $folder_Path = 'assets/upload/';

        // print_r($_POST['image']);
        // die();
        
        if(isset($_POST['image']) ){
           $customer_id = $_POST['id'];
           $image = $_POST['image'];
             // $_POST['id'];
            // print_r($customer_id);
            //     die();
             
             $image_parts = explode(";base64,",$_POST['image']);
             $image_type_aux = explode("image/",$image_parts[0]);

             $image_type = $image_type_aux[1];
             $data = $_POST['image'];// base64_decode($image_parts[1]);


            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
             
             $file = $folder_Path .uniqid() .'.png';
            file_put_contents($file, $data);
    
            $this->update_customer_profile($file,$customer_id);
            echo json_encode("Passport uploaded Successfully");
           
        }
    }

    public function update_customer_profile($file,$customer_id){
    $sqldata="UPDATE `tbl_sub_customer` SET `passport`= '$file' WHERE `customer_id`= '$customer_id'";
   $query = $this->db->query($sqldata);
   return true;
   }



		public function create_lastDetail($customer_id){
            //Prepare array of user data
            $data = array(
            'customer_id'=> $this->input->post('customer_id'),
            'famous_area'=> $this->input->post('famous_area'),
            'martial_status'=> $this->input->post('martial_status'),
            'natinal_identity'=> $this->input->post('natinal_identity'),
            'bussiness_type'=> $this->input->post('bussiness_type'),
            'work_status'=> $this->input->post('work_status'),
            'number_dependents'=> $this->input->post('number_dependents'),
            'place_imployment'=> $this->input->post('place_imployment'),
            'month_income'=> $this->input->post('month_income'),
            'code'=> $this->input->post('code'),
            'account_id'=> $this->input->post('account_id'),
            );

            // print_r($data);
            //     exit();
         
            //Pass user data to model
            $customer_code = $data['code'];
            $customer_id = $data['customer_id'];
            $natinal_identity = $data['natinal_identity'];
           $this->load->model('queries');
           $check_nation_id = $this->queries->check_national_Id($natinal_identity);
            if ($check_nation_id == TRUE) {
            $this->session->set_flashdata('error','National Identity Number Aledy Registered');	
            return redirect('admin/customer_details/'.$customer_id);
            }elseif ($check_nation_id == FALSE) {
            $data = $this->queries->insert_customerData($data);
            //Storing insertion status message.
            if($data){
            	$this->update_code($customer_id,$customer_code);
            	$this->update_customer_pendData($customer_id);
            	$this->session->set_flashdata('','');
             }else{
                $this->session->set_flashdata('error','Data failed!!');
            }
            }
            return redirect('admin/view_customer_Id/'.$customer_id);
	     }

	public function view_customer_Id($customer_id){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$data_customer = $this->queries->get_customer_data($customer_id);
		$this->load->view('admin/customer_id',['data_customer'=>$data_customer]);
	}


	// public function update_customerID($customer_id){
    //     if(!empty($_FILES['passport']['name'])){
    //             $config['upload_path'] = 'assets/img/';
    //             $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
    //             $config['file_name'] = $_FILES['passport']['name'];
    //             $config['max_size']      = '8192'; 
    //             $config['remove_spaces']=TRUE;  //it will remove all spaces
    //             $config['encrypt_name']=TRUE;   //it wil encrypte the original file name
    //                 //die($config);
    //             //Load upload library and initialize configuration
    //             $this->load->library('upload',$config);
    //             $this->upload->initialize($config);
                
    //             if($this->upload->do_upload('passport')){
    //                 $uploadData = $this->upload->data();
    //                 $passport = $uploadData['file_name'];
    //             }else{
    //                 $passport = '';
    //             }
    //         }else{
    //             $passport = '';
    //         }
    //         if(!empty($_FILES['signature']['name'])){
    //             $config['upload_path'] = 'assets/img/';
    //             $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
    //             $config['file_name'] = $_FILES['signature']['name'];
    //             $config['max_size']      = '8192'; 
    //             $config['remove_spaces']=TRUE;  //it will remove all spaces
    //             $config['encrypt_name']=TRUE;   //it wil encrypte the original file name
    //                 //die($config);
    //             //Load upload library and initialize configuration
    //             $this->load->library('upload',$config);
    //             $this->upload->initialize($config);
                
    //             if($this->upload->do_upload('signature')){
    //                 $uploadData = $this->upload->data();
    //                 $signature = $uploadData['file_name'];
    //             }else{
    //                 $signature = '';
    //             }
    //         }else{
    //             $signature = '';
    //         }
            
    //         //Prepare array of user data
    //         $data = array(
    //         'customer_id' => $this->input->post('customer_id'),
    //         'code' => $this->input->post('code'),
    //         'signature' => $signature,
    //         'passport' => $passport,
    //         );

    //         $customer_id = $data['customer_id'];
    //         $customer_code = $data['code'];
    //         //   echo "<pre>";
    //         // print_r($customer_id);
    //         //  echo "</pre>";
    //         //   exit();
    //        $this->load->model('queries'); 
    //         //Storing insertion status message.
    //         if($data){
    //             $this->queries->update_customer_profile($data);
    //             $this->update_code($customer_id,$customer_code);
    //             $this->session->set_flashdata('massage','Customer Registration Successfully');
    //            }else{
    //             $this->session->set_flashdata('error','Data failed!!');
    //         }
    //         return redirect('admin/customer_profile/'.$customer_id);

    // }




	 public function update_customer_pendData($customer_id){
      $sqldata="UPDATE `tbl_customer` SET `customer_status`= 'pending' WHERE `customer_id`= '$customer_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;  
    }


			public function customer_profile($customer_id){
				$this->load->model('queries');
				$comp_id =  $this->session->userdata('comp_id');
				$customer_profile = $this->queries->get_customer_profileData($customer_id);

				$blanch = $this->queries->get_blanch($comp_id);
				$sponser = $this->queries->get_guarantors_data($customer_id);
				$loan_customer = $this->queries->get_loan_customer($customer_id);
				   //   echo "<pre>";
				   // print_r($sponser);
				   // echo "</pre>";
				   //             exit();
	           $this->load->view('admin/customer_profile',['customer_profile'=>$customer_profile,'blanch'=>$blanch,'sponser'=>$sponser,'loan_customer'=>$loan_customer]);
}





	   public function update_code($customer_id,$customer_code){
  $sqldata="UPDATE `tbl_customer` SET `customer_code`= '$customer_code',`customer_status`='pending' WHERE `customer_id`= '$customer_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}

public function all_customer(){
	$this->load->model('queries');
    $this->load->library('pagination');
	$comp_id = $this->session->userdata('comp_id');
	//$customer = $this->queries->get_allcutomer($comp_id);
	$data['blanch'] = $this->queries->get_blanch($comp_id);

    $config = array();
       $config["base_url"] = base_url() . "admin/all_customer";
       $config["total_rows"] = $this->queries->record_count($comp_id);
       $config["per_page"] = 10;
       $config["uri_segment"] = 3;
        $config['full_tag_open'] = '<ul class="pagination">';        
    $config['full_tag_close'] = '</ul>';        
    $config['first_link'] = 'First';        
    $config['last_link'] = 'Last';        
    $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';        
    $config['first_tag_close'] = '</span></li>';        
    $config['prev_link'] = '&laquo';        
    $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';        
    $config['prev_tag_close'] = '</span></li>';        
    $config['next_link'] = '&raquo';        
    $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';        
    $config['next_tag_close'] = '</span></li>';        
    $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';        
    $config['last_tag_close'] = '</span></li>';        
    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';        
    $config['cur_tag_close'] = '</a></li>';        
    $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';        
    $config['num_tag_close'] = '</span></li>';
       $this->pagination->initialize($config);
       $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
       $data["customer"] = $this->queries->
           fetch_departments($config["per_page"], $page,$comp_id);
       $data["links"] = $this->pagination->create_links();



	   //  echo"<pre>";
	   // print_r($customer);
	   // echo"</pre>";
	   //      exit();
	$this->load->view('admin/all_customer',$data);
}


public function filter_customer_status(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$blanch = $this->queries->get_blanch($comp_id);

	$blanch_id = $this->input->post('blanch_id');
	$comp_id = $this->input->post('comp_id');
	$customer_status = $this->input->post('customer_status');

   
     if ($blanch_id == 'all') {
    $customer_statusData = $this->queries->get_customer_statusData_comp($comp_id,$customer_status);
       }else{
	$customer_statusData = $this->queries->get_customer_statusData($blanch_id,$comp_id,$customer_status);
	}
	 //  echo "<pre>";
	 // print_r($customer_statusData);
	 //           exit();

	$blanch_customer = $this->queries->get_blanch_data($blanch_id);
	
	$this->load->view('admin/customer_status',['blanch'=>$blanch,'customer_statusData'=>$customer_statusData,'blanch_customer'=>$blanch_customer,'blanch_id'=>$blanch_id,'comp_id'=>$comp_id,'customer_status'=>$customer_status]);
}


public function print_customer_status($blanch_id,$comp_id,$customer_status){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$compdata = $this->queries->get_companyData($comp_id);
	$customer_statusData = $this->queries->get_customer_statusData($blanch_id,$comp_id,$customer_status);
 //         echo "<pre>";
	// print_r($customer_statusData);
	//               exit();
	$blanch_customer = $this->queries->get_blanch_data($blanch_id);
	$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
    $html = $this->load->view('admin/customer_status_report',['compdata'=>$compdata,'customer_statusData'=>$customer_statusData,'blanch_customer'=>$blanch_customer],true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
    $mpdf->WriteHTML($html);
    $mpdf->Output(); 
}




public function print_allCustomer(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$customer = $this->queries->get_allcutomer($comp_id);
	$compdata = $this->queries->get_companyData($comp_id);
	  //      echo "<pre>";
	  // print_r($customer);
	  //          exit();

	$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
    $html = $this->load->view('admin/customer_report_pdf',['compdata'=>$compdata,'customer'=>$customer],true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
    $mpdf->WriteHTML($html);
    $mpdf->Output(); 

}


public function delete_capital($capital_id,$comp_id){
	$this->load->model('queries');
	$old_capital = $this->queries->get_capital_balance($capital_id);
	$amount = $old_capital->amount;
	   // print_r($amount);
	   //           exit();
    $acount = $this->queries->get_remain_company_balance($comp_id);
    $old_comp_balance = $acount->comp_balance;
	$total_remain = $old_comp_balance - $amount;
	if($this->queries->remove_capital($capital_id));
	$this->update_company_balance($comp_id,$total_remain);
	$this->session->set_flashdata('massage','Data Deleted successfully');
	return redirect('admin/capital');
}

public function accountType(){
	$this->load->model('queries');
	$account = $this->queries->get_accountTYpe();
	   // print_r($account);
	   //     exit();
	$this->load->view('admin/account_type',['account'=>$account]);
}

public function create_account(){
	$this->form_validation->set_rules('account_name','Account type','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
	if ($this->form_validation->run()) {
		  $data = $this->input->post();

		     // print_r($data);
		     //     exit();
		  $this->load->model('queries');
		  if ($this->queries->insert_account($data)) {
		  	    $this->session->set_flashdata('massage','Account type saved successfully');
		  }else{
		  	    $this->session->set_flashdata('error','Date Failed');

		  }

		  return redirect('admin/accountType');
	}
	$this->accountType();
}


public function modify_account($account_id){
	$this->form_validation->set_rules('account_name','Account type','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
	if ($this->form_validation->run()) {
		  $data = $this->input->post();

		     // print_r($data);
		     //     exit();
		  $this->load->model('queries');
		  if ($this->queries->update_account($account_id,$data)) {
		  	    $this->session->set_flashdata('massage','Account type Upated successfully');
		  }else{
		  	    $this->session->set_flashdata('error','Date Failed');

		  }

		  return redirect('admin/accountType');
	}
	$this->accountType();
}

public function delete_accountType($account_id){
	$this->load->model('queries');
	if($this->queries->remove_accountType($account_id));
	$this->session->set_flashdata('massage','Data Deleted successfully');
	return redirect('admin/accountType');
}


public function view_more_customer($customer_id){
	$this->load->model('queries');
	$customer_profile = $this->queries->get_customer_profileData($customer_id);
	 $customer = $this->queries->edit_customer($customer_id);
	$this->load->view('admin/view_more_customer',['customer_profile'=>$customer_profile,'customer'=>$customer]);
}


public function upadate_customer($customer_id){
    $this->form_validation->set_rules('phone_no','phone number','required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
    if ($this->form_validation->run()) {
        $data = $this->input->post();
        $data['phone_no'] = $this->input->post('phone_no');
        // print_r($data);
        //     exit();
        $this->load->model('queries');
        if ($this->queries->update_customer($customer_id,$data)) {
            $this->session->set_flashdata('massage','Phone number Updated successfully');
        }else{
      $this->session->set_flashdata('error','Failed');

        }
        return redirect('admin/view_more_customer/'.$customer_id);
    }
    $this->view_more_customer();
}


public function loan_application(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$customer = $this->queries->get_allcustomerData($comp_id);
	  //   echo "<pre>";
	  // print_r($customer);
	  //      exit();
	$this->load->view('admin/loan_application',['customer'=>$customer]);
}


public function search_customer(){
$this->load->model('queries');
$comp_id = $this->session->userdata('comp_id');
$customer_id = $this->input->post('customer_id');
$customer = $this->queries->search_CustomerID($customer_id,$comp_id);
$sponser = $this->queries->get_sponser($customer_id);
$sponsers_data = $this->queries->get_sponserCustomer($customer_id);
$region = $this->queries->get_region();

$data_loan_desc = $this->queries->get_loan_desc_loan($customer_id);
//   echo "<pre>";
// print_r($data_loan_desc);
//  echo "</pre>";
//    exit();
$this->load->view('admin/search_customer',['customer'=>$customer,'sponser'=>$sponser,'sponsers_data'=>$sponsers_data,'region'=>$region,'data_loan_desc'=>$data_loan_desc]);
}


    public function create_sponser($customer_id){
            //Prepare array of user data
            $data = array(
            'sp_name'=> $this->input->post('sp_name'),
            'sp_mname'=> $this->input->post('sp_mname'),
            'customer_id'=> $this->input->post('customer_id'),
            'comp_id'=> $this->input->post('comp_id'),
            'sp_lname'=> $this->input->post('sp_lname'),
            'sp_phone_no'=> $this->input->post('sp_phone_no'),
            'sp_relation'=> $this->input->post('sp_relation'),
            );
            //   echo "<pre>";
            // print_r($data);
            //  echo "</pre>";
            //   exit();

           $this->load->model('queries'); 
           $data = $this->queries->insert_sponser_info($data);
            //Storing insertion status message.
            if($data){
            	$this->session->set_flashdata('massage','Gualantors information Saved successfully');
               }else{
                $this->session->set_flashdata('error','Data failed!!');
            }
        return redirect("admin/edit_viewSponser/".$customer_id);        
    }


    public function modify_sponser($sp_id,$customer_id){
    	$this->form_validation->set_rules('sp_name','Sponser first name','required');
    	$this->form_validation->set_rules('sp_mname','Sponser midle name','required');
    	$this->form_validation->set_rules('sp_lname','Sponser last name','required');
    	$this->form_validation->set_rules('sp_phone_no','Sponser phone number','required');
    	$this->form_validation->set_rules('sp_relation','Sponser relation','required');
    	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
    	if ($this->form_validation->run()) {
    		$data = $this->input->post();
      //         echo "<pre>";
    		// print_r($data);
    		//       exit();
    		$this->load->model('queries');
    		if ($this->queries->update_sponser($sp_id,$data)) {
    			$this->session->set_flashdata('massage','Sponsers information Updated successfully');
    		}else{
    		$this->session->set_flashdata('error','Failed');	
    		}
    		$sponser = $this->queries->get_sponser($customer_id);
    		$customer_id = $sponser->customer_id;
              // print_r($customer_id);
              //     exit();
    		return redirect('admin/edit_viewSponser/'.$customer_id);
    	}
    	$this->edit_viewSponser();
    }


    public function edit_viewSponser($customer_id){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
    	$sponser = $this->queries->get_sponser($customer_id);
        $sponsers_data = $this->queries->get_sponserCustomer($customer_id);
        $customer = $this->queries->get_search_dataCustomer($customer_id);
        $region = $this->queries->get_region();
        $data_loan_desc = $this->queries->get_loan_desc_loan($customer_id);
        //   echo "<pre>";
        // print_r($customer);
        //        exit();
        $this->load->view('admin/sponser_view',['sponser'=>$sponser,'sponsers_data'=>$sponsers_data,'customer'=>$customer,'region'=>$region,'data_loan_desc'=>$data_loan_desc]);

    }



    public function verfication_code($customer_id)
    {
     $this->load->model('queries');
     $this->load->helper('string');
     $comp_id = $this->session->userdata('comp_id');
     $compdata = $this->queries->get_companyData($comp_id);
     $custm_data = $this->queries->get_customer_data($customer_id);
     $data_vefication = $this->queries->get_otp_done($customer_id);
       if ($data_vefication->otp == FALSE) {
       $loan_verfication = 'N-'. random_string('numeric',4);	
       }else{
       $loan_verfication = $data_vefication->otp;	

       }
     
     //$loan_verfication = 'N-'. random_string('numeric',4);
     $this->update_customer_verfication_code($customer_id,$loan_verfication);
     

     $company_name = $compdata->comp_name;
     //$full_name = $custm_data->f_name . ' ' . $custm_data->m_name . ' ' . $custm_data->l_name ;
     $phone = $custm_data->phone_no; 
     $massage = $loan_verfication .' ' .'Msimbo wa Uthibitisho' .' '. $company_name;
     // print_r($massage);
     //         exit(); 
     $this->sendsms($phone,$massage);
     
      
      $this->load->view('admin/loan_verfication',['customer_id'=>$customer_id]);
    }

    public function update_customer_verfication_code($customer_id,$loan_verfication){
    $sqldata="UPDATE `tbl_customer` SET `otp`= '$loan_verfication' WHERE `customer_id`= '$customer_id'";
    $query = $this->db->query($sqldata);
    return true;
    }

    public function verfy_otp_data($customer_id){
    	$this->form_validation->set_rules('otp','otp','required');
    	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
    	if ($this->form_validation->run()) {
    		$this->load->model('queries');
    		$data = $this->input->post();
    		$otp = $data['otp'];
    		$code = $this->queries->get_verfication_code($customer_id);
    		$verf = $code->otp;
    		if ($verf == $otp) {
    		return redirect('admin/loan_applicationForm/'.$customer_id);
    			//echo "successfully";
    		}else{
    	 $this->session->set_flashdata("error",'Incorrect OTP Number');
    	 return redirect('admin/verfication_code/'.$customer_id);
    			//echo "successfully";
    		}

    	}
    }




     public function loan_applicationForm($customer_id){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
    	$customer = $this->queries->get_customer_data($customer_id);
    	$blanch_id = $customer->blanch_id;
    	$loan_category = $this->queries->get_loancategory($comp_id);
    	$group = $this->queries->get_groupData($comp_id);
    	$region = $this->queries->get_region();
    	$blanch = $this->queries->get_blanch($comp_id);
    	$loan_form_request = $this->queries->get_customerDataLOANform($customer_id);
    	$loan_option = $this->queries->get_loan_done($customer_id);
    	$skip_next = $this->queries->get_loanOpen_skip($customer_id);
    	$reject_skip = $this->queries->get_loanOpen_skipReject($customer_id);
    	$formular = $this->queries->get_interestFormular($comp_id);
    	$loan_fee_category = $this->queries->get_loanfee_categoryData($comp_id);
    	$mpl_data_blanch = $this->queries->get_blanchEmployee($blanch_id);

    	    //   echo "<pre>";
    	    // print_r($loan_fee_category);
    	    // echo "</pre>";
    	    //      exit();
    	$this->load->view('admin/loan_aplication_form',['customer'=>$customer,'loan_category'=>$loan_category,'group'=>$group,'region'=>$region,'blanch'=>$blanch,'loan_form_request'=>$loan_form_request,'loan_option'=>$loan_option,'skip_next'=>$skip_next,'reject_skip'=>$reject_skip,'formular'=>$formular,'loan_fee_category'=>$loan_fee_category,'mpl_data_blanch'=>$mpl_data_blanch,'customer_id'=>$customer_id]);
    }

    


    public function group(){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
    	$blanch = $this->queries->get_blanch($comp_id);
    	$group = $this->queries->get_groupData($comp_id);
    	   // print_r($group);
    	   //    exit();
    	$this->load->view('admin/group',['blanch'=>$blanch,'group'=>$group]);
    }


    public function create_group(){
    	$this->load->helper('string');
    	$this->form_validation->set_rules('blanch_id','Blanch name','required');
    	$this->form_validation->set_rules('group_name','group name','required');
    	$this->form_validation->set_rules('comp_id','Company name','required');
    	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
    	if ($this->form_validation->run()) {
    		   $data = $this->input->post();
    		   //$data['code'] = random_string('basic',20);
    		      // print_r($data);
    		      //      exit();
    		   $this->load->model('queries');
    		   if ($this->queries->insert_group($data)) {
    		   	    $this->session->set_flashdata('massage','Customer Group saved successfully');
    		   }else{
    		   	$this->session->set_flashdata('error','Failed');
    		   }

    		   return redirect('admin/group');
    	}

    	$this->group();
    }

    public function modify_group($group_id){
    	$this->load->helper('string');
    	$this->form_validation->set_rules('blanch_id','Blanch name','required');
    	$this->form_validation->set_rules('group_name','group name','required');
    	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
    	if ($this->form_validation->run()) {
    		   $data = $this->input->post();
    		      // print_r($data);
    		      //      exit();
    		   $this->load->model('queries');
    		   if ($this->queries->update_group($group_id,$data)) {
    		   	    $this->session->set_flashdata('massage','Customer Group updated successfully');
    		   }else{
    		   	$this->session->set_flashdata('error','Failed');
    		   }

    		   return redirect('admin/group');
    	}

    	$this->group();
    }


    public function delete_group($group_id){
    	$this->load->model('queries');
    	if($this->queries->remove_group($group_id));
    	$this->session->set_flashdata('massage','Data Deleted successfully');
    	return redirect('admin/group');
    }


    public function create_loanapplication($customer_id){
    	$this->load->helper('string');
        $this->form_validation->set_rules('comp_id','Company','required');
        $this->form_validation->set_rules('blanch_id','Blanch','required');
        $this->form_validation->set_rules('customer_id','Customer','required');
        $this->form_validation->set_rules('category_id','category','required');
        $this->form_validation->set_rules('group_id','group');
        $this->form_validation->set_rules('how_loan','How loan','required');
        $this->form_validation->set_rules('day','day','required');
        $this->form_validation->set_rules('session','session','required');
        $this->form_validation->set_rules('rate','rate','required');
        $this->form_validation->set_rules('reason','reason','required');
        if ($this->form_validation->run()) {
        	  $data = $this->input->post();
        	  // print_r($data);
        	  //           exit();
        	  $data['loan_code'] = random_string('numeric',4);
        	  
        	  $this->load->model('queries');
        	   $category_id = $data['category_id'];
        	   $how_loan = $data['how_loan'];
        	   $cat = $this->queries->get_loancategoryData($category_id);
        	   $loan_price = $cat->loan_price;
        	   $loan_perday = $cat->loan_perday;
        	   $zaidi = $loan_perday;
        	      // print_r($zaidi);
        	      //       exit();
        	   $input = $how_loan;
        	   $output = $loan_price;
                
                if ($input < $output) {
                $this->session->set_flashdata('mass','Amount of Loan Is Less');
                return redirect('admin/loan_applicationForm/'.$customer_id);
                }elseif($input > $zaidi){
                	$this->session->set_flashdata('mass','Amount of Loan Is Greater');
                    return redirect('admin/loan_applicationForm/'.$customer_id);
        	  }else{
        	  $loan_id =  $this->queries->insert_loan($data);
              $this->insert_loan_attachment($loan_id);
               $this->session->set_flashdata('massage','');	
        	  }
        	  return redirect('admin/collelateral_session/'.$loan_id);
           }
    		 
          $this->collelateral_session();
    	}


        public function insert_loan_attachment($loan_id){
         $this->db->query("INSERT INTO tbl_attachment (`loan_id`) VALUES ('$loan_id')");   
        }

    	public function modify_loanapplication($customer_id,$loan_id){
    	$this->load->helper('string');
        $this->form_validation->set_rules('comp_id','Company','required');
        $this->form_validation->set_rules('blanch_id','Blanch','required');
        $this->form_validation->set_rules('customer_id','Customer','required');
        $this->form_validation->set_rules('category_id','category','required');
        $this->form_validation->set_rules('empl_id','Employee','required');
        $this->form_validation->set_rules('how_loan','How loan','required');
        $this->form_validation->set_rules('day','day','required');
        $this->form_validation->set_rules('session','session','required');
        $this->form_validation->set_rules('rate','rate','required');
        $this->form_validation->set_rules('loan_status','loan status','required');
        $this->form_validation->set_rules('reason','reason','required');
        if ($this->form_validation->run()) {
        	  $data = $this->input->post();

        	  // print_r($data);
        	  //    exit();
        	  
        	  //$data['loan_code'] = random_string('numeric',14);
        	  
        	  $this->load->model('queries');
        	   $category_id = $data['category_id'];
        	   $how_loan = $data['how_loan'];
        	   $cat = $this->queries->get_loancategoryData($category_id);
        	   $loan_price = $cat->loan_price;
        	   $loan_perday = $cat->loan_perday;
        	   $zaidi = $loan_perday;
        	      // print_r($zaidi);
        	      //       exit();
        	   $input = $how_loan;
        	   $output = $loan_price;
                
                if ($input < $output) {
                $this->session->set_flashdata('mass','Amount of Loan Is Less');
                return redirect('admin/loan_applicationForm/'.$customer_id);
                }elseif($input > $zaidi){
                	$this->session->set_flashdata('mass','Amount of Loan Is Greater');
                    return redirect('admin/loan_applicationForm/'.$customer_id);
        	  }else{
        	  $this->queries->upadete_loan($data,$loan_id);
               $this->session->set_flashdata('massage','Loan Application Upated successfully');	
        	  }
        	  return redirect('admin/loan_applicationForm/'.$customer_id);
           }
    		 
          $this->loan_applicationForm();
    	}


    	         //update loan + interest in pay table
    public function upadete_loan($loan_id,$total_loan){
  $sqldata="UPDATE `tbl_pay` SET `interest_loan`= '$total_loan' WHERE `pay_id`= '$pay_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}


    public function loan_pending(){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
        $loan_pending = $this->queries->get_loanPending($comp_id);
        $blanch = $this->queries->get_blanch($comp_id);
            //     echo "<pre>";
            // print_r($loan_pending);
            //     echo "<pre>";
            //         exit();
    	$this->load->view('admin/loan_pending',['loan_pending'=>$loan_pending,'blanch'=>$blanch]);
    }


    public function loan_pendingAproveBlanch(){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
    	$blanch_id = $this->input->post('blanch_id');
    	$loan_pending = $this->queries->get_loanPendingBlanch($blanch_id);
    	$blanch = $this->queries->get_blanch($comp_id);
    	$blanch_data = $this->queries->get_blanch_data($blanch_id);
    	   //     echo "<pre>";
    	   // print_r($blanch_data);
    	   //           exit();
    	$this->load->view('admin/loan_pend_aproveBlanch',['loan_pending'=>$loan_pending,'blanch'=>$blanch,'blanch_data'=>$blanch_data]);
    }


    public function view_LoanCustomerData($customer_id,$comp_id){
    	 $this->load->model('queries');
    	 $comp_id = $this->session->userdata('comp_id');
    	 $customer_data = $this->queries->get_loanCustomer($customer_id,$comp_id);
    	 $sponser_detail = $this->queries->get_sponser_data($customer_id,$comp_id);
    	 $loan_form = $this->queries->get_loanform($customer_id,$comp_id);
    	 $loan_id = $loan_form->loan_id;
    	 $collateral = $this->queries->get_colateral_data($loan_id);
         $local_oficer = $this->queries->get_loacagovment_data($loan_id);
    	 $group = $this->queries->get_groupLoan_detail($loan_id);
    	 $group_id = $group->group_id;
    	 $member_data = $this->queries->get_groupMember($group_id);
    	   // print_r($member_data);
    	   //     exit();
    	$this->load->view('admin/view_loancustomer_data',['customer_data'=>$customer_data,'sponser_detail'=>$sponser_detail,'loan_form'=>$loan_form,'collateral'=>$collateral,'local_oficer'=>$local_oficer,'group'=>$group,'member_data'=>$member_data]);
    }


        public function view_Dataloan($customer_id,$comp_id){
    	 $this->load->model('queries');
    	 $comp_id = $this->session->userdata('comp_id');
    	 $customer = $this->queries->get_loanData($customer_id,$comp_id);
    	 $sponser_detail = $this->queries->get_sponser_data($customer_id,$comp_id);
    	 $loan_form = $this->queries->get_formloanData($customer_id,$comp_id);
    	 $loan_id = $loan_form->loan_id;
    	 $collateral = $this->queries->get_colateral_data($loan_id);
         $local_oficer = $this->queries->get_loacagovment_data($loan_id);
         $inc_history = $this->queries->get_loanIncomeHistory($customer_id);
 
    	    // echo "<pre>";
    	    // print_r($collateral);
    	    // echo "</pre>";
    	    // exit();
    	$this->load->view('admin/view_loan_customer',['customer'=>$customer,'sponser_detail'=>$sponser_detail,'loan_form'=>$loan_form,'collateral'=>$collateral,'local_oficer'=>$local_oficer,'inc_history'=>$inc_history]);
    }


    public function download_attach($attach_id){
        if(!empty($attach_id)){
            //load download helper
            $this->load->helper('download');
            $this->load->model('queries');
            //get file info from database
            $filedata = $this->queries->data_download(array('attach_id' => $attach_id));
            
            //file path
            $file = 'assets/img/'.$filedata['cont_attachment'];
            
            //download file from directory
            force_download($file, NULL);
        }
    }


    public function loanpending_groups(){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
    	$group = $this->queries->get_groupData($comp_id);
    	  // print_r($group);
    	  //      exit();
    	$this->load->view('admin/loan_grouppending',['group'=>$group]);
    }


    public function  view_customer_group($group_id,$comp_id){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
    	$customer_group = $this->queries->get_customergroupdata($group_id,$comp_id);
    	$loan_pending = $this->queries->get_loanGroup($group_id,$comp_id);
    	$group_data = $this->queries->get_groupDataone($group_id);
		$total_loan_group = $this->queries->get_total_loanGroup($comp_id,$group_id);
		$total_depost_group = $this->queries->get_total_depostGroup($comp_id,$group_id);
    	//     echo "<pre>";
    	//    print_r($total_depost_group);
    	//     echo "</pre>";
    	//         exit();
    	$this->load->view('admin/loan_customer_group',['customer_group'=>$customer_group,'loan_pending'=>$loan_pending,'group_data'=>$group_data,'total_loan_group'=>$total_loan_group,'total_depost_group'=>$total_depost_group,'group_id'=>$group_id,'comp_id'=>$comp_id]);
    }


	public function  print_loangroup($comp_id,$group_id){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
    	$customer_group = $this->queries->get_customergroupdata($group_id,$comp_id);
    	$loan_pending = $this->queries->get_loanGroup($group_id,$comp_id);
    	$group_data = $this->queries->get_groupDataone($group_id);
		$total_loan_group = $this->queries->get_total_loanGroup($comp_id,$group_id);
		$total_depost_group = $this->queries->get_total_depostGroup($comp_id,$group_id);
		$compdata = $this->queries->get_companyData($comp_id);
		// print_r($loan_pending);
		//      exit();
    	
		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
		$html = $this->load->view('admin/print_loan_group',['compdata'=>$compdata,'group_data'=>$group_data,'loan_pending'=>$loan_pending,'total_loan_group'=>$total_loan_group,'total_depost_group'=>$total_depost_group],true);
		$mpdf->SetFooter('Generated By Brainsoft Technology');
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}


    public function parsonal_pending_loan(){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
    	$personal = $this->queries->get_parsonalloan_pending($comp_id);
    	    //  echo "<pre>";
    	    // print_r($personal);
    	    //  echo "</pre>";
    	    //    exit();
    	$this->load->view('admin/personal_pandingloan',['personal'=>$personal]);
    }

    public function aprove_loan($loan_id){
    	$this->load->helper('string');
            //Prepare array of user data
    	$day = date('Y-m-d H:i');
            $data = array(
            'loan_aprove'=> $this->input->post('how_loan'),
            'penat_status'=> $this->input->post('penat_status'),
            'loan_status'=> 'aproved',
            'loan_day' => $day,
            'code' => random_string('numeric',4),
           
            );
            //   echo "<pre>";
            // print_r($data);
            //  echo "</pre>";
            //   exit();
            
            //Pass user data to model
            $this->load->model('queries'); 
            $data = $this->queries->update_status($loan_id,$data);

            $this->disburse($loan_id);
            //  echo "<pre>";
            // print_r($loan_id);
            //  echo "</pre>";
            //   exit();
            //Storing insertion status message.
            if($data){
            	
                $this->session->set_flashdata('massage','Loan Approved successfully');
            }else{
                $this->session->set_flashdata('error','Data failed!!');
            }
            return redirect('admin/loan_pending');
	}


public function get_loan_aproved(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$loan_aproved = $this->queries->get_loanAproved($comp_id);
	   //   echo "<pre>";
	   // print_r($loan_aproved);
	   //   echo "</pre>";
	   //          exit();
	$this->load->view('admin/loan_aproved',['loan_aproved'=>$loan_aproved]);

}




public function loan_fee(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$loan_fee = $this->queries->get_loanfee($comp_id);
	$fee_type = $this->queries->get_loanfee_type($comp_id);
	$fee_data = $this->queries->get_loanfee_typeData($comp_id);
	$fee_category = $this->queries->get_loanfee_category($comp_id);
	$fee_category_data = $this->queries->get_loanfee_categoryData($comp_id);
	$loan_category = $this->queries->get_loancategory($comp_id);
	    // print_r($fee_category_data);
	    //     exit();
	$this->load->view('admin/loan_fee',['loan_fee'=>$loan_fee,'fee_type'=>$fee_type,'fee_data'=>$fee_data,'fee_category'=>$fee_category,'fee_category_data'=>$fee_category_data,'loan_category'=>$loan_category]);
}


public function create_loanfee_category(){
	$this->form_validation->set_rules('comp_id','Company','required');
	$this->form_validation->set_rules('fee_category','Loan Fee category','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

	if ($this->form_validation->run()) {
		 $data = $this->input->post();
		 // print_r($data);
		 //       exit();
		 $this->load->model('queries');
		 if ($this->queries->insert_loanFee_category($data)) {
		 	 $this->session->set_flashdata('massage','Data saved successfully');
		 }else{
		 	$this->session->set_flashdata('error','Failed');
		 }
		 return redirect('admin/loan_fee');
	}
	$this->loan_fee();
}


public function modify_loanfee_category($id){
$this->form_validation->set_rules('fee_category','Loan Fee category','required');
$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

	if ($this->form_validation->run()) {
		 $data = $this->input->post();
		 // print_r($data);
		 //       exit();
		 $this->load->model('queries');
		 if ($this->queries->modify_loanFee_category($data,$id)) {
		 	 $this->session->set_flashdata('massage','Data Updated successfully');
		 }else{
		 	$this->session->set_flashdata('error','Failed');
		 }
		 return redirect('admin/loan_fee');
	}
	$this->loan_fee();	
}


public function create_loanfee_type(){
	$this->form_validation->set_rules('type','Loan Fee type','required');
	$this->form_validation->set_rules('comp_id','company','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

	if ($this->form_validation->run()) {
		$data = $this->input->post();
		// print_r($data);
		//      exit();
		$this->load->model('queries');
		if ($this->queries->insert_loanfee_type($data)) {
			$this->session->set_flashdata("massage",'Loan Fee Type Saved successfully');
		}else{
			$this->session->set_flashdata("error",'Failed');
		}
		return redirect('admin/loan_fee');
	}
	$this->loan_fee();
}


public function modify_loanfee_type($id){
$this->form_validation->set_rules('type','Loan Fee type','required');
$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
	if ($this->form_validation->run()) {
		$data = $this->input->post();
		// print_r($data);
		//      exit();
		$this->load->model('queries');
		if ($this->queries->update_loanfee_type($data,$id)) {
			$this->session->set_flashdata("massage",'Loan Fee Type updated successfully');
		}else{
			$this->session->set_flashdata("error",'Failed');
		}
		return redirect('admin/loan_fee');
	}
	$this->loan_fee();	
}

public function create_loan_fee(){
	$this->form_validation->set_rules('comp_id','company','required');
	$this->form_validation->set_rules('description','description','required');
	$this->form_validation->set_rules('fee_interest','fee interest','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
	if ($this->form_validation->run()) {
		 $data = $this->input->post();
		   // print_r($data);
		   //      exit();
		 $this->load->model('queries');
		 if ($this->queries->insert_loanfee($data)) {
		 	$this->session->set_flashdata('massage','Loan Fee saved successfully');
		 }else{
		 	$this->session->set_flashdata('error','Failed');

		 }
		 return redirect('admin/loan_fee');
	}
	$this->loan_fee();
}

public function modify_loan_fee($fee_id){
	$this->form_validation->set_rules('description','description','required');
	$this->form_validation->set_rules('fee_interest','fee interest','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
	if ($this->form_validation->run()) {
		 $data = $this->input->post();
		   // print_r($data);
		   //      exit();
		 $this->load->model('queries');
		 if ($this->queries->update_loanfee($fee_id,$data)) {
		 	$this->session->set_flashdata('massage','Loan Fee Updated successfully');
		 }else{
		 	$this->session->set_flashdata('error','Failed');

		 }
		 return redirect('admin/loan_fee');
	}
	$this->loan_fee();
}


public function delete_loan_fee($fee_id){
	$this->load->model('queries');
	if($this->queries->remove_loan_fee($fee_id));
	$this->session->set_flashdata('massage','Data Deleted successfully');
	return redirect('admin/loan_fee');
}





public function disburse($loan_id){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$admin_data = $this->queries->get_admin_role($comp_id);
	$loan_fee = $this->queries->get_loanfee($comp_id);
	$loan_data = $this->queries->get_loanDisbarsed($loan_id);
	$loan_data_interst = $this->queries->get_loanInterest($loan_id);
	$loan_fee_sum = $this->queries->get_sumLoanFee($comp_id);
	$total_loan_fee = $loan_fee_sum->total_fee;

      // print_r($admin_data);
      //       exit();
        
	  $loan_id = $loan_data->loan_id;
	  $blanch_id = $loan_data->blanch_id;
	  $comp_id = $loan_data->comp_id;
	  $customer_id = $loan_data->customer_id;
	  $balance = $loan_data->how_loan;
	  $group_id = $loan_data->group_id;
	  $loan_codeID = $loan_data->loan_code;
	  $code = $loan_data->code;
	  $comp_name = $loan_data->comp_name;
	  $phones = $loan_data->phone_no;
	  $day = $loan_data->day;
	  $session = $loan_data->session;

	  //admin data
	  $role = $admin_data->role;
// print_r($balance);
// 	      exit();
      $interest_loan = $loan_data_interst->interest_formular;
	  $interest = $interest_loan;
      $end_date = $day * $session;
      if($loan_data_interst->rate == 'FLAT RATE') {
      // $now = date("Y-m-d");
      // $someDate = DateTime::createFromFormat("Y-m-d",$now);
      // $someDate->add(new DateInterval('P'.$end_date.'D'));
      // $return_data = $someDate->format("Y-m-d");

      // $date1 = $now;
      // $date2 = $return_data;

      // $ts1 = strtotime($date1);
      // $ts2 = strtotime($date2);

      // $year1 = date('Y', $ts1);
      // $year2 = date('Y', $ts2);

      // $month1 = date('m', $ts1);
      // $month2 = date('m', $ts2);

      // $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
      	$day_data = $end_date;
	    $months = floor($day_data / 30);
       
      $loan_interest = $interest /100 * $balance * $months;
      $total_loan = $balance + $loan_interest;

      }elseif($loan_data_interst->rate == 'SIMPLE'){
      $loan_interest = $interest /100 * $balance;
      $total_loan = $balance + $loan_interest;
      }elseif($loan_data_interst->rate == 'REDUCING'){
      	$month = date("m");
        $year = date("Y");
        $d=cal_days_in_month(CAL_GREGORIAN,$month,$year);
       $months = $end_date / $d;
       $interest = $interest_loan / 1200;
       $loan = $balance;
       $amount = $interest * -$loan * pow((1 + $interest), $months) / (1 - pow((1 + $interest), $months));
       $total_loan = $amount * 1 * $months;
       $loan_interest = $total_loan - $loan;
       $res = $amount;
      }

      // print_r($total_loan);
      //      echo "<br>";
      //   print_r($loan_interest);
      //      echo "<br>";
      //    print_r($res);
      //      exit();
      //data inorder to send sms
      $sms_data = $total_loan_fee /100 * $balance;
      $remain_balance = $balance - $sms_data;
        
     
      // $sms = 'Taasisi ya '.$comp_name.' Imeingiza Mkopo Kiasi cha Tsh.'.$remain_balance.' kwenye Acc Yako ' . $loan_codeID .' Namba yasiri ya kutolea mkopo ni '.$code;
      // $massage = $sms;
      // $phone = $phones;

      $loan_fee_type = $this->queries->get_loanfee_type($comp_id);
      $type = $loan_fee_type->type;
      $this->insert_loan_aprovedDisburse($comp_id,$loan_id,$customer_id,$blanch_id,$balance,$role,$group_id);
	  $unchangable_balance = $balance;
        if ($type == 'PERCENTAGE VALUE') {
	  for ($i=0; $i<count($loan_fee); $i++) { 
		$interest = $loan_fee[$i]->fee_interest;
		$fee_description = $loan_fee[$i]->description;
		$fee_number = $loan_fee[$i]->fee_interest;
	  	$withdraw_balance = $unchangable_balance * ($interest / 100);

	  	
	  	$new_balance = $balance - $withdraw_balance;
        $pay_id = $this->insert_loanfee($loan_fee[$i]->fee_id,$loan_fee[$i]->fee_interest,$loan_fee[$i]->description,$loan_fee[$i]->fee_interest,$loan_id,$blanch_id,$comp_id,$customer_id,$new_balance, $withdraw_balance,$group_id);
     //Update Balance in this Loop
        $balance = $new_balance;   
    }
   }elseif ($type == 'MONEY VALUE') {
   	 for ($i=0; $i<count($loan_fee); $i++) { 
		$interest = $loan_fee[$i]->fee_interest;
		$fee_description = $loan_fee[$i]->description;
		$fee_number = $loan_fee[$i]->fee_interest;
	  	$withdraw_balance = $interest;

	  	
	  	$new_balance = $balance - $withdraw_balance;
        $pay_id = $this->insert_loanfee_money($loan_fee[$i]->fee_id,$loan_fee[$i]->fee_interest,$loan_fee[$i]->description,$loan_fee[$i]->fee_interest,$loan_id,$blanch_id,$comp_id,$customer_id,$new_balance, $withdraw_balance,$group_id);

     //Update Balance in this Loop
        $balance = $new_balance;   
    }
   }


           $this->insert_loan_lecord($comp_id,$customer_id,$loan_id,$blanch_id,$total_loan,$loan_interest,$group_id);
           $this->update_loaninterest($pay_id,$total_loan);
           //$this->sendsms($phone,$massage);
           $this->aprove_disbas_status($loan_id);
           
          return redirect('admin/get_loan_aproved');      
	     
         }

         
        public function insert_loan_aprovedDisburse($comp_id,$loan_id,$customer_id,$blanch_id,$balance,$role,$group_id){
      	$day = date("Y-m-d");
      $this->db->query("INSERT INTO tbl_pay (`comp_id`,`loan_id`,`customer_id`,`blanch_id`,`balance`,`depost`,`emply`,`description`,`group_id`,`date_data`) VALUES ('$comp_id','$loan_id', '$customer_id','$blanch_id','$balance','$balance','$role','CASH DEPOST','$group_id','$day')");
      }


     public function insert_loanfee($loan_fee,$interest,$fee_description,$fee_number,$loan_id,$blanch_id,$comp_id,$customer_id,$new_balance, $withdraw_balance,$group_id){
 	$date = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_pay (`fee_id`,`fee_desc`,`fee_percentage`,`loan_id`,`blanch_id`,`comp_id`,`customer_id`,`balance`,`withdrow`,`p_today`,`emply`,`symbol`,`group_id`,`date_data`) VALUES ('$loan_fee','$fee_description','$fee_number','$loan_id','$blanch_id','$comp_id','$customer_id','$new_balance','$withdraw_balance','$date','SYSTEM WITHDRAWAL','%','$group_id','$date')");
   return $this->db->insert_id();
      }

      public function insert_loanfee_money($loan_fee,$interest,$fee_description,$fee_number,$loan_id,$blanch_id,$comp_id,$customer_id,$new_balance, $withdraw_balance,$group_id){
 	$date = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_pay (`fee_id`,`fee_desc`,`fee_percentage`,`loan_id`,`blanch_id`,`comp_id`,`customer_id`,`balance`,`withdrow`,`p_today`,`emply`,`symbol`,`group_id`,`date_data`) VALUES ('$loan_fee','$fee_description','$fee_number','$loan_id','$blanch_id','$comp_id','$customer_id','$new_balance','$withdraw_balance','$date','SYSTEM WITHDRAWAL','Tsh','$group_id','$date')");
   return $this->db->insert_id();
      }



         //update loan + interest in pay table
    public function update_loaninterest($pay_id,$total_loan){
  $sqldata="UPDATE `tbl_pay` SET `interest_loan`= '$total_loan' WHERE `pay_id`= '$pay_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}




      public function insert_loan_lecord($comp_id,$customer_id,$loan_id,$blanch_id,$total_loan,$loan_interest,$group_id){
      	$day = date("Y-m-d");
      $this->db->query("INSERT INTO tbl_prev_lecod (`comp_id`,`customer_id`,`loan_id`,`blanch_id`,`total_loan`,`total_int`,`lecod_day`,`group_id`) VALUES ('$comp_id', '$customer_id','$loan_id','$blanch_id','$total_loan','$loan_interest','$day','$group_id')");
      }




      public function aprove_disbas_status($loan_id){
            //Prepare array of user data
      	$this->load->model('queries');
      	$comp_id = $this->session->userdata('comp_id');
      	$loan_data = $this->queries->get_loanInterest($loan_id);
      	$loan_fee_sum = $this->queries->get_sumLoanFee($comp_id);
      	$loan_datas = $this->queries->get_loanDisbarsed($loan_id);
	    $total_loan_fee = $loan_fee_sum->total_fee;

	     //sms count function
	      @$smscount = $this->queries->get_smsCountDate($comp_id);
	      $sms_number = @$smscount->sms_number;
	      $sms_id = @$smscount->sms_id;
      	   //echo "<pre>";
      	// print_r($loan_data);
      	//             exit();

      	$interest_loan = $loan_data->interest_formular;
      	$loan_aproved = $loan_data->how_loan;
      	$session_loan = $loan_data->session;
      	$customer_id = $loan_data->customer_id;
      	$day = $loan_data->day;
      	$end_date = $day * $session_loan;

      	
      if ($loan_data->rate == 'FLAT RATE') {
      	$day_data = $end_date;
	    $months = floor($day_data / 30);
           
      $interest = $interest_loan;
      $loan_interest = $interest /100 * $loan_aproved * $months;

      $total_loan = $loan_aproved + $loan_interest; 

      $restoration = ($loan_interest + $loan_aproved) / ($session_loan);
      $res = $restoration;
   }elseif ($loan_data->rate == 'SIMPLE') {
  	  $interest = $interest_loan;
      $loan_interest = $interest /100 * $loan_aproved;
      $total_loan = $loan_aproved + $loan_interest; 
      $restoration = ($loan_interest + $loan_aproved) / ($session_loan);
      $res = $restoration;
   }elseif($loan_data->rate == 'REDUCING'){
   	    $month = date("m");
        $year = date("Y");
        $d = cal_days_in_month(CAL_GREGORIAN,$month,$year);
   	   $months = $end_date / $d;
       $interest = $interest_loan / 1200;
       $loan = $loan_aproved;
       $amount = $interest * -$loan * pow((1 + $interest), $months) / (1 - pow((1 + $interest), $months));
       $total_loan = $amount * 1 * $months;
       $loan_interest = $total_loan - $loan;
       $res = $amount;
   }
      	     // print_r($total_loan);
      	     // echo "<br>";
      	     // print_r($loan_interest);
      	     //     echo "<br>";
      	     //  print_r($res);
      	    //     echo "<br>";
      	    //  print_r($loan_interest);
      	    //      echo "<br>";
      	    //  print_r($total_loan);
      	    //       exit();
    	$day = date('Y-m-d H:i');
    	$day_data = date('Y-m-d H:i');
            $data = array(
            'loan_status'=> 'disbarsed',
            'loan_day' => $day,
            'loan_int' => $total_loan,
            'disburse_day' => $day_data,
            'dis_date' => $day_data,
            'restration' => $res,
            );

      $loan_codeID = $loan_datas->loan_code;
	  $code = $loan_datas->code;
	  $comp_name = $loan_datas->comp_name;
	  $comp_phone = $loan_datas->comp_phone;
	  $phones = $loan_datas->phone_no;
	  $full_name = $loan_datas->f_name;

            //data inorder to send sms
      $sms_data = $total_loan_fee /100 * $loan_aproved;
      $remain_balance = $loan_aproved - $sms_data;
            //   echo "<pre>";
            // print_r($data);
            //  echo "</pre>";
            //   exit();
           //send sms function
         $sms ='Ndugu,'.' '.$full_name .' '.'Tunapenda Kukutaarifu Kuwa Mkopo wako Wa Tsh.'.number_format($loan_aproved) . ' '.'Umepitishwa'. ' '. $comp_name.' '.' Inakujari Mteja';
           $massage = $sms;
           $phone = $phones;
               // print_r($massage);
               //     exit();
            //Pass user data to model
           $this->load->model('queries'); 
            $data = $this->queries->update_status($loan_id,$data);
            
            //Storing insertion status message.
            if($data){
            	
            	$this->sendsms($phone,$massage);
                $this->session->set_flashdata('massage','Loan disbarsed successfully');
            }else{
                $this->session->set_flashdata('error','Data failed!!');
            }

            return redirect('admin/loan_pending');
	}


	


	public function view_report($customer_id){
		$this->load->model('queries');
		$conditions = $this->queries->get_all_dataloan($customer_id);
		   //    echo "<pre>";
		   // print_r($null);
		   //    echo "<pre>";
		   //       exit();
		if ($conditions->fee_id == TRUE) {
     $data = $this->queries->get_loanfeedata($customer_id);
     $null = $this->queries->get_data_notfeeid($customer_id);
     $without = $this->queries->get($customer_id);
		}else{
	 $data = $this->queries->get_loanfeedatanotfee($customer_id);
	 $without = $this->queries->get($customer_id);
	  $null = $this->queries->get_data_notfeeid($customer_id);	
		}
		
		  //  echo "<pre>";
		  // print_r($data);
		  // echo "</pre>";
		  //      exit();
   $this->load->view('admin/report_data',['data'=>$data,'null'=>$null,'without'=>$without]);
	}


	public function disburse_loan(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$disburse = $this->queries->get_DisbarsedLoan($comp_id);
		$total_loanDis = $this->queries->get_sum_loanDisbursed($comp_id);
		$total_interest_loan = $this->queries->get_sum_loanDisburse_interest($comp_id);

		    // echo "<pre>";
		    // print_r($total_interest_loan);
		    // echo "</pre>";
		    //     exit();
		$this->load->view('admin/disburse_loan',['disburse'=>$disburse,'total_loanDis'=>$total_loanDis,'total_interest_loan'=>$total_interest_loan]);
	}

	public function delete_loanDisbursed($loan_id){
		ini_set("max_execution_time", 3600);
		$this->load->model('queries');
		$receive_deducted = $this->queries->get_sum_nonDeducted_fee($loan_id);
		$blanch_id = $receive_deducted->blanch_id;
        @$balance_nonDeducted = $this->queries->get_non_deducted_balance($blanch_id);

         $deductedNon_balance = @$balance_nonDeducted->non_balance;
         $old_receive = $receive_deducted->total_receive;
         $remain_nonBalance = $deductedNon_balance - $old_receive;
             
             // print_r($remain_nonBalance);
             //          exit();

		if($this->queries->remove_loandisbursed($loan_id));
		   $this->remove_nonDeducted_amount($blanch_id,$remain_nonBalance);
           $this->delete_from_tbl_pay($loan_id);
           $this->delete_from_Deposttable($loan_id);
           $this->delete_from_prevlecod($loan_id);
           $this->delete_from_reciveTable($loan_id);
           //$this->delete_storePenart($loan_id);
           $this->delete_storePenart($loan_id);
           $this->delete_payPenartTable($loan_id);
           $this->delete_outstandLoan($loan_id);
           $this->delete_loanPending($loan_id);
           $this->delete_customer_report($loan_id);
           $this->delete_outstand($loan_id);
		$this->session->set_flashdata("massage",'Loan Deleted successfully');
		return redirect('admin/disburse_loan');
	}
	//delete from paytble
	public function delete_from_tbl_pay($loan_id){
		return $this->db->delete('tbl_pay',['loan_id'=>$loan_id]);
	}
	public function delete_from_Deposttable($loan_id){
		return $this->db->delete('tbl_depost',['loan_id'=>$loan_id]);
	}

	public function delete_from_prevlecod($loan_id){
		return $this->db->delete('tbl_prev_lecod',['loan_id'=>$loan_id]);
	}

	public function delete_from_reciveTable($loan_id){
		return $this->db->delete('tbl_receve',['loan_id'=>$loan_id]);
	}

	public function delete_storePenart($loan_id){
		return $this->db->delete('tbl_store_penalt',['loan_id'=>$loan_id]);
	}

	public function delete_payPenartTable($loan_id){
		return $this->db->delete('tbl_pay_penart',['loan_id'=>$loan_id]);
	}

	public function delete_outstandLoan($loan_id){
		return $this->db->delete('tbl_outstand_loan',['loan_id'=>$loan_id]);
	}

	public function delete_loanPending($loan_id){
		return $this->db->delete('tbl_loan_pending',['loan_id'=>$loan_id]);
	}

	public function delete_customer_report($loan_id){
		return $this->db->delete('tbl_customer_report',['loan_id'=>$loan_id]);
	}

	public function delete_outstand($loan_id){
		return $this->db->delete('tbl_outstand',['loan_id'=>$loan_id]);
	}

	public function loan_withdrawal(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
	    $loan_withdrawal = $this->queries->get_loan_withdrawal_today($comp_id);
	    $total_loan_with = $this->queries->get_today_loan_withdrawal_loan($comp_id);
	    $blanch = $this->queries->get_blanch($comp_id);
		    // echo "<pre>";
		    // print_r($total_loan_with);
		    // echo "</pre>";
		    //     exit();
		$this->load->view('admin/loan_withdrawal',['loan_withdrawal'=>$loan_withdrawal,'total_loan_with'=>$total_loan_with,'blanch'=>$blanch]);
	}

	public function filter_loan_withdrawal(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$blanch = $this->queries->get_blanch($comp_id);
		$blanch_id = $this->input->post('blanch_id');
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$loan_status = $this->input->post('loan_status');
		$data = $this->queries->get_previous_loan_with($from,$to,$blanch_id,$loan_status);
  //      echo "<pre>";
		// print_r($data);
		//    exit();

		$blanch_data = $this->queries->get_blanch_data($blanch_id);
		$sum_loan_withdrawal = $this->queries->get_previous_loan_with_total($from,$to,$blanch_id,$loan_status);
		
		$this->load->view('admin/loan_withdrawal_date',['data'=>$data,'blanch'=>$blanch,'from'=>$from,'to'=>$to,'blanch_data'=>$blanch_data,'sum_loan_withdrawal'=>$sum_loan_withdrawal,'blanch_id'=>$blanch_id,'loan_status'=>$loan_status]);
	}


	public function print_loan_withdrawalFilter($from,$to,$blanch_id,$loan_status){
	 $this->load->model('queries');
	 $comp_id = $this->session->userdata('comp_id');
	 $compdata = $this->queries->get_companyData($comp_id);
	 $data = $this->queries->get_previous_loan_with($from,$to,$blanch_id,$loan_status);
	 $blanch_data = $this->queries->get_blanch_data($blanch_id);
	 $sum_loan_withdrawal = $this->queries->get_previous_loan_with_total($from,$to,$blanch_id,$loan_status);
	 $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
     $html = $this->load->view('admin/loan_withdrawal_dateReport',['compdata'=>$compdata,'blanch_data'=>$blanch_data,'data'=>$data,'sum_loan_withdrawal'=>$sum_loan_withdrawal,'from'=>$from,'to'=>$to],true);
     $mpdf->SetFooter('Generated By Brainsoft Technology');
     $mpdf->WriteHTML($html);
     $mpdf->Output();
	}	



	public function print_loan_withdrawal(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$loan_withdrawal = $this->queries->get_withdrawal_Loan($comp_id);
	$compdata = $this->queries->get_companyData($comp_id);
	$total_interest_loan = $this->queries->get_sum_loanwithdrawal_interest($comp_id);

	 $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
     $html = $this->load->view('admin/loan_withdrawal_report',['compdata'=>$compdata,'loan_withdrawal'=>$loan_withdrawal,'total_interest_loan'=>$total_interest_loan],true);
     $mpdf->SetFooter('Generated By Brainsoft Technology');
     $mpdf->WriteHTML($html);
     $mpdf->Output();
	}



//begin not loan fee functin
	public function disburse_lonnottfee($loan_id){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$admin_data = $this->queries->get_admin_role($comp_id);
		$disbursed_data = $this->queries->get_loanDisbarsed($loan_id);
		$loan_data_interst = $this->queries->get_loanInterest($loan_id);
		$int_loan = $loan_data_interst->interest_formular;
		$loan_aproved = $loan_data_interst->loan_aprove;
         $loan_id = $disbursed_data->loan_id;
         $comp_id = $disbursed_data->comp_id;
         $blanch_id = $disbursed_data->blanch_id;
         $customer_id = $disbursed_data->customer_id;
         $balance = $disbursed_data->loan_aprove;
         $group_id = $disbursed_data->group_id;
         $loan_codeID = $disbursed_data->loan_code;
         $session = $disbursed_data->session;
         $day = $disbursed_data->day;
	     $code = $disbursed_data->code;
	     $comp_name = $disbursed_data->comp_name;
	     $phones = $disbursed_data->phone_no;
         $deposit = $balance;
         $remain_balance = $balance;
         $end_date = $day * $session;
        
         $fee_category = $this->queries->get_loanfee_categoryData($comp_id);
         $category_fee = $fee_category->fee_category;
         
         $loan_category = $this->queries->get_loanproduct_fee($loan_id);
         $fee_category_type = $loan_category->fee_category_type;
         $fee_value = $loan_category->fee_value;
         
         if ($fee_category_type == 'MONEY') {
          $symbol = "Tsh";
          $with_fee = $fee_value;
          $cash_aprove = $balance - $fee_value;
         }elseif ($fee_category_type == 'PERCENTAGE') {
         $symbol = "%";
         $with_fee = $balance * ($fee_value / 100);
         $cash_aprove = $balance -  $balance * ($fee_value / 100);
         }



         // print_r($cash_aprove);
         //        exit();

         
      if($loan_data_interst->rate == 'FLAT RATE'){  
      // $now = date("Y-m-d");
      // $someDate = DateTime::createFromFormat("Y-m-d",$now);
      // $someDate->add(new DateInterval('P'.$end_date.'D'));
      // $return_data = $someDate->format("Y-m-d");

      // $date1 = $now;
      // $date2 = $return_data;

      // $ts1 = strtotime($date1);
      // $ts2 = strtotime($date2);

      // $year1 = date('Y', $ts1);
      // $year2 = date('Y', $ts2);

      // $month1 = date('m', $ts1);
      // $month2 = date('m', $ts2);

      // $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
      	$day_data = $end_date;
	    $months = floor($day_data / 30);

      $interest_loan = $loan_data_interst->interest_formular;
	  $interest = $interest_loan;
      $loan_interest = $interest /100 * $deposit * $months;
      $total_loan = $deposit + $loan_interest;

    }elseif ($loan_data_interst->rate == 'SIMPLE') {
  	 $interest_loan = $loan_data_interst->interest_formular;
	  $interest = $interest_loan;
      $loan_interest = $interest /100 * $deposit;
      $total_loan = $deposit + $loan_interest;
    }elseif($loan_data_interst->rate == 'REDUCING'){
      $months = $end_date / 30;
       $interest = $int_loan / 1200;
       $loan = $loan_aproved;
       $amount = $interest * -$loan * pow((1 + $interest), $months) / (1 - pow((1 + $interest), $months));
       $total_loan = $amount * 1 * $months;
       $loan_interest = $total_loan - $loan;
       $res = $amount;	
    }
       
       // print_r($total_loan);
       //    echo "<br>";
       // print_r($loan_interest);
       //    echo "<br>";
       // print_r($res);
       //     exit();
         //admin role
        // if () {
        //     // code...
        // }
      $role = $admin_data->role;
      $fee_description = "Loan Processing Fee";
      $loan_fee = "0";
      if ($category_fee == 'LOAN PRODUCT') {
       echo "hapa nimakato ya kila loan product"; 
       $pay_id = $this->insert_loan_aprovedDisburse($comp_id,$loan_id,$customer_id,$blanch_id,$balance,$role,$group_id);
       $this->insert_loanfee_money_feetype($loan_fee,$fee_description,$fee_value,$loan_id,$blanch_id,$comp_id,$customer_id,$cash_aprove,$group_id,$symbol,$with_fee);
      }elseif($category_fee == 'GENERAL') {
         //echo "hapa nimakato ya loan fee general";
       $pay_id = $this->insert_loan_aprovedDisburse($comp_id,$loan_id,$customer_id,$blanch_id,$balance,$role,$group_id);
      }
      //exit();
	  
	  $this->update_loaninterest($pay_id,$total_loan);
	  $this->insert_loan_lecord($comp_id,$customer_id,$loan_id,$blanch_id,$total_loan,$loan_interest,$group_id);
	  $this->aprove_disbas_statusNotloanfee($loan_id);
		   //$this->aprove_disbas_status($loan_id);
	  return redirect('admin/get_loan_aproved');

	}

	 public function insert_loanfee_money_feetype($loan_fee,$fee_description,$fee_value,$loan_id,$blanch_id,$comp_id,$customer_id,$cash_aprove,$group_id,$symbol,$with_fee){
 	$date = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_pay (`fee_id`,`fee_desc`,`fee_percentage`,`loan_id`,`blanch_id`,`comp_id`,`customer_id`,`balance`,`withdrow`,`p_today`,`emply`,`symbol`,`group_id`,`date_data`) VALUES ('$loan_fee','$fee_description','$fee_value','$loan_id','$blanch_id','$comp_id','$customer_id','$cash_aprove','$with_fee','$date','SYSTEM WITHDRAWAL','$symbol','$group_id','$date')");
   return $this->db->insert_id();
      }




  //loan not loan fee function
	public function aprove_disbas_statusNotloanfee($loan_id){
		    //Prepare array of user data
      	$this->load->model('queries');
      	$comp_id = $this->session->userdata('comp_id');
      	$loan_data = $this->queries->get_loanInterest($loan_id);
      	$loan_fee_sum = $this->queries->get_sumLoanFee($comp_id);
      	$loan_datas = $this->queries->get_loanDisbarsed($loan_id);
	    $total_loan_fee = $loan_fee_sum->total_fee;

	      //sms count function
	      @$smscount = $this->queries->get_smsCountDate($comp_id);
	      $sms_number = @$smscount->sms_number;
	      $sms_id = @$smscount->sms_id;
      	   //echo "<pre>";
      	// print_r($loan_data);
      	//             exit();

      	$interest_loan = $loan_data->interest_formular;
      	$loan_aproved = $loan_data->loan_aprove;
      	$session_loan = $loan_data->session;
      	$day = $loan_data->day;
      	$end_date = $day * $session_loan;
       if($loan_data->rate == 'FLAT RATE'){
         // $now = date("Y-m-d");
         // $someDate = DateTime::createFromFormat("Y-m-d",$now);
         // $someDate->add(new DateInterval('P'.$end_date.'D'));
         // $return_data = $someDate->format("Y-m-d");

         // $date1 = $now;
         // $date2 = $return_data;

         // $ts1 = strtotime($date1);
         // $ts2 = strtotime($date2);

         // $year1 = date('Y', $ts1);
         // $year2 = date('Y', $ts2);

         // $month1 = date('m', $ts1);
         // $month2 = date('m', $ts2);

         // $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
       	$day_data = $end_date;
	    $months = floor($day_data / 30);
           
      	 $interest = $interest_loan;
      	 $loan_interest = $interest /100 * $loan_aproved * $months;
      	 $total_loan = $loan_aproved + $loan_interest; 
      	 $restoration = ($loan_interest + $loan_aproved) / ($session_loan);
      	 $res = $restoration;

      	}elseif ($loan_data->rate == 'SIMPLE') {
      	 $interest = $interest_loan;
      	 $loan_interest = $interest /100 * $loan_aproved;
      	 $total_loan = $loan_aproved + $loan_interest; 
      	 $restoration = ($loan_interest + $loan_aproved) / ($session_loan);
      	 $res = $restoration;	
      	}elseif($loan_data->rate == 'REDUCING'){
      	$months = $end_date / 30;
        $interest = $interest_loan / 1200;
        $loan = $loan_aproved;
        $amount = $interest * -$loan * pow((1 + $interest), $months) / (1 - pow((1 + $interest), $months));
        $total_loan = $amount * 1 * $months;
        $res = $amount;	
      	}

      	 // print_r($total_loan);
      	 //   echo "<br>";
      	 // print_r($res); 
      	 //      exit();
    	$day = date('Y-m-d H:i');
    	$day_data = date('Y-m-d H:i');
            $data = array(
            'loan_status'=> 'disbarsed',
            'loan_day' => $day,
            'loan_int' => $total_loan,
            'disburse_day' => $day_data,
            'dis_date' => $day_data,
            'restration' => $res,
            );

      $loan_codeID = $loan_datas->loan_code;
	  $code = $loan_datas->code;
	  $comp_name = $loan_datas->comp_name;
	  $comp_phone = $loan_datas->comp_phone;
	  $phones = $loan_datas->phone_no;

           //send sms function
         $sms = $comp_name.' Imeingiza Mkopo Kiasi cha Tsh.'.$loan_aproved.' kwenye Acc Yako ' . $loan_codeID .' Kwa msaada zaidi Piga simu Namba '.$comp_phone;
         $massage = $sms;
         $phone = $phones;
               // print_r($massage);
               //     exit();
            //Pass user data to model
           $this->load->model('queries'); 
            $data = $this->queries->update_status($loan_id,$data);
            
            //Storing insertion status message.
            if($data){
            if (@$smscount->sms_number == TRUE) {
              	$new_sms = 1;
              	$total_sms = @$sms_number + $new_sms;
              	$this->update_count_sms($comp_id,$total_sms,$sms_id);
              }elseif (@$smscount->sms_number == FALSE) {
          	 $sms_number = 1;
             $this->insert_count_sms($comp_id,$sms_number);
             }
            	$this->sendsms($phone,$massage);
                $this->session->set_flashdata('massage','Loan disbarsed successfully');
            }else{
                $this->session->set_flashdata('error','Data failed!!');
            }

            return redirect('admin/get_loan_aproved');
         
    }



	public function insert_loannot_fee($loan_id,$comp_id,$blanch_id,$customer_id,$deposit,$balance){
        $this->db->query("INSERT INTO tbl_pay (`loan_id`,`blanch_id`,`comp_id`,`customer_id`,`balance`,`description`) VALUES ('$loan_id','$blanch_id','$comp_id','$customer_id','$balance','CASH DEPOSIT')");
       return $this->db->insert_id();
     }
//end notloanfee function 




	public function teller_dashboard(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$float = $this->queries->get_today_float($comp_id);
		$depost = $this->queries->get_sumTodayDepost($comp_id);
		$withdraw = $this->queries->get_sumTodayWithdrawal($comp_id);
		$customer = $this->queries->get_allcustomerData($comp_id);
		  // echo "<pre>";
		  // print_r($customer);
		  //   exit();
		$this->load->view('admin/teller_dashboard',['float'=>$float,'depost'=>$depost,'withdraw'=>$withdraw,'customer'=>$customer]);
	}


	public function search_customerData(){
    $this->load->model('queries');
    $comp_id = $this->session->userdata('comp_id');
    $yesterday_balance = $this->queries->get_yesterday_balance_comp($comp_id);
    $today_deposit = $this->queries->get_total_today_deposit_comp($comp_id);
    $loanwith = $this->queries->get_loan_withdrawal_today_company($comp_id);
    $balance_blanch = $this->queries->get_today_cash_balancecompany($comp_id);
     // print_r($balance_blanch);
     //       exit();
    $customery = $this->queries->get_allcustomerDatagroup($comp_id);
    $customer_id = $this->input->post('customer_id');
    $comp_id = $this->input->post('comp_id');
    $customer = $this->queries->search_CustomerLoan($customer_id);
    @$blanch_id = $customer->blanch_id;
    $acount = $this->queries->get_customer_account_verfied($blanch_id);

  

   

    $this->load->view('admin/search_loan_customer',['customer'=>$customer,'customery'=>$customery,'acount'=>$acount,'yesterday_balance'=>$yesterday_balance,'today_deposit'=>$today_deposit,'loanwith'=>$loanwith,'balance_blanch'=>$balance_blanch]);
}


public function data_with_depost($customer_id){
	$this->load->model('queries');
    $comp_id = $this->session->userdata('comp_id');
    $yesterday_balance = $this->queries->get_yesterday_balance_comp($comp_id);
    $today_deposit = $this->queries->get_total_today_deposit_comp($comp_id);
    $loanwith = $this->queries->get_loan_withdrawal_today_company($comp_id);
    $balance_blanch = $this->queries->get_today_cash_balancecompany($comp_id);
     // print_r($balance_blanch);
    $customer = $this->queries->search_CustomerLoan($customer_id);
    $customery = $this->queries->get_allcustomerDatagroup($comp_id);
    $customer_id = $this->input->post('customer_id');
    $comp_id = $this->input->post('comp_id');
    
    @$blanch_id = $customer->blanch_id;
    $acount = $this->queries->get_customer_account_verfied($blanch_id);
	$this->load->view('admin/depost_withdrow',['customer'=>$customer,'customery'=>$customery,'acount'=>$acount,'yesterday_balance'=>$yesterday_balance,'today_deposit'=>$today_deposit,'loanwith'=>$loanwith,'balance_blanch'=>$balance_blanch]);
}


public function create_withdrow_balance($customer_id){
		ini_set("max_execution_time", 3600);
	$this->form_validation->set_rules('customer_id','Customer','required');
	$this->form_validation->set_rules('comp_id','Company','required');
	$this->form_validation->set_rules('blanch_id','blanch','required');
	$this->form_validation->set_rules('loan_id','Loan','required');
	$this->form_validation->set_rules('method','method','required');
	$this->form_validation->set_rules('withdrow','withdrow','required');
	$this->form_validation->set_rules('loan_status','loan status','required');
	$this->form_validation->set_rules('code','Code','required');
	$this->form_validation->set_rules('with_date','with date','required');
	$this->form_validation->set_rules('description','description','required');
	if ($this->form_validation->run() ) {
		  $data = $this->input->post();
          $this->load->model('queries');
		  $withdrow_newbalance = $data['withdrow'];
		  $loan_id = $data['loan_id'];
		  $customer_id = $data['customer_id'];
		  $blanch_id = $data['blanch_id'];
		  $comp_id = $data['comp_id'];
		  $description = $data['description'];
		  $method = $data['method'];
		  $new_code = $data['code'];
		  $with_date = $data['with_date'];
		  $loan_status = 'withdrawal';
		  $new_balance = $withdrow_newbalance;
		  $with_method = $method;
		  $statusLoan = $loan_status;
		  $payment_method = $method;
		  $trans_id = $method;

		  // print_r($withdrow_newbalance);
		  //        exit();
		 
		  $day_loan = $this->queries->get_loan_day($loan_id);
		  $admin_data = $this->queries->get_admin_role($comp_id);
		  $company_data = $this->queries->get_companyData($comp_id);
          $day = $day_loan->day;
          $disburse_day = $day_loan->disburse_day;
          $dis_day = $day_loan->dis_date;
          $session = $day_loan->session;
          $code = $day_loan->code;
          $empl_id = $day_loan->empl_id;
          $loan_aprove = $day_loan->loan_aprove;
          $restoration = $day_loan->restration;
          $loan_codeID = $day_loan->loan_code;
          $group_id = $day_loan->group_id;
          $end_date = $day * $session;
         
        // print_r($loan_aprove);
        //          exit();
         //company loan fee setting
         $comp_fee = $this->queries->get_loanfee_categoryData($comp_id);
         $aina_makato = $comp_fee->fee_category;
          //loanfee setting
         $fee_type = $this->queries->get_loanfee_type($comp_id);
         $type = $fee_type->type;

          
         if ($aina_makato == 'LOAN PRODUCT') {
         $category_loan = $this->queries->get_loanproduct_fee($loan_id);
         $fee_category_type = $category_loan->fee_category_type;
         $fee_value = $category_loan->fee_value;
            if ($fee_category_type == 'MONEY') {
            $sum_fee = $this->queries->get_sumfeepercentage($loan_id);
		    $fee = $sum_fee->total_fee;
		    $sum_total_loanFee = $fee;
            }elseif ($fee_category_type == 'PERCENTAGE') {
            	echo "makato ya percent";
            $sum_fee = $this->queries->get_sumfeepercentage($loan_id);
		    $fee = $sum_fee->total_fee;
		    $sum_total_loanFee = $loan_aprove * $fee / 100;	
            }
               
          }elseif ($aina_makato == 'GENERAL') {
          if ($type == 'PERCENTAGE VALUE') {
          $sum_fee = $this->queries->get_sumfeepercentage($loan_id);
		  $fee = $sum_fee->total_fee;
		  $sum_total_loanFee = $loan_aprove * $fee / 100;
		  }elseif ($type == 'MONEY VALUE') {
		  $sum_fee = $this->queries->get_sumfeepercentage($loan_id);
		  $fee = $sum_fee->total_fee;
		  $sum_total_loanFee = $fee;
		 }

		}
   //       print_r($sum_total_loanFee);
		 // exit();
		

		  //branch Account
		  @$blanch_account = $this->queries->get_amount_remainAmountBlanch($blanch_id,$payment_method);
		  $blanch_capital = @$blanch_account->blanch_capital;
		  $withMoney = ($blanch_capital) - ($new_balance + $sum_total_loanFee);
           
          //admin role
          $role = $admin_data->role;
             
		  $datas_balance = $this->queries->get_remainbalance($customer_id);
		  $customer_data = $this->queries->get_customerData($customer_id);
		  $phones = $customer_data->phone_no;
		  $old_balance = $datas_balance->balance;
		 
		  $balance = $old_balance;
		  $with_balance = $balance - $new_balance; 

		  $up_balance = $this->queries->get_upBalance_Data($customer_id);
		  $balance = $up_balance->balance;
		  $customer_id = $up_balance->customer_id;
		  $input_balance = $withdrow_newbalance;

		  //$today_float = $this->queries->get_today_cash($blanch_id);
          //$float = $today_float->blanch_capital;
          $comp_name = $company_data->comp_name;
          $remain_balance = $balance;
          $today = date("Y-m-d H:i");

          $sms = 'Umepokea ' .' '. 'Tsh.'.number_format($remain_balance).' ' .'Kutoka ' .' '.$comp_name.' '. 'Tarehe '.$today;
          $massage = $sms;
          $phone = $phones;

		//sms counter function
          @$smscount = $this->queries->get_smsCountDate($comp_id);
	      $sms_number = @$smscount->sms_number;
	      $sms_id = @$smscount->sms_id;

	      @$check_deducted = $this->queries->get_deducted_blanch($blanch_id);
	       $deducted = @$check_deducted->deducted;
	       $blanch_deducted = @$check_deducted->blanch_id;
           
           $new_deducted = $deducted + $sum_total_loanFee;
            if($new_code != $code){
		 	 $this->session->set_flashdata('error','Loan Code is Invalid Please Try Again');	
		      }else{
            if($blanch_capital < $withdrow_newbalance) {
		      	$this->session->set_flashdata('error','Branch Account balance Is Not Enough to withdraw');
		      	}elseif($input_balance <= $balance){
		      //$day_loandata = $this->queries->get_loan_day($loan_id);
		      $this->witdrow_balance($loan_id,$comp_id,$blanch_id,$customer_id,$new_balance,$with_balance,$description,$role,$group_id,$method);
		      $this->insert_loan_lecordData($comp_id,$customer_id,$loan_id,$blanch_id,$withdrow_newbalance,$group_id,$trans_id,$restoration,$loan_aprove,$empl_id,$with_date);
		      $this->withdrawal_blanch_capital($blanch_id,$payment_method,$withMoney);
		      $this->insert_deducted_fee($comp_id,$blanch_id,$loan_id,$sum_total_loanFee,$group_id);
               if ($blanch_deducted == TRUE) {
               	$this->update_old_deducted_balance($comp_id,$blanch_id,$new_deducted);
               	//echo "update";
               }else{
               	$this->insert_sum_deducted_fee($comp_id,$blanch_id,$sum_total_loanFee);
               	//echo "ingiza";
               }
	       // print_r($sum_total_loanFee);
	       //            exit();
	          $this->update_withtime($loan_id,$with_method,$statusLoan,$input_balance,$with_date);
	          $this->update_returntime($loan_id,$day,$dis_day,$with_date);
	          $this->insert_startLoan_date($comp_id,$loan_id,$blanch_id,$end_date,$customer_id,$with_date);
              $this->update_customer_status($customer_id);
              if($company_data->sms_status == 'YES'){
              	 $this->sendsms($phone,$massage);
              }elseif ($company_data->sms_status == 'NO'){
              	 //echo "hakuna kitu";
              }
	           $this->session->set_flashdata('massage','withdrow Has made Sucessfully');
		      }else{
		     $this->session->set_flashdata('error','Customer Balance is not Enough to withdraw');
		      }
		      }
         return redirect('admin/data_with_depost/'.$customer_id);
	     }
	  $this->data_with_depost();
     }


     public function insert_loan_lecordData($comp_id,$customer_id,$loan_id,$blanch_id,$withdrow_newbalance,$group_id,$trans_id,$restoration,$loan_aprove,$empl_id,$with_date){
	$day = date("Y-m-d H:i:s");
    $this->db->query("INSERT INTO tbl_prev_lecod (`comp_id`,`customer_id`,`loan_id`,`blanch_id`,`withdraw`,`lecod_day`,`group_id`,`restrations`,`loan_aprov`,`with_trans`,`empl_id`,`time_rec`) VALUES ('$comp_id','$customer_id','$loan_id','$blanch_id','$withdrow_newbalance','$with_date','$group_id','$restoration','$loan_aprove','$trans_id','$empl_id','$day')");
  
}



     //update deducted fee
     public function update_old_deducted_balance($comp_id,$blanch_id,$new_deducted){
      $sqldata="UPDATE `tbl_receive_deducted` SET `deducted`= '$new_deducted' WHERE `blanch_id`= '$blanch_id'";
      $query = $this->db->query($sqldata);
      return true;	
     }

     //insert sumdeducted fee
     public function insert_sum_deducted_fee($comp_id,$blanch_id,$sum_total_loanFee){
      $this->db->query("INSERT INTO tbl_receive_deducted (`comp_id`,`blanch_id`,`deducted`) VALUES ('$comp_id','$blanch_id','$sum_total_loanFee')");	
     }
//insert deducted fee
 public function insert_deducted_fee($comp_id,$blanch_id,$loan_id,$sum_total_loanFee,$group_id){
  $day = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_deducted_fee (`comp_id`,`blanch_id`,`loan_id`,`deducted_balance`,`deducted_date`,`group_id`) VALUES ('$comp_id','$blanch_id','$loan_id','$sum_total_loanFee','$day','$group_id')");	
 }
//withdral blanch Float
public function withdrawal_blanch_capital($blanch_id,$payment_method,$withMoney){
$sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`= '$withMoney' WHERE `blanch_id`= '$blanch_id' AND `receive_trans_id` = '$payment_method'";
    // print_r($sqldata);
    //  echo "<br>";
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}

//update customer status
public function update_customer_status($customer_id){
$sqldata="UPDATE `tbl_customer` SET `customer_status`= 'open' WHERE `customer_id`= '$customer_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}

//update customer status
public function update_customer_statusLoan($customer_id){
$sqldata="UPDATE `tbl_customer` SET `customer_status`= 'close' WHERE `customer_id`= '$customer_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}


//update withdraw time
 public function update_withtime($loan_id,$with_method,$statusLoan,$input_balance,$with_date){
 	$data_day = $with_date;
  $sqldata="UPDATE `tbl_loans` SET `dis_date`= '$data_day',`method`='$with_method',`loan_status`='$statusLoan',`disburse_day`='$data_day',`with_amount`='$input_balance',`region_id`='ok' WHERE `loan_id`= '$loan_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}

//update return date
public function update_returntime($loan_id,$day,$dis_date,$with_date){
$now = $with_date;
$someDate = DateTime::createFromFormat("Y-m-d",$now);
$someDate->add(new DateInterval('P'.$day.'D'));
 //echo $someDate->format("Y-m-d");
       $return_data = $someDate->format("Y-m-d 23:59");
       $rtn = $someDate->format("Y-m-d");
   //       $return = $rtn;
   //print_r($day); 
   //    echo "<br>";
   // print_r($rtn); 
   // echo "<br>";
   //print_r($return_data); 
     //exit();
$sqldata="UPDATE `tbl_loans` SET `dis_date`='$now',`return_date`= '$return_data',`date_show`='$rtn' WHERE `loan_id`= '$loan_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}


//insert start loan and end loan  date
// public function insert_startLoan_date($comp_id,$loan_id,$blanch_id){
// // $now = date("Y-m-d");
// // $someDate = DateTime::createFromFormat("Y-m-d",$now);
// // $someDate->add(new DateInterval('P'.$end_date.'D'));
// //  //echo $someDate->format("Y-m-d");
// //        $return_data = $someDate->format("Y-m-d H:i");
// $this->db->query("INSERT INTO tbl_outstand (`comp_id`,`loan_id`,`blanch_id`) VALUES ('$comp_id','$loan_id','$blanch_id')");
// }

public function insert_startLoan_date($comp_id,$loan_id,$blanch_id,$end_date,$customer_id,$with_date){
$this->load->model('queries');
ini_set("max_execution_time", 3600);
$get_day = $this->queries->get_loan_day($loan_id);
$day = $get_day->day;
$now = $with_date;
$someDate = DateTime::createFromFormat("Y-m-d",$now);
$someDate->add(new DateInterval('P'.$end_date.'D'));
$return_data = $someDate->format("Y-m-d 23:59");

$this->db->query("INSERT INTO tbl_outstand (`comp_id`,`loan_id`,`blanch_id`,`loan_stat_date`,`loan_end_date`) VALUES ('$comp_id','$loan_id','$blanch_id','$now','$return_data')");
//     if ($day == 1) {
//      $begin = new DateTime($now);
//      $end = new DateTime($return_data);
//      //$end = $end->modify( '+1 day' );
     
//      $array = array();
//      $interval = DateInterval::createFromDateString('1 day');
//      $period = new DatePeriod($begin, $interval, $end);
      
//      foreach($period as $dt){
//      $array[] = $dt->format("Y-m-d");   
//      } 
//       $loan_id = $loan_id;
//       $customer_id = $customer_id;
//        for($i=0; $i<count($array);$i++) {
//        	//$loan_id = 1;
//       $this->db->query("INSERT INTO  tbl_test_date (`date`,`loan_id`,`customer_id`) 
//       VALUES ('".$array[$i]."','$loan_id','$customer_id')"); 
//        }
//    $this->update_shedure_status($loan_id);
//     }elseif($day == 7){
// $startTime = strtotime($now);
// $endTime = strtotime($return_data);
// $weeks = array();
// while ($startTime < $endTime) {  
//     $weeks[] = date('Y-m-d', $startTime); 
//     $startTime += strtotime('+1 week', 0);
// }
//       $loan_id = $loan_id;
//       $customer_id = $customer_id;
//        for($i=0; $i<count($weeks);$i++) {
//        	//$loan_id = 1;
//       $this->db->query("INSERT INTO  tbl_test_date (`date`,`loan_id`,`customer_id`) 
//       VALUES ('".$weeks[$i]."','$loan_id','$customer_id')"); 
//      }
//    $this->update_shedure_status($loan_id);
//     }elseif($day == 30){
//     $start = $month = strtotime($now);
//     $end = strtotime($return_data);
//     //$end   =   strtotime("+1 months", $end);
// $months = array();
// while($month < $end){
//      $months[] = date('Y-m-d', $month);
//      $month = strtotime("+1 month", $month);  
//   }
//       $loan_id = $loan_id;
//       $customer_id = $customer_id;
//        for($i=0; $i<count($months);$i++) {
//        	//$loan_id = 1;
//       $this->db->query("INSERT INTO  tbl_test_date (`date`,`loan_id`,`customer_id`) 
//       VALUES ('".$months[$i]."','$loan_id','$customer_id')"); 
//      }
//      $this->update_shedure_status($loan_id);
//     }
//      }

//      public function update_shedure_status($loan_id){
//      $today = date("Y-m-d");
//      $sqldata="UPDATE `tbl_test_date` SET `date_status`= 'withdrawal' WHERE `loan_id`= '$loan_id' AND `date` ='$today'";
//     // print_r($sqldata);
//     //    exit();
//      $query = $this->db->query($sqldata);
//      return true;	
     }









	public function witdrow_balance($loan_id,$comp_id,$blanch_id,$customer_id,$new_balance,$with_balance,$description,$role,$group_id,$method){
		$day = date("Y-m-d");
     $this->db->query("INSERT INTO tbl_pay (`loan_id`,`blanch_id`,`comp_id`,`customer_id`,`withdrow`,`balance`,`description`,`pay_status`,`stat`,`date_pay`,`emply`,`group_id`,`date_data`,`p_method`) VALUES ('$loan_id','$blanch_id','$comp_id','$customer_id','$new_balance','$with_balance','$description','2','1','$day','$role','$group_id','$day','$method')");
      }


    public function deposit_loan($customer_id){
    $this->form_validation->set_rules('customer_id','Customer','required');
	$this->form_validation->set_rules('comp_id','Company','required');
	$this->form_validation->set_rules('blanch_id','blanch','required');
	$this->form_validation->set_rules('loan_id','Loan','required');
	$this->form_validation->set_rules('depost','depost','required');
	$this->form_validation->set_rules('p_method','Method','required');
	$this->form_validation->set_rules('description','description','required');
	$this->form_validation->set_rules('deposit_date','deposit date','required');
	//$this->form_validation->set_rules('day_id','deposit day','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
	   if ($this->form_validation->run()) {
	      $depost = $this->input->post();
	      // print_r($depost);
	      //     exit();
	      $customer_id = $depost['customer_id'];
	      $comp_id = $depost['comp_id'];
	      $blanch_id = $depost['blanch_id'];
	      $p_method = $depost['p_method'];
	      $loan_id = $depost['loan_id'];
	      $deposit_date = $depost['deposit_date'];
	      $depost = filter_var($depost['depost'], FILTER_SANITIZE_NUMBER_INT);
	      $description = 'LOAN RETURN';
          $new_depost = $depost;
          $deposit_date = $deposit_date;
          $payment_method = $p_method;
          $kumaliza = $depost;
          $trans_id = $p_method;
          $new_balance = $depost;

          $today = date("Y-m-d");

           //  echo "<pre>";
           // print_r($today);
           //   exit();

          
	         
	      $this->load->model('queries');
	      $comp_id = $this->session->userdata('comp_id');
	      $company_data = $this->queries->get_companyData($comp_id);
	      $loan_restoration = $this->queries->get_restoration_loan($loan_id);
	      $empl_id = $loan_restoration->empl_id;
	      $date_show = $loan_restoration->date_show;
	      $company = $this->queries->get_comp_data($comp_id);

	      $day_id = $loan_restoration->day;

	      // print_r($day_id);
	      //       exit();
         


	      //sms count function
	      @$smscount = $this->queries->get_smsCountDate($comp_id);
	      $sms_number = @$smscount->sms_number;
	      $sms_id = @$smscount->sms_id;

	      $comp_name = $company->comp_name;
	      $comp_phone = $company->comp_phone;
	      
	      $restoration = $loan_restoration->restration;
	      $group_id = $loan_restoration->group_id;
	      $loan_codeID = $loan_restoration->loan_code;

      
 
	      $data_depost = $this->queries->get_customer_Loandata($customer_id);
	      $customer_data = $this->queries->get_customerData($customer_id);
		  $phones = $customer_data->phone_no;
		  $full_name = $customer_data->f_name;
	      $admin_data = $this->queries->get_admin_role($comp_id);
	      $remain_balance = $data_depost->balance;
	      $old_balance = $remain_balance;
	      $sum_balance = $old_balance + $new_depost;

	      @$blanch_account = $this->queries->get_amount_remainAmountBlanch($blanch_id,$payment_method);
		  $blanch_capital = @$blanch_account->blanch_capital;
		  $depost_money = $blanch_capital + $new_depost;
               
	      //admin role
	      $role = $admin_data->role;
          

	      $out_data = $this->queries->getOutstand_loanData($loan_id);
	      $total_depost_loan = $this->queries->get_total_depost($loan_id);

	           //new code
	      $interest_data = $this->queries->get_interest_loan($loan_id);
	      $int = $new_depost;
	      $day = $interest_data->day;
	      $interest_formular = $interest_data->interest_formular;
	      $session = $interest_data->session;
	      $loan_aprove = $interest_data->loan_aprove;
	      $loan_status = $interest_data->loan_status;
	      $loan_int = $interest_data->loan_int;
          $ses_day = $session;
          $day_int = $int /  $ses_day;
          $day_princ = $int - $day_int;

          //insert principal balance 
          $trans_id = $payment_method;
          $princ_status = $loan_status;
          $principal_balance = $day_princ;
          $interest_balance = $day_int;
           
           
          
          //principal
          $principal_blanch = $this->queries->get_blanch_capitalPrincipal($comp_id,$blanch_id,$trans_id,$princ_status);
          $old_principal_balance = @$principal_blanch->principal_balance;
          $principal_insert = $old_principal_balance + $principal_balance;

           //interest
          $interest_blanch = $this->queries->get_blanch_interest_capital($comp_id,$blanch_id,$trans_id,$princ_status);
          $interest_blanch_balance = @$interest_blanch->capital_interest;
          $interest_insert = $interest_blanch_balance + $day_int;
           //       echo "<pre>";
           // print_r($interest_balance);
           //         exit();

          // $total_depost = $this->queries->get_total_amount_depost_loan($loan_id);
          // print_r($total_depost);
          //           exit();


         $total_depost = $this->queries->get_sum_dapost($loan_id);
         $loan_dep = $total_depost->remain_balance_loan;
         $kumaliza_depost = $loan_dep + $kumaliza;

	     $loan_int = $loan_restoration->loan_int;
	     $remain_loan = $loan_int - $total_depost->remain_balance_loan;

	     $sun_blanch_capital = $this->queries->get_remain_blanch_capital($blanch_id,$trans_id);
	     $total_blanch_amount = $sun_blanch_capital->blanch_capital;
	     $deposit_new = $total_blanch_amount + $depost;
	     // echo "<pre>";
	     // print_r($deposit_new);
	     // echo "<br>";
	     // print_r($depost);
	     //      exit();

	    

	     if ($kumaliza_depost < $loan_int){
	     	//print_r($kumaliza_depost);
              // echo "bado sana";
	       }elseif($kumaliza_depost > $loan_int){
	       	//echo "hapana";
	       }elseif($kumaliza_depost = $loan_int){
           	$this->update_loastatus_done($loan_id);
            $this->insert_loan_kumaliza($comp_id,$blanch_id,$customer_id,$loan_id,$kumaliza,$group_id);
            $this->update_customer_statusclose($customer_id);
           	//echo "tunamaliza kazi";
	      }

	        //exit();

	      @$check_deposit = $this->queries->get_today_deposit_record($loan_id,$deposit_date);
	      $depost_check = @$check_deposit->depost;
	      $dep_id = @$check_deposit->dep_id;
          $again_deposit = $depost_check +  $depost;

	      @$check_prev = $this->queries->get_prev_record_report($loan_id,$deposit_date);
	      $prev_deposit = @$check_prev->depost;
	      $dep_id = @$check_prev->pay_id;
	      $again_prev = $prev_deposit + $depost;

	      @$out_deposit = $this->queries->get_outstand_deposit($blanch_id,$trans_id);
          $out_balance = @$out_deposit->out_balance;

          $new_out_balance = $out_balance + $depost;
	       
            
         $pay_id = $dep_id;

         // print_r($out_data);
         //     exit();
            
	       if ($out_data == TRUE){
	       	if ($depost > $out_data->remain_amount){
	       	$this->session->set_flashdata("error",'Your Depost Amount is Greater');
	       	}else{
	       $remain_amount = $out_data->remain_amount;
	       $paid_amount = $out_data->paid_amount;
	       $customer_id = $out_data->customer_id;
            if($new_balance >= $remain_amount){
           $depost_amount = $remain_amount - $new_balance;
	       $paid_out = $paid_amount + $new_balance;
           
           // print_r($depost_amount);
	          //       exit();
	      //insert depost balance

          if ($check_deposit == TRUE) {
            $this->update_deposit_record($loan_id,$deposit_date,$again_deposit,$p_method,$day_id);
             }else{
             $dep_id = $this->insert_loan_lecorDeposit($comp_id,$customer_id,$loan_id,$blanch_id,$new_depost,$p_method,$role,$day_int,$day_princ,$loan_status,$group_id,$deposit_date,$empl_id,$day_id);
             }
           

           if (@$out_deposit->out_balance == TRUE || @$out_deposit->out_balance == '0' ) {
           $this->update_blanch_amount_outstand($comp_id,$blanch_id,$new_out_balance,$trans_id);   
           }else{
          $this->insert_blanch_amount_outstand_deposit($comp_id,$blanch_id,$new_out_balance,$trans_id);
           }
           $this->update_loan_dep_status($loan_id);

          $new_balance = $new_depost;

	      if ($dep_id > 0) {
	      	 $this->session->set_flashdata('massage',number_format($depost).' Deposit has made Sucessfully');
	      }else{
	      	$this->session->set_flashdata('massage','Deposit has made Sucessfully');
	      } // print_r($day_id);
	      //       exit();
	      $this->update_outstand_status($loan_id);
	     if ($check_prev == TRUE) {
          $dep_id = $dep_id;
          $empl_id = $empl_id;
          $this->update_deposit_record_prev($loan_id,$deposit_date,$again_prev,$dep_id,$p_method);
          }else{
          $dep_id = $dep_id;
          $empl_id = $empl_id;
	     $this->insert_loan_lecordDataDeposit($comp_id,$customer_id,$loan_id,$blanch_id,$new_depost,$dep_id,$group_id,$trans_id,$restoration,$loan_aproved,$deposit_date,$empl_id);
          }
	     $this->insert_remainloan($loan_id,$depost_amount,$paid_out,$pay_id);
	     $this->update_loastatus($loan_id);
	     $this->depost_balance($loan_id,$comp_id,$blanch_id,$customer_id,$new_depost,$sum_balance,$description,$role,$group_id,$p_method,$deposit_date,$dep_id);
	     //$this->depost_Blanch_accountBalance($comp_id,$blanch_id,$payment_method,$depost_money);
	     //$this->insert_blanch_amount_deposit($blanch_id,$deposit_new,$trans_id);
	        if(@$principal_blanch == TRUE){
         $this->update_principal_capital_balanc($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
	     }elseif(@$principal_blanch == FALSE){
	     $this->insert_blanch_principal($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
	     }
          //interest
	     if (@$interest_blanch == TRUE) {
	     $this->update_interest_blanchBalance($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);	
	     }elseif(@$interest_blanch == FALSE){
	     $this->insert_interest_blanch_capital($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);
       }
	      $this->insert_customer_report($loan_id,$comp_id,$blanch_id,$customer_id,$group_id,$new_depost,$pay_id,$deposit_date);
	     //$this->insert_prepaid_balance($loan_id,$comp_id,$blanch_id,$customer_id,$prepaid);
	     $this->update_customer_statusLoan($customer_id);
	     $total_depost = $this->queries->get_sum_dapost($loan_id);
	     $loan_int = $loan_restoration->loan_int;
	     $remain_loan = $loan_int - $total_depost->remain_balance_loan;
	        //sms send
	     $today = date("Y-m-d") ;
	     $date = date("d/m/Y");
          $sms = 'Ndugu, '.$full_name. ' '. $date. ' Umeingiza TZS.' .number_format($new_balance). ' ' . $comp_name.' Mpokeaji '.$role . ' bado unadaiwa kiasi cha TZS.'.$remain_loan;
          $massage = $sms;
          $phone = $phones;



          $loan_ID = $loan_id;
          @$out_check = $this->queries->get_outstand_total($loan_id);
          $amount_remain = @$out_check->remain_amount;
            // print_r($new_balance);
            //       exit();
          if($amount_remain > $new_balance){
          $this->insert_outstand_balance($comp_id,$blanch_id,$customer_id,$loan_id,$new_balance,$group_id,$dep_id);
          }elseif($amount_remain = $new_balance) {
          $this->insert_outstand_balance($comp_id,$blanch_id,$customer_id,$loan_id,$new_balance,$group_id,$dep_id);
          }

          //$phone = '255'.substr($phones, 1,10);
            // print_r($sms);
            //   echo "<br>";
            // print_r($phone);
            //      exit();
          if ($company_data->sms_status == 'YES'){
          	 
             $this->sendsms($phone,$massage);
             //echo "kitu kipo";
          }elseif($company_data->sms_status == 'NO'){
          	 //echo "Hakuna kitu hapa";
          }

            }else{	

            	
	       $depost_amount = $remain_amount - $new_balance;
	       $paid_out = $paid_amount + $new_balance;
	          
	      //insert depost balance
          if ($check_deposit == TRUE) {
            $this->update_deposit_record($loan_id,$deposit_date,$again_deposit,$p_method,$day_id);
             }else{
             $dep_id = $this->insert_loan_lecorDeposit($comp_id,$customer_id,$loan_id,$blanch_id,$new_depost,$p_method,$role,$day_int,$day_princ,$loan_status,$group_id,$deposit_date,$empl_id,$day_id);
             }
          
          if (@$out_deposit->out_balance == TRUE || @$out_deposit->out_balance == '0' ) {
           $this->update_blanch_amount_outstand($comp_id,$blanch_id,$new_out_balance,$trans_id);   
           }else{
          $this->insert_blanch_amount_outstand_deposit($comp_id,$blanch_id,$new_out_balance,$trans_id);
           }
           $this->update_loan_dep_status($loan_id);
          $new_balance = $new_depost;
	      if ($dep_id > 0) {
	      	 $this->session->set_flashdata('massage',number_format($depost).' Deposit has made Sucessfully');
	      }else{
	      	$this->session->set_flashdata('massage','Failed');
	      }
	     if ($check_prev == TRUE) {
          $dep_id = $dep_id;
          $empl_id = $empl_id;
          $this->update_deposit_record_prev($loan_id,$deposit_date,$again_prev,$dep_id,$p_method);
          }else{
          $dep_id = $dep_id;
          $empl_id = $empl_id;
	     $this->insert_loan_lecordDataDeposit($comp_id,$customer_id,$loan_id,$blanch_id,$new_depost,$dep_id,$group_id,$trans_id,$restoration,$loan_aproved,$deposit_date,$empl_id);
          }
	     $this->insert_remainloan($loan_id,$depost_amount,$paid_out,$pay_id);
	     
	     $this->depost_balance($loan_id,$comp_id,$blanch_id,$customer_id,$new_depost,$sum_balance,$description,$role,$group_id,$p_method,$deposit_date,$dep_id);

	     //$this->depost_Blanch_accountBalance($comp_id,$blanch_id,$payment_method,$depost_money);
	     //$this->insert_blanch_amount_deposit($blanch_id,$deposit_new,$trans_id);
	        if (@$principal_blanch == TRUE) {
         $this->update_principal_capital_balanc($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
	     }elseif(@$principal_blanch == FALSE){
	     $this->insert_blanch_principal($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
	     }
          //inrterest
	     if (@$interest_blanch == TRUE) {
	     $this->update_interest_blanchBalance($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);	
	     }elseif(@$interest_blanch == FALSE){
	     $this->insert_interest_blanch_capital($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);
       }
	      $this->insert_customer_report($loan_id,$comp_id,$blanch_id,$customer_id,$group_id,$new_depost,$pay_id,$deposit_date);
	     //$this->insert_prepaid_balance($loan_id,$comp_id,$blanch_id,$customer_id,$prepaid);
	      $total_depost = $this->queries->get_sum_dapost($loan_id);
	     $loan_int = $loan_restoration->loan_int;
	     $remain_loan = $loan_int - $total_depost->remain_balance_loan;
	        //sms send
           $today = date("Y-m-d") ;
         $date = date("d/m/Y");
          $sms = 'Ndugu, '.$full_name. ' '. $date. ' Umeingiza TZS.' .number_format($new_balance). ' ' . $comp_name.' Mpokeaji '.$role . ' bado unadaiwa kiasi cha TZS.'.$remain_loan;
          $massage = $sms;
          $phone = $phones;


           $loan_ID = $loan_id;
          @$out_check = $this->queries->get_outstand_total($loan_id);
          $amount_remain = @$out_check->remain_amount;
              
          if($amount_remain > $new_balance){

         $this->insert_outstand_balance($comp_id,$blanch_id,$customer_id,$loan_id,$new_balance,$group_id,$dep_id);
          // print_r($comp_id);
          //         exit();
          }elseif($amount_remain = $new_balance) {
          $this->insert_outstand_balance($comp_id,$blanch_id,$customer_id,$loan_id,$new_balance,$group_id,$dep_id);
          }
          //$phone = '255'.substr($phones, 1,10);
            // print_r($sms);
            //   echo "<br>";
            // print_r($phone);
            //      exit();
          if ($company_data->sms_status == 'YES'){
          	 
             $this->sendsms($phone,$massage);
             //echo "kitu kipo";
          }elseif($company_data->sms_status == 'NO'){
          	 //echo "Hakuna kitu hapa";
          }
          }
          }



        //ndani ya mkataba
	       }elseif($out_data == FALSE){
	       	if ($kumaliza_depost > $loan_int) {
	       	$this->session->set_flashdata("error",'Your Depost Amount is Greater');	
	       	}else{
	      //insert depost balance

	       	if ($check_deposit == TRUE) {
            $this->update_deposit_record($loan_id,$deposit_date,$again_deposit,$p_method,$day_id);
             }else{
             $dep_id = $this->insert_loan_lecorDeposit($comp_id,$customer_id,$loan_id,$blanch_id,$new_depost,$p_method,$role,$day_int,$day_princ,$loan_status,$group_id,$deposit_date,$empl_id,$day_id);
             }
           

          $this->insert_blanch_amount_deposit($blanch_id,$deposit_new,$trans_id);
          $this->update_loan_dep_status($loan_id);
             //exit();
          
          $new_balance = $new_depost;
	      if ($dep_id > 0) {
	      	 $this->session->set_flashdata('massage',number_format($depost).' Deposit has made Sucessfully');
	      }else{
	      	$this->session->set_flashdata('massage','Deposit has made Sucessfully');
	      }
          
          if ($check_prev == TRUE) {
          $dep_id = $dep_id;
          $empl_id = $empl_id;
          $this->update_deposit_record_prev($loan_id,$deposit_date,$again_prev,$dep_id,$p_method);
          }else{
          $dep_id = $dep_id;
          $empl_id = $empl_id;
	     $this->insert_loan_lecordDataDeposit($comp_id,$customer_id,$loan_id,$blanch_id,$new_depost,$dep_id,$group_id,$trans_id,$restoration,$loan_aproved,$deposit_date,$empl_id);
          }
	     $this->depost_balance($loan_id,$comp_id,$blanch_id,$customer_id,$new_depost,$sum_balance,$description,$role,$group_id,$p_method,$deposit_date,$dep_id);

	     //$this->depost_Blanch_accountBalance($comp_id,$blanch_id,$payment_method,$depost_money);
	     //principal
	     if (@$principal_blanch == TRUE) {
         $this->update_principal_capital_balanc($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
	     }elseif(@$principal_blanch == FALSE){
	     $this->insert_blanch_principal($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
	     }
          //inrterest
	     if (@$interest_blanch == TRUE) {
	     $this->update_interest_blanchBalance($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);	
	     }elseif(@$interest_blanch == FALSE){
	     $this->insert_interest_blanch_capital($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);
       }
	    
	     
          //updating recovery loan
         $loan_ID = $loan_id;
         @$data_pend = $this->queries->get_total_pending_loan($loan_ID);
          $total_pend = @$data_pend->total_pend;

          if (@$data_pend->total_pend == TRUE) {
          	if($depost > $total_pend){
           $deni_lipa = $depost - $total_pend;
           //$recovery = $deni_lipa - $total_pend; 
           $this->update_loan_pending_remain($loan_id);
           $this->insert_description_report($comp_id,$blanch_id,$customer_id,$loan_id,$total_pend,$deni_lipa,$group_id,$dep_id); 
          	}elseif($depost < $total_pend){
           $deni_lipa = $total_pend - $depost;
           $this->update_loan_pending_balance($loan_id,$deni_lipa);
           $this->insert_returnDescriptionData_report($comp_id,$blanch_id,$customer_id,$loan_id,$depost,$group_id,$dep_id);
          }elseif ($depost = $total_pend) {
          $this->update_loan_pending_remain($loan_id);
          $this->insert_returnDescriptionData_report($comp_id,$blanch_id,$customer_id,$loan_id,$depost,$group_id,$dep_id);
          }
          }elseif ($data_pend->total_pend == FALSE) {
          if($date_show >= $today){
          	if ($depost < $restoration) {
          		$prepaid = 0;
          	}else{
           $prepaid = $depost - $restoration;
           }
           $this->insert_prepaid_balance($loan_id,$comp_id,$blanch_id,$customer_id,$prepaid,$dep_id);	
          	}else{
            
          	}
          
          }

         $total_depost = $this->queries->get_sum_dapost($loan_id);
	     $loan_int = $loan_restoration->loan_int;
	     $remain_loan = $loan_int - $total_depost->remain_balance_loan;
	        //sms send
            $today = date("Y-m-d") ;
         $date = date("d/m/Y");
          $sms = 'Ndugu, '.$full_name. ' '. $date. ' Umeingiza TZS.' .number_format($new_balance). ' ' . $comp_name.' Mpokeaji '.$role . ' bado unadaiwa kiasi cha TZS.'.$remain_loan;
          $massage = $sms;
          $phone = $phones;


          //    //sms send
          // $sms = 'Umeingiza Tsh.' .$new_balance. ' kwenye Acc Yako ' . $loan_codeID . $comp_name.' Mpokeaji '.$role . ' Kiasi kilicho baki Kulipwa ni Tsh.'.$remain_loan.' Kwa malalamiko piga '.$comp_phone;
          // $massage = $sms;
          // $phone = $phones;

	     // print_r($deni_lipa);
	     //    exit();
          // $phone = '255'.substr($phones, 1,10);
          //   print_r($sms);
          //     echo "<br>";
          //   print_r($phone);
          //        exit();
          if ($company_data->sms_status == 'YES'){
           
             $this->sendsms($phone,$massage);
             //echo "kitu kipo";
          }elseif($company_data->sms_status == 'NO'){
          	 //echo "Hakuna kitu hapa";
          }
	     }
	     }

	      
	      return redirect('admin/data_with_depost/'.$customer_id);
	         
	   }
	     
	   $this->data_with_depost();

      }


    public function update_loan_dep_status($loan_id){
     $sqldata="UPDATE `tbl_loans` SET `dep_status`= 'close' WHERE `loan_id`= '$loan_id'";
    // print_r($sqldata);
    //    exit();
     $query = $this->db->query($sqldata);
     return true;    
    }  


      public function insert_blanch_amount_deposit($blanch_id,$deposit_new,$trans_id){
      $sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`= '$deposit_new' WHERE `blanch_id`= '$blanch_id' AND `receive_trans_id` ='$trans_id'";
      $query = $this->db->query($sqldata);
      return true;
      }

      public function update_prepaid($loan_id,$total_prepaid){
     $sqldata="UPDATE `tbl_prepaid` SET `prepaid_amount`= '$total_prepaid' WHERE `loan_id`= '$loan_id'";
     $query = $this->db->query($sqldata);
     return true;
      }


    public function update_deposit_record_prev($loan_id,$deposit_date,$again_prev,$dep_id,$p_method){
     $sqldata="UPDATE `tbl_prev_lecod` SET `depost`= '$again_prev',`pay_id`='$dep_id',`trans_id`='$p_method' WHERE `loan_id`= '$loan_id' AND `lecod_day`='$deposit_date'";

     $query = $this->db->query($sqldata);
     return true;
    }


  public function update_deposit_record($loan_id,$deposit_date,$again_deposit,$p_method,$day_id){
    $sqldata="UPDATE `tbl_depost` SET `depost`= '$again_deposit',`depost_method`='$p_method',`day_id`='$day_id' WHERE `loan_id`= '$loan_id' AND `depost_day`='$deposit_date'";
     $query = $this->db->query($sqldata);
     return true;	
  }


   public function insert_outstand_balance($comp_id,$blanch_id,$customer_id,$loan_id,$new_balance,$group_id,$dep_id){

   	 $report_day = date("Y-m-d");
    $this->db->query("INSERT INTO  tbl_pay (`comp_id`,`blanch_id`,`customer_id`,`loan_id`,`withdrow`,`balance`,`description`,`date_data`,`auto_date`,`group_id`,`dep_id`) VALUES ('$comp_id','$blanch_id','$customer_id','$loan_id','$new_balance','0','SYSTEM / DEFAULT LOAN RETURN','$report_day','$report_day','$group_id','$dep_id')");
   }

  public function insert_returnDescriptionData_report($comp_id,$blanch_id,$customer_id,$loan_id,$depost,$group_id,$dep_id){
     $report_day = date("Y-m-d");
    $this->db->query("INSERT INTO  tbl_pay (`comp_id`,`blanch_id`,`customer_id`,`loan_id`,`withdrow`,`balance`,`description`,`date_data`,`auto_date`,`group_id`,`dep_id`) VALUES ('$comp_id','$blanch_id','$customer_id','$loan_id','$depost','0','SYSTEM / PENDING LOAN RETURN','$report_day','$report_day','$group_id','$dep_id')");
   }

     public function update_loan_pending_balance($loan_id,$deni_lipa){
     $sqldata="UPDATE `tbl_pending_total` SET `total_pend`= '$deni_lipa' WHERE `loan_id`= '$loan_id'";
     $query = $this->db->query($sqldata);
     return true;
     }

      public function insert_description_report($comp_id,$blanch_id,$customer_id,$loan_id,$total_pend,$deni_lipa,$group_id,$dep_id){
      $report_day = date("Y-m-d");
    $this->db->query("INSERT INTO  tbl_pay (`comp_id`,`blanch_id`,`customer_id`,`loan_id`,`withdrow`,`balance`,`description`,`date_data`,`auto_date`,`group_id`,`dep_id`) VALUES ('$comp_id','$blanch_id','$customer_id','$loan_id','$total_pend','$deni_lipa','SYSTEM / LOAN PENDING RETURN','$report_day','$report_day','$group_id','$dep_id')");
      }

   //update empty
   public function update_loan_pending_remain($loan_id)
     {
     $sqldata="UPDATE `tbl_pending_total` SET `total_pend`= '0' WHERE `loan_id`= '$loan_id'";
     $query = $this->db->query($sqldata);
     return true;	
     }

       public function insert_blanch_amount_outstand_deposit($comp_id,$blanch_id,$new_out_balance,$trans_id){
        $date = date("Y-m-d");
        $this->db->query("INSERT INTO  tbl_receve_outstand (`comp_id`,`blanch_id`,`trans_id`,`out_balance`,`date`) VALUES ('$comp_id','$blanch_id','$trans_id','$new_out_balance','$date')"); 
      }


                     //update loan status
    public function update_loastatus_done($loan_id){
  $sqldata="UPDATE `tbl_loans` SET `loan_status`= 'done' WHERE `loan_id`= '$loan_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}

  public function insert_loan_kumaliza($comp_id,$blanch_id,$customer_id,$loan_id,$kumaliza,$group_id){
       		$report_day = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_customer_report (`comp_id`,`blanch_id`,`customer_id`,`loan_id`,`recevable_amount`,`pending_amount`,`rep_date`,`group_id`) VALUES ('$comp_id','$blanch_id','$customer_id','$loan_id','$kumaliza','$kumaliza','$report_day','$group_id')");
    }

             //update customer status
public function update_customer_statusclose($customer_id){
$sqldata="UPDATE `tbl_customer` SET `customer_status`= 'close' WHERE `customer_id`= '$customer_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}


  public function update_interest_blanchBalance($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert){
   $sqldata="UPDATE `tbl_blanch_capital_interest` SET `capital_interest`= '$interest_insert' WHERE `blanch_id`= '$blanch_id' AND `trans_id`='$trans_id' AND `int_status`='$princ_status'";
    // print_r($sqldata);
    //    exit();
   $query = $this->db->query($sqldata);
   return true;	
  }    

  public function update_principal_capital_balanc($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert){
  $sqldata="UPDATE `tbl_blanch_capital_principal` SET `principal_balance`= '$principal_insert' WHERE `blanch_id`= '$blanch_id' AND `trans_id`='$trans_id' AND `princ_status`='$princ_status'";
    // print_r($sqldata);
    //    exit();
   $query = $this->db->query($sqldata);
   return true;
  }    

public function insert_interest_blanch_capital($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert){
$this->db->query("INSERT INTO tbl_blanch_capital_interest (`comp_id`,`blanch_id`,`trans_id`,`int_status`,`capital_interest`) VALUES ('$comp_id','$blanch_id','$trans_id','$princ_status','$interest_insert')");	
}
      
public function insert_blanch_principal($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert){
 $this->db->query("INSERT INTO tbl_blanch_capital_principal (`comp_id`,`blanch_id`,`trans_id`,`princ_status`,`principal_balance`) VALUES ('$comp_id','$blanch_id','$trans_id','$princ_status','$principal_insert')");	
}

      //update blanch Balance
   public function depost_Blanch_accountBalance($comp_id,$blanch_id,$payment_method,$depost_money){
      $sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`= '$depost_money' WHERE `blanch_id`= '$blanch_id' AND `receive_trans_id`='$payment_method'";
    // print_r($sqldata);
    //    exit();
     $query = $this->db->query($sqldata);
     return true;
      }


        //insert sms counter
    public function insert_count_sms($comp_id,$sms_number){
    	$date = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_sms_count (`comp_id`,`sms_number`,`date`) VALUES ('$comp_id','$sms_number','$date')");
      }

      //update smscounter
      public function update_count_sms($comp_id,$total_sms,$sms_id){
      $sqldata="UPDATE `tbl_sms_count` SET `sms_number`= '$total_sms' WHERE `comp_id`= '$comp_id' AND `sms_id`='$sms_id'";
    // print_r($sqldata);
    //    exit();
     $query = $this->db->query($sqldata);
     return true;
      }


      //update outstand status
      public function update_outstand_status($loan_id){
     $sqldata="UPDATE `tbl_outstand_loan` SET `out_status`= 'close' WHERE `loan_id`= '$loan_id'";
    // print_r($sqldata);
    //    exit();
     $query = $this->db->query($sqldata);
     return true;
   }

      public function insert_remainloan($loan_id,$depost_amount,$paid_out,$pay_id){
   $sqldata="UPDATE `tbl_outstand_loan` SET `remain_amount`= '$depost_amount',`paid_amount`='$paid_out',`pay_id`='$pay_id' WHERE `loan_id`= '$loan_id'";
  $query = $this->db->query($sqldata);
  return true;
      }

      	public function insert_blanch_amount($blanch_id,$new_depost){
  $sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`= `blanch_capital`+$new_depost WHERE `blanch_id`= '$blanch_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
  return true;
}

    public function insert_comp_balance($comp_id,$new_depost){
  $sqldata="UPDATE `tbl_ac_company` SET `comp_balance`= `comp_balance`+$new_depost WHERE `comp_id`= '$comp_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
  return true;
}

        //insert prepaid balance
    public function insert_prepaid_balance($loan_id,$comp_id,$blanch_id,$customer_id,$prepaid,$dep_id){
    	$date = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_prepaid (`loan_id`,`comp_id`,`blanch_id`,`customer_id`,`prepaid_amount`,`prepaid_date`,`dep_id`) VALUES ('$loan_id','$comp_id','$blanch_id','$customer_id','$prepaid','$date','$dep_id')");
      }



    public function create_adjustment($customer_id){
    $this->form_validation->set_rules('customer_id','Customer','required');
	$this->form_validation->set_rules('comp_id','Company','required');
	$this->form_validation->set_rules('blanch_id','blanch','required');
	$this->form_validation->set_rules('loan_id','Loan','required');
	$this->form_validation->set_rules('withdrow','withdrow','required');
	$this->form_validation->set_rules('description','description','required');
	   if ($this->form_validation->run()) {
	      $depost = $this->input->post();
	      $customer_id = $depost['customer_id'];
	      $comp_id = $depost['comp_id'];
	      $blanch_id = $depost['blanch_id'];
	      $loan_id = $depost['loan_id'];
	      $withdraw = $depost['withdrow'];
	      $description = 'ADJUSTMENT';
          
	      $this->load->model('queries');
	      $data_depost = $this->queries->get_customer_Loandata($customer_id);
	      $blanch_acount_balance = $this->queries->get_blanchAccountremain($blanch_id);
	      $blanch_balance = $blanch_acount_balance->blanch_capital;
	        
	      $loan_id = $data_depost->loan_id;
	      @$group = $this->queries->get_groupLoan_detail($loan_id);
	      $group_id = @$group->group_id;
	        // print_r($group_id);
	        //      exit();
	         
	      $admin_data = $this->queries->get_admin_role($comp_id);
	      $remain_balance = $data_depost->balance;
	      $pay_id = $data_depost->pay_id;
	      $depost = $data_depost->depost;
          $role = $admin_data->role;



	      $old_balance = $remain_balance;
	      $old_depost = $depost;
	      $new_withdrawal = $withdraw;

	      $remain_oldDepost = $old_depost - $new_withdrawal;
	      $remain_oldBalance = $old_balance - $new_withdrawal;
	      $adjust_balance = $blanch_balance - $withdraw;
            
	       @$adjust_outstand = $this->queries->get_payID_outstand_loan($pay_id);
           $remain_amount = @$adjust_outstand->remain_amount;
           $paid_amount = @$adjust_outstand->paid_amount;

           $add_remain = $remain_amount + $new_withdrawal;
           $remove_paidAmount = $paid_amount - $new_withdrawal;

           @$loan_state = $this->queries->get_customerLoanStatement($loan_id);
            $pending_amount = @$loan_state->pending_amount;

            $report = $new_withdrawal - $pending_amount;
           
           $check_depost = $this->queries->get_depost_adjust($loan_id);
           $depost = $check_depost->depost;

           $deposting = $this->queries->get_Desc_depost($loan_id);
           $payment_method  = $deposting->depost_method;

           $blanch_capital_balance = $this->queries->get_amount_remainAmountBlanch($blanch_id,$payment_method);
            $old_blanch_capital = $blanch_capital_balance->blanch_capital;
            $remain_blanch_account = $old_blanch_capital - $withdraw;


           $interest_data = $this->queries->get_interest_loan($loan_id);
           $depost_old = $this->queries->get_depost_record_data($loan_id);
           $olddepost = $depost_old->depost;

	       $int = $olddepost - $withdraw;
	       $day = $interest_data->day;
	       $session = $interest_data->session;
	       $princ_status = $interest_data->loan_status;
           $ses_day = $day * $session;
           $day_int = $int /  $ses_day;
           $day_princ = $int - $day_int;

           $trans_id = $payment_method;


             

             //principal
          $principal_blanch = $this->queries->get_blanch_capitalPrincipal($comp_id,$blanch_id,$trans_id,$princ_status);
          $old_principal_balance = @$principal_blanch->principal_balance;
          $principal_insert = $old_principal_balance - $day_princ;

           //interest
          $interest_blanch = $this->queries->get_blanch_interest_capital($comp_id,$blanch_id,$trans_id,$princ_status);
          $interest_blanch_balance = @$interest_blanch->capital_interest;
          $interest_insert = $interest_blanch_balance - $day_int;
           //       echo "<pre>";
           // print_r($interest_blanch_balance);
           //      echo "<br>";
           // print_r($old_principal_balance);
           //         exit();
            


           if ($withdraw > $depost) {
           	$this->session->set_flashdata('error','Adjustiment Amount is Greater');
           return redirect('admin/data_with_depost/'.$customer_id); 
           }else{
            //echo "kama kawaida";  
	      //admin role
          //$this->remove_kilichozidi($comp_id,$blanch_id,$payment_method,$remain_blanch_account);
          
	      $this->update_udjust_balanceData($pay_id,$remain_oldDepost,$group_id);
	      $this->update_outstandlon_balance($pay_id,$add_remain,$remove_paidAmount);
	              //exit();
	      if ($this->insert_remainBalanceData($loan_id,$comp_id,$blanch_id,$customer_id,$new_withdrawal,$remain_oldBalance,$description,$role,$group_id)) {
	      	 $this->session->set_flashdata('massage','');
	      }else{
	      	$this->session->set_flashdata('massage','Adjustiment has made Sucessfully');
	      }
	      $this->update_loan_lecordDataDeposit($pay_id,$remain_oldDepost);
	      $this->update_loan_Depost($pay_id,$remain_oldDepost,$day_princ,$day_int);
	      $this->update_principal_capital_balanc($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
          $this->update_interest_blanchBalance($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);
	      //$this->update_account_balance($blanch_id,$adjust_balance);
	      //$this->update_accountComp_balance($comp_id,$adjust_balance);
	      $this->update_customer_loanAccount($pay_id,$report);
	      return redirect('admin/data_with_depost/'.$customer_id);  
	   }
	   $this->data_with_depost();
     }
      }

      public function remove_kilichozidi($comp_id,$blanch_id,$payment_method,$remain_blanch_account){
      $sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`= '$remain_blanch_account' WHERE `blanch_id`= '$blanch_id' AND `receive_trans_id` = '$payment_method'";
       $query = $this->db->query($sqldata);
       return true;
      }

      //update customer loan account 
      public function update_customer_loanAccount($pay_id,$report){
     $sqldata="UPDATE `tbl_customer_report` SET `pending_amount`= '$report' WHERE `pay_id`= '$pay_id'";
  $query = $this->db->query($sqldata);
  return true;
      }

      //update outstand loan 
  public function update_outstandlon_balance($pay_id,$add_remain,$remove_paidAmount){
  $sqldata="UPDATE `tbl_outstand_loan` SET `remain_amount`= '$add_remain',`paid_amount`='$remove_paidAmount' WHERE `pay_id`= '$pay_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
  return true;
  }
      //update blanch account Adjustment
       public function update_account_balance($blanch_id,$adjust_balance){
  $sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`= '$adjust_balance' WHERE `blanch_id`= '$blanch_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
  return true;
}

     //update comp account Adjustment
  public function update_accountComp_balance($comp_id,$adjust_balance){
  $sqldata="UPDATE `tbl_ac_company` SET `comp_balance`= '$adjust_balance' WHERE `comp_id`= '$comp_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
  return true;
}



              //update adjustment data
    public function update_udjust_balanceData($pay_id,$remain_oldDepost,$group_id){
    	$date = date("Y-m-d");
  $sqldata="UPDATE `tbl_pay` SET `depost`= '$remain_oldDepost',`group_id`='$group_id',`date_data`='$date' WHERE `pay_id`= '$pay_id'";
  $query = $this->db->query($sqldata);
   return true;
}

public function insert_remainBalanceData($loan_id,$comp_id,$blanch_id,$customer_id,$new_withdrawal,$remain_oldBalance,$description,$role,$group_id){
	$date = date("Y-m-d");
  $this->db->query("INSERT INTO tbl_pay (`loan_id`,`comp_id`,`blanch_id`,`customer_id`,`withdrow`,`balance`,`description`,`emply`,`group_id`,`date_data`) VALUES ('$loan_id','$comp_id','$blanch_id','$customer_id','$new_withdrawal','$remain_oldBalance','ADJUSTMENT','$role','$group_id','$date')");
}

public function update_loan_lecordDataDeposit($pay_id,$remain_oldDepost){
$sqldata="UPDATE `tbl_prev_lecod` SET `depost`= '$remain_oldDepost' WHERE `pay_id`= '$pay_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}

public function update_loan_Depost($pay_id,$remain_oldDepost,$day_princ,$day_int){
$sqldata="UPDATE `tbl_depost` SET `depost`= '$remain_oldDepost',`sche_principal`='$day_princ',`sche_interest`='$day_int' WHERE `pay_id`= '$pay_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}



    public function insert_loan_lecordDataDeposit($comp_id,$customer_id,$loan_id,$blanch_id,$new_depost,$dep_id,$group_id,$trans_id,$restoration,$loan_aproved,$deposit_date,$empl_id){
    	//$day = date("Y-m-d");
    	$time = date("Y-m-d H:i:s");
    	$this->db->query("INSERT INTO tbl_prev_lecod (`comp_id`,`customer_id`,`loan_id`,`blanch_id`,`depost`,`lecod_day`,`pay_id`,`time_rec`,`trans_id`,`restrations`,`loan_aprov`,`empl_id`) VALUES ('$comp_id','$customer_id','$loan_id','$blanch_id','$new_depost','$deposit_date','$dep_id','$time','$trans_id','$restoration','$loan_aproved','$empl_id')");
    }

     public function insert_loan_lecorDeposit($comp_id,$customer_id,$loan_id,$blanch_id,$new_depost,$p_method,$role,$day_int,$day_princ,$loan_status,$group_id,$deposit_date,$empl_id,$day_id){
    	$time = date("Y-m-d H:i:s");
    	$this->db->query("INSERT INTO  tbl_depost (`comp_id`,`customer_id`,`loan_id`,`blanch_id`,`depost`,`depost_day`,`depost_method`,`empl_username`,`sche_principal`,`sche_interest`,`dep_status`,`group_id`,`deposit_day`,`empl_id`,`day_id`) VALUES ('$comp_id','$customer_id','$loan_id','$blanch_id','$new_depost','$deposit_date','$p_method','$role','$day_princ','$day_int','$loan_status','$group_id','$time','$empl_id','$day_id')");
    	return $this->db->insert_id();
    }

   public function depost_balance($loan_id,$comp_id,$blanch_id,$customer_id,$new_depost,$sum_balance,$description,$role,$group_id,$p_method,$deposit_date,$dep_id){
   	$day = date("Y-m-d");
  $this->db->query("INSERT INTO tbl_pay (`loan_id`,`blanch_id`,`comp_id`,`customer_id`,`depost`,`balance`,`description`,`pay_status`,`stat`,`date_pay`,`emply`,`group_id`,`date_data`,`p_method`,`dep_id`) VALUES ('$loan_id','$blanch_id','$comp_id','$customer_id','$new_depost','$sum_balance','CASH DEPOSIT','1','1','$day','$role','$group_id','$deposit_date','$p_method','$dep_id')");
    

      }

      //begin withdrawal function
      public function get_autodata(){
      	$data = $this->db->query("SELECT * FROM tbl_loans WHERE loan_status = 'withdrawal'");
        $all_loans = $data->result();
        foreach ($all_loans as $loan) {
        	  //echo "<br>";
        	  echo $loan->loan_id;
        	    echo "<br>";
        	  //exit();
        $this->withdraw_automatic_loan($loan->loan_id);
        }
      }
      public function withdraw_automatic_loan($loan_id){
      	ini_set("max_execution_time", 3600);
      	$this->load->model('queries');
      	$loan_data = $this->queries->get_loan_LoandataAutomatic($loan_id);
      	// print_r($loan_data);
      	//    exit();
         if(!empty($loan_data)){
      	  $loan_id = $loan_data->loan_id;
      	  $loan_aprove = $loan_data->loan_aprove;
      	  $session = $loan_data->session;
      	  $balance = $loan_data->balance;
      	  $description = $loan_data->description;
      	  $comp_id = $loan_data->comp_id;
      	  $blanch_id = $loan_data->blanch_id;
      	  $customer_id = $loan_data->customer_id;
      	  $group_id = $loan_data->group_id;
      	  $loan_status = $loan_data->loan_status;
      	  $loan_end_date = $loan_data->loan_end_date;
      	    // print_r($loan_end_date);
      	    //      exit();
      	  $day = $loan_data->day;
      	  $disburse_day = $loan_data->disburse_day;
      	  $dis_date = $loan_data->dis_date;
      	  //$rtn_date = $loan_data->rtn_date;
      	  $return_date = $loan_data->return_date;

      	  $old_balance_data = $balance;

      	  $interest_formular = $loan_data->interest_formular;
      	  $day = $loan_data->day;
      	  $interest = $interest_formular /100 * $loan_aprove;
      	  $total_loan_interest = $interest + $loan_aprove;

      	  $totalloan =  $total_loan_interest;

      	  $total_session = $session;
      	  $time_return = $total_session;

      	  $loan_returnday = $totalloan / $time_return;

      	  $loanreturn = $loan_returnday;

      	  $withdraw_ba = $old_balance_data - $loanreturn;
      	  $remain = $withdraw_ba;
      	  $today = date("Y-m-d H:i");
      	  $loans = $this->queries->get_sum_depostLoan($loan_id);
      	  //$out_stand = $this->queries->get_outstand_loan($loan_id);
      	  //$loan_end_date = $out_stand->loan_end_date;
      	  //$outdata = $loan_end_date;
      	    // print_r($outdata);
      	    //          exit();
      	  $depost_data = $loans->depos;
      	      // print_r($depost_data);
      	      //  exit();
      	  //loan penart by samwel
      	   $penart_data = $loan_data->penat_status;
      	   $penart_status = $penart_data;
      	   $action_penart = $loan_data->action_penart;
      	   $action = $action_penart;
      	   $penart_value = $loan_data->penart;
      	   $money_value = $penart_value;
      	   $restoration_loan = $loan_data->restration;
      	   $lejesho = $restoration_loan;
 
      	   //asilimia lejesho
      	   $percent_calc = $money_value / 100 * $lejesho;

           if ($old_balance_data >= $loanreturn) {
      	       $sua = 0;
      	  
      	   }elseif($old_balance_data == 0){
      	   	    $sua = 0;
      	   }elseif($loanreturn >= $old_balance_data) {
      	   	$sua = $loanreturn - $old_balance_data;
                  }
      	    //   echo "<br>";
      	    // //print_r($penart_status);
      	    // //echo "<br>";
      	    // //print_r($action);
      	    // //echo "<br>";
      	    // //print_r($money_value);
      	    // echo "<br>";
      	    // print_r($sua);
      	    //        exit();
                  if($loan_end_date == $today and $loan_status == 'withdrawal'){
                  	  echo "jamaa unazingua";
                   }elseif($depost_data >= $totalloan){
                    $this->update_loastatus($loan_id);
                    // $this->update_customer_status($customer_id);
                       	//echo"tayali";
                     }elseif($return_date == NULL){
                       	//echo "bado sana";
                   }elseif($return_date == $today){
                   if($old_balance_data < $loanreturn and $penart_status == 'YES' and $action == 'MONEY VALUE'){ 
                    	//insert penart money value
                    	//echo "penati ya hela";
                     $this->insert_loanPenart_moneyValue($comp_id,$blanch_id,$customer_id,$loan_id,$money_value);
                       // insert pending loan
                     $this->insert_pending_data($comp_id,$blanch_id,$customer_id,$loan_id,$totalloan,$day,$loanreturn,$old_balance_data);
                     //insert customer report money value
                     $this->insert_loan_pending_report($comp_id,$blanch_id,$customer_id,$loan_id,$loanreturn,$sua,$money_value,$group_id);
                       //echo "anadaiwa";
                   }elseif($old_balance_data < $loanreturn and $penart_status == 'YES' and $action == 'PERCENTAGE VALUE'){
                   //echo "penati ya asilimia";
                   	//insert loanpenart percentage value
                     $this->insert_loanPenart_percentage_Value($comp_id,$blanch_id,$customer_id,$loan_id,$percent_calc);
                   	   //insert pending loan
                     $this->insert_pending_data($comp_id,$blanch_id,$customer_id,$loan_id,$totalloan,$day,$loanreturn,$old_balance_data);
                   	   //update return date
                      //insert customer report percentage value
                     $this->insert_loan_pending_reportPercentage_value($comp_id,$blanch_id,$customer_id,$loan_id,$loanreturn,$sua,$percent_calc,$group_id);
                   	//echo "penati ya asilimia";
                   }elseif($old_balance_data < $loanreturn and $penart_status == 'NO'){
                   	 //echo "hakuna penart";
                   	 //insert loan penart
                    $this->insert_pending_data($comp_id,$blanch_id,$customer_id,$loan_id,$totalloan,$day,$loanreturn,$old_balance_data);
                    //insert customer report no penart 
                    $this->insert_loan_penart_free($comp_id,$blanch_id,$customer_id,$loan_id,$loanreturn,$sua,$group_id);
                   }if($old_balance_data >= $loanreturn){
                   	  //echo "makato yanaendelea";
                    $this->witdrow_balanceAuto($loan_id,$comp_id,$blanch_id,$customer_id,$loanreturn,$remain,$description,$group_id);
                    $this->insert_loan_penartPaid($comp_id,$blanch_id,$customer_id,$loan_id,$loanreturn,$group_id);  
                    }
                     //ilinitesa sana hii update return time
                    $this->update_returntime($loan_id,$day,$dis_date);
                    }
                  }
                 }


           //insert penart in fixed amount by samwel damian
           public function insert_loanPenart_moneyValue($comp_id,$blanch_id,$customer_id,$loan_id,$money_value){
    	   $day_penart = date("Y-m-d H:i");
            $this->db->query("INSERT INTO tbl_store_penalt (`comp_id`,`blanch_id`,`customer_id`,`loan_id`,`total_penart`,`penart_day`) VALUES ('$comp_id','$blanch_id','$customer_id','$loan_id','$money_value','$day_penart')");
            }  

       //insert penart in percentage by samwel damian
     public function insert_loanPenart_percentage_Value($comp_id,$blanch_id,$customer_id,$loan_id,$percent_calc){
    	$day_penart = date("Y-m-d H:i");
      $this->db->query("INSERT INTO tbl_store_penalt (`comp_id`,`blanch_id`,`customer_id`,`loan_id`,`total_penart`,`penart_day`) VALUES ('$comp_id','$blanch_id','$customer_id','$loan_id','$percent_calc','$day_penart')");
       }
      //insert receivable pending penart report yes/money value
       public function insert_loan_pending_report($comp_id,$blanch_id,$customer_id,$loan_id,$loanreturn,$sua,$money_value,$group_id){
       	 $report_day = date("Y-m-d");
         $this->db->query("INSERT INTO tbl_customer_report (`comp_id`,`blanch_id`,`customer_id`,`loan_id`,`recevable_amount`,`pending_amount`,`penart_amount`,`rep_date`,`group_id`) VALUES ('$comp_id','$blanch_id','$customer_id','$loan_id','$loanreturn','$sua','$money_value','$report_day','$group_id')");
       }

         //insert receivable pending penart report yes/percentage value
        public function insert_loan_pending_reportPercentage_value($comp_id,$blanch_id,$customer_id,$loan_id,$loanreturn,$sua,$percent_calc,$group_id){
       	$report_day = date("Y-m-d");
        $this->db->query("INSERT INTO tbl_customer_report (`comp_id`,`blanch_id`,`customer_id`,`loan_id`,`recevable_amount`,`pending_amount`,`penart_amount`,`rep_date`,`group_id`) VALUES ('$comp_id','$blanch_id','$customer_id','$loan_id','$loanreturn','$sua','$percent_calc','$report_day','$group_id')");
        }



       //insert loan free penart
       public function insert_loan_penart_free($comp_id,$blanch_id,$customer_id,$loan_id,$loanreturn,$sua,$group_id){
       		$report_day = date("Y-m-d");
        $this->db->query("INSERT INTO tbl_customer_report (`comp_id`,`blanch_id`,`customer_id`,`loan_id`,`recevable_amount`,`pending_amount`,`rep_date`,`group_id`) VALUES ('$comp_id','$blanch_id','$customer_id','$loan_id','$loanreturn','$sua','$report_day','$group_id')");
       }

            //insert paid not penart
       public function insert_loan_penartPaid($comp_id,$blanch_id,$customer_id,$loan_id,$loanreturn,$group_id){
       		$report_day = date("Y-m-d");
        $this->db->query("INSERT INTO tbl_customer_report (`comp_id`,`blanch_id`,`customer_id`,`loan_id`,`recevable_amount`,`pending_amount`,`rep_date`,`group_id`) VALUES ('$comp_id','$blanch_id','$customer_id','$loan_id','$loanreturn','$loanreturn','$report_day','$group_id')");
       }

  //insert pending report by samwel
       public function insert_pending_data($comp_id,$blanch_id,$customer_id,$loan_id,$totalloan,$day,$loanreturn,$old_balance_data){
    	$day_pend = date("Y-m-d");
        $this->db->query("INSERT INTO tbl_loan_pending (`comp_id`,`blanch_id`,`customer_id`,`loan_id`,`total_loan`,`return_day`,`return_total`,`pend_date`) VALUES ('$comp_id','$blanch_id','$customer_id','$loan_id','$totalloan','$day','$loanreturn'-$old_balance_data,'$day_pend')");
      }


             //insert paid customer report and  penart status  No
     public function insert_loan_customer_report_loanStatusNo($comp_id,$blanch_id,$customer_id,$loan_id,$loanreturn,$sua){
       		$report_day = date("Y-m-d");
         $this->db->query("INSERT INTO tbl_customer_report (`comp_id`,`blanch_id`,`customer_id`,`loan_id`,`recevable_amount`,`pending_amount`,`rep_date`) VALUES ('$comp_id','$blanch_id','$customer_id','$loan_id','$loanreturn','$sua','$report_day')");
       }





          //update loan status
    public function update_loastatus($loan_id){
     $sqldata="UPDATE `tbl_loans` SET `loan_status`= 'done' WHERE `loan_id`= '$loan_id'";
    // print_r($sqldata);
    //    exit();
     $query = $this->db->query($sqldata);
     return true;
   }


  public function witdrow_balanceAuto($loan_id,$comp_id,$blanch_id,$customer_id,$loanreturn,$remain,$description,$group_id){
    	$date = date("Y-m-d");
    	 // print_r($group_id);
    	 //    echo "<br>";
    	 //    print_r($date);
  	   //        exit();
    $this->db->query("INSERT INTO tbl_pay (`loan_id`,`blanch_id`,`comp_id`,`customer_id`,`withdrow`,`balance`,`description`,`auto_date`,`group_id`,`date_data`) VALUES ('$loan_id','$blanch_id','$comp_id','$customer_id','$loanreturn','$remain','SYSTEM/LOAN RETURN','$date','$group_id','$date')");

         // echo "good data";
      }


    //end withdrwal function 

    public function reject_loan($loan_id){
    $this->load->model('queries');
    $data = $this->queries->get_loan_rejectData($loan_id);
    // print_r($data);
    //     exit();
    if ($data->loan_status = 'reject') {
        // print_r($data);
        //   exit();
        $this->queries->update_status($loan_id,$data);
        $this->session->set_flashdata('massage','Loan Rejected successfully');
    }
    return redirect('admin/loan_pending');
 }


 public function delete_loan($loan_id){
 	$this->load->model('queries');
 	if($this->queries->remove_loan($loan_id));
 	$this->session->set_flashdata('massage','Loan Deleted successfully');
 	return redirect('admin/loan_pending');
 }

 public function delete_loanReject($loan_id){
 	$this->load->model('queries');
 	if($this->queries->remove_loan($loan_id));
 	$this->session->set_flashdata('massage','Loan Deleted successfully');
 	return redirect('admin/all_loan_lejected');
 }


 public function all_loan_lejected(){
 	$this->load->model('queries');
 	$comp_id = $this->session->userdata('comp_id');
 	$loan_reject = $this->queries->get_loan_reject($comp_id);
 	   //  echo "<pre>";
 	   // print_r($loan_reject);
 	   //         exit();
 	$this->load->view('admin/loan_rejected',['loan_reject'=>$loan_reject]);
 }


 public function transfar_amount(){
 	$this->load->model('queries');
 	$comp_id = $this->session->userdata('comp_id');
 	$blanch = $this->queries->get_blanch($comp_id);
 	$float = $this->queries->get_amount_transfor($comp_id);
 	$blanch = $this->queries->get_blanch($comp_id);
 	$sum_froat = $this->queries->get_sumFloatData($comp_id);
 	$account = $this->queries->get_account_transaction($comp_id);
 	$sum_chargers = $this->queries->get_sumTransfor_chargers($comp_id);
   //    echo "<pre>";
 	 // print_r($sum_chargers);
 	 //      exit();
 	$this->load->view('admin/amount_transfor',['blanch'=>$blanch,'float'=>$float,'blanch'=>$blanch,'sum_froat'=>$sum_froat,'account'=>$account,'sum_chargers'=>$sum_chargers]);
 }

 public function create_float(){
 	$this->load->model('queries');
 	$this->form_validation->set_rules('comp_id','company','required');
 	$this->form_validation->set_rules('blanch_id','Blanch','required');
 	$this->form_validation->set_rules('blanch_amount','Amount','required');
 	$this->form_validation->set_rules('trans_day','date','required');
 	$this->form_validation->set_rules('from_trans_id','transaction','required');
 	$this->form_validation->set_rules('to_trans_id','transaction','required');
 	$this->form_validation->set_rules('charger','with charger','required');
 	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
 	if ($this->form_validation->run()) {
 		  $data = $this->input->post();
 		  $comp_id = $data['comp_id'];
 		  $blanch_id = $data['blanch_id'];
 		  $blanch_amount_data = $data['blanch_amount'];
 		  $from_account = $data['from_trans_id'];
 		  $to_account = $data['to_trans_id'];
 		  $charger = $data['charger'];
 		  $trans_id = $from_account;
 		  $blanch_amount = $blanch_amount_data + $charger;
           // print_r($comp_id);
           //       exit();
     @$main_account = $this->queries->get_account_balance($trans_id);
     $old_blanch_amount = $this->queries->get_ledyAmount($to_account,$blanch_id);
     $capital_blanch = @$old_blanch_amount->blanch_capital;
     $newAmount = $capital_blanch  + $blanch_amount - $charger;
     //          echo "<pre>";
     // //print_r($capital_blanch);
     // print_r($old_blanch_amount);
     //            exit();
     
     $account_balance = @$main_account->comp_balance;
     //$from_account = $main_account->trans_id;
         if ($account_balance < $blanch_amount) {
         	   //echo "pesa haitoshi";
          $this->session->set_flashdata('errors','Don`t Have Enough balance');
          return redirect('admin/transfar_amount');
         }else{

            $transaction = $account_balance - $blanch_amount;
             //after chargers
            $after_makato = $blanch_amount - $charger;
           $this->insert_transfor_recod($comp_id,$blanch_id,$from_account,$to_account,$after_makato,$charger);
            //print_r($transaction);
            if ($old_blanch_amount->blanch_capital == TRUE || $old_blanch_amount->blanch_capital == '0') {
               $this->update_blanch_oldBalance($comp_id,$blanch_id,$to_account,$newAmount);
               $this->update_remain_accountCompany($comp_id,$trans_id,$transaction);
            }else{
           $this->insert_blanch_amountAccount($comp_id,$blanch_id,$to_account,$after_makato);
           $this->update_remain_accountCompany($comp_id,$trans_id,$transaction);
         	
         }

         }
          $this->session->set_flashdata('massage','Transaction successfully');
 		  	 return redirect('admin/transfar_amount');
 		  	 }
 		  $this->transfar_amount();
 		 
            }



public function insert_transfor_recod($comp_id,$blanch_id,$from_account,$to_account,$after_makato,$charger){
	  $day = date("Y-m-d");
	 $this->db->query("INSERT INTO  tbl_transfor (`comp_id`,`blanch_id`,`blanch_amount`,`trans_day`,`from_trans_id`,`to_trans_id`,`charger`) 
      VALUES ('$comp_id','$blanch_id','$after_makato','$day','$from_account','$to_account','$charger')");
}

public function insert_blanch_amountAccount($comp_id,$blanch_id,$to_account,$after_makato){
	 $this->db->query("INSERT INTO  tbl_blanch_account (`comp_id`,`blanch_id`,`blanch_capital`,`receive_trans_id`) 
      VALUES ('$comp_id','$blanch_id','$after_makato','$to_account')");
         
}

public function update_blanch_oldBalance($comp_id,$blanch_id,$to_account,$newAmount){
  $sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`='$newAmount'  WHERE `receive_trans_id`= '$to_account' AND `blanch_id` = '$blanch_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}

public function update_remain_accountCompany($comp_id,$trans_id,$transaction){
  $sqldata="UPDATE `tbl_ac_company` SET `comp_balance`= '$transaction' WHERE `trans_id`= '$trans_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}
 		 




 public function modify_float($trans_id,$comp_id){
 	$this->form_validation->set_rules('blanch_id','Blanch','required');
 	$this->form_validation->set_rules('blanch_amount','Amount','required');
 	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
 	if ($this->form_validation->run()) {
 		  $data = $this->input->post();
 		  $blanch_amount = $data['blanch_amount'];
 		  $blanch_id = $data['blanch_id'];
 		  $input_amount = $data['blanch_amount'];
 		  // echo "<pre>";
 		  // print_r($blanch_amount);
 		  //    exit();
 		  $this->load->model('queries');
          $trans = $this->queries->get_remainBlanch_balance($trans_id);
          $remain_trans = $trans->blanch_amount;
          $with = $remain_trans - $input_amount;
      
 		  $remain_balance = $this->queries->get_remain_company_balance($comp_id);
 		  $comp_balance = $remain_balance->comp_balance;
          $backap_data = $comp_balance + $with;

          $blanch_ac = $this->queries->get_blanch_account_remain($blanch_id);
          $remain_blanch = $blanch_ac->blanch_capital;
          $backap_blanch = $remain_blanch - $with;
 		   // print_r($remain_blanch);
      //           echo "<br>";
      //        print_r($backap_blanch);
      //          echo "<br>";
      //        print_r($input_amount);
      //              exit();
 		  if ($this->queries->update_amount($trans_id,$data)) {
 		  	$this->update_blanchCapitalModify($blanch_id,$backap_blanch);
 		  	$this->update_backap_capital($comp_id,$backap_data);
 		  	 $this->session->set_flashdata('massage','Float Updated Sucessfully');
 		  }else{
 		  	 $this->session->set_flashdata('error','Failed');

 		  }

 		  return redirect('admin/transfar_amount');
 	}
 	$this->transfar_amount();

 }

 public function update_blanchCapitalModify($blanch_id,$backap_blanch){
  $sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`= '$backap_blanch' WHERE `blanch_id`= '$blanch_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}


public function update_backap_capital($comp_id,$backap_data){
$sqldata="UPDATE `tbl_ac_company` SET `comp_balance`= '$backap_data' WHERE `comp_id`= '$comp_id'";
  $query = $this->db->query($sqldata);
   return true;
}

public function previous_transfor(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$blanch = $this->queries->get_blanch($comp_id);
	$from = $this->input->post('from');
	$to = $this->input->post('to');
	$blanch_id = $this->input->post('blanch_id');
	$cash = $this->queries->get_transforFloat($from,$to,$blanch_id);
	$sum_float = $this->queries->get_toal_Float_date($from,$to,$blanch_id);
	 //  echo "<pre>";
	 // print_r($sum_float);
	 //     exit();
	$this->load->view('admin/previous_trans',['blanch'=>$blanch,'cash'=>$cash,'sum_float'=>$sum_float,'from'=>$from,'to'=>$to]);
}


 public function delete_float($trans_id){
 	$this->load->model('queries');
 	if($this->queries->remove_float($trans_id));
 	   $this->session->set_flashdata('massage','Float Deleted successfully');
 	   return redirect('admin/transfar_amount');
 }


 public function view_blanch_customer($blanch_id){
 	$this->load->model('queries');
 	$customer_blanch = $this->queries->get_allcutomerBlanch($blanch_id);
 	$blanch = $this->queries->view_blanchDetail($blanch_id);
 	   //    echo "<pre>";
 	   // print_r($blanch);
 	   //             exit();
 	$this->load->view('admin/customer_blanch',['customer_blanch'=>$customer_blanch,'blanch'=>$blanch]);
 }


 public function delete_customer($customer_id){
 	$this->load->model('queries');
 	$customer = $this->queries->get_customer($customer_id);
 	$blanch_id = $customer->blanch_id;
 	     // print_r($blanch_id);
 	     //            exit();
 	if($this->queries->remove_customer($customer_id));
 	     $this->session->set_flashdata('massage','Customer Deleted successfully');
 	     return redirect('admin/view_blanch_customer/'.$blanch_id);
 }

  public function delete_customerData($customer_id){
  	ini_set("max_execution_time", 3600);
 	$this->load->model('queries');
 	if($this->queries->remove_customer($customer_id));
          $this->delete_from_paytable($customer_id);
          $this->delete_from_subcustomer($customer_id);
          $this->delete_from_loans($customer_id);
          $this->delete_from_depost($customer_id);
          $this->delete_from_prev_lecod($customer_id);
          $this->delete_from_receive($customer_id);
          $this->delete_from_store_penart($customer_id);
          $this->delete_from_sponser($customer_id);
          $this->delete_from_paypenart($customer_id);
          $this->delete_from_outstand_loan($customer_id);
          $this->delete_from_loanPending($customer_id);
          $this->delete_from_customer_report($customer_id);

 	     $this->session->set_flashdata('massage','Customer Deleted successfully');
 	     return redirect('admin/all_customer');
 }
 public function delete_from_paytable($customer_id){
 	return $this->db->delete('tbl_pay',['customer_id'=>$customer_id]);	
 }

 public function delete_from_subcustomer($customer_id){
 	return $this->db->delete('tbl_sub_customer',['customer_id'=>$customer_id]);	
 }


 public function delete_from_loans($customer_id){
 	return $this->db->delete('tbl_loans',['customer_id'=>$customer_id]);	
 }

  public function delete_from_depost($customer_id){
 	return $this->db->delete('tbl_depost',['customer_id'=>$customer_id]);	
 }

  public function delete_from_prev_lecod($customer_id){
 	return $this->db->delete('tbl_prev_lecod',['customer_id'=>$customer_id]);	
 }

   public function delete_from_receive($customer_id){
 	return $this->db->delete('tbl_receve',['customer_id'=>$customer_id]);	
 }

   public function delete_from_store_penart($customer_id){
 	return $this->db->delete('tbl_store_penalt',['customer_id'=>$customer_id]);	
 }

  public function delete_from_sponser($customer_id){
 	return $this->db->delete('tbl_sponser',['customer_id'=>$customer_id]);	
 }

   public function delete_from_paypenart($customer_id){
 	return $this->db->delete('tbl_pay_penart',['customer_id'=>$customer_id]);	
 }

    public function delete_from_outstand_loan($customer_id){
 	return $this->db->delete('tbl_outstand_loan',['customer_id'=>$customer_id]);	
 }

     public function delete_from_loanPending($customer_id){
 	return $this->db->delete('tbl_loan_pending',['customer_id'=>$customer_id]);	
 }

    public function delete_from_customer_report($customer_id){
 	return $this->db->delete('tbl_customer_report',['customer_id'=>$customer_id]);	
 }


 public function cash_transaction(){
 	$this->load->model('queries');
 	$comp_id = $this->session->userdata('comp_id');
 	$cash = $this->queries->get_cash_transaction($comp_id);
 	$sum_depost = $this->queries->get_sumCashtransDepost($comp_id);
 	$sum_withdrawls = $this->queries->get_cash_transaction_sum($comp_id);

 	$sum_deducted = $this->queries->get_total_deducted_income_today($comp_id);
 	$sum_paid_penart = $this->queries->get_paid_paenart_today($comp_id);
 	$blanch = $this->queries->get_blanch($comp_id);

 	$account_deposit = $this->queries->get_deposit_sunnary_account($comp_id);
 	$default_list = $this->queries->get_depositing_out($comp_id);
 	$toyal_default = $this->queries->get_depositing_out_total($comp_id);

 	$withdrawal_account = $this->queries->get_withdrawal_summary_account($comp_id);
 	$total_code_no = $this->queries->get_total_code_number($comp_id);
 	$deducted_fee = $this->queries->get_total_deducted_income($comp_id);

 	$penart_paid = $this->queries->get_total_penart_paid($comp_id);

 	$miamala = $this->queries->get_miamala_hewa($comp_id);
 	$total_miamala = $this->queries->get_miamala_hewa_total($comp_id);

    $hai_wateja = $this->queries->get_depositing_hai($comp_id);
    $sugu_wateja = $this->queries->get_depositing_sugu($comp_id);
 	   //  echo "<pre>";
 	   // print_r($sugu_wateja);
 	   //       exit();
 	$this->load->view('admin/cash_transaction',['cash'=>$cash,'sum_depost'=>$sum_depost,'sum_withdrawls'=>$sum_withdrawls,'blanch'=>$blanch,'sum_deducted'=>$sum_deducted,'sum_paid_penart'=>$sum_paid_penart,'account_deposit'=>$account_deposit,'default_list'=>$default_list,'toyal_default'=>$toyal_default,'withdrawal_account'=>$withdrawal_account,'total_code_no'=>$total_code_no,'deducted_fee'=>$deducted_fee,'penart_paid'=>$penart_paid,'miamala'=>$miamala,'total_miamala'=>$total_miamala,'hai_wateja'=>$hai_wateja,'sugu_wateja'=>$sugu_wateja]);
 }

 public function cash_transaction_blanch(){
 	$this->load->model('queries');
 	$comp_id = $this->session->userdata('comp_id');
 	$blanch_id = $this->input->post('blanch_id');
 	$from = $this->input->post('from');
 	$to = $this->input->post('to');
   
   if ($blanch_id == 'all') {
   $cash = $this->queries->get_blanchTransaction_comp($from,$to,$comp_id);
   $total_comp_data = $this->queries->get_blanchTransaction_comp_data($from,$to,$comp_id);

   $account_deposit = $this->queries->get_deposit_sunnary_account_company($comp_id,$from,$to);
   $default_list = $this->queries->get_depositing_out_comp($comp_id,$from,$to);
   $toyal_default = $this->queries->get_depositing_out_total_comp($comp_id,$from,$to);

   $withdrawal_account = $this->queries->get_withdrawal_summary_account_company($comp_id,$from,$to);
 	$total_code_no = $this->queries->get_total_code_number_comp($comp_id,$from,$to);
 	$deducted_fee = $this->queries->get_total_deducted_income_company($comp_id,$from,$to);

 	$penart_paid = $this->queries->get_total_penart_paid_company($comp_id,$from,$to);

 	$miamala = $this->queries->get_miamala_hewa_company($comp_id,$from,$to);
 	$total_miamala = $this->queries->get_miamala_hewa_total_company($comp_id,$from,$to);
    $hai_wateja = $this->queries->get_depositing_hai_prev($comp_id,$from,$to);
    $sugu_wateja = $this->queries->get_depositing_sugu_prev($comp_id,$from,$to);
   }else{
 	$cash = $this->queries->get_blanchTransaction($from,$to,$blanch_id);
 	$total_comp_data = $this->queries->get_blanchTransaction_comp_blanch($from,$to,$blanch_id);

 	$account_deposit = $this->queries->get_deposit_sunnary_account_prev_blanch($blanch_id,$from,$to);
 	$default_list = $this->queries->get_depositing_out_prev_blanch($blanch_id,$from,$to);
 	$toyal_default = $this->queries->get_depositing_out_total_prev_blanch($blanch_id,$from,$to);

 	$withdrawal_account = $this->queries->get_withdrawal_summary_account_blanch($blanch_id,$from,$to);
 	$total_code_no = $this->queries->get_total_code_number_blanch($blanch_id,$from,$to);
 	$deducted_fee = $this->queries->get_total_deducted_income_blanch($blanch_id,$from,$to);

 	$penart_paid = $this->queries->get_total_penart_paid_blanch($blanch_id,$from,$to);

 	$miamala = $this->queries->get_miamala_hewa_blanch($blanch_id,$from,$to);
 	$total_miamala = $this->queries->get_miamala_hewa_total_blanch($blanch_id,$from,$to);

    $hai_wateja = $this->queries->get_depositing_hai_prev_blanch($blanch_id,$from,$to);
    $sugu_wateja = $this->queries->get_depositing_sugu_prev_blanch($blanch_id,$from,$to);
 	
   }
  $blanch = $this->queries->get_blanchd($comp_id);
  $blanch_data = $this->queries->get_blanch_data($blanch_id);
  //   echo "<pre>";
 	//  print_r($cash);
 	// exit();
     
 $this->load->view('admin/cash_transaction_blanch',['blanch'=>$blanch,'cash'=>$cash,'blanch_id'=>$blanch_id,'from'=>$from,'to'=>$to,'blanch_id'=>$blanch_id,'total_comp_data'=>$total_comp_data,'blanch_data'=>$blanch_data,'account_deposit'=>$account_deposit,'default_list'=>$default_list,'toyal_default'=>$toyal_default,'withdrawal_account'=>$withdrawal_account,'total_code_no'=>$total_code_no,'deducted_fee'=>$deducted_fee,'penart_paid'=>$penart_paid,'miamala'=>$miamala,'total_miamala'=>$total_miamala,'hai_wateja'=>$hai_wateja,'sugu_wateja'=>$sugu_wateja]);
 }



  public function print_cashBlanch($from,$to,$blanch_id){
    $this->load->model('queries');
    $comp_id = $this->session->userdata('comp_id');
    
    if ($blanch_id == 'all') {
   $cash = $this->queries->get_blanchTransaction_comp($from,$to,$comp_id);
   $total_comp_data = $this->queries->get_blanchTransaction_comp_data($from,$to,$comp_id);

   $account_deposit = $this->queries->get_deposit_sunnary_account_company($comp_id,$from,$to);
   $default_list = $this->queries->get_depositing_out_comp($comp_id,$from,$to);
   $toyal_default = $this->queries->get_depositing_out_total_comp($comp_id,$from,$to);

   $withdrawal_account = $this->queries->get_withdrawal_summary_account_company($comp_id,$from,$to);
 	$total_code_no = $this->queries->get_total_code_number_comp($comp_id,$from,$to);
 	$deducted_fee = $this->queries->get_total_deducted_income_company($comp_id,$from,$to);

 	$penart_paid = $this->queries->get_total_penart_paid_company($comp_id,$from,$to);

 	$miamala = $this->queries->get_miamala_hewa_company($comp_id,$from,$to);
 	$total_miamala = $this->queries->get_miamala_hewa_total_company($comp_id,$from,$to);

    $hai_wateja = $this->queries->get_depositing_hai_prev($comp_id,$from,$to);
    $sugu_wateja = $this->queries->get_depositing_sugu_prev($comp_id,$from,$to);

   }else{
 	$cash = $this->queries->get_blanchTransaction($from,$to,$blanch_id);
 	$total_comp_data = $this->queries->get_blanchTransaction_comp_blanch($from,$to,$blanch_id);


 	$account_deposit = $this->queries->get_deposit_sunnary_account_prev_blanch($blanch_id,$from,$to);
 	$default_list = $this->queries->get_depositing_out_prev_blanch($blanch_id,$from,$to);
 	$toyal_default = $this->queries->get_depositing_out_total_prev_blanch($blanch_id,$from,$to);

 	$withdrawal_account = $this->queries->get_withdrawal_summary_account_blanch($blanch_id,$from,$to);
 	$total_code_no = $this->queries->get_total_code_number_blanch($blanch_id,$from,$to);
 	$deducted_fee = $this->queries->get_total_deducted_income_blanch($blanch_id,$from,$to);

 	$penart_paid = $this->queries->get_total_penart_paid_blanch($blanch_id,$from,$to);
 	$miamala = $this->queries->get_miamala_hewa_blanch($blanch_id,$from,$to);
 	$total_miamala = $this->queries->get_miamala_hewa_total_blanch($blanch_id,$from,$to);
 	
    $hai_wateja = $this->queries->get_depositing_hai_prev_blanch($blanch_id,$from,$to);
    $sugu_wateja = $this->queries->get_depositing_sugu_prev_blanch($blanch_id,$from,$to);
   }
  $blanch = $this->queries->get_blanchd($comp_id);
  $blanch_data = $this->queries->get_blanch_data($blanch_id);
  $compdata = $this->queries->get_companyData($comp_id);
        //        echo "<pre>";
        // print_r($cash);
        //        exit();
    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
    $html = $this->load->view('admin/print_cashTransaction_blanch',['cash'=>$cash,'blanch_id'=>$blanch_id,'from'=>$from,'to'=>$to,'total_comp_data'=>$total_comp_data,'blanch_data'=>$blanch_data,'compdata'=>$compdata,'account_deposit'=>$account_deposit,'default_list'=>$default_list,'toyal_default'=>$toyal_default,'withdrawal_account'=>$withdrawal_account,'total_code_no'=>$total_code_no,'deducted_fee'=>$deducted_fee,'penart_paid'=>$penart_paid,'miamala'=>$miamala,'total_miamala'=>$total_miamala,'hai_wateja'=>$hai_wateja,'sugu_wateja'=>$sugu_wateja],true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
        $mpdf->WriteHTML($html);
        $mpdf->Output();
         
    }


 public function delete_depost_data($pay_id){
 	$this->load->model('queries');
 	$deposit = $this->queries->get_deposit_data_record($pay_id);
 	$depost = $deposit->depost;
 	$trans_id = $deposit->trans_id;
 	$blanch_id = $deposit->blanch_id;
 	$comp_id = $deposit->comp_id;
 	$customer_id = $deposit->customer_id;
 	$loan_id = $deposit->loan_id;
 	$dep_id = $pay_id;

 	$remain_depost = $depost - $depost;

 	$blanch_balance = $this->queries->get_remain_blanch_capital($blanch_id,$trans_id);
 	$old_balance = $blanch_balance->blanch_capital;
 	$deposit_new = $old_balance - $depost;
    
    $descriptions = $this->queries->get_description_pay($loan_id);
    $description = $descriptions->description;
    
    @$recovery = $this->queries->get_total_pend_data($loan_id);
    $total_pend = @$recovery->total_pend;
    $recov = $total_pend + $depost;

    @$out = $this->queries->get_outstand_loan_depost($loan_id);
    $remain = @$out->remain_amount;
    $paid = @$out->paid_amount;

    $remain_data = $remain + $depost;
    $paid_data =  $paid - $depost;


    @$out_deposit = $this->queries->get_outstand_deposit($blanch_id,$trans_id);
    $out_balance = @$out_deposit->out_balance;
    $new_out_balance = $out_balance - $depost;

    $total_depost = $this->queries->get_sum_dapost($loan_id);
    $loan_restoration = $this->queries->get_loanInterest($loan_id);
    $compdata = $this->queries->get_companyData($comp_id);
    $customer_data = $this->queries->get_customer_data($customer_id);

    $loan_dep = $total_depost->remain_balance_loan;
    $remove_deposit = $loan_dep - $depost;

    $loan_int = $loan_restoration->loan_int;
    $remain_loan = $loan_int - $remove_deposit;

    $comp_name = $compdata->comp_name;
    $comp_phone = $compdata->comp_phone;
    $phone = $customer_data->phone_no;

    $massage ='Tsh.'. number_format($depost) .' '. 'Iliyoingizwa Kimakosa Kwenye Mkopo wako'.' '. $comp_name . ' '.' Imetolewa' .' '. 'Kiasi Kilichobaki Kulipwa '.number_format($remain_loan).' ' . 'Kwa Msaada ' .''. $comp_phone;

    $this->sendsms($phone,$massage);

     //    echo "<pre>";
     // print_r($phone);
     //        exit();

    if ($description == 'CASH DEPOSIT') {
    $this->update_loan_statatus_adjust_withdrawal($loan_id);
    }elseif ($description == 'SYSTEM / PENDING LOAN RETURN') {
     $this->update_recovery_amount($loan_id,$recov);
    $this->update_loan_statatus_adjust_withdrawal($loan_id);
    }elseif ($description == 'SYSTEM / DEFAULT LOAN RETURN') {
    $this->update_outstand_table_mistak($loan_id,$remain_data,$paid_data);
    $this->update_loan_statatus_adjust_out($loan_id);
    }else{

    }
 	// print_r($description);
 	//     exit();
 	if ($description == 'SYSTEM / DEFAULT LOAN RETURN') {
 		$this->update_blanch_amount_outstand($comp_id,$blanch_id,$new_out_balance,$trans_id);
 	}else{
 	$this->insert_blanch_amount_deposit($blanch_id,$deposit_new,$trans_id);	
 	}
 	
 	$this->update_prev_record_data($pay_id,$remain_depost);
 	$this->update_deposit_record_data($pay_id,$remain_depost);
    $this->remove_deposit_loan($dep_id);
    $this->remove_prepaid_deposit($dep_id);



 	// print_r($remain_depost);
 	//      exit();
 	$this->session->set_flashdata("massage","Adjust successfully");
 	return redirect("admin/cash_transaction");
 }

 public function update_blanch_amount_outstand($comp_id,$blanch_id,$new_out_balance,$trans_id){
    $sqldata="UPDATE `tbl_receve_outstand` SET `out_balance`= '$new_out_balance' WHERE `blanch_id`= '$blanch_id' AND `trans_id`='$trans_id'";
    // print_r($sqldata);
    //    exit();
     $query = $this->db->query($sqldata);
     return true; 
   }


 public function update_outstand_table_mistak($loan_id,$remain_data,$paid_data){
 $sqldata="UPDATE `tbl_outstand_loan` SET `remain_amount`= '$remain_data',`paid_amount`='$paid_data',`out_status`='open' WHERE `loan_id`= '$loan_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;	
 }

 public function update_recovery_amount($loan_id,$recov){
 $sqldata="UPDATE `tbl_pending_total` SET `total_pend`= '$recov' WHERE `loan_id`= '$loan_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
 }

 public function update_loan_statatus_adjust_out($loan_id){
 $sqldata="UPDATE `tbl_loans` SET `loan_status`= 'out' WHERE `loan_id`= '$loan_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;		
 }

 public function update_loan_statatus_adjust_withdrawal($loan_id){
  $sqldata="UPDATE `tbl_loans` SET `loan_status`= 'withdrawal' WHERE `loan_id`= '$loan_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;	
 }


 public function update_prev_record_data($pay_id,$remain_depost){
 $sqldata="UPDATE `tbl_prev_lecod` SET `depost`= '$remain_depost',`trans_id`='0' WHERE `pay_id`= '$pay_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
 }

 public function update_deposit_record_data($pay_id,$remain_depost){
 $sqldata="UPDATE `tbl_depost` SET `depost`= '$remain_depost',`sche_principal`='0',`sche_interest`='0',`depost_method`='0' WHERE `dep_id`= '$pay_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
 }

 public function remove_deposit_loan($dep_id){
 	return $this->db->delete('tbl_pay',['dep_id'=>$dep_id]);
 }

 public function remove_prepaid_deposit($dep_id){
 	return $this->db->delete('tbl_prepaid',['dep_id'=>$dep_id]);
 }

   


    public function print_cash(){
    $this->load->model('queries');
    $comp_id = $this->session->userdata('comp_id');
    $cash = $this->queries->get_cash_transaction($comp_id);
    $compdata = $this->queries->get_companyData($comp_id);
    $sum_depost = $this->queries->get_sumCashtransDepost($comp_id);
 	$sum_withdrawls = $this->queries->get_sumCashtransWithdrow($comp_id);
        // print_r($comdata);
        //        exit();
    $mpdf = new \Mpdf\Mpdf();
    $html = $this->load->view('admin/print_cash_transaction',['cash'=>$cash,'compdata'=>$compdata,'sum_depost'=>$sum_depost,'sum_withdrawls'=>$sum_withdrawls],true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
        $mpdf->WriteHTML($html);
        $mpdf->Output();
         
    }


    public function blanchiwise_report(){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
    	$data_blanch = $this->queries->get_sumblanch_wise($comp_id);
    	$total_allblanch = $this->queries->get_sum_Depost($comp_id);
    	$total_depost_comp = $this->queries->get_total_comp_deposit($comp_id);
    	   //  echo "<pre>";
    	   // print_r($total_depost_comp);
    	   //       exit();
    	$this->load->view('admin/branch_wise_report',['data_blanch'=>$data_blanch,'total_allblanch'=>$total_allblanch,'total_allblanch'=>$total_allblanch,'total_depost_comp'=>$total_depost_comp]);
    }

    public function print_blanchWisereport(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$data_blanch = $this->queries->get_sumblanch_wise($comp_id);
    $total_allblanch = $this->queries->get_sum_Depost($comp_id);
	$compdata = $this->queries->get_companyData($comp_id);
	$total_depost_comp = $this->queries->get_total_comp_deposit($comp_id);

    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
    $html = $this->load->view('admin/print_blanchwise_report',['data_blanch'=>$data_blanch,'total_allblanch'=>$total_allblanch,'compdata'=>$compdata,'total_depost_comp'=>$total_depost_comp],true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
        $mpdf->WriteHTML($html);
        $mpdf->Output();

    }

    public function previous_blanchwise_data(){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
	    $from = $this->input->post('from');
	    $to = $this->input->post('to');
	    $comp_id = $this->input->post('comp_id');
	    $data_blanchwise = $this->queries->get_blanchwise_previous($from,$to,$comp_id);
	    $total_receivable = $this->queries->get_blanchwise_Totalreceivable($from,$to,$comp_id);
	    $total_receved = $this->queries->get_blanchwise_Totalreceved($from,$to,$comp_id);
	      //       echo "<pre>";
	      // print_r($total_receved);
	      //       exit();
	    $this->load->view('admin/previous_blanchwise',['data_blanchwise'=>$data_blanchwise,'total_receivable'=>$total_receivable,'total_receved'=>$total_receved,'from'=>$from,'to'=>$to,'comp_id'=>$comp_id]);

    }

    public function print_previous_blanchwise($from,$to,$comp_id){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
        $data_blanchwise = $this->queries->get_blanchwise_previous($from,$to,$comp_id);
	    $total_receivable = $this->queries->get_blanchwise_Totalreceivable($from,$to,$comp_id);
	    $total_receved = $this->queries->get_blanchwise_Totalreceved($from,$to,$comp_id);
    	$compdata = $this->queries->get_companyData($comp_id); 

	    $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('admin/print_previous_blanchwise',['data_blanchwise'=>$data_blanchwise,'total_receivable'=>$total_receivable,'total_receved'=>$total_receved,'from'=>$from,'to'=>$to,'comp_id'=>$comp_id,'compdata'=>$compdata],true);
        $mpdf->SetFooter('Generated By Brainsoft Technology');
        $mpdf->WriteHTML($html);
        $mpdf->Output();

    }

    


    public function prev_cashtransaction(){
    $this->load->model('queries');
    $comp_id = $this->session->userdata('comp_id');
    $blanch = $this->queries->get_blanch($comp_id);
    $from = $this->input->post('from');
    $to = $this->input->post('to');
    $comp_id = $this->input->post('comp_id');
    $blanch_id = $this->input->post('blanch_id');
    // print_r($blanch_id);
    //        exit();
    $blanch_data = $this->queries->get_blanch_data($blanch_id);
    $data = $this->queries->search_prev_cashtransaction($from,$to,$comp_id,$blanch_id);
    $total_cashDepost = $this->queries->get_sumCashtransDepostPrvious($from,$to,$comp_id,$blanch_id);
    $total_withdrawal = $this->queries->get_sumCashtransWithdrowPrevious($from,$to,$comp_id,$blanch_id);
    
    
       //     echo "<pre>";
       // print_r($data);
       //        exit();

    $this->load->view('admin/previous_cash',['data'=>$data,'from'=>$from,'to'=>$to,'total_cashDepost'=>$total_cashDepost,'total_withdrawal'=>$total_withdrawal,'comp_id'=>$comp_id,'blanch'=>$blanch,'blanch_data'=>$blanch_data,'blanch_id'=>$blanch_id]);
    }




    public function print_previous_cash($from,$to,$comp_id,$blanch_id){
    $this->load->model('queries');
    $comp_id = $this->session->userdata('comp_id');
    $compdata = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanch_data($blanch_id);
    $data = $this->queries->search_prev_cashtransaction($from,$to,$comp_id,$blanch_id);
    $total_cashDepost = $this->queries->get_sumCashtransDepostPrvious($from,$to,$comp_id,$blanch_id);
    $total_withdrawal = $this->queries->get_sumCashtransWithdrowPrevious($from,$to,$comp_id,$blanch_id);
    $mpdf = new \Mpdf\Mpdf();
    $html = $this->load->view('admin/previous_cash_report',['compdata'=>$compdata,'data'=>$data,'total_cashDepost'=>$total_cashDepost,'total_withdrawal'=>$total_withdrawal,'from'=>$from,'to'=>$to,'blanch_data'=>$blanch_data],true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
         
    }


    public function loan_pending_time(){
    $this->load->model('queries');
    $comp_id = $this->session->userdata('comp_id');
    $blanch = $this->queries->get_blanch($comp_id);

    $new_pending = $this->queries->get_total_loan_pendingComp($comp_id);
    $total_pending_new = $this->queries->get_total_pend_loan_company($comp_id);

    $old_newpend = $this->queries->get_pending_reportLoancompany($comp_id);
    $pend = $this->queries->get_sun_loanPendingcompany($comp_id);


      //  echo "<pre>";
      // print_r($new_pending);
      //     exit();
    
    $this->load->view('admin/loan_pending_time',['blanch'=>$blanch,'new_pending'=>$new_pending,'total_pending_new'=>$total_pending_new,'old_newpend'=>$old_newpend,'pend'=>$pend]);
    }


    public function prev_pendingLoan(){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
    	$from = $this->input->post('from');
    	$to = $this->input->post('to');
    	$blanch_id = $this->input->post('blanch_id');
    	$loan_pend= $this->queries->get_penddata($from,$to,$blanch_id);
    	
    	$pend = $this->queries->get_sun_loanPendingPrev($from,$to,$blanch_id);
    	$blanch = $this->queries->get_blanch($comp_id);
    	//   echo "<pre>";
    	// print_r($loan_pend);
    	//     exit();
    	$this->load->view('admin/prev_pending_loan',['blanch'=>$blanch,'loan_pend'=>$loan_pend,'pend'=>$pend,'from'=>$from,'to'=>$to,'blanch_id'=>$blanch_id]);
    }

    public function print_prevPendloan($from,$to,$blanch_id){
       $this->load->model('queries');
     $comp_id = $this->session->userdata('comp_id');
     $compdata = $this->queries->get_companyData($comp_id);
     $loan_pend= $this->queries->get_penddata($from,$to,$blanch_id);
     $pend = $this->queries->get_sun_loanPendingPrev($from,$to,$blanch_id);
     $blanch = $this->queries->get_blanch_data($blanch_id);
     $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
     $html = $this->load->view('admin/prev_pending_report',['compdata'=>$compdata,'pend'=>$pend,'loan_pend'=>$loan_pend,'from'=>$from,'to'=>$to,'blanch'=>$blanch],true);
     $mpdf->SetFooter('Generated By Brainsoft Technology');
     $mpdf->WriteHTML($html);
     $mpdf->Output();
    	
    }


    public function print_pending_report(){
     $this->load->model('queries');
     $comp_id = $this->session->userdata('comp_id');
     $compdata = $this->queries->get_companyData($comp_id);
     $loan_pend = $this->queries->get_pending_reportLoan($comp_id);
     $pend = $this->queries->get_sun_loanPending($comp_id);
     $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
     $html = $this->load->view('admin/loan_pending_report',['compdata'=>$compdata,'pend'=>$pend,'loan_pend'=>$loan_pend],true);
     $mpdf->SetFooter('Generated By Brainsoft Technology');
     $mpdf->WriteHTML($html);
     $mpdf->Output(); 
    }

 


    public function repaymant_data(){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
    	$repayment = $this->queries->get_repayment_data($comp_id);
    	$total_loanAprove = $this->queries->get_total_loanDone($comp_id);
    	$total_loan_int = $this->queries->get_sum_totalloanInterst($comp_id);
    	  //     echo "<pre>";
    	  // print_r($repayment);
    	  //      exit();
    	$this->load->view('admin/loan_repayment',['repayment'=>$repayment,'total_loanAprove'=>$total_loanAprove,'total_loan_int'=>$total_loan_int]);
    }




    public function print_repayment_report(){
    $this->load->model('queries');
    $comp_id = $this->session->userdata('comp_id');
    $compdata = $this->queries->get_companyData($comp_id);
    $repayment = $this->queries->get_repayment_data($comp_id);
    $total_loanAprove = $this->queries->get_total_loanDone($comp_id);
    $total_loan_int = $this->queries->get_sum_totalloanInterst($comp_id);
    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
    $html = $this->load->view('admin/repayment_report',['compdata'=>$compdata,'repayment'=>$repayment,'total_loanAprove'=>$total_loanAprove,'total_loan_int'=>$total_loan_int],true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
    $mpdf->WriteHTML($html);
    $mpdf->Output();    
    }

    public function previour_repayment(){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $comp_id = $this->input->post('comp_id');
        $repayment = $this->queries->get_previous_repayments($from,$to,$comp_id);
        $total_loanAprove = $this->queries->get_sumprev_loanAprove($from,$to,$comp_id);
        $total_loan_int = $this->queries->get_sum_prevtotalLoansint($from,$to,$comp_id);
          //   echo "<pre>";
          // print_r($repayment);
          //      exit();
    	$this->load->view('admin/previous_repayment',['repayment'=>$repayment,'from'=>$from,'to'=>$to,'total_loanAprove'=>$total_loanAprove,'total_loan_int'=>$total_loan_int,'comp_id'=>$comp_id]);
    }

    public function print_prev_reportRepayment($from,$to,$comp_id){
     $this->load->model('queries');
     $repayment = $this->queries->get_previous_repayments($from,$to,$comp_id);
     $total_loanAprove = $this->queries->get_sumprev_loanAprove($from,$to,$comp_id);
     $total_loan_int = $this->queries->get_sum_prevtotalLoansint($from,$to,$comp_id);
     $compdata = $this->queries->get_companyData($comp_id);
     $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
     $html = $this->load->view('admin/prev_repayment_report',['compdata'=>$compdata,'repayment'=>$repayment,'total_loanAprove'=>$total_loanAprove,'total_loan_int'=>$total_loan_int,'from'=>$from,'to'=>$to],true);
     $mpdf->SetFooter('Generated By Brainsoft Technology');
     $mpdf->WriteHTML($html);
     $mpdf->Output();
    }


    public function customer_account_statement(){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
    	$customer = $this->queries->get_allcustomerData($comp_id);
    	$this->load->view('admin/account_statement',['customer'=>$customer]);
    }

    public    function fetch_data_loanActive()
{
$this->load->model('queries');
if($this->input->post('customer_id'))
{
echo $this->queries->fetch_loan_list($this->input->post('customer_id'));
}
}

    public function search_acount_statement(){
    $this->load->model('queries');
    $comp_id = $this->session->userdata('comp_id');
    $customery = $this->queries->get_allcustomerData($comp_id);
    $customer_id = $this->input->post('customer_id');
    $loan_id = $this->input->post('loan_id');
    $customer = $this->queries->search_CustomerLoan($customer_id);

      //   echo "<pre>";
      // print_r($loan_id);
      //       exit();
    $this->load->view('admin/search_account',['customer'=>$customer,'customery'=>$customery,'customer_id'=>$customer_id,'loan_id'=>$loan_id]);
    }


    public function view_customer_statemnt($loan_id){
        $this->load->model('queries');
        $comp_id = $this->session->userdata('comp_id');

        $this->load->view('admin/customer_loan_statement',['loan_id'=>$loan_id]);
    }


    public function filter_customer_statement(){
    $this->load->model('queries');
    $comp_id = $this->session->userdata('comp_id');
    $from = $this->input->post('from');
    $to = $this->input->post('to');
    $customer_id = $this->input->post('customer_id');

    $data_account = $this->queries->get_account_statement($customer_id,$from,$to);
    $customer = $this->queries->search_CustomerLoan($customer_id);
    $customery = $this->queries->get_allcustomerData($comp_id);
    
    // print_r($data_account);
    //     exit();

    $this->load->view('admin/customer_statement',['customer'=>$customer,'data_account'=>$data_account,'customery'=>$customery]);
}

    public function search_customer_loan_report(){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
    	$customer = $this->queries->get_allcustomerData($comp_id);
    	$this->load->view('admin/search_loan_report',['customer'=>$customer]);
    }

      public function print_account_statement($customer_id,$loan_id){
    	// print_r($loan_id);
    	//    exit();
     $this->load->model('queries');
     $comp_id = $this->session->userdata('comp_id');
     $compdata = $this->queries->get_companyData($comp_id);
     $customer_data = $this->queries->get_loan_schedule_customer($loan_id);
     
    $mpdf = new \Mpdf\Mpdf();
     $html = $this->load->view('admin/customer_account_statement',['compdata'=>$compdata,'customer_data'=>$customer_data,'loan_id'=>$loan_id,'customer_id'=>$customer_id],true);
     $mpdf->SetFooter('Generated By Brainsoft');
     $mpdf->WriteHTML($html);
     $mpdf->Output(); 

    }

    public function customer_loan_report(){
    $this->load->model('queries');
    $comp_id = $this->session->userdata('comp_id');
    $customer_id = $this->input->post('customer_id');
    $comp_id = $this->input->post('comp_id');
    $customer = $this->queries->search_CustomerLoan_report($customer_id,$comp_id);
    @$customer_id = $customer->customer_id;
    @$customer_report = $this->queries->get_customer_loanReport($customer_id);
    @$sum_recevable = $this->queries->get_sum_receivableAmountCustomer($customer_id);
    @$sum_pend = $this->queries->get_sumPending_Amount($customer_id);
    @$sum_penart = $this->queries->get_penart_amount_total($customer_id);
    //    echo "<pre>";
    // print_r($customer);
    //       exit();
    $this->load->view('admin/customer_report',['customer'=>$customer,'customer_report'=>$customer_report,'sum_recevable'=>$sum_recevable,'sum_pend'=>$sum_pend,'sum_penart'=>$sum_penart,'customer_id'=>$customer_id]);
    }


    public function print_customer_loan_report($customer_id){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
    	$compdata = $this->queries->get_companyData($comp_id);
    	$customer_report = $this->queries->get_customer_loanReport($customer_id);
    	$sum_recevable = $this->queries->get_sum_receivableAmountCustomer($customer_id);
        $sum_pend = $this->queries->get_sumPending_Amount($customer_id);
        $sum_penart = $this->queries->get_penart_amount_total($customer_id);
        $statement = $this->queries->get_customer_datareport($customer_id);
         //  echo "<pre>";
         // print_r($customer_report);
         //     exit();
    	$mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('admin/customer_loan_report',['compdata'=>$compdata,'customer_report'=>$customer_report,'customer_id'=>$customer_id,'sum_recevable'=>$sum_recevable,'sum_pend'=>$sum_pend,'sum_penart'=>$sum_penart,'statement'=>$statement],true);
        $mpdf->SetFooter('Generated By Brainsoft Technology');
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }




    public function print_customer_statement($customer_id){
    $this->load->model('queries');
    $comp_id = $this->session->userdata('comp_id');
    $statement = $this->queries->get_customer_datareport($customer_id);
    $pay_customer = $this->queries->get_paycustomer($customer_id);
    $payisnull = $this->queries->get_paycustomerNotfee_Statement($customer_id);
    $compdata = $this->queries->get_companyData($comp_id);
    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
    $html = $this->load->view('admin/customer_statement_report',['compdata'=>$compdata,'statement'=>$statement,'pay_customer'=>$pay_customer,'payisnull'=>$payisnull],true);
     $mpdf->SetFooter('Generated By Brainsoft Technology');
     $mpdf->WriteHTML($html);
     $mpdf->Output();
    }
       


    	public function collelateral_session($loan_id){
    		$this->load->model('queries');
            $loan_attach = $this->queries->get_loanAttach($loan_id);
            $collateral = $this->queries->get_colateral_data($loan_id);
              //   echo "<pre>";
              // print_r($loan_attach);
              //      exit();
    		$this->load->view('admin/collelateral',['loan_attach'=>$loan_attach,'collateral'=>$collateral]);
    	}

    // public function create_colateral($loan_id){
    // 	$this->load->model('queries');
    // 	 $data = array(); 
    //    // $errorUploadType = $statusMsg = ''; 
    //     // If file upload form submitted 
    //     if($this->input->post('fileSubmit')){ 
    //      $loan_id =  $_POST['loan_id']; 
    //     //$description =  $_POST['description'];
    //     //$attach =  $_POST['attach'];
    //         // If files are selected to upload 
    //         if(!empty($_FILES['attach']['name']) && count(array_filter($_FILES['attach']['name'])) > 0){ 
    //             $filesCount = count($_FILES['attach']['name']); 
    //             for($i = 0; $i < $filesCount; $i++){ 
    //                 $_FILES['file']['name']     = $_FILES['attach']['name'][$i]; 
    //                 $_FILES['file']['type']     = $_FILES['attach']['type'][$i]; 
    //                 $_FILES['file']['tmp_name'] = $_FILES['attach']['tmp_name'][$i]; 
    //                 $_FILES['file']['error']     = $_FILES['attach']['error'][$i]; 
    //                 $_FILES['file']['size']     = $_FILES['attach']['size'][$i]; 
                     
    //                 // File upload configuration 
    //                 $uploadPath = 'assets/img/'; 
    //                 $config['upload_path'] = $uploadPath; 
    //                 $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
    //                 $config['max_size']      = '8192'; 
    //                 $config['remove_spaces']=TRUE;  //it will remove all spaces
    //                 $config['encrypt_name']=TRUE;   //it wil encrypte the original file name
                     
    //                 // Load and initialize upload library 
    //                 $this->load->library('upload', $config); 
    //                 $this->upload->initialize($config); 
                     
    //                 // Upload file to server 
    //                 if($this->upload->do_upload('file')){ 
    //                     // Uploaded file data 
    //                     $fileData = $this->upload->data(); 
    //                     // $data = array(
    //                     // 'loan_id' => $this->input->post('loan_id'),
    //                     // 'description' => $this->input->post('description'),
    //                     // 	 );
    //                     $uploadData[$i]['file_name'] = $fileData['file_name']; 
    //                     $uploadData[$i]['loan_id'] =  $loan_id;
    //                     //$uploadData[$i]['description'] =  $fileData['description'];
    //                    // $uploadData[$i] =  $description;
    //                        echo "<pre>";
    //                        print_r($uploadData);
    //                             exit(); 
    //                 }else{  
    //                     $errorUploadType .= $_FILES['file']['name'].' | ';  
    //                 } 
    //             } 
                 
    //             $errorUploadType = !empty($errorUploadType)?'<br/>File Type Error: '.trim($errorUploadType, ' | '):''; 
    //             if(!empty($uploadData)){ 
    //                 // Insert files data into the database 
    //                 $insert = $this->queries->insert($uploadData); 
                     
    //                 // Upload status message 
    //                 $statusMsg = $insert?'Files uploaded successfully!'.$errorUploadType:'Some problem occurred, please try again.'; 
    //             }else{ 
    //                 $statusMsg = "Sorry, there was an error uploading your file.".$errorUploadType; 
    //             } 
    //         }else{ 
    //             $statusMsg = 'Please select image files to upload.'; 
    //         } 
    //     } 
        
    //        //echo "mwizi";
    //     return redirect('admin/local_government/'.$loan_id);
        
    // }  




	public function create_colateral($loan_id){
            if(!empty($_FILES['file_name']['name'])){
                $config['upload_path'] = 'assets/img/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
                $config['file_name'] = $_FILES['file_name']['name'];
                $config['max_size']      = '8192'; 
                $config['remove_spaces']=TRUE;  //it will remove all spaces
                $config['encrypt_name']=TRUE;   //it wil encrypte the original file name
                    //print_r($config);
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('file_name')){
                    $uploadData = $this->upload->data();
                    $file_name = $uploadData['file_name'];
                }else{
                    $file_name = '';
                }
            }else{
                $file_name = '';
            }
            
            //Prepare array of user data
            $data = array(
            'description' =>$this->input->post('description'),
            'loan_id' =>$this->input->post('loan_id'),
            'co_condition' =>$this->input->post('co_condition'),
            'value' =>$this->input->post('value'),
            'file_name' => $file_name,
            );
            //   echo "<pre>";
            // print_r($data);
            //  echo "</pre>";
            //   exit();
           $this->load->model('queries'); 
            //Storing insertion status message.
            if($data){
                $this->queries->insert($data);
                $this->session->set_flashdata('massage','Colateral Uploaded  Successfully');
               }else{
                $this->session->set_flashdata('error','Data failed!!');
            }
            return redirect('admin/collelateral_session/'.$loan_id);

    }

    public function modify_colateral($loan_id,$col_id){
            //Prepare array of user data
            $data = array(
            'description' =>$this->input->post('description'),
            //'loan_id' =>$this->input->post('loan_id'),
            'co_condition' =>$this->input->post('co_condition'),
            'value' =>$this->input->post('value'),
            //'file_name' => $file_name,
            );
            //   echo "<pre>";
            // print_r($data);
            //  echo "</pre>";
            //   exit();
           $this->load->model('queries'); 
            //Storing insertion status message.
            if($data){
                $this->queries->queries->update_collateral($data,$col_id);
                $this->session->set_flashdata('massage','Colateral Updated  Successfully');
               }else{
                $this->session->set_flashdata('error','Data failed!!');
            }
            return redirect('admin/collelateral_session/'.$loan_id."/".$col_id);

    }


    public function modify_colateral_picture($loan_id,$col_id){
            if(!empty($_FILES['file_name']['name'])){
                $config['upload_path'] = 'assets/img/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
                $config['file_name'] = $_FILES['file_name']['name'];
                $config['max_size']      = '8192'; 
                $config['remove_spaces']=TRUE;  //it will remove all spaces
                $config['encrypt_name']=TRUE;   //it wil encrypte the original file name
                    //die($config);
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('file_name')){
                    $uploadData = $this->upload->data();
                    $file_name = $uploadData['file_name'];
                }else{
                    $file_name = '';
                }
            }else{
                $file_name = '';
            }
            
            //Prepare array of user data
            $data = array(
            'file_name' => $file_name,
            );
            //   echo "<pre>";
            // print_r($data);
            //  echo "</pre>";
            //   exit();
           $this->load->model('queries'); 
            //Storing insertion status message.
            if($data){
                $this->queries->queries->update_collateral($data,$col_id);
                $this->session->set_flashdata('massage','Colateral Updated  Successfully');
               }else{
                $this->session->set_flashdata('error','Data failed!!');
            }
            return redirect('admin/collelateral_session/'.$loan_id."/".$col_id);

    }



    public function delete_colateral($loan_id,$col_id){
    	$this->load->model('queries');
    	if($this->queries->remove_collateral($col_id));
    	$this->session->set_flashdata('massage','Colateral Deleted successfully');
    	return redirect('admin/collelateral_session/'.$loan_id."/".$col_id);
    }




    public function local_government($loan_id){
    	$this->load->model('queries');
      $loan_attach = $this->queries->get_loanAttach($loan_id);
      $region = $this->queries->get_region();
      $local_gov = $this->queries->get_localgovernmentDetail($loan_id);

        // print_r($local_gov);
        //           exit();
    	$this->load->view('admin/local_government',['loan_attach'=>$loan_attach,'region'=>$region,'local_gov'=>$local_gov]);
    }


    public function create_local_govDetails(){
     $folder_Path = 'assets/upload/';
        if(isset($_POST['image']) ){
           $loan_id = $_POST['id'];
           $image = $_POST['image'];
           //$oficer = $_POST['oficer'];
           //$phone_oficer = $_POST['phone_oficer'];

            //  $_POST['id'];
            // print_r($phone_oficer);
            //     die();
             
             $image_parts = explode(";base64,",$_POST['image']);
             $image_type_aux = explode("image/",$image_parts[0]);

             $image_type = $image_type_aux[1];
             $data = $_POST['image'];// base64_decode($image_parts[1]);


            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
             
             $file = $folder_Path .uniqid() .'.png';
            file_put_contents($file, $data);
            $this->insert_customer_local($file,$loan_id);
            echo json_encode("Successfully");
           
        }
    }

    public function insert_customer_local($file,$loan_id){
    $data = "UPDATE tbl_attachment SET `cont_attachment`='$file' WHERE loan_id = '$loan_id'";
    $query = $this->db->query($data);
    return true;
   }



    


	public function Update_local_govDetails($loan_id,$attach_id){
    	$this->load->model('queries');     
            //Prepare array of user data
            $data = array(
            //'loan_id'=> $this->input->post('loan_id'),
            'oficer'=> $this->input->post('oficer'),
            'phone_oficer'=> $this->input->post('phone_oficer'),
            );
           //    echo "<pre>";
           // print_r($data);
           //      exit();
            //Pass user data to model
           $this->load->model('queries'); 
           $data = $this->queries->update_localDetail($data,$attach_id);
          
            //Storing insertion status message.
            if($data){
            	$this->session->set_flashdata('massage','Local government information Updated Successfully');
               }else{
                $this->session->set_flashdata('error','Data failed!!');
            }
            $group = $this->queries->get_groupLoanData($loan_id);
            $group_id = $group->group_id;
              // echo "<pre>";
              // print_r($group_id);
              //      exit();
              if ($group_id == TRUE) {
              	 //echo "machemba";
              return redirect('admin/group_member/'.$loan_id);
                   }else{     
            return redirect('admin/local_government/'.$loan_id."/".$attach_id);
            }
	}

	public function group_member($loan_id,$customer_id){
	  $this->load->model('queries');
      $member = $this->queries->get_groupLoanData($loan_id);
      $region = $this->queries->get_region();
      $groudata = $this->queries->get_groupLoan_detail($loan_id);
       //    echo "<pre>";
       // print_r($member);
       //      exit();
		$this->load->view('admin/group_member',['region'=>$region,'member'=>$member,'groudata'=>$groudata,'customer_id'=>$customer_id]);
	}

	//   public function create_member($loan_id){
    // 	$this->load->model('queries');
    //     if(!empty($this->input->post('submit'))){
    //         // echo "<pre>";
    //         // print_r($_POST['']);
    //           if(isset($_POST['submit'])){ 
    //                 $member_name =  $_POST['member_name']; 
    //                 $gender =  $_POST['gender']; 
    //                 $date_birth =  $_POST['date_birth']; 
    //                 $martial_status =  $_POST['martial_status']; 
    //                 $member_phone =  $_POST['member_phone']; 
    //                 $region_id =  $_POST['region_id']; 
    //                 $district =  $_POST['district']; 
    //                 $ward =  $_POST['ward']; 
    //                 $street =  $_POST['street']; 
    //                 $nature_setlement =  $_POST['nature_setlement']; 
    //                 $busines_name =  $_POST['busines_name']; 
    //                 $busines_place =  $_POST['busines_place']; 
    //                 $member_position =  $_POST['member_position']; 
    //                 $group_id =  $_POST['group_id']; 
    //                 $customer_id =  $_POST['customer_id']; 
    //                 $comp_id =  $_POST['comp_id']; 
    //                 $blanch_id =  $_POST['blanch_id']; 
    //                 $date_reg =  $_POST['date_reg'];

    //                //    echo "<pre>";
    //                // print_r ($member_name);
    //                // print_r ($gender);
    //                //  print_r ($date_birth);
    //                //  print_r ($martial_status);
    //                //  print_r ($member_phone);
    //                //  print_r ($region_id);
    //                //  print_r ($district);
    //                // print_r ($ward);
    //                //  print_r ($street);
    //                //  print_r ($nature_setlement);
    //                //  print_r ($busines_name);
    //                //  print_r ($busines_place);
    //                //  print_r ($group_id);
    //                //  print_r ($customer_id);
    //                //  print_r ($comp_id);
    //                //  print_r ($blanch_id);
    //                //  print_r ($date_reg);
    //                //          exit();
                   
    //       for($i=0; $i<count($member_name);$i++) {
    //     $this->db->query("INSERT INTO  tbl_group_member (`member_name`,`gender`,`date_birth`,`martial_status`,`member_phone`,`region_id`,`district`,`ward`,`street`,`nature_setlement`,`busines_name`,`busines_place`,`member_position`,`group_id`,`customer_id`,`comp_id`,`blanch_id`,`date_reg`) 
    //   VALUES ('".$member_name[$i]."','".$gender[$i]."','".$date_birth[$i]."','".$martial_status[$i]."','".$member_phone[$i]."','".$region_id[$i]."','".$district[$i]."','".$ward[$i]."','".$street[$i]."','".$nature_setlement[$i]."','".$busines_name[$i]."','".$busines_place[$i]."','".$member_position[$i]."','".$group_id[$i]."','".$customer_id[$i]."','".$comp_id[$i]."','".$blanch_id[$i]."','".$date_reg[$i]."')");
         
    //          }
                       
    //        }
    //    $this->session->set_flashdata('massage','Loan Application Sent Successfully');

                    
    //     }  
    //     return redirect("admin/loan_pending/");        
    // }



	public function salary_sheet(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$sheet = $this->queries->get_Allemployee_salary($comp_id);
		$total_salary = $this->queries->get_sum_salary($comp_id);
		  // print_r($total_salary);
		  //      exit();
		$this->load->view('admin/salary_sheet',['sheet'=>$sheet,'total_salary'=>$total_salary]);
	}


	public function print_salary_sheet(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
    $sheet = $this->queries->get_Allemployee_salary($comp_id);
	$total_salary = $this->queries->get_sum_salary($comp_id);
	$compdata = $this->queries->get_companyData($comp_id);
    $blanch = $this->queries->get_blanch($comp_id);
    // echo "<pre>";
    //  print_r($blanch);
    //       exit();
	$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
    $html = $this->load->view('admin/salary_sheet_report',['compdata'=>$compdata,'sheet'=>$sheet,'total_salary'=>$total_salary,'blanch'=>$blanch],true);
     $mpdf->SetFooter('Generated By Brainsoft Technology');
     $mpdf->WriteHTML($html);
     $mpdf->Output();
	}

	public function employee_allowance(){
		$this->load->model('queries');
    $comp_id = $this->session->userdata('comp_id');
    $employee = $this->queries->get_Allemployee_salary($comp_id);
    $all_alowance = $this->queries->get_all_allowance($comp_id);
       // print_r($all_alowance);
       //          exit();
		$this->load->view('admin/employee_allowance',['employee'=>$employee,'all_alowance'=>$all_alowance]);
	}

	public function create_allowance(){
		$this->form_validation->set_rules('empl_id','Employee','required');
		$this->form_validation->set_rules('new_amount','new amount','required');
		$this->form_validation->set_rules('remaks_allow','remaks allow','required');
		$this->form_validation->set_rules('comp_id','Company','required');
		$this->form_validation->set_rules('<div class="text-danger">','</div>');
		  if ($this->form_validation->run()) {
		  	$data = $this->input->post();
		  	$new_amount = $data['new_amount'];
		  	$empl_id = $data['empl_id'];
		  	 //  echo "<pre>";
		  	 // print_r($new_amount);
		  	 //    echo "<br>";
		  	 //    print_r($empl_id);
		  	 //     exit();
		  	$this->load->model('queries');
		  	if ($this->queries->insert_allowance($data)) {
		  	   $this->update_sallary($empl_id,$new_amount);
		  		$this->session->set_flashdata('massage','New Allowance Saved successfully');
		  	}else{

		  		$this->session->set_flashdata('error','Failed');
		  	}
		  	return redirect('admin/employee_allowance');
		  }
		  $this->employee_allowance();
	}


 public function update_sallary($empl_id,$new_amount){
  $sqldata="UPDATE `tbl_employee` SET `salary`= `salary`+$new_amount WHERE `empl_id`= '$empl_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}


public function modify_allowance($alow_id){
 $this->form_validation->set_rules('empl_id','Employee','required');
 $this->form_validation->set_rules('new_amount','new amount','required');
 $this->form_validation->set_rules('remaks_allow','remaks allow','required');
// $this->form_validation->set_rules('comp_id','Company','required');
 $this->form_validation->set_rules('<div class="text-danger">','</div>');
		  if ($this->form_validation->run()) {
		  	$data = $this->input->post();
		  	$new_amount = $data['new_amount'];
		  	$empl_id = $data['empl_id'];
		  	$remaks_allow = $data['remaks_allow'];
		  	 //  echo "<pre>";
		  	 // print_r($new_amount);
		  	 //    echo "<br>";
		  	 //    print_r($empl_id);
		  	 //    print_r($remaks_allow);
		  	 //     exit();
		  	$this->load->model('queries');
		  	if ($this->update_sallarydata($empl_id,$new_amount,$remaks_allow,$alow_id)) {
		  	   $this->update_sallary($empl_id,$new_amount);
		  		$this->session->set_flashdata('massage','New Allowance Updated successfully');
		  	}else{

		  		$this->session->set_flashdata('error','Failed');
		  	}
		  	return redirect('admin/employee_allowance');
		  }
		  $this->employee_allowance();	
	
}

 public function update_sallarydata($empl_id,$new_amount,$remaks_allow,$alow_id){
  $sqldata="UPDATE `tbl_new_allownce` SET `empl_id`='$empl_id',`new_amount`= `new_amount`+$new_amount,`remaks_allow`='$remaks_allow' WHERE `alow_id`= '$alow_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}


public function employee_deduction(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$employee = $this->queries->get_Allemployee_salary($comp_id);
	$all_deduction = $this->queries->get_deduction_empl($comp_id);
	$total_deduction = $this->queries->get_sumdeduction($comp_id);
	  //    echo "<pre>";
	  // print_r($total_deduction);
	  //          exit();
	$this->load->view('admin/employee_deduction',['employee'=>$employee,'all_deduction'=>$all_deduction,'total_deduction'=>$total_deduction]);
}


public function create_deduction(){
		$this->form_validation->set_rules('empl_id','Employee','required');
		$this->form_validation->set_rules('amount','amount','required');
		$this->form_validation->set_rules('description','description','required');
		$this->form_validation->set_rules('comp_id','Company','required');
		$this->form_validation->set_rules('<div class="text-danger">','</div>');
		  if ($this->form_validation->run()) {
		  	$data = $this->input->post();
		  	$amount = $data['amount'];
		  	$empl_id = $data['empl_id'];
		  	 //  echo "<pre>";
		  	 // print_r($amount);
		  	 //    echo "<br>";
		  	 //    print_r($empl_id);
		  	 //     exit();
		  	$this->load->model('queries');
		  	if ($this->queries->insert_deduction($data)) {
		  	   $this->update_sallary_mistake($empl_id,$amount);
		  		$this->session->set_flashdata('massage','Employee Deduction Saved successfully');
		  	}else{

		  		$this->session->set_flashdata('error','Failed');
		  	}
		  	return redirect('admin/employee_deduction');
		  }
		  $this->employee_deduction();
	}


public function update_sallary_mistake($empl_id,$amount){
  $sqldata="UPDATE `tbl_employee` SET `salary`= `salary`-$amount WHERE `empl_id`= '$empl_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
   return true;
}


public function expenses(){
$comp_id = $this->session->userdata('comp_id');
$this->load->model('queries');
$exp = $this->queries->get_expenses($comp_id);
  // print_r($exp);
  //       exit();
$this->load->view('admin/expenses',['exp'=>$exp]);
}

public function create_expenses(){
	$this->form_validation->set_rules('comp_id','company','required');
	$this->form_validation->set_rules('ex_name','expenses name','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
	if ($this->form_validation->run()) {
		 $data = $this->input->post();
		 //   echo "<pre>";
		 // print_r($data);
		 //      exit();
		 $this->load->model('queries');
		 if ($this->queries->insert_expenses($data)) {
		 	 $this->session->set_flashdata('massage','Expenses saved successfully');
		 }else{
		 	 $this->session->set_flashdata('error','Failed');

		 }
		 return redirect('admin/expenses');
	}
	$this->expenses();
}

public function modify_expences($ex_id){
	//$this->form_validation->set_rules('comp_id','company','required');
	$this->form_validation->set_rules('ex_name','expenses name','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
	if ($this->form_validation->run()) {
		 $data = $this->input->post();
		 //   echo "<pre>";
		 // print_r($data);
		 //      exit();
		 $this->load->model('queries');
		 if ($this->queries->update_expenses($data,$ex_id)) {
		 	 $this->session->set_flashdata('massage','Expenses Updated successfully');
		 }else{
		 	 $this->session->set_flashdata('error','Failed');

		 }
		 return redirect('admin/expenses');
	}
	$this->expenses();	
}

public function delete_expenses($ex_id){
	$this->load->model('queries');
	if($this->queries->remove_expenses($ex_id));
	$this->session->set_flashdata('massage','Expenses Deleted successfully');
	return redirect('admin/expenses');
}



public function expnses_requisition_form(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$expns = $this->queries->get_expenses($comp_id);
	$blanch = $this->queries->get_blanch($comp_id);
	   // print_r($expns);
	   //      exit();
    $this->load->view('admin/expenses_requisition',['expns'=>$expns,'blanch'=>$blanch]);
}

public function get_remove_expenses($req_id){
    $this->load->model('queries');
    $data_req = $this->queries->get_request_expenses($req_id);
    $type = $data_req->deduct_type;
    $blanch_id = $data_req->blanch_id;
    $req_amount = $data_req->req_amount;
    // print_r($req_amount);
    //         exit();

        $deducted_income = $this->queries->get_deducted_income_blanch($blanch_id);
        $deducted = $deducted_income->total_deducted;
    
        $expenses_deducted = $deducted + $req_amount;

        $non_deductedIncome = $this->queries->get_non_deducted_income_blanch($blanch_id);
        $non_income = $non_deductedIncome->total_nonbalance;

        $expenses_non = $non_income + $req_amount;

    
    if ($type == 'deducted') {
      $this->update_expenses_income_deducted($blanch_id,$expenses_deducted);
      $this->delete_request_data($req_id);
      $this->session->set_flashdata("massage",'Expenses Deleted Successfully');
    }elseif ($type == 'non deducted') {
    $this->update_income_nonbalance($blanch_id,$expenses_non);
    $this->delete_request_data($req_id);
    $this->session->set_flashdata("massage",'Expenses Deleted Successfully');
    }
    
    return redirect("admin/get_recomended_request");
}

public function delete_request_data($req_id){
 return $this->db->delete('tbl_request_exp',['req_id'=>$req_id]);
}



public function create_requstion_form(){
    $this->load->model('queries');
    $this->form_validation->set_rules('comp_id','company','required');
    $this->form_validation->set_rules('blanch_id','blanch','required');
    $this->form_validation->set_rules('req_description','description','required');
    $this->form_validation->set_rules('req_amount','Amount','required');
    //$this->form_validation->set_rules('empl_id','Employee','required');
    $this->form_validation->set_rules('req_date','req_date','required');
    $this->form_validation->set_rules('deduct_type','type','required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

    if ($this->form_validation->run()) {
        $data = $this->input->post();
        //    echo "<pre>";
        // print_r($data);
        //     exit();
        $comp_id = $data['comp_id'];
        $blanch_id = $data['blanch_id'];
        $deduct_type = $data['deduct_type'];
        $req_amount = $data['req_amount'];
        
        $deducted_income = $this->queries->get_deducted_income_blanch($blanch_id);
        $deducted = $deducted_income->total_deducted;
    
        $expenses_deducted = $deducted - $req_amount;

        $non_deductedIncome = $this->queries->get_non_deducted_income_blanch($blanch_id);
        $non_income = $non_deductedIncome->total_nonbalance;

        $expenses_non = $non_income - $req_amount;

        if ($deduct_type == 'deducted') {
           if ($deducted < $req_amount) {
            $this->session->set_flashdata("error",'You don`t Have Enough Balance');
            return redirect('admin/expnses_requisition_form');
           }else{
            $this->update_expenses_income_deducted($blanch_id,$expenses_deducted);
            $this->queries->insert_reques_expenses($data);
            $this->session->set_flashdata("massage",'Expenses Request Successfully');
           }

        }elseif ($deduct_type == 'non deducted') {
            if ($non_income < $req_amount) {
             $this->session->set_flashdata("error",'You don`t Have Enough Balance');
            return redirect('admin/expnses_requisition_form'); 
            }else{
                $this->update_income_nonbalance($blanch_id,$expenses_non);
                $this->queries->insert_reques_expenses($data);
                $this->session->set_flashdata("massage",'Expenses Request Successfully');
            }
        }
        return redirect("admin/expnses_requisition_form");
    }
    $this->expnses_requisition_form();
}

public function update_expenses_income_deducted($blanch_id,$expenses_deducted){
    $sqldata="UPDATE `tbl_receive_deducted` SET `deducted`= '$expenses_deducted' WHERE `blanch_id`= '$blanch_id'";
      $query = $this->db->query($sqldata);
      return true;
}

public function update_income_nonbalance($blanch_id,$expenses_non){
   $sqldata="UPDATE `tbl_receive_non_deducted` SET `non_balance`= '$expenses_non' WHERE `blanch_id`= '$blanch_id'";
      $query = $this->db->query($sqldata);
      return true; 
}


  function fetch_account_blanch()
{
$this->load->model('queries');
if($this->input->post('blanch_id'))
{
echo $this->queries->fetch_acount($this->input->post('blanch_id'));
}

}


  public function insert_expenses_request($comp_id,$blanch_id,$ex_id,$req_description,$req_amount,$trans_id){
   $date = date("Y-m-d");
  $this->db->query("INSERT INTO tbl_request_exp (`comp_id`,`blanch_id`,`ex_id`,`req_description`,`req_amount`,`req_date`,`trans_id`) VALUES ('$comp_id','$blanch_id','$ex_id','$req_description','$req_amount','$date','$trans_id')");	
  }

  public function update_blanch_account_balance($comp_id,$blanch_id,$trans_id,$remain_blanch_remain){
  $sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`= '$remain_blanch_remain' WHERE `blanch_id`= '$blanch_id' AND `receive_trans_id` = '$trans_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
  return true;
  }



   


    public function get_recomended_request(){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
    	$data = $this->queries->get_expences_request($comp_id);
    	$blanch = $this->queries->get_blanch($comp_id);
    	$tota_exp = $this->queries->get_sum_expences($comp_id);
    	$account = $this->queries->get_account_transaction($comp_id);
    	  //    echo "<pre>";
    	  // print_r($account);
    	  //        exit();
    	$this->load->view('admin/recomended_request',['data'=>$data,'blanch'=>$blanch,'tota_exp'=>$tota_exp,'account'=>$account]);
    }
   

   public function get_expences_notAcceptable(){
   	$this->load->model('queries');
   	$comp_id = $this->session->userdata('comp_id');
   	$data = $this->queries->get_expences_requestNotDone($comp_id);
    $blanch = $this->queries->get_blanch($comp_id);
    $tota_exp = $this->queries->get_sum_expencesnotAccept($comp_id);
    $account = $this->queries->get_account_transaction($comp_id);
     // print_r($data);
     //      exit();
   	$this->load->view('admin/exp_notAccept',['data'=>$data,'blanch'=>$blanch,'tota_exp'=>$tota_exp,'account'=>$account]);
   }



  public function print_all_request(){
 $this->load->model('queries');
$comp_id = $this->session->userdata('comp_id');
$data = $this->queries->get_expences_requestAccepted($comp_id);
$blanch = $this->queries->get_blanch($comp_id);
$tota_exp = $this->queries->get_sum_expences($comp_id);
$compdata = $this->queries->get_companyData($comp_id);

  // print_r($data);
  //      exit();
 $mpdf = new \Mpdf\Mpdf();
 $html = $this->load->view('admin/print_all_expences',['data'=>$data,'blanch'=>$blanch,'tota_exp'=>$tota_exp,'compdata'=>$compdata],true);
 $mpdf->SetFooter('Generated By Brainsoft Technology');
 $mpdf->WriteHTML($html);
 $mpdf->Output(); 	
}


    public function get_expnces_blanch(){
    	$this->load->model('queries');
    	$comp_id = $this->session->userdata('comp_id');
    	$blanch_id = $this->input->post('blanch_id');
        //$comp_id = $this->input->post('comp_id');
    	$data = $this->queries->get_expences_blanch($blanch_id);
    	$blanch = $this->queries->get_blanchd($comp_id);
    	$total_exp = $this->queries->get_sum_expencesBlanch($blanch_id);
    	  //  echo "<pre>";
    	  // print_r($data);
    	  //      exit();
    	$this->load->view('admin/blanch_expences',['data'=>$data,'blanch'=>$blanch,'total_exp'=>$total_exp]);
    }


   public function expenses_request_accept($req_id){
   	$this->load->model('queries');
   	$req = $this->queries->get_get_updated_request($req_id);
   	 $blanch_id = $req->blanch_id;
   	 $comp_id = $req->comp_id;
   	    // print_r($blanch_id);
   	    //         exit();
          //Prepare array of user data
    	$day = date('Y-m-d');
            $data = array(
            'req_comment'=> $this->input->post('req_comment'),
            'req_amount'=> $this->input->post('req_amount'),
            'trans_id'=> $this->input->post('trans_id'),
            'req_status'=> 'accept',
            'req_date' => $day,
           
            );

            $req_amount = $data['req_amount'];
            $trans_id = $data['trans_id'];
          
            //Pass user data to model
           $this->load->model('queries');
           $accept_balance = $this->queries->get_blanch_accountExpenses($blanch_id,$trans_id);
           $blanch_balance = @$accept_balance->blanch_capital;

           $removed_expences = $blanch_balance - $req_amount;

              // print_r($removed_expences);
              //  exit();
              if ($blanch_balance == TRUE) {
               if ($blanch_balance < $req_amount) {
               	$this->session->set_flashdata("error",'Balance Amount is not Enough');
               }else{
            $data = $this->queries->update_requet_status($req_id,$data);
            //Storing insertion status message.
            if($data){
            	$this->withdraw_expences($blanch_id,$trans_id,$removed_expences);
            	//$this->withdraw_expencesCompbalance($comp_id,$req_amount);
                $this->session->set_flashdata('massage','Expenses Accepted successfully');
            }
            }
        }elseif ($blanch_balance == FALSE) {
         $this->session->set_flashdata("error",'Selected Account Doesnot Exist');	
        }
              
            return redirect('admin/get_expences_notAcceptable');
	     }

	public function withdraw_expences($blanch_id,$trans_id,$removed_expences){
  $sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`= '$removed_expences' WHERE `blanch_id`= '$blanch_id' AND `receive_trans_id`='$trans_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
  return true;
}


	public function withdraw_expencesCompbalance($comp_id,$req_amount){
  $sqldata="UPDATE `tbl_ac_company` SET `comp_balance`= `comp_balance`-$req_amount WHERE `comp_id`= '$comp_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
  return true;
}

	public function delete_expences($req_id){
		$this->load->model('queries');
		$rejected = $this->queries->get_expenses_reject($req_id);
		$blanch_id = $rejected->blanch_id;
		$req_amount = $rejected->req_amount;
		$trans_id = $rejected->trans_id;
		$comp_id = $rejected->comp_id;
       
       $blanch_account = $this->queries->get_blanch_balance_expenses($blanch_id,$trans_id);
       $blanch_capital = $blanch_account->blanch_capital;

       $return_balance = $blanch_capital + $req_amount;

		// echo "<pre>";
		// print_r($return_balance);
		//      exit();
		 $this->update_account_balance_remain_data($comp_id,$blanch_id,$trans_id,$return_balance);
		if($this->queries->remove_expences($req_id));
		$this->session->set_flashdata('massage','Expenses rejected successfully');
		return redirect('admin/get_recomended_request');
	}

	public function update_account_balance_remain_data($comp_id,$blanch_id,$trans_id,$return_balance){
	$sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`= '$return_balance' WHERE `blanch_id`= '$blanch_id' AND `receive_trans_id`='$trans_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
  return true;	
	}

	public function income_detail(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$income = $this->queries->get_income($comp_id);
		   // print_r($income);
		   //      exit();
		$this->load->view('admin/income',['income'=>$income]);
	}

	public function create_income(){
		$this->form_validation->set_rules('inc_name','income','required');
		$this->form_validation->set_rules('comp_id','company','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			  $data = $this->input->post();
			    // echo "<pre>";
			  // print_r($data);
			  //       exit();
			  $this->load->model('queries');
			  if ($this->queries->insert_income($data)) {
			  	   $this->session->set_flashdata('massage','Income Data Saved successfully');
			  }else{
			  	 $this->session->set_flashdata('error','Failed');

			  }

			  return redirect('admin/income_detail');
		}
		$this->income_detail();
	}

		public function modify_income($inc_id){
		$this->form_validation->set_rules('inc_name','income','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			   $data = $this->input->post();
			  //    echo "<pre>";
			  // print_r($data);
			  //       exit();
			  $this->load->model('queries');
			  if ($this->queries->update_income($data,$inc_id)) {
			  	   $this->session->set_flashdata('massage','Income Data Updated successfully');
			  }else{
			  	 $this->session->set_flashdata('error','Failed');

			  }

			  return redirect('admin/income_detail');
		}
		$this->income_detail();
	}

	public function delete_income($inc_id){
		$this->load->model('queries');
		if($this->queries->remove_income($inc_id));
		$this->session->set_flashdata('massage','Income data Deleted successfully');
		return redirect('admin/income_detail');
	}


	public function income_dashboard(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$income = $this->queries->get_income($comp_id);
		$detail_income = $this->queries->get_income_detail($comp_id);
		$total_receved = $this->queries->get_sum_income($comp_id);
		$customer = $this->queries->get_allcutomer($comp_id);
		$blanch = $this->queries->get_blanch($comp_id);
		 // echo "<pre>";
		 //   print_r($blanch);
		 //         exit();
		$this->load->view('admin/income_dashboard',['income'=>$income,'detail_income'=>$detail_income,'total_receved'=>$total_receved,'customer'=>$customer,'blanch'=>$blanch]);
	}


	public function income_balance(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$blanch_summary = $this->queries->get_totaldeducted_blanch($comp_id);
		$blanch_summary_nonDeduected = $this->queries->get_nondeducted_blanch($comp_id);
		$total_deducted_balance = $this->queries->getTotal_deducted($comp_id);
		$total_non = $this->queries->getTotal_deductednon($comp_id);
		//  echo "<pre>";
		// print_r($total_non);
		//       exit();
		$this->load->view('admin/income_balance',['blanch_summary'=>$blanch_summary,'total_deducted_balance'=>$total_deducted_balance,'blanch_summary_nonDeduected'=>$blanch_summary_nonDeduected,'total_non'=>$total_non]);
	}


	    public function delete_receved($receved_id){
        $this->load->model('queries');
        $data_receive = $this->queries->income_receive_delete($receved_id);
        $loan_id = $data_receive->loan_id;
        $receve_amount = $data_receive->receve_amount;
        $blanch_id = $data_receive->blanch_id;

        $pay_penart = $this->queries->get_data_paypenart($loan_id);
        $penart_paid = @$pay_penart->penart_paid;

        $remove_receive = @$penart_paid - $receve_amount;

        $received_non = $this->queries->get_receive_nonDeducted($blanch_id);
        $non_balance = $received_non->non_balance;

        $remain_receive = $non_balance - $receve_amount;

       $this->remove_nondeducted_blanch_accout($blanch_id,$remain_receive);
       $this->remove_paid_penart_loan($loan_id,$remove_receive);
        //    echo "<pre>";
        // print_r($remain_receive);
        //     exit();
        if($this->queries->remove_receved($receved_id));
        $this->session->set_flashdata('massage','Data Deleted successfully');
        return redirect('admin/income_dashboard');
    }



    public function delete_receved_prev($receved_id){
        $this->load->model('queries');
        $data_receive = $this->queries->income_receive_delete($receved_id);
        $loan_id = $data_receive->loan_id;
        $receve_amount = $data_receive->receve_amount;
        $blanch_id = $data_receive->blanch_id;

        $pay_penart = $this->queries->get_data_paypenart($loan_id);
        $penart_paid = @$pay_penart->penart_paid;

        $remove_receive = @$penart_paid - $receve_amount;

        $received_non = $this->queries->get_receive_nonDeducted($blanch_id);
        $non_balance = $received_non->non_balance;

        $remain_receive = $non_balance - $receve_amount;

       $this->remove_nondeducted_blanch_accout($blanch_id,$remain_receive);
       $this->remove_paid_penart_loan($loan_id,$remove_receive);
        //    echo "<pre>";
        // print_r($remain_receive);
        //     exit();
        if($this->queries->remove_receved($receved_id));
        $this->session->set_flashdata('massage','Data Deleted successfully');
        return redirect('admin/previous_income');
    }


    public function remove_paid_penart_loan($loan_id,$remove_receive){
    $sqldata="UPDATE `tbl_pay_penart` SET `penart_paid`= '$remove_receive' WHERE `loan_id`= '$loan_id'";
    $query = $this->db->query($sqldata);
    return true;    
    }


    public function remove_nondeducted_blanch_accout($blanch_id,$remain_receive){
    $sqldata="UPDATE `tbl_receive_non_deducted` SET `non_balance`= '$remain_receive' WHERE `blanch_id`= '$blanch_id'";
    $query = $this->db->query($sqldata);
    return true;   
    }



//out data

function fetch_ward_data()
{
$this->load->model('queries');
if($this->input->post('blanch_id'))
{
echo $this->queries->fetch_eneos($this->input->post('blanch_id'));
}
}

function fetch_data_vipimioData()
{
$this->load->model('queries');
if($this->input->post('customer_id'))
{
echo $this->queries->fetch_vipmios($this->input->post('customer_id'));
}
}


function fetch_shedure_loan()
{
$this->load->model('queries');
if($this->input->post('customer_id'))
{
echo $this->queries->fetch_loancustomer($this->input->post('customer_id'));
}
}




// function fetch_data_malipo()
// {
// $this->load->model('queries');
// if($this->input->post('sc_id'))
// {
// echo $this->queries->fetch_malipo($this->input->post('sc_id'));
// }
// }


	public function search_income_inBlanch(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$blanch_id = $this->input->post('blanch_id');
		$receve_day = $this->input->post('receve_day');
		$blanch_income = $this->queries->get_blanchIncome($blanch_id,$receve_day);
		$blanch = $this->queries->get_blanch($comp_id);
		$sum_income = $this->queries->get_sum_incomeBlanchData($blanch_id);
		 //  echo "<pre>";
		 // print_r($sum_income);
		 //            exit();
		$this->load->view('admin/income_blanch',['blanch_income'=>$blanch_income,'blanch'=>$blanch,'sum_income'=>$sum_income,'blanch_id'=>$blanch_id,'receve_day'=>$receve_day]);
	}



	public function print_todayIncome(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
        $compdata = $this->queries->get_companyData($comp_id);
        $income = $this->queries->get_income($comp_id);
		$detail_income = $this->queries->get_income_detail($comp_id);
		$total_receved = $this->queries->get_sum_income($comp_id);
		$mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('admin/today_income_report',['compdata'=>$compdata,'income'=>$income,'detail_income'=>$detail_income,'total_receved'=>$total_receved],true);
        $mpdf->SetFooter('Generated By Brainsoft Technology');
        $mpdf->WriteHTML($html);
        $mpdf->Output(); 
	}


	public function print_blanch_income($blanch_id,$receve_day){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$compdata = $this->queries->get_companyData($comp_id);
        $blanch_data = $this->queries->get_blanch_data($blanch_id);
        $blanch_income = $this->queries->get_blanchDataIncome($blanch_id,$receve_day);
		$sum_income = $this->queries->get_sum_incomeBlanchData($blanch_id);
		     //     echo "<pre>";
		     // print_r($blanch_income);
		     //         exit();
		$mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('admin/print_blanch_income',['compdata'=>$compdata,'blanch_income'=>$blanch_income,'sum_income'=>$sum_income,'blanch_data'=>$blanch_data],true);
        $mpdf->SetFooter('Generated By Brainsoft Technology');
        $mpdf->WriteHTML($html);
        $mpdf->Output(); 
      //$this->load->view('admin/print_blanch_income');
	}


	public function previous_income(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$blanch = $this->queries->get_blanch($comp_id);
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $blanch_id = $this->input->post('blanch_id');
        $comp_id = $this->input->post('comp_id');

         if ($blanch_id == 'all') {
        $data = $this->queries->get_previous_income_all($from,$to,$comp_id);
        $sum_income = $this->queries->get_sum_previousIncome_COMP($from,$to,$comp_id);
         }else{
        $data = $this->queries->get_previous_income($from,$to,$comp_id,$blanch_id);
        $sum_income = $this->queries->get_sum_previousIncome_blanch($from,$to,$comp_id,$blanch_id);
          }
       
        $blanch_data = $this->queries->get_blanch_data($blanch_id);

          //   echo "<pre>";
          // print_r($data);
          //     exit();
		$this->load->view('admin/previous_income',['data'=>$data,'sum_income'=>$sum_income,'from'=>$from,'to'=>$to,'comp_id'=>$comp_id,'blanch_id'=>$blanch_id,'blanch'=>$blanch,'blanch_data'=>$blanch_data]);
	}

	public function print_previous_report($from,$to,$comp_id,$blanch_id){
	  $this->load->model('queries');
      $compdata = $this->queries->get_companyData($comp_id);
	    if ($blanch_id == 'all') {
        $data = $this->queries->get_previous_income_all($from,$to,$comp_id);
        $sum_income = $this->queries->get_sum_previousIncome_COMP($from,$to,$comp_id);
         }else{
        $data = $this->queries->get_previous_income($from,$to,$comp_id,$blanch_id);
        $sum_income = $this->queries->get_sum_previousIncome_blanch($from,$to,$comp_id,$blanch_id);
          }
       
        $blanch_data = $this->queries->get_blanch_data($blanch_id);
        //      echo "<pre>";
        // print_r($blanch);
        //        exit();
      $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
      $html = $this->load->view('admin/previous_income_report',['compdata'=>$compdata,'data'=>$data,'sum_income'=>$sum_income,'from'=>$from,'to'=>$to,'blanch_data'=>$blanch_data],true);
      $mpdf->SetFooter('Generated By Brainsoft Technology');
      $mpdf->WriteHTML($html);
      $mpdf->Output();
	}

  public function all_previous_income(){
  	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
    $from = $this->input->post('from');
    $to = $this->input->post('to');
    $comp_id = $this->input->post('comp_id');
    $data = $this->queries->get_previous_incomeAll($from,$to,$comp_id);
    $sum_income = $this->queries->get_sum_previousIncomeAll($from,$to,$comp_id);
    $this->load->view('admin/all_blanch_income',['data'=>$data,'sum_income'=>$sum_income,'from'=>$from,'to'=>$to,'comp_id'=>$comp_id]);
  }

  	public function print_previous_reportAll($from,$to,$comp_id){
	  $this->load->model('queries');
      $compdata = $this->queries->get_companyData($comp_id);
	  $data = $this->queries->get_previous_incomeAll($from,$to,$comp_id);
      $sum_income = $this->queries->get_sum_previousIncomeAll($from,$to,$comp_id);
      $mpdf = new \Mpdf\Mpdf();
      $html = $this->load->view('admin/previous_income_reportAll',['compdata'=>$compdata,'data'=>$data,'sum_income'=>$sum_income,'from'=>$from,'to'=>$to],true);
      $mpdf->SetFooter('Generated By Brainsoft Technology');
      $mpdf->WriteHTML($html);
      $mpdf->Output();
	}


	public function create_income_detail(){
		$this->form_validation->set_rules('comp_id','company','required');
		$this->form_validation->set_rules('blanch_id','company','required');
		$this->form_validation->set_rules('customer_id','company','required');
		$this->form_validation->set_rules('inc_id','Income','required');
		$this->form_validation->set_rules('receve_amount','Amount','required');
		$this->form_validation->set_rules('receve_day','company','required');
		//$this->form_validation->set_rules('empl','employee','required');
		$this->form_validation->set_rules('loan_id','Loan','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			 $data = $this->input->post();

			 
			 // echo "<pre>";
			 // print_r($data);
			 //       exit();
			 $this->load->model('queries');
			 $blanch_id = $data['blanch_id'];
			 //$blanch_id = $data['blanch_id'];
      		$loan_id = $data['loan_id'];
      		$comp_id = $data['comp_id'];
      		$penart_paid = $data['receve_amount'];
      		//$username = $data['empl'];
      		$customer_id = $data['customer_id'];
      		$penart_date = $data['receve_day'];
			 $receve_amount = $data['receve_amount'];
			 @$blanch_account = $this->queries->get_blanchAccountremain($blanch_id);
			 $old_balance = @$blanch_account->blanch_capital;
			 $total_new = $old_balance + $receve_amount;
			 $inc_id = $data['inc_id'];
			 $income_data = $this->queries->get_income_data($inc_id);
			 $income_name = $income_data->inc_name;
			 $alphabet = $income_name;
			 $penart = $this->queries->get_paidPenart($loan_id);

			 $loan_income = $this->queries->get_loan_income($loan_id);
			 $group_id = $loan_income->group_id;
			 $empl_id = $loan_income->empl_id;
			 $username = $empl_id;


		$company = $this->queries->get_comp_data($comp_id);
        $comp_name = $company->comp_name;
        $comp_phone = $company->comp_phone;
        
        $data_sms = $this->queries->get_loan_reminder($customer_id);
        $phone = $data_sms->phone_no;
        $first_name = $data_sms->f_name;
        $midle_name = $data_sms->m_name;
        $last_name = $data_sms->l_name;
        $massage = 'Ndugu, ' .$first_name . ' ' .$midle_name . ' ' .$last_name . ' ' .'Umelipa faini ya Tsh.'. number_format($penart_paid) . ' '.$comp_name .' kwa msaada 0679420326 / 0629364847';
			 // print_r($username);
			 //     exit();
             
             @$non_deducted = $this->queries->check_nonDeducted_balance($comp_id,$blanch_id);
              $deducted_blanch = @$non_deducted->blanch_id;
              $deducted_balance = @$non_deducted->non_balance;
              $another_deducted = $deducted_balance + $receve_amount;
              // print_r($another_deducted);
              //            exit();

              if ($deducted_blanch == TRUE) {
               $this->update_nonDeducted_balance($comp_id,$blanch_id,$another_deducted);
              	//echo "update";
              }else{

             $this->insert_non_deducted_balance($comp_id,$blanch_id,$receve_amount);
              	//echo "ingiza";
              }
			 //  echo "<pre>";
			 // print_r($penart);
			 //           exit();
			     if($alphabet == 'Penart'|| $alphabet == 'PENART' || $alphabet == 'penart'|| $alphabet == 'faini' || $alphabet == 'FAINI' || $alphabet == 'Faini' || $alphabet == 'fine' || $alphabet == 'FAINI KULALA' || $alphabet == 'faini kulala' || $alphabet == 'Faini kulala' || $alphabet == 'FAINI (PENALTY)' || $alphabet == 'penalt' || $alphabet == 'PENALT' || $alphabet == 'FAINI LALA' || $alphabet == 'PENATI' || $alphabet == 'penati' || $alphabet == 'Penati' || $alphabet == 'Adhabu' || $alphabet == 'ADHABU' || $alphabet == 'adhabu' || $alphabet == 'PENALTY' || $alphabet == 'Penarty' || $alphabet == 'penarty') {
			     	if ($penart == TRUE) {
			     $old_paid = $penart->penart_paid;
      			$update_paid = $old_paid + $penart_paid;
      			$this->update_paidPenart($loan_id,$update_paid);
      			$this->insert_income($comp_id,$inc_id,$blanch_id,$customer_id,$username,$penart_paid,$penart_date,$loan_id,$group_id);
      			$this->session->set_flashdata('massage','Tsh. '.$penart_paid .' Paid successfully');
      			$this->sendsms($phone,$massage);
			     	}elseif($penart == FALSE){
			     $this->insert_income($comp_id,$inc_id,$blanch_id,$customer_id,$username,$penart_paid,$penart_date,$loan_id,$group_id);
                 $this->insert_penartPaid($loan_id,$inc_id,$blanch_id,$comp_id,$penart_paid,$username,$customer_id,$penart_date,$group_id);
                 $this->sendsms($phone,$massage);
                 $this->session->set_flashdata('massage','Tsh. '.$penart_paid .' Paid successfully');

			     		}
			     
			     }else{	
			  $this->insert_income($comp_id,$inc_id,$blanch_id,$customer_id,$username,$penart_paid,$penart_date,$loan_id,$group_id);
			  $this->sendsms($phone,$massage);
			  $this->session->set_flashdata('massage','Tsh. '.$penart_paid .' Paid successfully');
			     }
			  // //print_r($alphabet);
			  //      exit();

			 return redirect('admin/income_dashboard');
		}
		$this->income_dashboard();
	}

//insert non-deducted
	public function insert_non_deducted_balance($comp_id,$blanch_id,$receve_amount){
    $this->db->query("INSERT INTO tbl_receive_non_deducted (`comp_id`,`blanch_id`,`non_balance`) VALUES ('$comp_id','$blanch_id','$receve_amount')");
	}

public function update_nonDeducted_balance($comp_id,$blanch_id,$another_deducted){
$sqldata="UPDATE `tbl_receive_non_deducted` SET `non_balance`= '$another_deducted' WHERE `blanch_id`= '$blanch_id'";
$query = $this->db->query($sqldata);
return true;	
}


	 public function insert_blanchAccount_income($blanch_id,$total_new){
  $sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`= '$total_new' WHERE `blanch_id`= '$blanch_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
  return true;
}


		public function modify_income_detail($receved_id){
		$this->form_validation->set_rules('inc_id','Income','required');
		$this->form_validation->set_rules('customer_id','customer','required');
		$this->form_validation->set_rules('receve_amount','Amount','required');
		$this->form_validation->set_rules('loan_id','loan_id','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			 $data = $this->input->post();
			 $loan_id = $data['loan_id'];
			 $update_paid = $data['receve_amount'];
			  //  echo "<pre>";
			  // print_r($loan_id);
			  //      exit();
			 $this->load->model('queries');
			 if ($this->queries->update_income_detail($data,$receved_id)) {
			 	  $this->update_paidPenart($loan_id,$update_paid);
			 	  $this->session->set_flashdata('massage','Income Updated successfully');
			 }else{
			 $this->session->set_flashdata('error','Failed');	
			 }
			 return redirect('admin/income_dashboard');
		}
		$this->income_dashboard();
	}

	// public function delete_receved($receved_id){
	// 	$this->load->model('queries');
	// 	if($this->queries->remove_receved($receved_id));
	// 	$this->session->set_flashdata('massage','Data Deleted successfully');
	// 	return redirect('admin/income_dashboard');
	// }

	public function print_general_report(){
    $this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
    $compdata = $this->queries->get_companyData($comp_id);  
    $capital = $this->queries->get_capital($comp_id);
	$total_capital = $this->queries->get_total_capital($comp_id);
	$total_expect = $this->queries->get_loanExpectation($comp_id);
	$out_float = $this->queries->get_with_done_principal($comp_id);
	$sum_depost_loan = $this->queries->get_total_loanDepost($comp_id);
	$sum_total_loanInt = $this->queries->get_sumtotal_interest($comp_id);
	$sum_total_comp_income = $this->queries->get_sum_Comp_income($comp_id);
	$total_loanFee = $this->queries->get_total_loanFee($comp_id);
	$total_expences = $this->queries->get_sum_requestExpences($comp_id);
    
    $sum_income = $this->queries->get_sum_IncomeData($comp_id);
    $fee = $this->queries->get_total_loanFeeData($comp_id);
    $exp = $this->queries->get_total_ExpencesData($comp_id);
    $cash_bank = $this->queries->get_sum_cashInHandcomp($comp_id);
    $active_loan = $this->queries->get_total_active($comp_id);

    $cash_depost = $this->queries->get_today_chashData_Comp($comp_id);
    $cash_income = $this->queries->get_today_incomeBlanchDataComp($comp_id);
    $cash_expences = $this->queries->get_today_expencesDataComp($comp_id);
    $bad_debts = $this->queries->total_outstand_loan($comp_id);

        $loanAprove = $this->queries->get_loan_aprove($comp_id);
        $withdrawal = $this->queries->get_total_withAmount($comp_id);
        $loan_depost = $this->queries->get_totalDepost($comp_id);
        $receive_Amount = $this->queries->get_sumReceve($comp_id);
        $loan_fee = $this->queries->get_total_loanFee($comp_id);
        $request_expences = $this->queries->get_expencesData($comp_id);

      //     echo "<pre>";
      // print_r($total_expect);
      //           exit();

    $mpdf = new \Mpdf\Mpdf();
    $html = $this->load->view('admin/general_report',['compdata'=>$compdata,'total_capital'=>$total_capital,'total_expect'=>$total_expect,'total_expect'=>$total_expect,'out_float'=>$out_float,'sum_depost_loan'=>$sum_depost_loan,'sum_total_loanInt'=>$sum_total_loanInt,'sum_total_comp_income'=>$sum_total_comp_income,'total_loanFee'=>$total_loanFee,'total_expences'=>$total_expences,'sum_income'=>$sum_income,'fee'=>$fee,'exp'=>$exp,'cash_bank'=>$cash_bank,'active_loan'=>$active_loan,'cash_depost'=>$cash_depost,'cash_income'=>$cash_income,'cash_expences'=>$cash_expences,'bad_debts'=>$bad_debts,'loanAprove'=>$loanAprove,'withdrawal'=>$withdrawal,'loan_depost'=>$loan_depost,'receive_Amount'=>$receive_Amount,'loan_fee'=>$loan_fee,'request_expences'=>$request_expences],true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
    $mpdf->WriteHTML($html);
    $mpdf->Output(); 
	}
   

   public function get_blanch_report(){
   	$this->load->model('queries');
   	$comp_id = $this->session->userdata('comp_id');
   	$blanch = $this->queries->get_blanch($comp_id);
   	 // print_r($blanch);
   	 //     exit();
   	$this->load->view('admin/blanch_general_report',['blanch'=>$blanch]);
   }

   public function print_general_reportBlanch($blanch_id){
   	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
    $compdata = $this->queries->get_companyData($comp_id);
    $total_capital = $this->queries->get_blanch_wallet($blanch_id);
    $principal = $this->queries->get_total_principalBlanch($blanch_id);
    $interst_principal = $this->queries->get_loanExpectationBlanch($blanch_id);
    $loan_return = $this->queries->get_totalLoanRepaymentBlanch($blanch_id);
    $out_stand = $this->queries->total_outstand_Blanch($blanch_id);
    $total_interest = $this->queries->get_sumtotal_interestBlanch($blanch_id);
    $blanch_income = $this->queries->get_sum_Comp_incomeBlanch($blanch_id);
    $blanch_fee = $this->queries->get_total_loanFeeBlanch($blanch_id);
    $blanch_expences = $this->queries->get_sum_requestExpencesBlanch($blanch_id);
    $sum_income = $this->queries->get_sum_IncomeDataBlanch($blanch_id);
    $fee = $this->queries->get_total_loanFeeDataBlanch($blanch_id);
    $exp = $this->queries->get_total_ExpencesDataBlanch($blanch_id);
    $blanch_data = $this->queries->get_blanch_data($blanch_id);


    //opening
     $loanAprove = $this->queries->get_loan_aproveBlanch($blanch_id);
     $withdrawal = $this->queries->get_total_withAmountBlanch($blanch_id);
     $loan_depost = $this->queries->get_totalDepostBlanch($blanch_id);
     $receive_Amount = $this->queries->get_sumReceveBlanch($blanch_id);
     $loan_fee = $this->queries->get_total_loanFeeBlanchOpen($blanch_id);
     $request_expences = $this->queries->get_expencesDataBlanch($blanch_id);

       // print_r($out_stand);
       //           exit();
    $mpdf = new \Mpdf\Mpdf();
    $html = $this->load->view('admin/blanch_generalPdf',['compdata'=>$compdata,'total_capital'=>$total_capital,'principal'=>$principal,'interst_principal'=>$interst_principal,'loan_return'=>$loan_return,'out_stand'=>$out_stand,'total_interest'=>$total_interest,'blanch_income'=>$blanch_income,'blanch_fee'=>$blanch_fee,'blanch_expences'=>$blanch_expences,'sum_income'=>$sum_income,'fee'=>$fee,'exp'=>$exp,'blanch_data'=>$blanch_data,'loanAprove'=>$loanAprove,'withdrawal'=>$withdrawal,'loan_depost'=>$loan_depost,'receive_Amount'=>$receive_Amount,'loan_fee'=>$loan_fee,'request_expences'=>$request_expences],true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
    $mpdf->WriteHTML($html);
    $mpdf->Output();  	
 
	}
   





   
   public function penart_setting(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$penart = $this->queries->get_penarty($comp_id);
		  //     echo "<pre>";
		  // print_r($penart);
		  //       exit();
		$this->load->view('admin/penart_setting',['penart'=>$penart]);
	}

	public function create_penarty(){
		$this->form_validation->set_rules('comp_id','company','required');
		$this->form_validation->set_rules('action_penart','action penart','required');
		$this->form_validation->set_rules('penart','penart','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			   $data = $this->input->post();
			     //  echo "<pre>";
			     // print_r($data);
			     //     exit();
			   $this->load->model('queries');
			   if($this->queries->insert_penarty($data)) {
			   	   $this->session->set_flashdata('massage','Penalt setting saved successfully');
			   }else{
			   	$this->session->set_flashdata('error','Failed');
			   }
			   return redirect('admin/penart_setting');
		}
		$this->penart_setting();
	}


	public function modify_penart($penalt_id){
		$this->form_validation->set_rules('action_penart','action penart','required');
		$this->form_validation->set_rules('penart','penart','required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
		if ($this->form_validation->run()) {
			   $data = $this->input->post();
			     //  echo "<pre>";
			     // print_r($data);
			     //      exit();
			   $this->load->model('queries');
			   if($this->queries->update_penarty($data,$penalt_id)) {
			   	   $this->session->set_flashdata('massage','Penalt setting Updated successfully');
			   }else{
			   	$this->session->set_flashdata('error','Failed');
			   }
			   return redirect('admin/penart_setting');
		}
		$this->penart_setting();
	}

	public function delete_penart($penalt_id){
		$this->load->model('queries');
		if($this->queries->remove_penart($penalt_id));
		$this->session->set_flashdata('massage','Data Deleted successfully');
		return redirect('admin/penart_setting');
	}

	public function today_recevable_loan(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$today_recevable = $this->queries->get_today_recevable_loan($comp_id);
		$rejesho = $this->queries->get_total_recevable($comp_id);

		$employee = $this->queries->get_today_recevable_employee($comp_id);
		$blanch = $this->queries->get_blanch($comp_id);
		  //     echo "<pre>";
		  // print_r($employee);
		  //           exit();
		$this->load->view('admin/today_recevable',['today_recevable'=>$today_recevable,'rejesho'=>$rejesho,'employee'=>$employee,'blanch'=>$blanch]);
	}


	public function filter_loan_receivable(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$blanch_id = $this->input->post('blanch_id');
		$today_receivable = $this->queries->get_today_recevable_loanBlanch($blanch_id);
		$blanch = $this->queries->get_blanch($comp_id);
		$rejesho = $this->queries->get_total_recevableBlanch($blanch_id);

		$blanch_data = $this->queries->get_blanch_data($blanch_id);
		// echo "<pre>";
		// print_r($today_receivable);
		//          exit();
		$this->load->view('admin/filter_loan_receivable',['blanch'=>$blanch,'today_receivable'=>$today_receivable,'rejesho'=>$rejesho,'blanch_data'=>$blanch_data]);
	}



	public function print_today_receivable(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
    $today_recevable = $this->queries->get_today_recevable_loan($comp_id);
    $rejesho = $this->queries->get_total_recevable($comp_id);	
    $compdata = $this->queries->get_companyData($comp_id);
	$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
    $html = $this->load->view('admin/today_receivable_report',['today_recevable'=>$today_recevable,'rejesho'=>$rejesho,'compdata'=>$compdata],true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
    $mpdf->WriteHTML($html);
    $mpdf->Output(); 
	}


	public function filter_filter_today_receivabe(){
	$this->load->model('queries');
    $empl_id = $this->input->post('empl_id');
    $comp_id = $this->input->post('comp_id');
    $data_employee = $this->queries->get_today_recevable_employee_data($empl_id,$comp_id);
    $tota_rejesho = $this->queries->get_today_recevable_employee_data_total($empl_id,$comp_id);
    $employee = $this->queries->get_today_recevable_employee($comp_id);
    $empl_data = $this->queries->get_employee_data($empl_id);
     // echo "<pre>";
     // print_r($tota_rejesho);
     // exit();
    $this->load->view('admin/today_received_empl',['data_employee'=>$data_employee,'employee'=>$employee,'empl_data'=>$empl_data,'tota_rejesho'=>$tota_rejesho,'empl_id'=>$empl_id,'comp_id'=>$comp_id]);

	}


	public function print_today_receivable_empl($empl_id,$comp_id){
		$this->load->model('queries');
    $data_employee = $this->queries->get_today_recevable_employee_data($empl_id,$comp_id);
    $tota_rejesho = $this->queries->get_today_recevable_employee_data_total($empl_id,$comp_id);
    $employee = $this->queries->get_today_recevable_employee($comp_id);
    $empl_data = $this->queries->get_employee_data($empl_id);
    $compdata = $this->queries->get_companyData($comp_id);

    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
    $html = $this->load->view('admin/today_receivable_report_empl',['empl_data'=>$empl_data,'data_employee'=>$data_employee,'tota_rejesho'=>$tota_rejesho,'compdata'=>$compdata],true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
    $mpdf->WriteHTML($html);
    $mpdf->Output(); 
	}

  


   



	public function today_receved_loan(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$received = $this->queries->get_today_received_loan($comp_id);
		$total_receved = $this->queries->get_sumReceived_amount($comp_id);
		$blanch = $this->queries->get_blanch($comp_id);
		$total_principal_receive = $this->queries->get_sum_principal_depost($comp_id);
		$total_interest = $this->queries->get_sum_interest_depost($comp_id);

		  //   echo "<pre>";
		  // print_r($total_principal);
		  //         exit();
		$this->load->view('admin/today_received',['received'=>$received,'total_receved'=>$total_receved,'blanch'=>$blanch,'total_principal_receive'=>$total_principal_receive,'total_interest'=>$total_interest]);
	}

	public function get_blanch_receved(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$blanch_id = $this->input->post('blanch_id');
		$comp_id = $this->input->post('comp_id');
		$depost_day = $this->input->post('depost_day');
		$blanch = $this->queries->get_blanch($comp_id);
		$data_blanch = $this->queries->get_blanchReced($blanch_id,$comp_id,$depost_day);
		$total_receve_blanch = $this->queries->get_blanch_total_receved($blanch_id,$comp_id,$depost_day);
		$blanch_data = $this->queries->get_blanchRecevedData($blanch_id);
		$blanch_principal = $this->queries->get_sum_principal_depostBranch($blanch_id);
		$blanch_interest = $this->queries->get_sum_interest_depostBlanch($blanch_id);
		$blanch_data = $this->queries->get_blanch_data($blanch_id);
		   // echo "<pre>";
		   // print_r($blanch_interest);
		   // exit();
		$this->load->view('admin/blanch_receved',['data_blanch'=>$data_blanch,'blanch'=>$blanch,'total_receve_blanch'=>$total_receve_blanch,'blanch_data'=>$blanch_data,'blanch_principal'=>$blanch_principal,'blanch_interest'=>$blanch_interest,'blanch_data'=>$blanch_data]);
	}

	
	public function bank_reconselation_report(){
		$this->load->model('queries');
        $comp_id = $this->session->userdata('comp_id');
        $daily_recons = $this->queries->get_total_recevableDaily($comp_id);
        $weekly_receivable = $this->queries->get_total_recevableweekly($comp_id);
        $monthly_receivable = $this->queries->get_total_recevableMonthly($comp_id);
        $receivable_total = $this->queries->get_total_recevable($comp_id);
        $received_daily = $this->queries->get_sumReceived_amountDaily($comp_id);
        $received_weekly = $this->queries->get_sumReceived_amountWeekly($comp_id);
        $received_monthly = $this->queries->get_sumReceived_amountmonthly($comp_id);


        $total_received = $this->queries->get_sumReceiveComp($comp_id);

        $prepaid_today = $this->queries->prepaid_pay($comp_id);

        $total_loan_fee = $this->queries->get_total_loanFeereconce($comp_id);

        $today_income = $this->queries->get_today_income($comp_id);

        $toay_expences = $this->queries->get_today_expences($comp_id);

          //  echo "<pre>";
          // print_r($prepaid_today);
          //     exit();
		$this->load->view('admin/reconselation',['daily_recons'=>$daily_recons,'weekly_receivable'=>$weekly_receivable,'monthly_receivable'=>$monthly_receivable,'receivable_total'=>$receivable_total,'received_daily'=>$received_daily,'received_weekly'=>$received_weekly,'received_monthly'=>$received_monthly,'total_received'=>$total_received,'prepaid_today'=>$prepaid_today,'total_loan_fee'=>$total_loan_fee,'today_income'=>$today_income,'toay_expences'=>$toay_expences]);
	}

   public function privillage($empl_id){
		$this->load->model('queries');
		$position = $this->queries->get_position();
		$emply = $this->queries->view_employee($empl_id);
		$my_priv = $this->queries->get_myprivillage($empl_id);
        $employee_privillage = $this->queries->get_empl_privillage($empl_id);
        $admin_privillage = $this->queries->get_employee_admin_privillage($empl_id);
		  //  echo "<pre>";
		  // print_r($my_priv);
		  //   exit();
		$this->load->view('admin/privillage',['position'=>$position,'emply'=>$emply,'my_priv'=>$my_priv,'employee_privillage'=>$employee_privillage,'admin_privillage'=>$admin_privillage]);
	}

	public function create_Employee_privillage($empl_id){
        $validation  = array( array('field'=> 'position_id[]','rules'=>'required'));
          $this->form_validation->set_rules($validation);
           if ($this->form_validation->run() == true) {
               $position_id  = $this->input->post('position_id[]');
               $empl_id = $this->input->post('empl_id');
               $comp_id = $this->input->post('comp_id');
              //    echo "<pre>";
              // print_r($position_id);
              //     echo "<br>";
              // print_r($comp_id);
              //     echo "<br>";
              // print_r($empl_id);
              //     exit();
              foreach ($position_id as $key => $value) {
      $this->db->query("INSERT INTO  tbl_privellage(`position_id`,`empl_id`,`comp_id`) VALUES ('$value','$empl_id','$comp_id')");
           }   
          $this->session->set_flashdata('massage','User Access Saved successfully');
       
           }
       }

public function careate_employee_privillage($priv,$empl_id,$comp_id){
 $this->load->model('queries');
 $empl_priv = $this->queries->check_employee_privillage($priv,$empl_id,$comp_id);
// print_r($priv);
//       exit();
   if ($empl_priv == TRUE) {
   $this->session->set_flashdata("error",'Privillage Added Please Select Another');
   return redirect('admin/privillage/'.$empl_id);
   }else{
  
 $this->db->query("INSERT INTO    tbl_empl_priv (`privillage`,`empl_id`,`comp_id`) VALUES ('$priv', '$empl_id','$comp_id')"); 
 $this->session->set_flashdata("massage",'Successfully');
 return redirect('admin/privillage/'.$empl_id);
 }
}


public function careate_amin_privillage($priv,$empl_id,$comp_id){
 $this->load->model('queries');
 $admin_priv = $this->queries->check_admin_privillage($priv,$empl_id,$comp_id);

   if ($admin_priv == TRUE) {
   $this->session->set_flashdata("error",'Privillage Added Please Select Another');
   return redirect('admin/privillage/'.$empl_id);
   }else{
  // print_r($admin_priv);
  //     exit();
 $this->db->query("INSERT INTO   tbl_admin_privillage (`privillage`,`empl_id`,`comp_id`) VALUES ('$priv', '$empl_id','$comp_id')"); 
 $this->session->set_flashdata("massage",'Successfully');
 return redirect('admin/privillage/'.$empl_id);
 }
}


 public function remove_empl_privillage($id){
    $this->load->model('queries');
    $privillage = $this->queries->get_empl_priv($id);
    $empl_id = $privillage->empl_id;
      // print_r($privillage);
      //       exit();
    if($this->queries->delete_empl_privillage($id));
    $this->session->set_flashdata("massage",'Privillage Removed Successfully');
    return redirect('admin/privillage/'.$empl_id);
}


 public function remove_admin_privillage($id){
    $this->load->model('queries');
    $privillage = $this->queries->get_admin_priv($id);
    $empl_id = $privillage->empl_id;
      // print_r($privillage);
      //       exit();
    if($this->queries->delete_admin_privillage($id));
    $this->session->set_flashdata("massage",'Privillage Removed Successfully');
    return redirect('admin/privillage/'.$empl_id);
}
  
         

       public function  delete_priv($priv_id){
       	$this->load->model('queries');
       	$pri = $this->queries->get_privData($priv_id);
       	$empl_id = $pri->empl_id;
       	  // print_r($empl_id);
       	  //     exit();
       	if($this->queries->remove_priv($priv_id));
       	$this->session->set_flashdata('massage','Privillage Removed successfully');
       	return redirect('admin/privillage/'.$empl_id);
       }

       public function get_cashInHand_Data(){
       	$this->load->model('queries');
       	$comp_id = $this->session->userdata('comp_id');
       	$cash_inhand = $this->queries->get_today_cashCompany($comp_id);
       	$total_cash = $this->queries->get_sumCashCompany($comp_id);

       	$total_blanch_account = $this->queries->get_cashbook($comp_id);
       	  //    echo "<pre>";
       	  // print_r($total_blanch_account);
       	  //       exit();
       	$this->load->view('admin/cash_inhand',['cash_inhand'=>$cash_inhand,'total_cash'=>$total_cash]);
       }


      public function previous_cashinhand(){
      	$this->load->model('queries');
      	$comp_id = $this->session->userdata('comp_id');
      	$from = $this->input->post('from');
        $to = $this->input->post('to');
        $comp_id = $this->input->post('comp_id');
        $data = $this->queries->search_previous_cashInHandCompany($from,$to,$comp_id);
        $sum_cash = $this->queries->search_Sum_previous_cashInHandCompany($from,$to,$comp_id);
        //  echo "<pre>";
        // print_r($sum_cash);
        //       exit();
      	$this->load->view('admin/previous_cashinhand',['data'=>$data,'sum_cash'=>$sum_cash]);
      }


      public function add_capital($capital_id,$comp_id,$pay_method){
      	 $trans_id = $pay_method;
       $this->form_validation->set_rules('amount','Amount','required');
       $this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
       if ($this->form_validation->run()) {
           $data = $this->input->post();
           $amount = $data['amount'];
           $this->load->model('queries');
          $acount = $this->queries->get_remain_company_balance($trans_id);
		  @$old_comp_balance = $acount->comp_balance;
		  $total_remain = @$old_comp_balance + $amount;
		  
           if ($this->update_capital_amount($capital_id,$total_remain)) {
           	  if ($acount == TRUE) {
           	  $this->update_company_balance($comp_id,$total_remain,$pay_method);
           	  }else{
           	$this->insert_company_balance($comp_id,$total_remain,$pay_method);
           	  }
           	  //exit();
           	  $this->session->set_flashdata('massage','Capital Amount Added successfully');
           }else{
           	$this->session->set_flashdata('error','Failed');
           }
           return redirect("admin/capital");
       }
       $this->capital();
      }

       public function minimize_capital($capital_id,$comp_id,$pay_method){
      	 $trans_id = $pay_method;
       $this->form_validation->set_rules('amount','Amount','required');
       $this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
       if ($this->form_validation->run()) {
           $data = $this->input->post();
           $amount = $data['amount'];
           $this->load->model('queries');
          $acount = $this->queries->get_remain_company_balance($trans_id);
		  @$old_comp_balance = $acount->comp_balance;
		  $total_remain = @$old_comp_balance - $amount;
		  
           if ($this->update_capital_amount($capital_id,$total_remain)) {
           	  if ($acount == TRUE) {
           	  $this->update_company_balance($comp_id,$total_remain,$pay_method);
           	  }else{
           	$this->insert_company_balance($comp_id,$total_remain,$pay_method);
           	  }
           	  //exit();
           	  $this->session->set_flashdata('massage','Capital Amount Minimized  successfully');
           }else{
           	$this->session->set_flashdata('error','Failed');
           }
           return redirect("admin/capital");
       }
       $this->capital();
      }







 public function update_capital_amount($capital_id,$total_remain){
  $sqldata="UPDATE `tbl_capital` SET `amount`= '$total_remain' WHERE `capital_id`= '$capital_id'";
    // print_r($sqldata);
    //    exit();
  $query = $this->db->query($sqldata);
  return true;
}


public function teller_group(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$grou_data = $this->queries->get_gropLoan($comp_id);
	  //    echo "<pre>";
	  // print_r($grou_data);
	  //           exit();
	$this->load->view('admin/teller_group',['grou_data'=>$grou_data]);
}

public function search_group(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
    $group_id = $this->input->post('group_id');
    $comp_id = $this->input->post('comp_id');
    $group_detail = $this->queries->get_group_loan_data($group_id,$comp_id);

  

      //    echo "<pre>";
      // print_r($group_detail);
      //       exit();
	$this->load->view('admin/group_account',['group_detail'=>$group_detail]);
}

public function previous_expences(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$from = $this->input->post('from');
	$to = $this->input->post('to');
	$blanch_id = $this->input->post('blanch_id');

   if ($blanch_id == 'all') {
   $blanch_exp = $this->queries->get_blanch_expDetail_comp($from,$to,$comp_id);
   $total_exp = $this->queries->get_total_expDetail_company($from,$to,$comp_id);
   }else{
   //echo "walete waafrika";
   $blanch_exp = $this->queries->get_blanch_expDetail($from,$to,$blanch_id);
   $total_exp = $this->queries->get_blanch_Total_expDetail($from,$to,$blanch_id);
   }
   // exit();
  

   $blanch = $this->queries->get_blanchd($comp_id);
   $data_blanch = $this->queries->get_blanch_data($blanch_id);

      //    echo "<pre>";
      // print_r($blanch_exp);
      //            exit();
   $this->load->view('admin/previous_expences',['blanch'=>$blanch,'from'=>$from,'to'=>$to,'blanch_id'=>$blanch_id,'from'=>$from,'to'=>$to,'data_blanch'=>$data_blanch,'blanch_exp'=>$blanch_exp,'total_exp'=>$total_exp]);
}


public function print_prev_expences($from,$to,$blanch_id){
 $this->load->model('queries');
 $comp_id = $this->session->userdata('comp_id');
 if ($blanch_id == 'all') {
   $blanch_exp = $this->queries->get_blanch_expDetail_comp($from,$to,$comp_id);
   $total_exp = $this->queries->get_total_expDetail_company($from,$to,$comp_id);
   }else{
   //echo "walete waafrika";
   $blanch_exp = $this->queries->get_blanch_expDetail($from,$to,$blanch_id);
   $total_exp = $this->queries->get_blanch_Total_expDetail($from,$to,$blanch_id);
   }
   // exit();
  

   $blanch = $this->queries->get_blanchd($comp_id);
   $data_blanch = $this->queries->get_blanch_data($blanch_id);
   $compdata = $this->queries->get_companyData($comp_id);


    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
    $html = $this->load->view('admin/print_prev_expences',['blanch_exp'=>$blanch_exp,'blanch'=>$blanch,'total_exp'=>$total_exp,'compdata'=>$compdata,'from'=>$from,'to'=>$to,'data_blanch'=>$data_blanch],true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
    $mpdf->WriteHTML($html);
    $mpdf->Output(); 	
}

public function get_outstand_loan(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$outstand = $this->queries->outstand_loan($comp_id);
	$total_remain = $this->queries->total_outstand_loan($comp_id);
	 //   echo "<pre>";
	 // print_r($total_remain);
	 //        exit();
	$this->load->view('admin/out_stand_loan',['outstand'=>$outstand,'total_remain'=>$total_remain]);
}

public function send_email(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$empl_data = $this->queries->get_employee_email($comp_id);
	$comp_data = $this->queries->get_compData($comp_id);
	   //        echo "<pre>";
	   // print_r($comp_data);
	   //      exit();
	$this->load->view('admin/send_email',['empl_data'=>$empl_data,'comp_data'=>$comp_data]);
}

	

	public function create_oficer_info(){
    $validation  = array( array('field'=> 'empl_id[]','rules'=>'required'));
      $this->form_validation->set_rules($validation);
       if ($this->form_validation->run() == true) {
           $empl_id  = $this->input->post('empl_id[]');
           $comp_id  = $this->input->post('comp_id');
           $send_email  = $this->input->post('send_email');
           $massage  = $this->input->post('massage');
          
            //    echo "<pre>";
            // print_r($empl_id);
            // print_r($description);
            //    echo "<br>";
            // print_r($comp_id);
            //     exit();
           
          for($i=0; $i<count($empl_id);$i++) {
        $this->db->query("INSERT INTO   tbl_email_send (`empl_id`,`comp_id` ,`send_email`,`massage`) 
        VALUES ('".$empl_id[$i]."','$comp_id','$send_email','$massage')");
         
          }
           $this->load->model('queries');
         $comp_id = $this->session->userdata('comp_id');
           $data = $this->gets_customerData($comp_id);
                  //echo "<pre>";
                //print_r($data);
                 ///print_r($massage);
                //print_r($name_info);
                 //print_r($send_email);
                 //print_r($phone_info);
                // echo "</pre>";
                  //exit();
            for ($i=0; $i<count($data); $i++) { 
          $this->sendEmail($data[$i]->empl_email,$send_email,$massage);
                 //print_r($data[$i]->empl_email);
              }
                //exit();
           $this->session->set_flashdata('massage','Email sent successfully');
   
       }
       return redirect("admin/send_email"); 
   }


    public function gets_customerData($comp_id){
  $sql = "SELECT e.empl_email FROM tbl_email_send s  JOIN tbl_employee e ON e.empl_id = s.empl_id WHERE s.comp_id = '$comp_id' AND s.date = NOW()";
  $query = $this->db->query($sql);
   return $query->result();
    }

  


    public function get_blanch_customer($blanch_id){
    	$this->load->model('queries');
    	$customer_blanch = $this->queries->get_cutomerBlanchData($blanch_id);
    	$blanch = $this->queries->get_blanch_data($blanch_id);
    	  //    echo "<pre>";
    	  // print_r($customer_blanch);
    	  //     exit();
    	$this->load->view('admin/blanch_customer',['customer_blanch'=>$customer_blanch,'blanch'=>$blanch]);
    }


    public function get_loan_aplicaionBlanch($blanch_id){
    	$this->load->model('queries');
    	$loan_request = $this->queries->get_loan_request_Balnch($blanch_id);
    	$blanch = $this->queries->get_blanch_data($blanch_id);
         
    	$this->load->view('admin/loan_aplication_blanch',['loan_request'=>$loan_request,'blanch'=>$blanch]);
    }

    public function view_aproved_loanBlanch($blanch_id){
    	$this->load->model('queries');
    	$aproved = $this->queries->get_aproved_loanBlabch($blanch_id);
    	$blanch = $this->queries->get_blanch_data($blanch_id);
    	$this->load->view('admin/aproved_loan_blanch',['aproved'=>$aproved,'blanch'=>$blanch]);
    }

    public function loan_disburesed_blanch($blanch_id){
    	$this->load->model('queries');
    	$disburesed = $this->queries->get_DisbarsedLoanBlanch($blanch_id);
    	$total_loanDis = $this->queries->get_sum_loanDisbursedBlanch($blanch_id);
    	$total_interest_loan = $this->queries->get_sum_loanDisburse_interestBlanch($blanch_id);
    	$blanch = $this->queries->get_blanch_data($blanch_id);
    	$this->load->view('admin/loan_disbursed_blanch',['disburesed'=>$disburesed,'total_loanDis'=>$total_loanDis,'total_interest_loan'=>$total_interest_loan,'blanch'=>$blanch]);
    }

    public function view_loan_pending_blanch($blanch_id){
    	$this->load->model('queries');
    	$loan_pending = $this->queries->get_pending_reportLoanblanch($blanch_id);
    	$pend = $this->queries->get_sun_loanPendingBlanch($blanch_id);
    	$blanch = $this->queries->get_blanch_data($blanch_id);
    	$this->load->view('admin/loan_pending_blanch',['loan_pending'=>$loan_pending,'pend'=>$pend,'blanch'=>$blanch]);
    }

    public function view_receivable_blanch($blanch_id){
    	$this->load->model('queries');
    	$receivable = $this->queries->get_today_recevable_loanBlanch($blanch_id);
    	$rejesho = $this->queries->get_total_recevableBlanch($blanch_id);
        $blanch = $this->queries->get_blanch_data($blanch_id);
    	$this->load->view('admin/receivable_blanch',['receivable'=>$receivable,'rejesho'=>$rejesho,'blanch'=>$blanch]);
    }


    public function view_received_blanch($blanch_id){
    	$this->load->model('queries');
    	$received = $this->queries->get_today_received_loanBlanch($blanch_id);
    	$total_receved = $this->queries->get_sum_today_recevedBlanch($blanch_id);
    	$blanch = $this->queries->get_blanch_data($blanch_id);
    	$this->load->view('admin/received_blanch',['received'=>$received,'total_receved'=>$total_receved,'blanch'=>$blanch]);
    }



      //insert loan Report 
      public function insert_customer_report($loan_id,$comp_id,$blanch_id,$customer_id,$group_id,$new_depost,$pay_id,$deposit_date){
          //$date = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_customer_report (`loan_id`,`comp_id`,`blanch_id`,`customer_id`,`group_id`,`pending_amount`,`pay_id`,`rep_date`) VALUES ('$loan_id','$comp_id','$blanch_id','$customer_id','$group_id','$new_depost','$pay_id','$deposit_date')");
      }

      public function loan_collection(){
      	$this->load->model('queries');
      	$comp_id = $this->session->userdata('comp_id');
      	$loan_collection = $this->queries->get_loan_collection($comp_id);

      	$income = $this->queries->get_income($comp_id);
      	$loan_total = $this->queries->get_total_loan($comp_id);
      	$depost_loan = $this->queries->get_totalPaid_loan($comp_id);
      	$penart = $this->queries->get_total_penart($comp_id);
      	$penart_paid = $this->queries->get_paid_penart($comp_id);
      	$blanch = $this->queries->get_blanch($comp_id);
		
     //  	          echo "<pre>";
     //      // print_r($loan_collection);
		   // print_r($this->get_total_penartData(723));
     //                  exit();      	
      	$this->load->view('admin/loan_collection',['loan_collection'=>$loan_collection,'income'=>$income,'loan_total'=>$loan_total,'depost_loan'=>$depost_loan,'penart'=>$penart,'penart_paid'=>$penart_paid,'blanch'=>$blanch]);
      }

	  
       public function print_all_loanCollection(){
      	$this->load->model('queries');
        $comp_id = $this->session->userdata('comp_id');
      	$loan_collection = $this->queries->get_loan_collection($comp_id);
      	$income = $this->queries->get_income($comp_id);
      	$loan_total = $this->queries->get_total_loan($comp_id);
      	$depost_loan = $this->queries->get_totalPaid_loan($comp_id);
      	$penart = $this->queries->get_total_penart($comp_id);
      	$penart_paid = $this->queries->get_paid_penart($comp_id);
      	$compdata = $this->queries->get_companyData($comp_id);

       $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
       $html = $this->load->view('admin/loan_collection_report',['compdata'=>$compdata,'loan_collection'=>$loan_collection,'income'=>$income,'loan_total'=>$loan_total,'depost_loan'=>$depost_loan,'penart'=>$penart,'penart_paid'=>$penart_paid],true);
       $mpdf->SetFooter('Generated By Brainsoft Technology');
       $mpdf->WriteHTML($html);
       $mpdf->Output();

      }




      public function search_loanSatatus(){
      $this->load->model('queries');
      $comp_id = $this->session->userdata('comp_id');
      $blanch = $this->queries->get_blanch($comp_id);
      $blanch_id = $this->input->post('blanch_id');
      $loan_status = $this->input->post('loan_status');
      $comp_id = $this->input->post('comp_id');
      $blanch = $this->queries->get_blanch($comp_id);
      $data_collection = $this->queries->filter_loanstatus($blanch_id,$loan_status,$comp_id);
      $data_blanch = $this->queries->get_blanch_data($blanch_id);
      $total_loans = $this->queries->get_total_loanFilter($blanch_id,$loan_status,$comp_id);
      $loan_paid = $this->queries->get_totalPaid_loanFilter($blanch_id,$loan_status,$comp_id);
      $penart_amounts = $this->queries->get_total_penartFilter($blanch_id,$loan_status,$comp_id);
      $paid_penart = $this->queries->get_paid_penartFilter($blanch_id,$loan_status,$comp_id);

      $blanch_data = $this->queries->get_blanch_data($blanch_id);
         //    echo "<pre>";
         // print_r($data_collection);
         //       exit();
      $this->load->view('admin/loan_collection_blanch',['data_collection'=>$data_collection,'blanch'=>$blanch,'data_blanch'=>$data_blanch,'total_loans'=>$total_loans,'loan_paid'=>$loan_paid,'penart_amounts'=>$penart_amounts,'paid_penart'=>$paid_penart,'blanch_id'=>$blanch_id,'loan_status'=>$loan_status,'comp_id'=>$comp_id,'blanch_data'=>$blanch_data]);

      }


      public function print_loanCollection_blanch($blanch_id,$loan_status,$comp_id){
      $this->load->model('queries');
      //$comp_id = $this->session->userdata('comp_id');
      $data_collection = $this->queries->filter_loanstatus($blanch_id,$loan_status,$comp_id);
      $data_blanch = $this->queries->get_blanch_data($blanch_id);
      $total_loans = $this->queries->get_total_loanFilter($blanch_id,$loan_status,$comp_id);
      $loan_paid = $this->queries->get_totalPaid_loanFilter($blanch_id,$loan_status,$comp_id);
      $penart_amounts = $this->queries->get_total_penartFilter($blanch_id,$loan_status,$comp_id);
      $paid_penart = $this->queries->get_paid_penartFilter($blanch_id,$loan_status,$comp_id);
      $compdata = $this->queries->get_companyData($comp_id);
       //   echo "<pre>";
       // print_r($data_collection);
       //            exit();
       
       $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
       $html = $this->load->view('admin/loan_collections_blanch_report',['data_collection'=>$data_collection,'compdata'=>$compdata,'data_blanch'=>$data_blanch,'total_loans'=>$total_loans,'loan_paid'=>$loan_paid,'penart_amounts'=>$penart_amounts,'paid_penart'=>$paid_penart],true);
       $mpdf->SetFooter('Generated By Brainsoft Technology');
       $mpdf->WriteHTML($html);
       $mpdf->Output();

      }





      public function pay_penart(){
      	$this->form_validation->set_rules('loan_id','Loan','required');
      	$this->form_validation->set_rules('blanch_id','Branch','required');
      	$this->form_validation->set_rules('comp_id','Comapany','required');
      	$this->form_validation->set_rules('inc_id','Income','required');
      	$this->form_validation->set_rules('penart_paid','Penart Amount','required');
      	$this->form_validation->set_rules('username','username','required');
      	$this->form_validation->set_rules('customer_id','Customer','required');
      	$this->form_validation->set_rules('penart_date','Date','required');
      	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
      	if ($this->form_validation->run()) {
      		$data = $this->input->post();
      		$inc_id = $data['inc_id'];
      		$blanch_id = $data['blanch_id'];
      		$loan_id = $data['loan_id'];
      		$comp_id = $data['comp_id'];
      		$penart_paid = $data['penart_paid'];
      		$username = $data['username'];
      		$customer_id = $data['customer_id'];
      		$penart_date = $data['penart_date'];
      		//    echo "<pre>";
      		// print_r($inc_id);
      		//       exit();
      		$this->load->model('queries');
      		$penart = $this->queries->get_paidPenart($loan_id);
      		$loan_income = $this->queries->get_loan_income($loan_id);
			$group_id = $loan_income->group_id;
      		if ($penart == TRUE) {
      			$old_paid = $penart->penart_paid;
      			$update_paid = $old_paid + $penart_paid;
      			$this->update_paidPenart($loan_id,$update_paid);
      			$this->insert_income($comp_id,$inc_id,$blanch_id,$customer_id,$username,$penart_paid,$penart_date,$group_id);
      			$this->session->set_flashdata('massage','Penart '.$penart_paid .' Paid successfully');
      	 	}else{
         $this->insert_income($comp_id,$inc_id,$blanch_id,$customer_id,$username,$penart_paid,$penart_date,$group_id);
         $this->insert_penartPaid($loan_id,$inc_id,$blanch_id,$comp_id,$penart_paid,$username,$customer_id,$penart_date,$group_id);      		}
      	 $this->session->set_flashdata('massage','Penart '.$penart_paid .'Paid successfully');	
      		}
      		return redirect('admin/loan_collection');
      }


  public function insert_penartPaid($loan_id,$inc_id,$blanch_id,$comp_id,$penart_paid,$username,$customer_id,$penart_date,$group_id){
   $this->db->query("INSERT INTO tbl_pay_penart (`loan_id`,`inc_id`,`blanch_id`,`comp_id`,`penart_paid`,`username`,`customer_id`,`penart_date`,`group_id`) VALUES ('$loan_id','$inc_id','$blanch_id','$comp_id','$penart_paid','$username','$customer_id','$penart_date','$group_id')");
  }

  public function insert_income($comp_id,$inc_id,$blanch_id,$customer_id,$username,$penart_paid,$penart_date,$loan_id,$group_id){
  	 $this->db->query("INSERT INTO tbl_receve (`comp_id`,`inc_id`,`blanch_id`,`customer_id`,`empl`,`receve_amount`,`receve_day`,`loan_id`,`group_id`) VALUES ('$comp_id','$inc_id','$blanch_id','$customer_id','$username','$penart_paid','$penart_date','$loan_id','$group_id')");
  }

  public function update_paidPenart($loan_id,$update_paid){
   $sqldata="UPDATE `tbl_pay_penart` SET `penart_paid`= '$update_paid' WHERE `loan_id`= '$loan_id'";
   $query = $this->db->query($sqldata);
   return true;
  }

    public function delete_formular($id){
    	$this->load->model('queries');
    	if($this->queries->remove_formular($id));
    	 $this->session->set_flashdata('massage','Formular Removed successfully');
    	 return redirect('admin/formular_setting');
    }


  // public function formular_setting(){
  // 	$this->load->model('queries');
  // 	$this->load->view('admin/interest_formular_setting');
  // }


   // function pmt() {
   //     $months = 12;
   //     $interest = 3.50 / 1200;
   //     $loan = 50000;
   //     $amount = $interest * -$loan * pow((1 + $interest), $months) / (1 - pow((1 + $interest), $months));
   //    // return number_format($amount, 2);
   //     // print_r(number_format($amount));
   //     //     exit();
   //     $total_loan = $amount * 1 * $months;

   //     // print_r($total_loan);
   //     //      exit();

   //      echo "Your payment will be Tsh " . number_format($amount) . " a month, for " . $months . " months" . "Total peyable" . number_format($total_loan);

   //  }


     public function formular_setting(){
  	$this->load->model('queries');
  	$comp_id = $this->session->userdata('comp_id');
  	$data = $this->queries->get_interestFormular($comp_id);
  	 // print_r($data);
  	 //       exit();
  	$this->load->view('admin/interest_formular_setting',['data'=>$data]);
  }


  public function create_interest_formular(){
  	 $this->load->model('queries');
        $validation  = array( array('field'=> 'formular_name[]','rules'=>'required'));
          $this->form_validation->set_rules($validation);
           if ($this->form_validation->run() == true) {
               $formular_name  = $this->input->post('formular_name[]');
               $comp_id = $this->input->post('comp_id');
              //    echo "<pre>";
              //  print_r($formular_name);
              //     echo "<br>";
              //  print_r($comp_id);
              // //    echo "<br>";
              //      exit();
              
            foreach ($formular_name as $key => $value){
      $this->db->query("INSERT INTO  tbl_formular_setting(`formular_name`,`comp_id`) VALUES ('$value','$comp_id')");
            }   
          $this->session->set_flashdata('massage','Interest formular Setting Sucessfully');
       
           }
           return redirect("admin/formular_setting"); 
       }

       public function loan_schedule(){
       	$this->load->model('queries');
       	$comp_id = $this->session->userdata('comp_id');
       	$customer = $this->queries->get_allcustomerDatagroup($comp_id);
       	$this->load->view('admin/loan_shedure',['customer'=>$customer]);
       }

       public function filter_loan_schedule(){
       	$this->load->model('queries');
       	$loan_id = $this->input->post('loan_id');
       	$data_loan = $this->queries->get_loanSchedule($loan_id);
       	$loan = $this->queries->get_loan_day($loan_id);
       	//   echo "<pre>";
       	// print_r($data_loan);
       	//          exit();
       	$this->load->view('admin/loan_shedure_list',['data_loan'=>$data_loan,'loan'=>$loan,'loan_id'=>$loan_id]);
       }

       public function print_loan_shedure($loan_id){
       $this->load->model('queries');
       $comp_id = $this->session->userdata('comp_id');
       $data_loan = $this->queries->get_loanSchedule($loan_id);
       $loan = $this->queries->get_loan_day($loan_id);
       $compdata = $this->queries->get_companyData($comp_id);
       $mpdf = new \Mpdf\Mpdf([]);
       $html = $this->load->view('admin/schedule_report',['compdata'=>$compdata,'data_loan'=>$data_loan,'loan'=>$loan],true);
       $mpdf->SetFooter('Generated By Brainsoft Technology');
       $mpdf->WriteHTML($html);
       $mpdf->Output();
       }

       



// huu mzigo wa week
//  public function increment_date(){
// $startTime = strtotime('2011-12-12');
// $endTime = strtotime('2012-02-01');
// $weeks = array();
// while ($startTime < $endTime) {  
//     $weeks[] = date('Y-m-d', $startTime); 
//     $startTime += strtotime('+1 week', 0);
// }
//   echo "<pre>";
// print_r($weeks);
       
//     }

//huu mzigo wa mwezi huu hapa
  public function increment_date(){
$start = $month = strtotime('2022-02-14');
$end   =  strtotime('2022-08-14');
$end   =   strtotime("+1 months", $end);
$monthy = array();
while($month < $end)
{
     $monthy[] = date('Y-m-d',$month);
     $month = strtotime("+1 months", $month);
     

    }
     echo "<pre>";
    print_r($monthy);
  }



// huu mzigo wa siku

    //  public function increment_date(){
    //  $begin = new DateTime('2010-05-01');
    //  $end = new DateTime('2010-06-10');
    //  $end = $end->modify( '+1 day' );
     
    //  $array = array();
    //  $interval = DateInterval::createFromDateString('1 day');
    //  $period = new DatePeriod($begin, $interval, $end);
      
    //    foreach ($period as $dt){
    //  $array[] = $dt->format("Y-m-d");
          
    //  } 
    //    echo "<pre>";
    //  print_r($array);

    //   // $loan_id = 1;
    //   //  for($i=0; $i<count($array);$i++) {
    //   //  	//$loan_id = 1;
    //   // $this->db->query("INSERT INTO  tbl_test_date (`date`,`loan_id`) 
    //   // VALUES ('".$array[$i]."','$loan_id')");
         
    //   //       }
       
    // }


public function sms_history(){
$this->load->model('queries');
$comp_id = $this->session->userdata('comp_id');
$history = $this->queries->get_smshIStorY($comp_id);
$sms_jumla = $this->queries->get_sumSmsHistory($comp_id);
 // print_r($history);
 //       exit();
$this->load->view('admin/sms_history',['history'=>$history,'sms_jumla'=>$sms_jumla]);
 }

 public function filter_smsData_history(){
 $this->load->model('queries');
 $from = $this->input->post('from');
 $to = $this->input->post('to');
 $comp_id = $this->input->post('comp_id');
 $data_sms = $this->queries->get_data_sms($from,$to,$comp_id);
 $total_sms = $this->queries->get_sumSms_total($from,$to,$comp_id);

 $this->load->view('admin/sms_history_list',['data_sms'=>$data_sms,'from'=>$from,'to'=>$to,'total_sms'=>$total_sms]);
 	
 }


 public function delete_loanwith($loan_id){
		ini_set("max_execution_time", 3600);
		 $this->load->model('queries');
		 $loan_with = $this->queries->get_loanDeletedata($loan_id);
		 $balance = $loan_with->loan_aprove;
		 $payment_method = $loan_with->method;
		 $blanch_id = $loan_with->blanch_id;
		 $comp_id = $loan_with->comp_id;
		 $loan_status = $loan_with->loan_status;

         $depost_lecod = $this->queries->get_total_loanDeposit($loan_id);
		 $loanDepost = $depost_lecod->total_loanDepost;
         
		 $blanch_account = $this->queries->get_amount_remainAmountBlanch($blanch_id,$payment_method);
		 $blanchBalance_amount = $blanch_account->blanch_capital;
		 $return_balance = $balance + $blanchBalance_amount;

         $deducted_loan = $this->queries->get_amount_deducted($loan_id);
         $total_receive_deducted = $this->queries->get_sum_receive_deducted($blanch_id);
         $deducted_amount = $total_receive_deducted->deducted;
         $old_deducted_data = $deducted_loan->deducted_balance;
         $remain_deducted_balance = $deducted_amount - $old_deducted_data;

         $receive_deducted = $this->queries->get_sum_nonDeducted_fee($loan_id);
         @$balance_nonDeducted = $this->queries->get_non_deducted_balance($blanch_id);

         $deductedNon_balance = @$balance_nonDeducted->non_balance;
         $old_receive = $receive_deducted->total_receive;
         $remain_nonBalance = $deductedNon_balance - $old_receive;

         //principal
         $total_depost_principal = $this->queries->get_total_loan_principal($loan_id);
         $principal_data = $total_depost_principal->total_principal;
        //interest
         $total_depost_interest = $this->queries->get_total_loan_interest($loan_id);
         $interest_data = $total_depost_interest->total_interest;
         
         //remain blanch principal
         $old_blanch_capital_princ = $this->queries->get_principal_remain($blanch_id,$payment_method,$loan_status);
         $old_principal = $old_blanch_capital_princ->principal_balance;
         //remove principal
         $remove_principal = $old_principal - $principal_data;

         //remain blanch interest
         $remain_interest = $this->queries->get_interest_remain($blanch_id,$payment_method,$loan_status);
         $old_interest = $remain_interest->capital_interest;
         //remove interest
         $remove_interest = $old_interest - $interest_data;

         $blanc_capital_remain = $this->queries->get_blanch_capital_balance($blanch_id,$payment_method);
         $blanch_balance_account = $blanc_capital_remain->blanch_capital;
         
         //toa principal akaunti kuu
         $bbpricipal = $blanch_balance_account -  $principal_data;
         //toa interest akaunti kuu
         $bbinterest = $blanch_balance_account - $interest_data;


         if ($principal_data > $old_principal) {
         	$this->update_main_account_blanch($blanch_id,$payment_method,$bbpricipal);
         	 echo "chukua akaunti kuu principal";
         }elseif($old_principal >= $principal_data){

         $this->update_principal_amount_remain($blanch_id,$payment_method,$remove_principal,$loan_status);
             echo "chukua mule mule principal";
         }

         if($interest_data > $old_interest) {
         $this->update_main_interest_account($blanch_id,$payment_method,$bbinterest);
         	echo "chukua akaunti kuu interest";
         }elseif ($old_interest >=$interest_data) {

         $this->remove_interest_account_balance($blanch_id,$payment_method,$remove_interest,$loan_status);
         	echo "chukua mule mule interest";
         }
           $this->return_loan_withdrawal($comp_id,$blanch_id,$payment_method,$return_balance);
		   $this->remove_deducted_balance_account($blanch_id,$remain_deducted_balance);
           $this->remove_nonDeducted_amount($blanch_id,$remain_nonBalance);
           $this->delete_from_tbl_pay($loan_id);
           $this->delete_from_Deposttable($loan_id);
           $this->delete_from_prevlecod($loan_id);
           $this->delete_from_reciveTable($loan_id);
           $this->delete_storePenart($loan_id);
           $this->delete_storePenart($loan_id);
           $this->delete_payPenartTable($loan_id);
           $this->delete_outstandLoan($loan_id);
           $this->delete_loanPending($loan_id);
           $this->delete_customer_report($loan_id);
           $this->delete_outstand($loan_id);
           $this->delete_deducted_fee($loan_id);
           $this->delete_prepaid_loan($loan_id);
           $this->delete_total_pending($loan_id);
		if($this->queries->remove_loandisbursed($loan_id)); 
		$this->session->set_flashdata("massage",'Loan Deleted successfully');
		return redirect('admin/loan_withdrawal');
	}
   
   public function remove_interest_account_balance($blanch_id,$payment_method,$remove_interest,$loan_status){
   	$sqldata="UPDATE `tbl_blanch_capital_interest` SET `capital_interest`= '$remove_interest' WHERE `blanch_id`= '$blanch_id' AND `trans_id`='$payment_method' AND `int_status`='$loan_status'";
     $query = $this->db->query($sqldata);
     return true;
   }
   
	public function update_main_interest_account($blanch_id,$payment_method,$bbinterest){
    $sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`= '$bbinterest' WHERE `blanch_id`= '$blanch_id' AND `receive_trans_id`='$payment_method'";
     $query = $this->db->query($sqldata);
     return true;
	}

	public function update_principal_amount_remain($blanch_id,$payment_method,$remove_principal,$loan_status){
	 $sqldata="UPDATE `tbl_blanch_capital_principal` SET `principal_balance`= '$remove_principal' WHERE `blanch_id`= '$blanch_id' AND `trans_id`='$payment_method' AND `princ_status`='$loan_status'";
     $query = $this->db->query($sqldata);
     return true;	
	}

	public function update_main_account_blanch($blanch_id,$payment_method,$bbpricipal){
	$sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`= '$bbpricipal' WHERE `blanch_id`= '$blanch_id' AND `receive_trans_id`='$payment_method'";
     $query = $this->db->query($sqldata);
     return true;	
	}

	//remove non deducted fee
	public function remove_nonDeducted_amount($blanch_id,$remain_nonBalance){
	 $sqldata="UPDATE `tbl_receive_non_deducted` SET `non_balance`= '$remain_nonBalance' WHERE `blanch_id`= '$blanch_id'";
     $query = $this->db->query($sqldata);
     return true;	
	}

	public function delete_prepaid_loan($loan_id){
	return $this->db->delete('tbl_prepaid',['loan_id'=>$loan_id]);	
	}

	public function delete_total_pending($loan_id){
	 return $this->db->delete('tbl_pending_total',['loan_id'=>$loan_id]);	
	}

  public function delete_deducted_fee($loan_id){
  return $this->db->delete('tbl_deducted_fee',['loan_id'=>$loan_id]);	
  }
	//remove deducted amount
	public function remove_deducted_balance_account($blanch_id,$remain_deducted_balance){
	 $sqldata="UPDATE `tbl_receive_deducted` SET `deducted`= '$remain_deducted_balance' WHERE `blanch_id`= '$blanch_id'";
     $query = $this->db->query($sqldata);
     return true;	
	}

	public function return_loan_withdrawal($comp_id,$blanch_id,$payment_method,$return_balance){
     $sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`= '$return_balance' WHERE `blanch_id`= '$blanch_id' AND `receive_trans_id` = '$payment_method'";
     $query = $this->db->query($sqldata);
     return true;
	}


      // public function test_data(){
      // 	$date = date("Y-m-d");
      //   $back = date('Y-m-d', strtotime('-1 day', strtotime($date)));
      //    print_r($back);
      //      exit();
      //   }


    // function sendEmail($data,$send_email,$massage){
    //     // $from = $send_email;
    //     // $to = $data;
    //     // $subject = "MikopoSoft";
    //     // $message   = $massage;
    //     // $headers = "from:". $from;
    //     // mail($to,$subject,$message,$headers);
    // }


       public function get_loan_code_resend($customer_id){
        $this->load->model('queries');

        $loan_code = $this->queries->get_loanCustomerCode($customer_id);
        $code = $loan_code->code;
        $phones = $loan_code->phone_no;
        $comp_id = $loan_code->comp_id;
         
        $sms = 'Namba ya Siri Ya Mkopo Wako ni ' .$code;
        $massage = $sms;
        $phone = '0'.substr($phones, 3,10);
        // print_r($phone);
        //      exit();
       
        $this->sendsms($phone,$massage);
        $this->session->set_flashdata('massage','Loan code sent please Wait');
        return redirect('admin/data_with_depost/'.$customer_id);
      }

   //graph 

      public function get_all_customer_record(){
      	$comp_id = $this->session->userdata('comp_id');
      	$customer = $this->db->query("SELECT COUNT(c.customer_id) AS total_customers,b.blanch_name,b.blanch_id FROM tbl_customer c JOIN tbl_blanch b ON b.blanch_id = c.blanch_id WHERE c.comp_id = '$comp_id' GROUP BY b.blanch_id");
      	foreach ($customer->result() as $r) {
      		$r->total_male = $this->male_customer($r->blanch_id);
      		$r->total_female = $this->female_customer($r->blanch_id);
      		$r->total_active = $this->active_customer($r->blanch_id);
      		$r->total_pending = $this->pending_customer($r->blanch_id);
      		$r->total_closed = $this->closed_customer($r->blanch_id);
      	}
        echo json_encode($customer->result());
      }

      public function male_customer($blanch_id){
        $male = $this->db->query("SELECT COUNT(customer_id) as total_male FROM  tbl_customer WHERE gender = 'male' AND blanch_id = '$blanch_id' GROUP BY blanch_id");
       if ($male->row()) {
      return $male->row()->total_male; 
    }
    return 0; 
      }

         public function female_customer($blanch_id){
        $female = $this->db->query("SELECT COUNT(customer_id) as total_female FROM  tbl_customer WHERE gender = 'female' AND blanch_id = '$blanch_id' GROUP BY blanch_id");
       if ($female->row()) {
      return $female->row()->total_female; 
    }
    return 0; 
      }

      public function active_customer($blanch_id){
      	$active = $this->db->query("SELECT COUNT(customer_id) AS total_active FROM tbl_customer WHERE customer_status = 'open' AND blanch_id = '$blanch_id'");
      	   if ($active->row()) {
      return $active->row()->total_active; 
    }
    return 0; 
      }

      public function pending_customer($blanch_id){
      	$pending = $this->db->query("SELECT COUNT(customer_id) AS total_pending FROM tbl_customer WHERE customer_status = 'pending' AND blanch_id = '$blanch_id'");
      if ($pending->row()) {
      return $pending->row()->total_pending; 
    }
    return 0; 
      }


      public function closed_customer($blanch_id){
     $closed = $this->db->query("SELECT COUNT(customer_id) AS total_closed FROM tbl_customer WHERE customer_status = 'close' AND blanch_id = '$blanch_id'");
      if ($closed->row()) {
      return $closed->row()->total_closed; 
    }
    return 0; 
      }


      public function transaction_account(){
      	$this->load->model('queries');
      	$comp_id = $this->session->userdata('comp_id');
      	$account = $this->queries->get_account_transaction($comp_id);
      	   // print_r($account);
      	   //         exit();
      	$this->load->view('admin/transaction_account',['account'=>$account]);
      }

      public function create_account_transaction(){
      	$this->form_validation->set_rules('account_name','Account','required');
      	$this->form_validation->set_rules('comp_id','company','required');
      	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
      	  if ($this->form_validation->run()) {
      	  	     $data = $this->input->post();
      	  	     // print_r($data);
      	  	     //       exit();
      	  	     $this->load->model('queries');
      	  	     if ($this->queries->insert_account_name($data)) {
      	  	     	$this->session->set_flashdata("massage","Data saved successfully");
      	  	     }else{
      	  	     	$this->session->set_flashdata("error","Failed");

      	  	     }
      	  	     return redirect('admin/transaction_account');
      	  }
           $this->transaction_account();
      }

      //delete Account 
      public function Delete_account($trans_id){
         $this->load->model('queries');
         if($this->queries->delete_account($trans_id));
             $this->session->set_flashdata("massage",'Data Deleted successfully');
             return redirect("admin/transaction_account");
      }


      public function trial_balance(){
      	$this->load->model('queries');
      	$this->load->view('admin/trial_balance');
      }


      public function profitloss_report(){
      	$this->load->view('admin/profit_loss');
      }

      public function deducted_income(){
      	$this->load->model('queries');
      	$comp_id = $this->session->userdata('comp_id');
      	$deducted_income = $this->queries->get_deducted_income($comp_id);
      	$deducted_sumary = $this->queries->get_deducted_account_balance($comp_id);

      	$total_deducted = $this->queries->get_total_deducted_income($comp_id);
      	$blanch = $this->queries->get_blanch($comp_id);
      	//  echo "<pre>";
      	// print_r($total_deducted);
      	//           exit();
      	$this->load->view('admin/deducted_income',['deducted_income'=>$deducted_income,'deducted_sumary'=>$deducted_sumary,'total_deducted'=>$total_deducted,'blanch'=>$blanch]);
      }


      public function filter_deducted_income(){
      	$this->load->model('queries');
      	$comp_id = $this->session->userdata('comp_id');
      	$blanch = $this->queries->get_blanch($comp_id);
      	$from = $this->input->post('from');
      	$to = $this->input->post('to');
      	$blanch_id = $this->input->post('blanch_id');
      	$comp_id = $this->input->post('comp_id');
         
         if ($blanch_id == 'all') {
        $data_deducted = $this->queries->get_deducted_incomeFilterComp($from,$to,$comp_id);
        $total_deducted_data = $this->queries->get_total_blanch_dataAll($from,$to,$comp_id);
         }else{
      	$data_deducted = $this->queries->get_deducted_incomeFilter($from,$to,$blanch_id);
      	$total_deducted_data = $this->queries->get_total_blanch_data($from,$to,$blanch_id);
      	}
      	$blanch_data = $this->queries->get_blanch_data($blanch_id);
      	
      	//   echo "<pre>";
      	// print_r($total_deducted_data);
      	//        exit();
      	$this->load->view('admin/filter_deducted_income',['from'=>$from,'to'=>$to,'blanch_id'=>$blanch_id,'comp_id'=>$comp_id,'data_deducted'=>$data_deducted,'blanch'=>$blanch,'blanch_data'=>$blanch_data,'total_deducted_data'=>$total_deducted_data]);
      }


      public function print_deducted_income($from,$to,$blanch_id,$comp_id){
      	$this->load->model('queries');
      	 if ($blanch_id == 'all') {
        $data_deducted = $this->queries->get_deducted_incomeFilterComp($from,$to,$comp_id);
        $total_deducted_data = $this->queries->get_total_blanch_dataAll($from,$to,$comp_id);
         }else{
      	$data_deducted = $this->queries->get_deducted_incomeFilter($from,$to,$blanch_id);
      	$total_deducted_data = $this->queries->get_total_blanch_data($from,$to,$blanch_id);
      	}
      	$blanch_data = $this->queries->get_blanch_data($blanch_id);
      	$compdata = $this->queries->get_companyData($comp_id);
      	

	    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
	    $html = $this->load->view('admin/deducted_report',['compdata'=>$compdata,'from'=>$from,'to'=>$to,'data_deducted'=>$data_deducted,'total_deducted_data'=>$total_deducted_data,'blanch_data'=>$blanch_data],true);
	    $mpdf->SetFooter('Generated By Brainsoft Technology');

	    $mpdf->WriteHTML($html);
	    $output = 'Deducted Income.pdf';
        $mpdf->Output("$output", 'I');

	    //$this->load->view('admin/deducted_report',['compdata'=>$compdata,'from'=>$from,'to'=>$to]);
	}
      





      public function deducted_income_sumary(){
      	$this->load->model('queries');
       $comp_id = $this->session->userdata('comp_id');
       $blanch = $this->queries->get_blanch($comp_id);
       $comp_transaction = $this->queries->get_account_transaction($comp_id);
       $transaction_list = $this->queries->get_blanch_blanchdata($comp_id);

       $blanch_deducted = $this->queries->get_blanch_balance_fee($comp_id);
       // echo "<pre>";
       //  print_r($blanch_deducted);
       //  exit();
      	$this->load->view('admin/deducted_report',['blanch'=>$blanch,'comp_transaction'=>$comp_transaction,'transaction_list'=>$transaction_list,'blanch_deducted'=>$blanch_deducted]);
      }


 function fetch_blanch_account()
{
$this->load->model('queries');
if($this->input->post('blanch_id'))
{
echo $this->queries->fetch_blanch_account_data($this->input->post('blanch_id'));
}
}


public function create_transfor_deducted(){
	$this->form_validation->set_rules('deduct_type','Deducted','required');
	$this->form_validation->set_rules('from_blanch_id','From Branch','required');
	$this->form_validation->set_rules('from_mount','Amount','required');
	$this->form_validation->set_rules('to_blanch_id','to blanch name','required');
	$this->form_validation->set_rules('to_blach_account_id','To blanch Account name','required');
	$this->form_validation->set_rules('trans_fee','Transaction Fee');
	$this->form_validation->set_rules('comp_id','company','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
	if ($this->form_validation->run()) {
		  $data = $this->input->post();
		  $deduct_type = $data['deduct_type'];
		  $from_blanch = $data['from_blanch_id'];
		  $from_amount = $data['from_mount'];
		  $to_blanch = $data['to_blanch_id'];
		  $to_blanch_account = $data['to_blach_account_id'];
		  $trans_chargers = $data['trans_fee'];
		  $comp_id = $data['comp_id'];
		 
		  $this->load->model('queries');
		  $deducte_blance = $this->queries->get_blance_deducted_fee($from_blanch);
		  $old_deducted = @$deducte_blance->deducted;
		  //blanch Account  
		  $blanch_account_balance = $this->queries->get_blanch_accountBalance($to_blanch,$to_blanch_account);
		  $old_account_blance = $blanch_account_balance->blanch_capital;
          
          $amaount_receive = $from_amount;
          $deducted_transaction = $amaount_receive + $old_account_blance;

          $deduction_warning = $amaount_receive + $trans_chargers;
          $makato_deducted = ($old_deducted) - ($amaount_receive + $trans_chargers); 

          $non_deducted = $this->queries->get_balance_nonDeducted($from_blanch);
          $non_blanch_balance = @$non_deducted->non_balance;
          
          $makato_non_deducted = ($non_blanch_balance) - ($amaount_receive + $trans_chargers);
           

		   if ($deduct_type == 'deducted') {
		   	if ($old_deducted < $deduction_warning) {
		   	  $this->session->set_flashdata('errors','Balance Amount is not Enough');
		   	}else{
		   	$this->insert_transaction_recod_blanch_balanch($comp_id,$deduct_type,$from_blanch,$amaount_receive,$to_blanch,$to_blanch_account,$trans_chargers);
		   	$this->update_remain_balance_deducted($comp_id,$from_blanch,$makato_deducted);
		   	$this->update_blanch_capital_account($comp_id,$to_blanch,$to_blanch_account,$deducted_transaction);
		   	$this->session->set_flashdata('massage','Balance transaction Sucessfully');
		   	}
		   }elseif($deduct_type == 'non deducted'){
		   	if ($non_blanch_balance < $deduction_warning) {
		   	$this->session->set_flashdata('errors','Balance Amount is not Enough');
		   	}else{
		   $this->insert_transaction_recod_blanch_balanch($comp_id,$deduct_type,$from_blanch,$amaount_receive,$to_blanch,$to_blanch_account,$trans_chargers);
		   $this->update_remain_balance_non_deducted($comp_id,$from_blanch,$makato_non_deducted);
           $this->update_blanch_capital_account($comp_id,$to_blanch,$to_blanch_account,$deducted_transaction);
           $this->session->set_flashdata('massage','Balance transaction Sucessfully');
           }
		   }
		  return redirect('admin/deducted_income_sumary');
	     }
	    $this->deducted_income_sumary();
       }

//non deducted session
public function update_remain_balance_non_deducted($comp_id,$from_blanch,$makato_non_deducted){
$sqldata="UPDATE `tbl_receive_non_deducted` SET `non_balance`= '$makato_non_deducted' WHERE `blanch_id`= '$from_blanch'";
     $query = $this->db->query($sqldata);
 return true;
}




//deducted session
public function insert_transaction_recod_blanch_balanch($comp_id,$deduct_type,$from_blanch,$amaount_receive,$to_blanch,$to_blanch_account,$trans_chargers){
	$day = date("Y-m-d");
$this->db->query("INSERT INTO tbl_transfor_blanch_blanch (`comp_id`,`deduct_type`,`from_blanch_id`,`from_mount`,`to_blanch_id`,`to_blach_account_id`,`trans_fee`,`date_transfor`) VALUES ('$comp_id','$deduct_type','$from_blanch','$amaount_receive','$to_blanch','$to_blanch_account','$trans_chargers','$day')");
}

public function update_remain_balance_deducted($comp_id,$from_blanch,$makato_deducted){
$sqldata="UPDATE `tbl_receive_deducted` SET `deducted`= '$makato_deducted' WHERE `blanch_id`= '$from_blanch'";
     $query = $this->db->query($sqldata);
 return true;
}

public function update_blanch_capital_account($comp_id,$to_blanch,$to_blanch_account,$deducted_transaction){
$sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`= '$deducted_transaction' WHERE `blanch_id`= '$to_blanch' AND `receive_trans_id`='$to_blanch_account'";
     $query = $this->db->query($sqldata);
 return true;	
}



public function blanch_company_transaction(){
	$this->form_validation->set_rules('deduct_type','Deduction type','required');
	$this->form_validation->set_rules('comp_id','Company','required');
	$this->form_validation->set_rules('from_blanch','From Branch','required');
	$this->form_validation->set_rules('balance','balance','required');
	$this->form_validation->set_rules('to_comp_account','company Account','required');
	$this->form_validation->set_rules('trans_fee','Transaction Fee','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
	if ($this->form_validation->run()) {
		$data = $this->input->post();
		$this->load->model('queries');
		$deducted_type = $data['deduct_type'];
		$comp_id = $data['comp_id'];
		$from_blanch = $data['from_blanch'];
		$balance = $data['balance'];
		$to_comp_account = $data['to_comp_account'];
		$trans_fee = $data['trans_fee'];

		$deducte_blance = $this->queries->get_blance_deducted_fee($from_blanch);
		$old_deducted = @$deducte_blance->deducted;

		$check_account = $this->queries->check_company_account($comp_id,$to_comp_account);
		$trans_account = @$check_account->trans_id;
		$comp_balance = @$check_account->comp_balance;
        
        $remove_balance_deducted  = ($old_deducted) - ($balance + $trans_fee);
        $new_balance_comp = $balance + $comp_balance;
        
        $non_deducted = $this->queries->get_balance_nonDeducted($from_blanch);
        $non_blanch_balance = @$non_deducted->non_balance;

        $remove_nonBalance = ($non_blanch_balance) - ($balance + $trans_fee);

        $balance_check = $balance + $trans_fee;

		 // print_r($balance_check);
		 // echo "<br>";
		 // //print_r($balance);
		 //         exit();
  
        if ($deducted_type == 'deducted'){
        	if ($old_deducted < $balance_check) {
               $this->session->set_flashdata("errors","Balance Amount is not Enough");
        	}else{
        	$this->insert_record_company($comp_id,$from_blanch,$deducted_type,$balance,$to_comp_account,$trans_fee);
            $this->update_remain_deducted_balance($comp_id,$from_blanch,$remove_balance_deducted);
        	if ($trans_account == TRUE) {
        		$this->update_oldBalance_capital($comp_id,$to_comp_account,$new_balance_comp);
        	}elseif ($trans_account == FALSE) {
        	$this->insert_new_blance_account($comp_id,$to_comp_account,$new_balance_comp);
        	}
        	 $this->session->set_flashdata("massage",'Transaction successfully');
        	}
         }elseif ($deducted_type == 'non deducted') {
              if ($non_blanch_balance < $balance_check) {
              	$this->session->set_flashdata('errors','Balance Amount is not Enough');
              }else{
           $this->insert_record_company($comp_id,$from_blanch,$deducted_type,$balance,$to_comp_account,$trans_fee);
            $this->update_remain_deducted_balanceNone($comp_id,$from_blanch,$remove_nonBalance);
        	if ($trans_account == TRUE) {
        		$this->update_oldBalance_capital($comp_id,$to_comp_account,$new_balance_comp);
        	}elseif ($trans_account == FALSE) {
        	$this->insert_new_blance_account($comp_id,$to_comp_account,$new_balance_comp);
        	}
        	$this->session->set_flashdata("massage",'Transaction successfully');
        }
        }
		return redirect('admin/deduction_branch_company');
	}
	$this->deduction_branch_company();
}


public function update_remain_deducted_balanceNone($comp_id,$from_blanch,$remove_nonBalance){
$sqldata="UPDATE `tbl_receive_non_deducted` SET `non_balance`= '$remove_nonBalance' WHERE `blanch_id`= '$from_blanch'";
     $query = $this->db->query($sqldata);
 return true;	
}

public function insert_new_blance_account($comp_id,$to_comp_account,$new_balance_comp){
$this->db->query("INSERT INTO tbl_ac_company (`comp_id`,`trans_id`,`comp_balance`) VALUES ('$comp_id','$to_comp_account','$new_balance_comp')");	
}

public function update_oldBalance_capital($comp_id,$to_comp_account,$new_balance_comp){
$sqldata="UPDATE `tbl_ac_company` SET `comp_balance`= '$new_balance_comp' WHERE `comp_id`= '$comp_id' AND `trans_id`='$to_comp_account'";
     $query = $this->db->query($sqldata);
 return true;	
}

public function update_remain_deducted_balance($comp_id,$from_blanch,$remove_balance_deducted){
$sqldata="UPDATE `tbl_receive_deducted` SET `deducted`= '$remove_balance_deducted' WHERE `blanch_id`= '$from_blanch'";
     $query = $this->db->query($sqldata);
 return true;	
}


public function insert_record_company($comp_id,$from_blanch,$deducted_type,$balance,$to_comp_account,$trans_fee){
 	$day = date("Y-m-d");
$this->db->query("INSERT INTO tbl_transfor_blanch_company (`comp_id`,`deduct_type`,`from_blanch`,`balance`,`to_comp_account`,`trans_fee`,`trans_date`) VALUES ('$comp_id','$deducted_type','$from_blanch','$balance','$to_comp_account','$trans_fee','$day')");
}


public function deduction_branch_company(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$blanch = $this->queries->get_blanch($comp_id);
    $comp_transaction = $this->queries->get_account_transaction($comp_id);
    $transaction = $this->queries->get_branch_comTransaction($comp_id);
    $total_transaction = $this->queries->get_totalBlanch_comptrans($comp_id);
    $total_fee = $this->queries->total_chargers_comp($comp_id);
    $blanch_deducted = $this->queries->get_blanch_balance_fee($comp_id);
    //  echo "<pre>";
    // print_r($total_fee);
    //        exit();
	$this->load->view('admin/branch_company_deduction',['blanch'=>$blanch,'comp_transaction'=>$comp_transaction,'transaction'=>$transaction,'total_transaction'=>$total_transaction,'total_fee'=>$total_fee,'blanch_deducted'=>$blanch_deducted]);
}

public function loss_profit(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$interest = $this->queries->get_interest_repayment($comp_id);
	$principal = $this->queries->get_principal_blanchAccount($comp_id);
	$deducted_fee = $this->queries->get_fee_deducted_total($comp_id);
	$data_nonDeducted = $this->queries->get_sum_nonDeducted($comp_id);

	$default_interest = $this->queries->get_default_interest_repayment($comp_id);

    $default_principal = $this->queries->get_principal_blanchAccountDefault($comp_id);
    $blanch_expenses = $this->queries->get_accept_expensesBlanch($comp_id);
    $sum_total_expense = $this->queries->get_sum_blanch_total_expenses($comp_id);
  //     echo "<pre>";
	 // print_r($sum_total_expense);
	 //          exit();
	$this->load->view('admin/loss_profit',['interest'=>$interest,'principal'=>$principal,'deducted_fee'=>$deducted_fee,'data_nonDeducted'=>$data_nonDeducted,'default_interest'=>$default_interest,'default_principal'=>$default_principal,'blanch_expenses'=>$blanch_expenses,'sum_total_expense'=>$sum_total_expense]);
}


public function cash_flow(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$blanch_account = $this->queries->get_account_balance_blanch($comp_id);
	$total_blanch_capital = $this->queries->get_total_blanch_capital($comp_id);
	$today_depost = $this->queries->get_depost_loan_withdrawal($comp_id);
	$total_depostin = $this->queries->get_total_depostloan_withdrawal($comp_id);
	$loan_depost_out = $this->queries->get_loanDepost_out($comp_id);
	$sum_depost_out = $this->queries->get_sumloanDepost_out($comp_id);
	$loan_withdrawal = $this->queries->get_loanWithdrawal_today($comp_id);
	$sum_loanwithdrawal = $this->queries->get_sumloan_withdrawal($comp_id);
	$expenses_today = $this->queries->get_today_expenses($comp_id);
	$sum_expenses_data = $this->queries->get_today_sumExpenses($comp_id);
	$today_deducted = $this->queries->get_today_deducted_fee($comp_id);
	$today_non_deducted = $this->queries->get_non_deducted_feeToday($comp_id);

	$blanch = $this->queries->get_blanch($comp_id);
	//     echo "<pre>";
	// print_r($blanch);
	//            exit();
	$this->load->view('admin/cash_flow',['blanch_account'=>$blanch_account,'total_blanch_capital'=>$total_blanch_capital,'today_depost'=>$today_depost,'total_depostin'=>$total_depostin,'loan_depost_out'=>$loan_depost_out,'sum_depost_out'=>$sum_depost_out,'loan_withdrawal'=>$loan_withdrawal,'sum_loanwithdrawal'=>$sum_loanwithdrawal,'expenses_today'=>$expenses_today,'sum_expenses_data'=>$sum_expenses_data,'today_deducted'=>$today_deducted,'today_non_deducted'=>$today_non_deducted,'blanch'=>$blanch]);
}


public function blanch_cash_flow()
{
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$blanch_id = $this->input->post('blanch_id');
	$data_accumlation = $this->queries->get_cashflow_accumlation($blanch_id);
	$blanch = $this->queries->get_blanch($comp_id);
	$blanch_capital_name = $this->queries->get_blanch_data($blanch_id);
	$total_blanch_accumlation = $this->queries->get_total_accumlation($blanch_id);

	$blanch_loan_depost = $this->queries->get_depost_loan_withdrawal_blanch($blanch_id);
	$total_today_depost_blanch = $this->queries->get_total_depostloan_withdrawalBlanch($blanch_id);
	$out_stand_depost = $this->queries->get_sumloanDepost_outBlanch($blanch_id);
	$data_out_depost = $this->queries->get_loanDepost_out_blanch($blanch_id);

	$today_withdraw = $this->queries->get_loanWithdrawal_today_blanch($blanch_id);
	$sum_loanwithdrawal = $this->queries->get_sumloan_withdrawal_blanch($blanch_id);

	$expenses_today = $this->queries->get_today_expenses_blanch($blanch_id);
	$sum_expenses_data = $this->queries->get_today_sumExpenses_blanch($blanch_id);

	$today_deducted = $this->queries->get_today_deducted_fee_blanch($blanch_id);
	$today_non_deducted = $this->queries->get_non_deducted_feeToday_blanch($comp_id);

	    //      echo "<pre>";
     // print_r($data_accumlation);
     //            exit();
	$this->load->view('admin/blanch_cashflow',['data_accumlation'=>$data_accumlation,'blanch'=>$blanch,'blanch_capital_name'=>$blanch_capital_name,'total_blanch_accumlation'=>$total_blanch_accumlation,'blanch_loan_depost'=>$blanch_loan_depost,'total_today_depost_blanch'=>$total_today_depost_blanch,'out_stand_depost'=>$out_stand_depost,'data_out_depost'=>$data_out_depost,'out_stand_depost'=>$out_stand_depost,'today_withdraw'=>$today_withdraw,'sum_loanwithdrawal'=>$sum_loanwithdrawal,'expenses_today'=>$expenses_today,'sum_expenses_data'=>$sum_expenses_data,'today_deducted'=>$today_deducted,'today_non_deducted'=>$today_non_deducted]);
}



public function collection_loan_data(){
	$this->load->model('queries');
	$this->load->view('admin/collection_loan');
}


public function create_member_status($customer_id){
	$this->form_validation->set_rules('member_status','Member status','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

	if ($this->form_validation->run()) {
		$data = $this->input->post();
		$this->load->model('queries');
		if ($this->queries->update_member_status($data,$customer_id)) {
			$this->session->set_flashdata("massage",'Loan Application Saved successfully');
		}else {
			$this->session->set_flashdata("error",'Failed');
			
		}
		return redirect('admin/loan_pending');
	}

$this->loan_pending();
	
}


public function provider(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	
	$this->load->view('admin/provider');
}


public function saving_deposit(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$miamala = $this->queries->get_comp_miamala_dada($comp_id);
	$total_miamala = $this->queries->get_total_miamala($comp_id);
	$blanch = $this->queries->get_blanch($comp_id);
	//  echo "<pre>";
	// print_r($miamala);
	//        exit();
	$this->load->view('admin/saving_deposit',['miamala'=>$miamala,'total_miamala'=>$total_miamala,'blanch'=>$blanch]);
}


public function create_saving_deposit(){
    $this->form_validation->set_rules('comp_id','company','required');
    $this->form_validation->set_rules('blanch_id','blanch','required');
    $this->form_validation->set_rules('provider','provider','required');
    $this->form_validation->set_rules('agent','Agent','required');
    $this->form_validation->set_rules('amount','amount','required');
    $this->form_validation->set_rules('ref_no','Reference','required');
    $this->form_validation->set_rules('time','time','required');
    $this->form_validation->set_rules('date','date','required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

    if ($this->form_validation->run()) {
        $data = $this->input->post();
        $this->load->model('queries');
        $blanch_id = $data['blanch_id'];
        $account = $data['provider'];
        $amount = $data['amount'];
        //   echo "<pre>";
        // print_r($data);
        //    exit();

        $blanch_balance = $this->queries->get_blanch_account_balance($blanch_id,$account);
        $blanch_capital = $blanch_balance->blanch_capital;

        $saving = $blanch_capital + $amount;

       $this->update_blanch_capitaldata($blanch_id,$account,$saving);
        

        if ($this->queries->insert_saving_deposit($data)) {
            $this->session->set_flashdata("massage",'Saving Deposit Saved successfully');
        }else{
           $this->session->set_flashdata("error",'Failed'); 
        }

        return redirect("admin/saving_deposit");
    }
    $this->saving_deposit();
  } 


   public function update_blanch_capitaldata($blanch_id,$account,$saving){
  $sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`= '$saving' WHERE `blanch_id`= '$blanch_id' AND `receive_trans_id`='$account'";
    // print_r($sqldata);
    //    exit();
   $query = $this->db->query($sqldata);
   return true;
  }




 public function check_miamala($id){
    $this->load->model('queries');
    $data = $this->queries->get_miamala_depost($id);
    $miamala = $this->queries->get_miamala_data($id);
    $amount = $miamala->amount;
    $account = $miamala->provider;
    $blanch_id = $miamala->blanch_id;
    $date = $miamala->date;
    $today = date("Y-m-d");

    // print_r($date);
    //   exit();

    $blanch_balance = $this->queries->get_blanch_account_balance($blanch_id,$account);
    $blanch_capital = $blanch_balance->blanch_capital;
    $saving = $blanch_capital - $amount;

    $cash_inHand = $this->queries->get_total_cashIn_Hand($blanch_id,$date);
    $cash_day = $cash_inHand->total_cashDay;

    $remove_cash = $cash_day - $amount;
     // print_r($remove_cash);
     //     exit();
    if ($date == $today) {
     $this->update_blanch_capitaldata($blanch_id,$account,$saving);  
    }else{
     $this->update_cash_prev($blanch_id,$remove_cash,$date);
    }
    
    if ($data->status = 'close') {
         // echo "<pre>";
      //   print_r($data);
      //     exit();
        $this->queries->update_miamala($data,$id);
        $this->session->set_flashdata('massage','Checked Successfully');
        }
    return redirect('admin/saving_deposit');
     
    }

  
    public function uncheck_miamala($id){
    $this->load->model('queries');
    $data = $this->queries->get_miamala_depost($id);
    $miamala = $this->queries->get_miamala_data($id);
    $amount = $miamala->amount;
    $account = $miamala->provider;
    $blanch_id = $miamala->blanch_id;
    $date = $miamala->date;
    $today = date("Y-m-d");

    $blanch_balance = $this->queries->get_blanch_account_balance($blanch_id,$account);
    $blanch_capital = $blanch_balance->blanch_capital;
    $saving = $blanch_capital + $amount;
    // print_r($saving);
    //       exit();
    $cash_inHand = $this->queries->get_total_cashIn_Hand($blanch_id,$date);
    $cash_day = $cash_inHand->total_cashDay;

    $remove_cash = $cash_day + $amount;
     // print_r($remove_cash);
     // echo "<br>";
     // print_r($cash_day);
     //     exit();
    if ($date == $today) {
     $this->update_blanch_capitaldata($blanch_id,$account,$saving);  
    }else{
     $this->update_cash_prev($blanch_id,$remove_cash,$date);
    }

    if ($data->status = 'open') {
        $this->queries->update_miamala($data,$id);
        $this->session->set_flashdata('massage','Un-Checked Successfully');
        }
    return redirect('admin/saving_deposit');
     
    }


    public function remove_saving_deoposit($id){
    $this->load->model('queries');
    $miamala = $this->queries->get_miamala_data($id);
    $amount = $miamala->amount;
    $account = $miamala->provider;
    $blanch_id = $miamala->blanch_id;

    // print_r($amount);
    //     exit();

    $blanch_balance = $this->queries->get_blanch_account_balance($blanch_id,$account);
    $blanch_capital = $blanch_balance->blanch_capital;

    $saving = $blanch_capital - $amount;
    // print_r($saving);
    //       exit();
    $this->update_blanch_capitaldata($blanch_id,$account,$saving);

    
    if($this->delete_miamala($id));
    $this->session->set_flashdata("massage",'Deleted successfully');
    return redirect("admin/saving_deposit");
  } 

  public function delete_miamala($id){
    return $this->db->delete('tbl_miamala',['id'=>$id]);
  }

    public function update_cash_prev($blanch_id,$remove_cash,$date){
    $sqldata="UPDATE `tbl_cash_inhand` SET `cash_amount`= '$remove_cash' WHERE `blanch_id`= '$blanch_id' AND `cash_day`='$date'";
    // print_r($sqldata);
    //    exit();
   $query = $this->db->query($sqldata);
   return true;    
    }


	public function general_operation(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$empl = $this->queries->get_general_loanGroup($comp_id);
		// echo "<pre>";
		// print_r($empl);
		//       exit();
	$this->load->view('admin/general_operation',['empl'=>$empl]);
	}


	public function print_general_operation()
	{
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
	    $empl = $this->queries->get_general_loanGroup($comp_id);
	    $compdata = $this->queries->get_companyData($comp_id);

    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
    $html = $this->load->view('admin/print_general_operation',['compdata'=>$compdata,'empl'=>$empl],true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
	}





	public function group_list(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$group_loan = $this->queries->get_group_loan($comp_id);
		$blanch = $this->queries->get_blanch($comp_id);
		// echo "<pre>";
		// print_r($group_loan);
		//         exit();
		$this->load->view('admin/group_list',['group_loan'=>$group_loan,'blanch'=>$blanch]);
	}

	public function print_collection_sheet(){
	$this->load->model('queries');
    $comp_id = $this->session->userdata('comp_id');
	$group_loan = $this->queries->get_group_loan($comp_id);
	$blanch = $this->queries->get_blanch($comp_id);
	$compdata = $this->queries->get_companyData($comp_id);


	$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
    $html = $this->load->view('admin/print_collection_sheet',['compdata'=>$compdata,'blanch'=>$blanch,'group_loan'=>$group_loan],true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
	}


	public function filter_group_collection(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$blanch_id = $this->input->post('blanch_id');
	$loan_status = $this->input->post('loan_status');
	$blanch = $this->queries->get_blanch($comp_id);
	$blanch_data = $this->queries->get_blanch_data($blanch_id); 

	$this->load->view('admin/group_collection',['blanch_id'=>$blanch_id,'loan_status'=>$loan_status,'blanch'=>$blanch,'blanch_data'=>$blanch_data]);
	}


	public function print_group_collection($blanch_id,$loan_status){
    $this->load->model('queries');
    $comp_id = $this->session->userdata('comp_id');
    $compdata = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanch_data($blanch_id);

    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
    $html = $this->load->view('admin/print_blanch_group_collection',['compdata'=>$compdata,'blanch_data'=>$blanch_data,'blanch_id'=>$blanch_id,'loan_status'=>$loan_status],true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
	//$this->load->view('admin/print_blanch_group_collection');
	}





	public function teller_oficer(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$empl_oficer = $this->queries->get_empl_data_loan($comp_id);
		$total_deposit = $this->queries->get_total_deposit($comp_id);
		$total_withdrawal = $this->queries->get_total_withdrawal($comp_id);
		$cash_account = $this->queries->get_totalaccount_transaction($comp_id);
		// echo "<pre>";
		//  print_r($cash_account);
		//           exit();
		$this->load->view('admin/teller_oficer',['empl_oficer'=>$empl_oficer,'total_deposit'=>$total_deposit,'total_withdrawal'=>$total_withdrawal,'cash_account'=>$cash_account]);
	}

	public function teller_trasior(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$transaction = $this->queries->get_teller_deposit_with($comp_id);
		// echo "<pre>";
		// print_r($transaction);
		//        exit();
		$this->load->view('admin/teller_trasior',['transaction'=>$transaction]);
	}

	public function daily_report(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$blanch_rec = $this->queries->get_blanch($comp_id);
		$sum_withdrawls = $this->queries->get_cash_transaction_sum($comp_id);
		$deducted_fee = $this->queries->get_total_deducted_income($comp_id);
		$total_code_no = $this->queries->get_total_code_number($comp_id);
		$penart_paid = $this->queries->get_total_penart_paid($comp_id);
		$total_stoo = $this->queries->get_total_stoo_company($comp_id);
		$total_miamala = $this->queries->get_miamala_hewa_total($comp_id);


		$account_deposit = $this->queries->get_deposit_sunnary_account($comp_id);
 	    $toyal_default = $this->queries->get_depositing_out_total($comp_id);

 	    $withdrawal_account = $this->queries->get_withdrawal_summary_account($comp_id);
 	    
		 //      echo "<pre>";
		 // print_r($total_stoo);
		 //        exit();
		$this->load->view('admin/daily_report',['blanch_rec'=>$blanch_rec,'sum_withdrawls'=>$sum_withdrawls,'deducted_fee'=>$deducted_fee,'total_code_no'=>$total_code_no,'penart_paid'=>$penart_paid,'total_stoo'=>$total_stoo,'total_miamala'=>$total_miamala,'account_deposit'=>$account_deposit,'toyal_default'=>$toyal_default,'withdrawal_account'=>$withdrawal_account]);
	}


	public function filter_daily_report(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
        $blanch_rec = $this->queries->get_blanch($comp_id);
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		$comp_id = $this->input->post('comp_id');


		$total_code_no = $this->queries->get_total_code_number_comp($comp_id,$from,$to);
		$deducted_fee = $this->queries->get_total_deducted_income_company($comp_id,$from,$to);
		$penart_paid = $this->queries->get_total_penart_paid_company($comp_id,$from,$to);
		$total_stoo = $this->queries->get_total_stoo_company_prev($comp_id,$from,$to);
		$total_miamala = $this->queries->get_miamala_hewa_total_company($comp_id,$from,$to);

		 $account_deposit = $this->queries->get_deposit_sunnary_account_company($comp_id,$from,$to);
         $toyal_default = $this->queries->get_depositing_out_total_comp($comp_id,$from,$to);
         $withdrawal_account = $this->queries->get_withdrawal_summary_account_company($comp_id,$from,$to);
 	    $total_code_no = $this->queries->get_total_code_number_comp($comp_id,$from,$to);
 	    //$deducted_fee = $this->queries->get_total_deducted_income_company($comp_id,$from,$to);

		// print_r($from);
		//    exit();

		$this->load->view('admin/daily_report_prev',['blanch_rec'=>$blanch_rec,'from'=>$from,'to'=>$to,'total_code_no'=>$total_code_no,'deducted_fee'=>$deducted_fee,'penart_paid'=>$penart_paid,'total_stoo'=>$total_stoo,'total_miamala'=>$total_miamala,'account_deposit'=>$account_deposit,'toyal_default'=>$toyal_default,'withdrawal_account'=>$withdrawal_account,'total_code_no'=>$total_code_no]);
	}

	public function print_daily_report($from,$to){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$compdata = $this->queries->get_companyData($comp_id);
	$blanch_rec = $this->queries->get_blanch($comp_id);

	$total_code_no = $this->queries->get_total_code_number_comp($comp_id,$from,$to);
	$deducted_fee = $this->queries->get_total_deducted_income_company($comp_id,$from,$to);
	$penart_paid = $this->queries->get_total_penart_paid_company($comp_id,$from,$to);
	$total_stoo = $this->queries->get_total_stoo_company_prev($comp_id,$from,$to);
	$total_miamala = $this->queries->get_miamala_hewa_total_company($comp_id,$from,$to);

	 $account_deposit = $this->queries->get_deposit_sunnary_account_company($comp_id,$from,$to);
     $toyal_default = $this->queries->get_depositing_out_total_comp($comp_id,$from,$to);
     $withdrawal_account = $this->queries->get_withdrawal_summary_account_company($comp_id,$from,$to);
	 $total_code_no = $this->queries->get_total_code_number_comp($comp_id,$from,$to);
	

	$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
    $html = $this->load->view('admin/daily_report_data',['compdata'=>$compdata,'blanch_rec'=>$blanch_rec,'from'=>$from,'to'=>$to,'total_code_no'=>$total_code_no,'deducted_fee'=>$deducted_fee,'penart_paid'=>$penart_paid,'total_stoo'=>$total_stoo,'total_miamala'=>$total_miamala,'account_deposit'=>$account_deposit,'toyal_default'=>$toyal_default,'withdrawal_account'=>$withdrawal_account,'total_code_no'=>$total_code_no],true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
    $mpdf->WriteHTML($html);
    $mpdf->Output();	
	}





	


	public function group_loaan_customer(){
		$this->load->model('queries');
		$this->load->view('admin/group_statement');
	}


	public function loan_oficer_expectation(){
		$this->load->model('queries');
		$comp_id = $this->session->userdata('comp_id');
		$blanch = $this->queries->get_blanch($comp_id);

		$this->load->view('admin/oficer_expectation',['blanch'=>$blanch]);
	}

	public function add_privillage($position_id,$empl_id,$comp_id){
		$this->load->model('queries');
		$position_id = $position_id;
		$empl_id = $empl_id;
		$comp_id = $comp_id;

      $check_priv = $this->queries->check_empl_privillage($position_id,$empl_id,$comp_id);

      if ($check_priv == TRUE) {
      	$this->session->set_flashdata("error",'Privillage Added Please Select Another Privillage');
      	return redirect('admin/privillage/'.$empl_id);
      }elseif ($check_priv == FALSE) {
     
     $this->db->query("INSERT INTO tbl_privellage (`comp_id`,`empl_id`,`position_id`) VALUES ('$comp_id','$empl_id','$position_id')");

     $this->session->set_flashdata("massage",'Privillage  Added successfully');
      	return redirect('admin/privillage/'.$empl_id);
      }

	}

function fetch_employee_blanch()
{
$this->load->model('queries');
if($this->input->post('blanch_id'))
{
echo $this->queries->fetch_employee($this->input->post('blanch_id'));
}

}


public function Default_loan(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$default = $this->queries->get_outstand_loan_company($comp_id);
	$total_default = $this->queries->get_total_outStand_comp($comp_id);
	$blanch = $this->queries->get_blanch($comp_id);
	// print_r($blanch);
	//     exit();
	$this->load->view('admin/default_loan',['default'=>$default,'total_default'=>$total_default,'blanch'=>$blanch]);
}


public function filter_default_loan(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$blanch = $this->queries->get_blanch($comp_id);



	$blanch_id = $this->input->post('blanch_id');
    $from = $this->input->post('from');
    $to = $this->input->post('to');

     if ($blanch_id == 'all') {
     $default_blanch = $this->queries->filter_loan_default_comp($comp_id,$from,$to);
    $total_blanch = $this->queries->get_total_outStand_company($comp_id,$from,$to);    
     }else{
	$default_blanch = $this->queries->filter_loan_default($blanch_id,$from,$to);
	$total_blanch = $this->queries->get_total_outStand_blanch($blanch_id,$from,$to);
    }

	$blanch_data = $this->queries->get_blanch_data($blanch_id);
	// echo "<pre>";
	// print_r($total_blanch);
	//       exit();

	$this->load->view('admin/filter_defaultloan',['blanch'=>$blanch,'default_blanch'=>$default_blanch,'total_blanch'=>$total_blanch,'blanch_data'=>$blanch_data,'blanch_id'=>$blanch_id,'from'=>$from,'to'=>$to]);
}


public function print_default_loan($blanch_id,$from,$to){
    $this->load->model('queries');
    $comp_id = $this->session->userdata('comp_id');
    $compdata = $this->queries->get_companyData($comp_id);
     if ($blanch_id == 'all') {
     $default_blanch = $this->queries->filter_loan_default_comp($comp_id,$from,$to);
    $total_blanch = $this->queries->get_total_outStand_company($comp_id,$from,$to);    
     }else{
    $default_blanch = $this->queries->filter_loan_default($blanch_id,$from,$to);
    $total_blanch = $this->queries->get_total_outStand_blanch($blanch_id,$from,$to);
    }

    $blanch_data = $this->queries->get_blanch_data($blanch_id);
    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4-L','orientation' => 'L']);
    $html = $this->load->view('admin/default_report',['compdata'=>$compdata,'default_blanch'=>$default_blanch,'total_blanch'=>$total_blanch,'blanch_data'=>$blanch_data,'blanch_id'=>$blanch_id,'from'=>$from,'to'=>$to],true);
    $mpdf->SetFooter('Generated By Brainsoft');
    $mpdf->SetWatermarkText($compdata->comp_name);
    $mpdf->showWatermarkText = true;
    $date = date("Y-m-d");
    $mpdf->WriteHTML($html);
    $output = 'Default Loan ' . $date.'.pdf';
    $mpdf->Output("$output", 'I');
}


public function default_outsystem(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
    $blanch = $this->queries->get_blanch($comp_id);
    $data_blanch_out = $this->queries->get_outloan_data($comp_id);

    $total_out_balance = $this->queries->get_total_out($comp_id);
    $blanch = $this->queries->get_blanch($comp_id);


    $out_deposit = $this->queries->get_otstand_systemDeposit_comp($comp_id);
    $sum_depost = $this->queries->get_otstand_systemDeposit_compsum_deposit($comp_id);
    //         echo "<pre>";
    // print_r($data_blanch_out);
    //           exit();
	$this->load->view('admin/default_outsystem',['blanch'=>$blanch,'data_blanch_out'=>$data_blanch_out,'total_out_balance'=>$total_out_balance,'blanch'=>$blanch,'out_deposit'=>$out_deposit,'sum_depost'=>$sum_depost]);
}


public function create_default_loan_out(){
	     $this->load->model('queries');
        $this->form_validation->set_rules('comp_id','company','required');
        $this->form_validation->set_rules('blanch_id','blanch','required');
        $this->form_validation->set_rules('out_amount','Amount','required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $comp_id = $data['comp_id'];
            $blanch_id = $data['blanch_id'];
            $out_amount = $data['out_amount'];
            
            $old_out = $this->queries->get_total_outsytem_loan($blanch_id,$comp_id);
            $old_balance = $old_out->out_amount;
            $out_data = $old_balance + $out_amount;

            if ($old_out == TRUE) {
            $this->update_outsystem_loan($comp_id,$blanch_id,$out_data);	
            }else{
            $this->insert_out_standloan_out($data);	
            }

            // print_r($out_data);
            //       exit();
            
            
            $this->session->set_flashdata("massage",'Saved successfully');
            return redirect("admin/default_outsystem");
        }
        $this->default_outsystem();
    }


      public function insert_out_standloan_out($data){
       	return $this->db->insert('tbl_out_system',$data);
     }

     public function update_outsystem_loan($comp_id,$blanch_id,$out_data){
     $sqldata="UPDATE `tbl_out_system` SET `out_amount`= '$out_data' WHERE `blanch_id`= '$blanch_id' AND `comp_id`='$comp_id'";
     $query = $this->db->query($sqldata);
     return true; 
     }


     public function update_out_prepaid($id){
     $this->form_validation->set_rules('out_amount','Amount','required');
     $this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
     if ($this->form_validation->run()) {
     	 $data = $this->input->post();
     	 //  echo "<pre>";
     	 // print_r($data);
     	 //       exit();
     	 $this->load->model('queries');
     	 if ($this->queries->update_loan_outstand($data,$id)) {
     	 	$this->session->set_flashdata("massage",'Successfully');
     	 }else{
     	 	$this->session->set_flashdata("error",'Failed');
     	 }
     	 return redirect('admin/default_outsystem');
       }
       $this->default_outsystem();
     }


     public function create_deposit_out(){
        $this->load->model('queries');
        $this->form_validation->set_rules('comp_id','company','required');
        $this->form_validation->set_rules('blanch_id','blanch','required');
        //$this->form_validation->set_rules('empl_id','Employee','required');
        $this->form_validation->set_rules('trans_id','Account','required');
        $this->form_validation->set_rules('customer_name','Customer','required');
        $this->form_validation->set_rules('amount','Amount','required');
        $this->form_validation->set_rules('date','date','required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

        if ($this->form_validation->run()) {
            $data = $this->input->post();
             //  echo "<pre>";
             // print_r($data);
             //      exit();
            $blanch_id = $data['blanch_id'];
            $empl_id = $data['empl_id'];
            $trans_id = $data['trans_id'];
            $amount = $data['amount'];
            $comp_id = $data['comp_id'];

            @$blanch_out = $this->queries->get_receive_outsystem($blanch_id,$trans_id);
            $amount_receive = @$blanch_out->amount_receive;

            $new_receve = $amount_receive + $amount;

            if (@$blanch_out->amount_receive == TRUE || @$blanch_out->amount_receive == '0') {

                $this->update_outstand_deposit_system($blanch_id,$trans_id,$new_receve);
                //echo "UPDATE";
            }else{

            $this->insert_outstand_deposit_system($comp_id,$blanch_id,$trans_id,$new_receve);
                //echo "insert";
            }

            // echo "<pre>";
            // print_r($new_receve);
            //     exit();
            
            if ($this->queries->insert_deposit_out($data)) {
                $this->session->set_flashdata("massage",'Deposit Successfully');
            }else{
              $this->session->set_flashdata("error",'Failed');  
            }
            return redirect("admin/default_outsystem");
        }
        $this->default_outsystem();
    }

    public function update_outstand_deposit_system($blanch_id,$trans_id,$new_receve){
    $sqldata="UPDATE `tbl_receive_outsystem` SET `amount_receive`= '$new_receve' WHERE `blanch_id`= '$blanch_id' AND `trans_id`='$trans_id'";
   $query = $this->db->query($sqldata);
   return true;   
    }

     public function insert_outstand_deposit_system($comp_id,$blanch_id,$trans_id,$new_receve){
     $this->db->query("INSERT INTO  tbl_receive_outsystem (`comp_id`,`blanch_id`,`trans_id`,`amount_receive`) VALUES ('$comp_id', '$blanch_id','$trans_id','$new_receve')");  
    }

     public function delete_outstand_system($id){
        $this->load->model('queries');
        $data_out = $this->queries->get_out_system($id);
        $amount = $data_out->amount;
        $trans_id = $data_out->trans_id;
        $blanch_id = $data_out->blanch_id;

        $out_system_data = $this->queries->get_receive_outsystem($blanch_id,$trans_id);
        $amount_receive = $out_system_data->amount_receive;

        $new_receve = $amount_receive - $amount;

        $this->update_outstand_deposit_system($blanch_id,$trans_id,$new_receve);
        // print_r($amount_receive);
        //         exit();
        if($this->remove_out_system($id));
        $this->session->set_flashdata("massage",'Data Deleted successfully');
        return redirect("admin/default_outsystem");
    }

    public function remove_out_system($id){
        return $this->db->delete('tbl_depost_out',['id'=>$id]);
    }


    function fetch_blanch_acount()
{
$this->load->model('queries');
if($this->input->post('blanch_id'))
{
echo $this->queries->fetch_blanch_account_data($this->input->post('blanch_id'));
}
}



public function amount_setting(){
	$this->load->model('queries');
	$comp_id = $this->session->userdata('comp_id');
	$blanch = $this->queries->get_blanch($comp_id);

	$this->load->view('admin/amount_setting',['blanch'=>$blanch]);
}


public function modify_blanch_account(){
	$this->form_validation->set_rules('blanch_id','Branch','required');
	$this->form_validation->set_rules('receive_trans_id','account','required');
	$this->form_validation->set_rules('blanch_capital','Capital','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

	if ($this->form_validation->run()) {
		$data = $this->input->post();
		$blanch_id = $data['blanch_id'];
		$account = $data['receive_trans_id'];
		$capital = $data['blanch_capital'];

		$this->update_capital_blanch($blanch_id,$account,$capital);
		$this->session->set_flashdata("massage",'Successfully');
         return redirect('admin/amount_setting');
		// print_r($capital);
		//    exit();
	}
	$this->amount_setting();
}


public function update_capital_blanch($blanch_id,$account,$capital){
 $sqldata="UPDATE `tbl_blanch_account` SET `blanch_capital`= '$capital' WHERE `blanch_id`= '$blanch_id' AND `receive_trans_id`='$account'";
     $query = $this->db->query($sqldata);
     return true; 	
}


public function modify_cash_inhand(){
	$this->load->model('queries');
	$this->form_validation->set_rules('comp_id','company','required');
	$this->form_validation->set_rules('blanch_id','blanch','required');
	$this->form_validation->set_rules('cash_amount','Amount','required');
	$this->form_validation->set_rules('cash_day','date','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
	if ($this->form_validation->run()) {
		$data = $this->input->post();
		$comp_id = $data['comp_id'];
		$blanch_id = $data['blanch_id'];
		$cash_day = $data['cash_day'];
		$cash_amount = $data['cash_amount'];

        $date_confirm = $this->queries->get_date_cashinhand($comp_id,$blanch_id,$cash_day);

        if ($date_confirm == TRUE) {
         $this->update_cashdata($comp_id,$blanch_id,$cash_amount,$cash_day);
       $this->session->set_flashdata("massage",'Update Successfully');
        }else{
       $this->queries->insert_cash_inhand($data);
       $this->session->set_flashdata("massage",'Successfully');
        }

		// print_r($date_confirm);
		//       exit();
		return redirect('admin/amount_setting');
	}
	$this->amount_setting();
}



public function update_cashdata($comp_id,$blanch_id,$cash_amount,$cash_day){
 $sqldata ="UPDATE `tbl_cash_inhand` SET `cash_amount`= '$cash_amount' WHERE `comp_id`= '$comp_id' AND `blanch_id`='$blanch_id' AND `cash_day` = '$cash_day'";
 // print_r($sqldata);
 //         exit();
     $query = $this->db->query($sqldata);
     return true; 	
}


public function modify_fomu(){
	$this->load->model('queries');
	$this->form_validation->set_rules('comp_id','company','required');
	$this->form_validation->set_rules('blanch_id','blanch','required');
	$this->form_validation->set_rules('deduct_balance','Amount','required');
	$this->form_validation->set_rules('date_deduct','date','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
	if ($this->form_validation->run()) {
		$data = $this->input->post();
		$comp_id = $data['comp_id'];
		$blanch_id = $data['blanch_id'];
		$date_deduct = $data['date_deduct'];
		$deduct_balance = $data['deduct_balance'];

		$date_conf = $this->queries->get_daeduction_day_data($comp_id,$blanch_id,$date_deduct);
		if ($date_conf == TRUE){
			$this->update_hela_yafomu($comp_id,$blanch_id,$deduct_balance,$date_deduct);
			$this->session->set_flashdata("massage",'Update Successfully');
		}else{
		$this->queries->insert_fomu($data);
		$this->session->set_flashdata("massage",'Successfully');
		}
		//exit();
		
		
		return redirect('admin/amount_setting');
	}
	$this->amount_setting();
}

public function update_hela_yafomu($comp_id,$blanch_id,$deduct_balance,$date_deduct){
 $sqldata ="UPDATE `tbl_deduction_day` SET `deduct_balance`= '$deduct_balance' WHERE `comp_id`= '$comp_id' AND `blanch_id`='$blanch_id' AND `date_deduct` = '$date_deduct'";
 // print_r($sqldata);
 //         exit();
     $query = $this->db->query($sqldata);
     return true; 	
}

public function modify_faini(){
	$this->load->model('queries');
	$this->form_validation->set_rules('comp_id','company','required');
	$this->form_validation->set_rules('blanch_id','blanch','required');
	$this->form_validation->set_rules('non_deduct_balance','Amount','required');
	$this->form_validation->set_rules('non_date','date','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
	if ($this->form_validation->run()) {
		$data = $this->input->post();

		$comp_id = $data['comp_id'];
		$blanch_id = $data['blanch_id'];
		$non_deduct_balance = $data['non_deduct_balance'];
		$non_date = $data['non_date'];

		$date_conf = $this->queries->get_non_deduct_data($comp_id,$blanch_id,$non_date);

		if ($date_conf == TRUE) {
			//echo "update";
		$this->update_faini_data($comp_id,$blanch_id,$non_deduct_balance,$non_date);
		$this->session->set_flashdata("massage",'update Successfully');
		}else{
		//echo "insert";
		$this->queries->insert_faini($data);
		$this->session->set_flashdata("massage",'Successfully');	
		}
		// print_r($data);
		//       exit();
		
		
		return redirect('admin/amount_setting');
	}
	$this->amount_setting();
}

public function update_faini_data($comp_id,$blanch_id,$non_deduct_balance,$non_date){
$sqldata ="UPDATE `tbl_non_deduct_day` SET `non_deduct_balance`= '$non_deduct_balance' WHERE `comp_id`= '$comp_id' AND `blanch_id`='$blanch_id' AND `non_date` = '$non_date'";
 // print_r($sqldata);
 //         exit();
     $query = $this->db->query($sqldata);
     return true;	
}


public function modify_jumla_income(){
	$this->load->model('queries');
	$this->form_validation->set_rules('comp_id','company','required');
	$this->form_validation->set_rules('blanch_id','blanch','required');
	$this->form_validation->set_rules('amount','Amount','required');
	$this->form_validation->set_rules('date','date','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
	if ($this->form_validation->run()) {
		$data = $this->input->post();

		$comp_id = $data['comp_id'];
		$blanch_id = $data['blanch_id'];
		$amount = $data['amount'];
		$date = $data['date'];

		$date_conf = $this->queries->get_total_fainiFomu($comp_id,$blanch_id,$date);

		if ($date_conf == TRUE) {
		$this->update_jumla($comp_id,$blanch_id,$amount,$date);
		$this->update_receive_income_deducted($comp_id,$blanch_id,$amount);
		$this->update_non_balance_deducted($comp_id,$blanch_id);
		$this->session->set_flashdata("massage",'Update Successfully');
		}else{
          $this->queries->insert_jumla_income($data);
          $this->update_receive_income_deducted($comp_id,$blanch_id,$amount);
          $this->update_non_balance_deducted($comp_id,$blanch_id);
          $this->session->set_flashdata("massage",'Successfully');
		}
		// print_r($date_conf);
		//       exit();
		
		return redirect('admin/amount_setting');
	}
	$this->amount_setting();
}


public function update_jumla($comp_id,$blanch_id,$amount,$date){
 $sqldata ="UPDATE `tbl_deduction` SET `amount`= '$amount' WHERE `comp_id`= '$comp_id' AND `blanch_id`='$blanch_id' AND `date` = '$date'";
 // print_r($sqldata);
 //         exit();
     $query = $this->db->query($sqldata);
     return true;	
}

public function update_receive_income_deducted($comp_id,$blanch_id,$amount){
$sqldata ="UPDATE `tbl_receive_deducted` SET `deducted`= '$amount' WHERE `comp_id`= '$comp_id' AND `blanch_id`='$blanch_id'";
 // print_r($sqldata);
 //         exit();
     $query = $this->db->query($sqldata);
     return true;
}


public function update_non_balance_deducted($comp_id,$blanch_id){
  $sqldata ="UPDATE `tbl_receive_non_deducted` SET `non_balance`= '0' WHERE `comp_id`= '$comp_id' AND `blanch_id`='$blanch_id'";
 // print_r($sqldata);
 //         exit();
     $query = $this->db->query($sqldata);
     return true;
}



public function samehe_faini($customer_id){
	$this->load->model('queries');
	$this->form_validation->set_rules('comp_id','company','required');
	$this->form_validation->set_rules('blanch_id','blanch','required');
	$this->form_validation->set_rules('loan_id','Loan','required');
	$this->form_validation->set_rules('customer_id','Customer','required');
	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

	if ($this->form_validation->run()) {
		$data = $this->input->post();
		$comp_id = $data['comp_id'];
		$customer_id = $data['customer_id'];
		$blanch_id = $data['blanch_id'];

		$company = $this->queries->get_comp_data($comp_id);
        $comp_name = $company->comp_name;
        $comp_phone = $company->comp_phone;
        
        $data_sms = $this->queries->get_loan_reminder($customer_id);
        $phone = $data_sms->phone_no;
        $first_name = $data_sms->f_name;
        $midle_name = $data_sms->m_name;
        $last_name = $data_sms->l_name;
        $massage = 'Ndugu, ' .$first_name . ' ' .$midle_name . ' ' .$last_name . ' ' .'Umesamehewa faini ya kulaza rejesho '.$comp_name .' epuka kuchajiwa faini ukilaza rejesho';
		// print_r($massage);
		//     exit();
		$this->load->model('queries');
		if ($this->queries->insert_msamaha($data)) {
			$this->session->set_flashdata("massage",'Umefanikiwa Kusamehe Faini Ahsante');
		}else{
		 $this->session->set_flashdata("massage",'Umefanikiwa Kusamehe Faini Ahsante');	
		}
		//$this->sendsms($phone,$massage);
		return redirect('admin/data_with_depost/'.$customer_id);
	}
	$this->data_with_depost();
}


public function reminder_sms(){
$this->load->model('queries');
$comp_id = $this->session->userdata('comp_id');
$sms_reminder = $this->queries->get_sms_data($comp_id);
$this->load->view('admin/reminder',['sms_reminder'=>$sms_reminder]);
}


public function create_sms_setup(){
    	$this->form_validation->set_rules('comp_id','company','required');
    	$this->form_validation->set_rules('description','Sms','required');
    	$this->form_validation->set_rules('sms_type','Type','required');
    	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

    	if ($this->form_validation->run()) {
    		$data = $this->input->post();
    		//      echo "<pre>";
    		// print_r($data);
    		//     exit();
    		$this->load->model('queries');

    		if ($this->queries->insert_sms_settup($data)) {
    			$this->session->set_flashdata("massage",'Sucessfully');
    		}else{
    			$this->session->set_flashdata("error",'Sucessfully');
    		}
    		return redirect('admin/reminder_sms');
    	}
    	$this->reminder_sms();
    }


    public function delete_sms_reminder($id){
    	$this->load->model('queries');
    	if($this->queries->remove_sms($id));
    	$this->session->set_flashdata("massage",'Data Deleted successfully');
    	return redirect('admin/reminder_sms');
    }

    public function update_sms_setup($id){
    	$this->form_validation->set_rules('description','Sms','required');
    	$this->form_validation->set_rules('sms_type','Type','required');
    	$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

    	if ($this->form_validation->run()) {
    		$data = $this->input->post();
    		//    echo "<pre>";
    		// print_r($data);
    		//     exit();
    		$this->load->model('queries');

    		if ($this->queries->update_sms_settup($data,$id)) {
    			$this->session->set_flashdata("massage",'SMS Update Sucessfully');
    		}else{
    			$this->session->set_flashdata("error",'SMS Update Sucessfully');
    		}
    		return redirect('admin/reminder_sms');
    	}
    	$this->reminder_sms();
    }



  public function send_sms_reminder(){
 $this->load->model('queries');
 $comp_id = $this->session->userdata('comp_id');
 $loan_status = $this->input->post('sms_type');

 if ($loan_status == 'staff') {
  $staff = $this->db->query("SELECT * FROM tbl_employee WHERE comp_id = '$comp_id'");
  $staff_reminder = $staff->result();

 }elseif($loan_status == 'all'){
  $data = $this->db->query("SELECT c.phone_no,c.customer_id FROM tbl_customer c  WHERE c.comp_id = '$comp_id'");
 $reminder = $data->result();
 }else{
$data = $this->db->query("SELECT c.phone_no,c.customer_id,c.customer_status FROM tbl_customer c  WHERE c.customer_status ='$loan_status' AND c.comp_id = '$comp_id'");
 	 $reminder = $data->result();
 }
  
 if ($loan_status == 'staff') {
  foreach ($staff_reminder as $staff_reminders) {
   $this->send_staff_sms($staff_reminders->empl_id,$comp_id,$loan_status);
  }
 }else{
  foreach ($reminder as $reminders) {
  $this->send_remindersms($reminders->customer_id,$comp_id,$loan_status);
  }

  }
	// echo "<pre>";
	// print_r($reminder);
	//        exit();
  $this->session->set_flashdata("massage",'massage Sent Successfully');
    return redirect('admin/reminder_sms');
}


public function send_remindersms($customer_id,$comp_id,$loan_status){
	// print_r($comp_id);
	// exit();
	$this->load->model('queries');
    $data_sms = $this->queries->get_sms_structure($comp_id,$loan_status);
    $sms = $data_sms->description;
		
	$data_sms = $this->queries->get_loan_reminder($customer_id);
	$phone = $data_sms->phone_no;
	$first_name = $data_sms->f_name;
	$midle_name = $data_sms->m_name;
	$last_name = $data_sms->l_name;
	$massage = 'Ndugu, ' .$first_name . ' ' .$midle_name . ' ' .$last_name . ' ' .$sms;
	//    echo "<pre>";
	// print_r($massage);
	//      exit();
	$this->sendsms($phone,$massage);

}


public function send_staff_sms($empl_id,$comp_id,$loan_status){
	$this->load->model('queries');
	$data_sms = $this->queries->get_sms_structure($comp_id,$loan_status);
    $sms = $data_sms->description;

    $staff_sms = $this->queries->get_employee_data_staff($empl_id);
    $phone_number = $staff_sms->empl_no;
    $full_name = $staff_sms->empl_name;
    $phone = $phone_number;

    $massage = 'Ndugu, '. $full_name . ' '. $sms;
    // print_r($massage);
    //  exit();
    $this->sendsms($phone,$massage);
    
     // print_r($massage);
     // exit();
}




   public function view_blanchPanel($blanch_id){
        $this->load->model('queries');
        $comp_id = $this->session->userdata('comp_id');
        $blanch = $this->queries->get_blanchd($comp_id);
        $blanch_datas = $this->queries->get_managerBlanch($blanch_id);
        $compdata = $this->queries->get_comp_data($comp_id);


 	    
        // print_r($compdata);
        //    exit();
        
        $this->load->view('admin/blanch_panel',['blanch'=>$blanch,'blanch_datas'=>$blanch_datas,'blanch_id'=>$blanch_id,'compdata'=>$compdata]);
    }















	

 


// public function sendEmail(){
// 	  // print_r($send_email);
// 	  //    exit();
// //$this->sendgrid();
//  $send_email = "kochatest@gmail.com";
//  $data = "samweldamian12@gmail.com";
//  $massage = "NAKUPENDA SANA";
//  // print_r($send_email);
//  // print_r($massage);
//  //       exit();
//  $email = new \SendGrid\Mail\Mail();
//  $email->setFrom($send_email);
//  $email->setSubject("MikopoSoft");
//  $email->addTo($data);
//  $email->addContent("text/plain",$massage);
//  $email->addContent(

//   "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
//    );
// $sendgrid = new \SendGrid('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');
//    print_r($sendgrid);
//  //print_r($massage);
//         exit();
//  try {
//  $response = $sendgrid->send($email);
//  print $response->statusCode() . "\n";
//  print_r($response->headers());
//  print $response->body() . "\n";

// } catch (Exception $e) {
// echo 'Caught exception: '. $e->getMessage() ."\n";
// }
// //$this->sendEmail();
// }

//send sms function
      //beem Api
// function sendsms($phone,$massage){
//     $message = urlencode($massage);
//     $sender = 'SEDEMO'; 
//     $api_key = 'd4af7dff16f3ab47';
//     $secret_key = 'MjIyNWIwODNmNTNjZTg3OTI2MDBlNGQyYThjNTFjMzAwNmIzMjBhMmJhMGFjNDUxYjRmNmRhOTYxZGY3ZGZiOA==';
    
// $postData = array(
//     'source_addr' => 'INFO',
//     'encoding'=>0,
//     'schedule_time' => '',
//     'message' => $massage,
//     'recipients' => [array('recipient_id' => '1','dest_addr'=>$phone)]
// );

// $Url ='https://apisms.beem.africa/v1/send';

// $ch = curl_init($Url);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
// curl_setopt_array($ch, array(
//     CURLOPT_POST => TRUE,
//     CURLOPT_RETURNTRANSFER => TRUE,
//     CURLOPT_HTTPHEADER => array(
//         'Authorization:Basic ' . base64_encode("$api_key:$secret_key"),
//         'Content-Type: application/json'
//     ),
//     CURLOPT_POSTFIELDS => json_encode($postData)
// ));

// $response = curl_exec($ch);

// if($response === FALSE){
//         echo $response;

//     die(curl_error($ch));
// }
// //var_dump($response);
// return true;

// }

//next sms Api
// function sendsms($phone,$massage){

//     //$phone = "255753871034";
//     //$massage = "haloo there pokea salaam";
//     $address = array("from"=>"NEXTSMS","to"=>$phone,"text"=>$massage);
//     $curl = curl_init();
//     curl_setopt_array($curl, array(
//     CURLOPT_URL => 'https://messaging-service.co.tz/api/sms/v1/text/single',
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => '',
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 0,
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => 'POST',
//     CURLOPT_POSTFIELDS => json_encode($address),
//     CURLOPT_HTTPHEADER => array(
//         'Authorization: Basic bWlrb3Bvc29mdDpwYXNzd29yZA==',
//         'Content-Type: application/json',
//         'Accept: application/json'
//     ),
//     ));

// $response = curl_exec($curl);
// curl_close($curl);
// //echo $response;
// return true;
// }

public function sendsms($phone,$massage){
	//public function sendsms(){
	//$phone = '255628323760';
	//$massage = 'mapenzi yanauwa';
	$api_key = 'hzj3MH7QjV9cMSnjTTemjvXi5k';
	//$api_key = 'qFzd89PXu1e/DuwbwxOE5uUBn6';
	//$curl = curl_init();
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,"https://galadove.loan-pocket.com/api/v1/receive/action/send/sms");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            'apiKey='.$api_key.'&phoneNumber='.$phone.'&messageContent='.$massage);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($ch);
curl_close ($ch);

//print_r($server_output);
}



	  	//session destroy
	  public function __construct(){
	   parent::__construct();
	   $lang = ($this->session->userdata('lang')) ?
       $this->session->userdata('lang') : config_item('language');
       $this->lang->load('menu',$lang);
	   if (!$this->session->userdata("comp_id"))
	  return redirect("welcome/index");
}

  

}