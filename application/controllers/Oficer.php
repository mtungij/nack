<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Oficer extends CI_Controller
{
  public function index()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $blanch_id = $manager_data->blanch_id;
    $blanchCostomer = $this->queries->get_active_todayblanch_customer($blanch_id);
    $wadeni = $this->queries->get_wadeni_sugu($blanch_id);
    $activecustomer = $this->queries->get_active_todayblanch_customer($blanch_id);
    $out_customer_count = $this->queries->getOutCustomersCountByBlanchId($blanch_id);
    $pendingtoday = $this->queries->get_pending_customer($blanch_id);
    $hai_wateja = $this->queries->get_depositing_hai_blanch($blanch_id);
    $today_default = $this->queries->get_depositing_out_total_blanch($blanch_id);
    $defaulttotal = $this->queries->get_total_branch_default($blanch_id);
    $defaulttotalpay = $this->queries->get_customer_default_pay($blanch_id);
    $donetoday = $this->queries->get_done_customers_count($blanch_id);
    $todaydeposit = $this->queries->get_total_deposits($blanch_id);
    $denijumla = $this->queries->get_total_deni($blanch_id);
    $haijumla = $this->queries->get_total_hai($blanch_id);
    $jumlahai = $this->queries->get_hai_jumla($blanch_id);
    $denisugu = $this->queries->get_mauzo_out_jumla($blanch_id);
    $todayclose = $this->queries->get_total_deposit_for_closed_customers($blanch_id);
    $rejeshoclose = $this->queries->get_closed_rejesho_today($blanch_id);
    $rejesho = $this->queries->get_open_rejesho_today($blanch_id);
    $double = $this->queries->get_overpaid_amounts($blanch_id);
    $today_mauzo = $this->queries->get_total_recevabletawi($blanch_id);
    $total_faini = $this->queries->get_sum_incomeBlanchData($blanch_id);

    //  var_dump( $total_faini);

    //   exit();


    $data = [
      'activecustomer' => $activecustomer,
      'defaulttotal' => $defaulttotal,
      'defaulttotalpay' => $defaulttotalpay,
      'manager_data' => $manager_data,
      'blanchCostomer' => $blanchCostomer,
      'wadeni' => $wadeni,
      'hai_wateja' => $hai_wateja,
      'today_default' => $today_default,
      'donetoday' => $donetoday,
      'out_customer_count' => $out_customer_count,
      'pendingtoday' => $pendingtoday,
      'today_mauzo' => $today_mauzo,
      'total_faini' => $total_faini,

      'todaydeposit' => $todaydeposit,
      'denijumla' => $denijumla,
      'haijumla' => $haijumla,
      'jumlahai' => $jumlahai,
      'denisugu' => $denisugu,
      'todayclose' => $todayclose,
      'rejeshoclose' => $rejeshoclose
    ];



    $this->load->view('oficer/index', $data);


  }


  public function setting()
  {
    $this->load->model('queries');
    $empl_id = $this->session->userdata('empl_id');
    $empl_data = $this->queries->get_employee_data($empl_id);
    $this->load->view('oficer/setting', ['empl_data' => $empl_data]);
  }

  //change password
  public function change_password()
  {
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

    if ($this->form_validation->run()) {
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
      if ($old !== sha1($oldpass)) {
        $this->session->set_flashdata('error', 'Old Password not Match');
        return redirect('oficer/setting');
      } elseif ($old == sha1($oldpass)) {
        $this->queries->update_password_dataEmployee($empl_id, array('password' => sha1($newpass)));
        $this->session->set_flashdata('massage', 'Password changed successfully');
        $empl_data = $this->queries->get_employee_data($empl_id);
        $privillage = $this->queries->get_position_empl($empl_id);
        $manager = $this->queries->get_position_manager($empl_id);
        $this->load->view("oficer/setting", ['empl_data' => $empl_data, 'privillage' => $privillage, 'manager' => $manager]);

      } else {
        $empl_data = $this->queries->get_employee_data($empl_id);
        $privillage = $this->queries->get_position_empl($empl_id);
        $manager = $this->queries->get_position_manager($empl_id);
        $this->load->view("oficer/setting", ['empl_data' => $empl_data, 'privillage' => $privillage, 'manager' => $manager]);
      }
    }
  }
  // check old password is match
  public function password_check($oldpass)
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);
    $user = $this->queries->get_employee_data($empl_id);

    if ($user->password !== sha1($oldpass)) {
      $this->form_validation->set_message('error', 'Old Password not Match');
      //return false;
    }

    return redirect("oficer/setting");
  }



  public function income_dashboard()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $income = $this->queries->get_income($comp_id);
    $detail_income = $this->queries->get_income_detailBlanchData($blanch_id);
    $total_receved = $this->queries->get_sum_incomeBlanchData($blanch_id);
    $customer = $this->queries->get_allcutomerblanchData($blanch_id);

    // echo "<pre>";
    //   print_r($detail_income);
    //         exit();
    $this->load->view('oficer/income_dashboard', ['income' => $income, 'detail_income' => $detail_income, 'total_receved' => $total_receved, 'customer' => $customer, 'empl_data' => $empl_data]);
  }

  function fetch_data_vipimioData()
  {
    $this->load->model('queries');
    if ($this->input->post('customer_id')) {
      echo $this->queries->fetch_vipmios($this->input->post('customer_id'));
    }
  }


  public function create_income_detail()
  {
    $this->form_validation->set_rules('comp_id', 'company', 'required');
    $this->form_validation->set_rules('blanch_id', 'company', 'required');
    $this->form_validation->set_rules('customer_id', 'company', 'required');
    $this->form_validation->set_rules('inc_id', 'Income', 'required');
    $this->form_validation->set_rules('receve_amount', 'Amount', 'required');
    $this->form_validation->set_rules('receve_day', 'company', 'required');
    $this->form_validation->set_rules('empl', 'employee', 'required');
    $this->form_validation->set_rules('loan_id', 'Loan', 'required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
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
      $username = $data['empl'];
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
      $empl = $username;
      $penart = $this->queries->get_paidPenart($loan_id);

      $loan_income = $this->queries->get_loan_income($loan_id);
      $group_id = $loan_income->group_id;

      @$non_deducted = $this->queries->check_nonDeducted_balance($comp_id, $blanch_id);
      $deducted_blanch = @$non_deducted->blanch_id;
      $deducted_balance = @$non_deducted->non_balance;
      $another_deducted = $deducted_balance + $receve_amount;

      $company = $this->queries->get_comp_data($comp_id);
      $comp_name = $company->comp_name;
      $comp_phone = $company->comp_phone;

      $data_sms = $this->queries->get_loan_reminder($customer_id);
      $phone = $data_sms->phone_no;
      $first_name = $data_sms->f_name;
      $midle_name = $data_sms->m_name;
      $last_name = $data_sms->l_name;
      $massage = 'Ndugu, ' . $first_name . ' ' . $midle_name . ' ' . $last_name . ' ' . 'Umelipa faini ya Tsh.' . number_format($penart_paid) . ' ' . $comp_name . ' kwa msaada 0679420326 / 0629364847';
      //    echo "<pre>";
      // print_r($massage);
      //      exit();


      // print_r($amount);
      //            exit();

      if ($deducted_blanch == TRUE) {
        $this->update_nonDeducted_balance($comp_id, $blanch_id, $another_deducted);
        //echo "update";
      } else {

        $this->insert_non_deducted_balance($comp_id, $blanch_id, $receve_amount);
        //echo "ingiza";
      }



      //  echo "<pre>";
      // print_r($penart);
      //           exit();
      if ($alphabet == 'Penart' || $alphabet == 'PENART' || $alphabet == 'penart' || $alphabet == 'faini' || $alphabet == 'FAINI' || $alphabet == 'Faini' || $alphabet == 'fine' || $alphabet == 'FAINI KULALA' || $alphabet == 'faini kulala' || $alphabet == 'Faini kulala' || $alphabet == 'FAINI (PENALTY)' || $alphabet == 'penalt' || $alphabet == 'PENALT' || $alphabet == 'FAINI LALA' || $alphabet == 'PENATI' || $alphabet == 'penati' || $alphabet == 'Penati' || $alphabet == 'Adhabu' || $alphabet == 'ADHABU' || $alphabet == 'adhabu' || $alphabet == 'PENALTY' || $alphabet == 'Penarty' || $alphabet == 'penarty') {
        if ($penart == TRUE) {
          $old_paid = $penart->penart_paid;
          $update_paid = $old_paid + $penart_paid;
          $this->update_paidPenart($loan_id, $update_paid);
          $this->insert_income($comp_id, $inc_id, $blanch_id, $customer_id, $username, $penart_paid, $penart_date, $loan_id, $group_id);
          $this->session->set_flashdata('massage', 'Tsh. ' . $penart_paid . ' Paid successfully');
          $this->sendsms($phone, $massage);
        } elseif ($penart == FALSE) {
          $this->insert_income($comp_id, $inc_id, $blanch_id, $customer_id, $username, $penart_paid, $penart_date, $loan_id, $group_id);
          $this->insert_penartPaid($loan_id, $inc_id, $blanch_id, $comp_id, $penart_paid, $username, $customer_id, $penart_date, $group_id);
          $this->session->set_flashdata('massage', 'Tsh. ' . $penart_paid . ' Paid successfully');
          $this->sendsms($phone, $massage);
        }

      } else {
        $this->insert_income($comp_id, $inc_id, $blanch_id, $customer_id, $username, $penart_paid, $penart_date, $loan_id, $group_id);
        $this->session->set_flashdata('massage', 'Tsh. ' . $penart_paid . ' Paid successfully');
        $this->sendsms($phone, $massage);
      }
      // //print_r($alphabet);
      //      exit();

      return redirect('oficer/income_dashboard');
    }
    $this->income_dashboard();
  }


  public function insert_penartPaid($loan_id, $inc_id, $blanch_id, $comp_id, $penart_paid, $username, $customer_id, $penart_date, $group_id)
  {
    $this->db->query("INSERT INTO tbl_pay_penart (`loan_id`,`inc_id`,`blanch_id`,`comp_id`,`penart_paid`,`username`,`customer_id`,`penart_date`,`group_id`) VALUES ('$loan_id','$inc_id','$blanch_id','$comp_id','$penart_paid','$username','$customer_id','$penart_date','$group_id')");
  }



  //insert non-deducted
  public function insert_non_deducted_balance($comp_id, $blanch_id, $receve_amount)
  {
    $this->db->query("INSERT INTO tbl_receive_non_deducted (`comp_id`,`blanch_id`,`non_balance`) VALUES ('$comp_id','$blanch_id','$receve_amount')");
  }

  public function update_nonDeducted_balance($comp_id, $blanch_id, $another_deducted)
  {
    $sqldata = "UPDATE `tbl_receive_non_deducted` SET `non_balance`= '$another_deducted' WHERE `blanch_id`= '$blanch_id'";
    $query = $this->db->query($sqldata);
    return true;
  }

  public function update_paidPenart($loan_id, $update_paid)
  {
    $sqldata = "UPDATE `tbl_pay_penart` SET `penart_paid`= '$update_paid' WHERE `loan_id`= '$loan_id'";
    $query = $this->db->query($sqldata);

    return true;
  }

  public function insert_income($comp_id, $inc_id, $blanch_id, $customer_id, $username, $penart_paid, $penart_date, $loan_id, $group_id)
  {
    $this->db->query("INSERT INTO tbl_receve (`comp_id`,`inc_id`,`blanch_id`,`customer_id`,`empl`,`receve_amount`,`receve_day`,`loan_id`,`group_id`) VALUES ('$comp_id','$inc_id','$blanch_id','$customer_id','$username','$penart_paid','$penart_date','$loan_id','$group_id')");
  }



  public function delete_receved($receved_id)
  {
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

    $this->remove_nondeducted_blanch_accout($blanch_id, $remain_receive);
    $this->remove_paid_penart_loan($loan_id, $remove_receive);
    //    echo "<pre>";
    // print_r($remain_receive);
    //     exit();
    if ($this->queries->remove_receved($receved_id))
      ;
    $this->session->set_flashdata('massage', 'Data Deleted successfully');
    return redirect('oficer/income_dashboard');
  }

  public function remove_paid_penart_loan($loan_id, $remove_receive)
  {
    $sqldata = "UPDATE `tbl_pay_penart` SET `penart_paid`= '$remove_receive' WHERE `loan_id`= '$loan_id'";
    $query = $this->db->query($sqldata);
    return true;
  }


  public function remove_nondeducted_blanch_accout($blanch_id, $remain_receive)
  {
    $sqldata = "UPDATE `tbl_receive_non_deducted` SET `non_balance`= '$remain_receive' WHERE `blanch_id`= '$blanch_id'";
    $query = $this->db->query($sqldata);
    return true;
  }



  public function previous_income()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $blanch = $this->queries->get_blanch($comp_id);
    $from = $this->input->post('from');
    $to = $this->input->post('to');
    $blanch_id = $this->input->post('blanch_id');
    $comp_id = $this->input->post('comp_id');
    $data = $this->queries->get_previous_income($from, $to, $comp_id, $blanch_id);
    $sum_income = $this->queries->get_sum_previousIncome($from, $to, $comp_id, $blanch_id);

    //   echo "<pre>";
    // print_r($data);
    //     exit();
    $this->load->view('oficer/previous_income', ['data' => $data, 'sum_income' => $sum_income, 'from' => $from, 'to' => $to, 'comp_id' => $comp_id, 'blanch_id' => $blanch_id, 'blanch' => $blanch, 'empl_data' => $empl_data]);
  }



  public function deducted_income()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $deducted_data = $this->queries->get_deducted_balance_blanch($blanch_id);
    $total_deducted = $this->queries->get_today_deducted_feeblanch($blanch_id);
    //  echo "<pre>";
    // print_r($total_deducted);
    //        exit();

    $this->load->view('oficer/deducted_income', ['deducted_data' => $deducted_data, 'total_deducted' => $total_deducted, 'empl_data' => $empl_data]);
  }


  public function filter_deducted_income()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);
    $from = $this->input->post('from');
    $to = $this->input->post('to');
    $blanch_id = $this->input->post('blanch_id');
    $data_deducted = $this->queries->get_deducted_fee_prev($from, $to, $blanch_id);
    $total_deducted = $this->queries->get_total_deducted($from, $to, $blanch_id);
    //    echo "<pre>";
    // print_r($total_deducted);
    //       exit();
    $this->load->view('oficer/filter_deducted_income', ['empl_data' => $empl_data, 'data_deducted' => $data_deducted, 'from' => $from, 'to' => $to, 'total_deducted' => $total_deducted]);
  }


  public function income_balance()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $deducted_balance = $this->queries->get_deducted_income_blanch($blanch_id);
    $non_balance = $this->queries->get_non_deducted_income_blanch($blanch_id);

    $acount = $this->queries->get_customer_account_verfied($blanch_id);

    $transaction = $this->queries->get_income_transaction($blanch_id);

    //         echo "<pre>";
    // print_r($transaction);
    //        exit();

    $this->load->view('oficer/income_balance', ['empl_data' => $empl_data, 'deducted_balance' => $deducted_balance, 'non_balance' => $non_balance, 'acount' => $acount, 'transaction' => $transaction]);
  }


  public function transfor_income_data()
  {
    $this->load->model('queries');
    $this->form_validation->set_rules('comp_id', 'Company', 'required');
    $this->form_validation->set_rules('deduct_type', 'Deduction', 'required');
    $this->form_validation->set_rules('from_blanch_id', 'blanch', 'required');
    $this->form_validation->set_rules('from_mount', 'Amount', 'required');
    $this->form_validation->set_rules('to_blanch_account_id', 'Acount', 'required');
    $this->form_validation->set_rules('trans_fee', 'Fee', 'required');
    $this->form_validation->set_rules('user_trans', 'employee', 'required');
    $this->form_validation->set_rules('date_transfor', 'Date', 'required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

    if ($this->form_validation->run()) {
      $data = $this->input->post();
      $deduct_type = $data['deduct_type'];
      $account = $data['to_blanch_account_id'];
      $amount = $data['from_mount'];
      $fee = $data['trans_fee'];
      $comp_id = $data['comp_id'];
      $emply = $data['user_trans'];
      $blanch = $data['from_blanch_id'];
      $date = $data['date_transfor'];
      $blanch_id = $blanch;

      $amount_fee = $amount + $fee;

      $deducted_income = $this->queries->get_deducted_income_blanch($blanch_id);
      $total_deducted = $deducted_income->total_deducted;
      $remove_deduction = $total_deducted - $amount_fee;

      $non = $this->queries->get_non_deducted_income_blanch($blanch_id);
      $total_nonbalance = $non->total_nonbalance;
      $remove_non = $total_nonbalance - $amount_fee;

      $blanch_account = $this->queries->get_blanch_capital_account($blanch_id, $account);
      $blanch_balance = $blanch_account->blanch_capital;

      $new_added = $blanch_balance + $amount;


      if ($deduct_type == 'deducted') {

        if ($total_deducted < $amount_fee) {
          $this->session->set_flashdata("error", 'You don`t Have Enough Balance');
          return redirect("oficer/income_balance");

        } else {
          $this->update_deducted_income_balance($blanch_id, $remove_deduction);
          $this->update_account_blanch_balance($blanch_id, $account, $new_added);
        }

      } elseif ($deduct_type == 'non deducted') {
        if ($total_nonbalance < $amount_fee) {
          $this->session->set_flashdata("error", 'You don`t Have Enough Balance');
          return redirect("oficer/income_balance");
        } else {
          $this->update_nondeducted_income_balance($blanch_id, $remove_non);
          $this->update_account_blanch_balance($blanch_id, $account, $new_added);
        }

      }

      $this->insert_transaction_fee($comp_id, $blanch_id, $emply, $amount, $account, $fee, $deduct_type, $date);
      $this->session->set_flashdata("massage", 'Transaction successfully');
      return redirect('oficer/income_balance');
    }
    $this->income_balance();
  }

  public function update_account_blanch_balance($blanch_id, $account, $new_added)
  {
    $sqldata = "UPDATE `tbl_blanch_account` SET `blanch_capital`= '$new_added' WHERE `blanch_id`= '$blanch_id' AND `receive_trans_id`='$account'";

    $query = $this->db->query($sqldata);
    return true;
  }

  public function update_nondeducted_income_balance($blanch_id, $remove_non)
  {
    $sqldata = "UPDATE `tbl_receive_non_deducted` SET `non_balance`= '$remove_non' WHERE `blanch_id`= '$blanch_id'";
    $query = $this->db->query($sqldata);
    return true;
  }

  public function update_deducted_income_balance($blanch_id, $remove_deduction)
  {
    $sqldata = "UPDATE `tbl_receive_deducted` SET `deducted`= '$remove_deduction' WHERE `blanch_id`= '$blanch_id'";
    $query = $this->db->query($sqldata);
    return true;
  }


  public function insert_transaction_fee($comp_id, $blanch_id, $emply, $amount, $account, $fee, $deduct_type, $date)
  {
    $this->db->query("INSERT INTO tbl_transfor_blanch_blanch (`comp_id`,`from_blanch_id`,`user_trans`,`from_mount`,`to_blach_account_id`,`trans_fee`,`deduct_type`,`date_transfor`) VALUES ('$comp_id','$blanch_id','$emply','$amount','$account','$fee','$deduct_type','$date')");
  }



  public function delete_transaction($id)
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $transaction = $this->queries->get_transaction_blanch($id);
    $account = $transaction->to_blach_account_id;
    $type_deduct = $transaction->deduct_type;
    $blanch_id = $transaction->from_blanch_id;
    $amount = $transaction->from_mount;
    $fee = $transaction->trans_fee;

    $amount_fee = $amount + $fee;

    $total_deducted_income = $this->queries->get_deducted_income_blanch($blanch_id);
    $total_deducted = $total_deducted_income->total_deducted;

    $return_deducted = $total_deducted + $amount_fee;
    $remove_deduction = $return_deducted;

    $non_deducted = $this->queries->get_non_deducted_income_blanch($blanch_id);
    $total_non = $non_deducted->total_nonbalance;

    $return_non = $total_non + $amount_fee;
    $remove_non = $return_non;

    $blanch_account = $this->queries->get_blanch_capital_account($blanch_id, $account);
    $blanch_balance = $blanch_account->blanch_capital;

    $remove_balance = $blanch_balance - $amount;
    $new_added = $remove_balance;



    if ($type_deduct == 'deducted') {
      $this->update_deducted_income_balance($blanch_id, $remove_deduction);
      $this->update_account_blanch_balance($blanch_id, $account, $new_added);
    } elseif ($type_deduct == 'non deducted') {
      $this->update_nondeducted_income_balance($blanch_id, $remove_non);
      $this->update_account_blanch_balance($blanch_id, $account, $new_added);
    }

    $this->remove_transaction_fee($id);
    $this->session->set_flashdata("massage", 'Adjustiment Successfully');
    return redirect('oficer/income_balance');
    // print_r($amount);
    //      exit();
  }

  public function remove_transaction_fee($id)
  {
    return $this->db->delete('tbl_transfor_blanch_blanch', ['id' => $id]);
  }


  public function customer()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);
    $employee = $this->queries->get_blanch_employee($blanch_id);
    // print_r($employee);
    //        exit();

    $this->load->view('oficer/customer', ['empl_data' => $empl_data, 'employee' => $employee]);
  }



  public function create_customer()
  {
    $this->form_validation->set_rules('comp_id', 'company', 'required');
    $this->form_validation->set_rules('blanch_id', 'blanch', 'required');
    $this->form_validation->set_rules('f_name', 'First name', 'required');
    $this->form_validation->set_rules('m_name', 'Middle name', 'required');
    $this->form_validation->set_rules('l_name', 'Last name', 'required');
    $this->form_validation->set_rules('gender', 'gender', 'required');
    $this->form_validation->set_rules('date_birth', 'date_birth', 'required');
    $this->form_validation->set_rules('phone_no', 'phone number', 'required');
    $this->form_validation->set_rules('region_id', 'region', 'required');
    $this->form_validation->set_rules('district', 'district', 'required');
    $this->form_validation->set_rules('ward', 'ward', 'required');
    $this->form_validation->set_rules('street', 'street', 'required');
    $this->form_validation->set_rules('age', 'age', 'required');
    $this->form_validation->set_rules('reg_date', 'reg_date', 'required');
    $this->form_validation->set_rules('empl_id', 'Employee', 'required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

    if ($this->form_validation->run()) {
      $data = $this->input->post();
      $data['phone_no'] = '255' . $data['phone_no']; // Add country code

      // Load the model
      $this->load->model('queries');

      // Check for existing customer with the same name and phone number
      $check = $this->queries->check_name($data['f_name'], $data['m_name'], $data['l_name'], $data['phone_no']);

      if ($check) {
        $this->session->set_flashdata('error', 'This customer is already registered with the provided name and phone number.');
        return redirect('oficer/customer');
      }

      // Insert customer details
      $date = date("Y-m-d");
      $customer_id = $this->insert_customer_detail(
        $data['comp_id'],
        $data['blanch_id'],
        $data['empl_id'],
        $data['f_name'],
        $data['m_name'],
        $data['l_name'],
        $data['gender'],
        $data['date_birth'],
        $data['age'],
        $data['phone_no'],
        $data['region_id'],
        $data['district'],
        $data['ward'],
        $data['street'],
        $data['reg_date']
      );

      // Generate customer number
      $number = 'C' . substr($date, 0, 4) . substr($date, 5, 2) . $customer_id;
      $this->update_customer_number($customer_id, $number);
      $this->insert_sub_customer_data($customer_id);

      // Check if customer was successfully created
      if ($customer_id > 0) {
        $this->session->set_flashdata('message', 'Customer created successfully.');
      } else {
        $this->session->set_flashdata('error', 'Error creating customer.');
      }

      return redirect('oficer/customer_details/' . $customer_id);
    }

    // If validation fails, reload customer details
    $this->customer_details();
  }


  public function insert_customer_detail($comp_id, $blanch_id, $empl_id, $f_name, $m_name, $l_name, $gender, $date_birth, $age, $phone, $region_id, $district, $ward, $street, $date_reg)
  {
    $this->db->query("INSERT INTO   tbl_customer (`comp_id`,`blanch_id`,`empl_id`,`f_name`,`m_name`,`l_name`,`gender`,`date_birth`,`age`,`phone_no`,`region_id`,`district`,`ward`,`street`,`reg_date`) 
      VALUES ('$comp_id','$blanch_id','$empl_id','$f_name','$m_name','$l_name','$gender','$date_birth','$age','$phone','$region_id','$district','$ward','$street','$date_reg')");
    return $this->db->insert_id();
  }


  public function update_customer_number($customer_id, $number)
  {
    $sqldata = "UPDATE `tbl_customer` SET `customer_code`= '$number',`customer_status`='pending' WHERE `customer_id`= '$customer_id'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }

  public function insert_sub_customer_data($customer_id)
  {
    $this->db->query("INSERT INTO  tbl_sub_customer (`customer_id`) VALUES ('$customer_id')");
  }



  public function customer_details($customer_id)
  {
    $this->load->model('queries');
    $customer = $this->queries->get_customer_data($customer_id);
    $account = $this->queries->get_accountTYpe();
    // print_r($account);
    //    exit();
    $this->load->view('oficer/detail', ['customer' => $customer, 'account' => $account]);
  }



  public function update_customerID()
  {
    $folder_Path = 'assets/upload/';

    // print_r($_POST['image']);
    // die();

    if (isset($_POST['image'])) {
      $customer_id = $_POST['id'];
      $image = $_POST['image'];
      // $_POST['id'];
      // print_r($customer_id);
      //     die();

      $image_parts = explode(";base64,", $_POST['image']);
      $image_type_aux = explode("image/", $image_parts[0]);

      $image_type = $image_type_aux[1];
      $data = $_POST['image'];// base64_decode($image_parts[1]);


      list($type, $data) = explode(';', $data);
      list(, $data) = explode(',', $data);
      $data = base64_decode($data);

      $file = $folder_Path . uniqid() . '.png';
      file_put_contents($file, $data);

      $this->update_customer_profile($file, $customer_id);
      echo json_encode("Passport uploaded Successfully");

    }
  }

  public function update_customer_profile($file, $customer_id)
  {
    $sqldata = "UPDATE `tbl_sub_customer` SET `passport`= '$file' WHERE `customer_id`= '$customer_id'";
    $query = $this->db->query($sqldata);
    return true;
  }



  // 	public function update_customerID($customer_id){
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
  //         'signature' => $signature,
  //         'passport' => $passport,
  //         );

  //         $customer_id = $data['customer_id'];
  //         //   echo "<pre>";
  //         // print_r($customer_id);
  //         //  echo "</pre>";
  //         //   exit();
  //        $this->load->model('queries'); 
  //         //Storing insertion status message.
  //         if($data){
  //             $this->queries->update_customer_profile($data);
  //             $this->session->set_flashdata('massage','Customer Registration Successfully');
  //            }else{
  //             $this->session->set_flashdata('error','Data failed!!');
  //         }
  //         return redirect('oficer/customer_profile/'.$customer_id);

  // }

  function fetch_employee_blanch()
  {
    $this->load->model('queries');
    if ($this->input->post('blanch_id')) {
      echo $this->queries->fetch_employee($this->input->post('blanch_id'));
    }

  }



  public function customer_profile($customer_id)
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);
    $customer_profile = $this->queries->get_customer_profileData($customer_id);

    $blanch = $this->queries->get_blanch($comp_id);
    $sponser = $this->queries->get_guarantors_data($customer_id);
    $loan_customer = $this->queries->get_loan_customer($customer_id);
    //   echo "<pre>";
    // print_r($loan_customer);
    //          exit();
    $this->load->view('oficer/customer_profile', ['customer_profile' => $customer_profile, 'blanch' => $blanch, 'sponser' => $sponser, 'loan_customer' => $loan_customer]);
  }


  public function update_customer_info($customer_id)
  {
    $this->form_validation->set_rules('blanch_id', 'blanch', 'required');
    $this->form_validation->set_rules('f_name', 'First name', 'required');
    $this->form_validation->set_rules('m_name', 'Middle name', 'required');
    $this->form_validation->set_rules('l_name', 'Last name', 'required');
    $this->form_validation->set_rules('gender', 'gender', 'required');
    $this->form_validation->set_rules('date_birth', 'date_birth', 'required');
    $this->form_validation->set_rules('phone_no', 'phone number', 'required');
    $this->form_validation->set_rules('region_id', 'region', 'required');
    $this->form_validation->set_rules('district', 'district', 'required');
    $this->form_validation->set_rules('ward', 'ward', 'required');
    $this->form_validation->set_rules('street', 'street', 'required');
    $this->form_validation->set_rules('age', 'age', 'required');
    $this->form_validation->set_rules('empl_id', 'empl', 'required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
    if ($this->form_validation->run()) {
      $data = $this->input->post();
      // echo "<pre>";
      // print_r($data);
      //     exit();
      $this->load->model('queries');
      if ($this->queries->update_customer_info($data, $customer_id)) {
        $this->session->set_flashdata('massage', 'Customer Updated Successfully');
      } else {
        $this->session->set_flashdata('error', 'Failed');
      }
      return redirect('oficer/customer_profile/' . $customer_id);
    }
    $this->customer_profile();
  }


  public function all_customer()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $customer = $this->queries->get_customer_blanch($blanch_id);

    //  echo"<pre>";
    // print_r($customer);
    // echo"</pre>";
    //      exit();
    $this->load->view('oficer/all_customer', ['customer' => $customer, 'customer' => $customer]);
  }


  public function loan_application()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $customer = $this->queries->get_allcutomerblanchData($blanch_id);
    //   echo "<pre>";
    // print_r($customer);
    //      exit();
    $this->load->view('oficer/loan_application', ['customer' => $customer]);
  }


  public function search_customer()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $customer_id = $this->input->post('customer_id');
    $customer = $this->queries->search_CustomerID($customer_id, $comp_id);
    $sponser = $this->queries->get_sponser($customer_id);
    $sponsers_data = $this->queries->get_sponserCustomer($customer_id);
    $region = $this->queries->get_region();

    $data_loan_desc = $this->queries->get_loan_desc_loan($customer_id);
    //   echo "<pre>";
// print_r($customer);
//  echo "</pre>";
//    exit();
    $this->load->view('oficer/search_customer', ['customer' => $customer, 'sponser' => $sponser, 'sponsers_data' => $sponsers_data, 'region' => $region, 'data_loan_desc' => $data_loan_desc]);
  }



  public function modify_sponser($sp_id, $customer_id)
  {
    $this->form_validation->set_rules('sp_name', 'Sponser first name', 'required');
    $this->form_validation->set_rules('sp_mname', 'Sponser midle name', 'required');
    $this->form_validation->set_rules('sp_lname', 'Sponser last name', 'required');
    $this->form_validation->set_rules('sp_phone_no', 'Sponser phone number', 'required');
    $this->form_validation->set_rules('sp_relation', 'Sponser relation', 'required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
    if ($this->form_validation->run()) {
      $data = $this->input->post();
      //         echo "<pre>";
      // print_r($data);
      //       exit();
      $this->load->model('queries');
      if ($this->queries->update_sponser($sp_id, $data)) {
        $this->session->set_flashdata('massage', 'Sponsers information Updated successfully');
      } else {
        $this->session->set_flashdata('error', 'Failed');
      }
      $sponser = $this->queries->get_sponser($customer_id);
      $customer_id = $sponser->customer_id;
      // print_r($customer_id);
      //     exit();
      return redirect('oficer/edit_viewSponser/' . $customer_id);
    }
    $this->edit_viewSponser();
  }


  public function edit_viewSponser($customer_id)
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);
    $sponser = $this->queries->get_sponser($customer_id);
    $sponsers_data = $this->queries->get_sponserCustomer($customer_id);
    $customer = $this->queries->get_search_dataCustomer($customer_id);
    $region = $this->queries->get_region();

    $data_loan_desc = $this->queries->get_loan_desc_loan($customer_id);
    //   echo "<pre>";
    // print_r($customer);
    //        exit();
    $this->load->view('oficer/sponser_view', ['sponser' => $sponser, 'sponsers_data' => $sponsers_data, 'customer' => $customer, 'region' => $region, 'data_loan_desc' => $data_loan_desc]);

  }


  public function create_sponser($customer_id)
  {
    //Prepare array of user data
    $data = array(
      'sp_name' => $this->input->post('sp_name'),
      'sp_mname' => $this->input->post('sp_mname'),
      'customer_id' => $this->input->post('customer_id'),
      'comp_id' => $this->input->post('comp_id'),
      'sp_lname' => $this->input->post('sp_lname'),
      'sp_phone_no' => $this->input->post('sp_phone_no'),
      'sp_relation' => $this->input->post('sp_relation'),
    );
    //   echo "<pre>";
    // print_r($data);
    //  echo "</pre>";
    //   exit();

    $this->load->model('queries');
    $data = $this->queries->insert_sponser_info($data);
    //Storing insertion status message.
    if ($data) {
      $this->session->set_flashdata('massage', 'Gualantors information Saved successfully');
    } else {
      $this->session->set_flashdata('error', 'Data failed!!');
    }
    return redirect("oficer/edit_viewSponser/" . $customer_id);
  }


  public function verfication_code($customer_id)
  {
    $this->load->model('queries');
    $this->load->helper('string');
    //$comp_id = $this->session->userdata('comp_id');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $empl_data = $this->queries->get_employee_data($empl_id);
    $compdata = $this->queries->get_companyData($comp_id);
    $custm_data = $this->queries->get_customer_data($customer_id);

    $data_vefication = $this->queries->get_otp_done($customer_id);
    if ($data_vefication->otp == FALSE) {
      $loan_verfication = 'N-' . random_string('numeric', 4);
    } else {
      $loan_verfication = $data_vefication->otp;
    }
    $this->update_customer_verfication_code($customer_id, $loan_verfication);

    // print_r($loan_verfication);
    //          exit();
    $company_name = $compdata->comp_name;
    //$full_name = $custm_data->f_name . ' ' . $custm_data->m_name . ' ' . $custm_data->l_name ;
    $phone = $custm_data->phone_no;
    $massage = $loan_verfication . ' ' . 'Msimbo wa Uthibitisho' . ' ' . $company_name;
    $this->sendsms($phone, $massage);
    $this->load->view('oficer/loan_verfication', ['customer_id' => $customer_id]);
  }

  public function update_customer_verfication_code($customer_id, $loan_verfication)
  {
    $sqldata = "UPDATE `tbl_customer` SET `otp`= '$loan_verfication' WHERE `customer_id`= '$customer_id'";
    $query = $this->db->query($sqldata);
    return true;
  }

  public function verfy_otp_data($customer_id)
  {
    $this->form_validation->set_rules('otp', 'otp', 'required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
    if ($this->form_validation->run()) {
      $this->load->model('queries');
      $data = $this->input->post();
      $otp = $data['otp'];
      $code = $this->queries->get_verfication_code($customer_id);
      $verf = $code->otp;
      if ($verf == $otp) {
        return redirect('oficer/loan_applicationForm/' . $customer_id);
        //echo "successfully";
      } else {
        $this->session->set_flashdata("error", 'Msimbo Haupo Sahihi');
        return redirect('oficer/verfication_code/' . $customer_id);
        //echo "successfully";
      }

    }
  }


  public function loan_applicationForm($customer_id)
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);
    $mpl_data_blanch = $this->queries->get_blanchEmployee($blanch_id);

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

    // echo "<pre>";
    //   print_r($customer);
    //   echo "</pre>";
    //        exit();

    $this->load->view('oficer/loan_aplication_form', ['customer' => $customer, 'loan_category' => $loan_category, 'group' => $group, 'region' => $region, 'blanch' => $blanch, 'loan_form_request' => $loan_form_request, 'loan_option' => $loan_option, 'skip_next' => $skip_next, 'reject_skip' => $reject_skip, 'formular' => $formular, 'loan_fee_category' => $loan_fee_category, 'mpl_data_blanch' => $mpl_data_blanch, 'empl_data' => $empl_data, 'customer_id' => $customer_id]);
  }



  public function create_loanapplication($customer_id)
  {
    $this->load->helper('string');
    $this->form_validation->set_rules('comp_id', 'Company', 'required');
    $this->form_validation->set_rules('blanch_id', 'Blanch', 'required');
    $this->form_validation->set_rules('customer_id', 'Customer', 'required');
    $this->form_validation->set_rules('category_id', 'category', 'required');
    $this->form_validation->set_rules('group_id', 'group');
    $this->form_validation->set_rules('how_loan', 'How loan', 'required');
    $this->form_validation->set_rules('day', 'day', 'required');
    $this->form_validation->set_rules('session', 'session', 'required');
    $this->form_validation->set_rules('rate', 'rate', 'required');
    $this->form_validation->set_rules('reason', 'reason', 'required');
    if ($this->form_validation->run()) {
      $data = $this->input->post();
      // print_r($data);
      //           exit();
      $data['loan_code'] = random_string('numeric', 4);

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
        $this->session->set_flashdata('mass', 'Amount of Loan Is Less');
        return redirect('oficer/loan_applicationForm/' . $customer_id);
      } elseif ($input > $zaidi) {
        $this->session->set_flashdata('mass', 'Amount of Loan Is Greater');
        return redirect('oficer/loan_applicationForm/' . $customer_id);
      } else {
        $loan_id = $this->queries->insert_loan($data);
        $this->insert_loan_attachment($loan_id);
        $this->session->set_flashdata('massage', '');
      }
      return redirect('oficer/collelateral_session/' . $loan_id);
    }

    $this->collelateral_session();
  }

  public function insert_loan_attachment($loan_id)
  {
    $this->db->query("INSERT INTO tbl_attachment (`loan_id`) VALUES ('$loan_id')");
  }


  public function collelateral_session($loan_id)
  {
    $this->load->model('queries');
    $loan_attach = $this->queries->get_loanAttach($loan_id);
    $collateral = $this->queries->get_colateral_data($loan_id);
    //   echo "<pre>";
    // print_r($loan_attach);
    //      exit();
    $this->load->view('oficer/collelateral', ['loan_attach' => $loan_attach, 'collateral' => $collateral]);
  }


  public function create_colateral($loan_id)
  {
    if (!empty($_FILES['file_name']['name'])) {
      $config['upload_path'] = 'assets/img/';
      $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
      $config['file_name'] = $_FILES['file_name']['name'];
      $config['max_size'] = '8192';
      $config['remove_spaces'] = TRUE;  //it will remove all spaces
      $config['encrypt_name'] = TRUE;   //it wil encrypte the original file name
      //die($config);
      //Load upload library and initialize configuration
      $this->load->library('upload', $config);
      $this->upload->initialize($config);

      if ($this->upload->do_upload('file_name')) {
        $uploadData = $this->upload->data();
        $file_name = $uploadData['file_name'];
      } else {
        $file_name = '';
      }
    } else {
      $file_name = '';
    }

    //Prepare array of user data
    $data = array(
      'description' => $this->input->post('description'),
      'loan_id' => $this->input->post('loan_id'),
      'co_condition' => $this->input->post('co_condition'),
      'value' => $this->input->post('value'),
      'file_name' => $file_name,
    );
    //   echo "<pre>";
    // print_r($data);
    //  echo "</pre>";
    //   exit();
    $this->load->model('queries');
    //Storing insertion status message.
    if ($data) {
      $this->queries->insert($data);
      $this->session->set_flashdata('massage', 'Colateral Uploaded  Successfully');
    } else {
      $this->session->set_flashdata('error', 'Data failed!!');
    }
    return redirect('oficer/collelateral_session/' . $loan_id);

  }


  public function modify_loanapplication($customer_id, $loan_id)
  {
    $this->load->helper('string');
    $this->form_validation->set_rules('comp_id', 'Company', 'required');
    $this->form_validation->set_rules('blanch_id', 'Blanch', 'required');
    $this->form_validation->set_rules('customer_id', 'Customer', 'required');
    $this->form_validation->set_rules('category_id', 'category', 'required');
    $this->form_validation->set_rules('empl_id', 'Employee', 'required');
    $this->form_validation->set_rules('how_loan', 'How loan', 'required');
    $this->form_validation->set_rules('day', 'day', 'required');
    $this->form_validation->set_rules('session', 'session', 'required');
    $this->form_validation->set_rules('rate', 'rate', 'required');
    $this->form_validation->set_rules('loan_status', 'loan status', 'required');
    $this->form_validation->set_rules('fee_status', 'status', 'required');
    $this->form_validation->set_rules('reason', 'reason', 'required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
    if ($this->form_validation->run()) {
      $data = $this->input->post();

      // print_r($data);
      //    exit();

      //$data['loan_code'] = redit_viewSponserandom_string('numeric',14);

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
        $this->session->set_flashdata('mass', 'Amount of Loan Is Less');
        return redirect('admin/loan_applicationForm/' . $customer_id);
      } elseif ($input > $zaidi) {
        $this->session->set_flashdata('mass', 'Amount of Loan Is Greater');
        return redirect('admin/loan_applicationForm/' . $customer_id);
      } else {
        $this->queries->upadete_loan($data, $loan_id);
        $this->session->set_flashdata('massage', 'Loan Application Upated successfully');
      }
      return redirect('oficer/loan_applicationForm/' . $customer_id);
    }

    $this->loan_applicationForm();
  }


  public function modify_colateral($loan_id, $col_id)
  {

    //Prepare array of user data
    $data = array(
      'description' => $this->input->post('description'),
      //'loan_id' =>$this->input->post('loan_id'),
      'co_condition' => $this->input->post('co_condition'),
      'value' => $this->input->post('value'),
      //'file_name' => $file_name,
    );
    //   echo "<pre>";
    // print_r($data);
    //  echo "</pre>";
    //   exit();
    $this->load->model('queries');
    //Storing insertion status message.
    if ($data) {
      $this->queries->queries->update_collateral($data, $col_id);
      $this->update_loan_status($loan_id);
      $this->session->set_flashdata('massage', 'Colateral Updated  Successfully');
    } else {
      $this->session->set_flashdata('error', 'Data failed!!');
    }
    return redirect('oficer/collelateral_session/' . $loan_id . "/" . $col_id);

  }


  public function update_loan_status($loan_id)
  {
    $sqldata = "UPDATE `tbl_loans` SET `loan_status`= 'open' WHERE `loan_id`= '$loan_id'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }


  public function modify_colateral_picture($loan_id, $col_id)
  {
    if (!empty($_FILES['file_name']['name'])) {
      $config['upload_path'] = 'assets/img/';
      $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
      $config['file_name'] = $_FILES['file_name']['name'];
      $config['max_size'] = '8192';
      $config['remove_spaces'] = TRUE;  //it will remove all spaces
      $config['encrypt_name'] = TRUE;   //it wil encrypte the original file name
      //die($config);
      //Load upload library and initialize configuration
      $this->load->library('upload', $config);
      $this->upload->initialize($config);

      if ($this->upload->do_upload('file_name')) {
        $uploadData = $this->upload->data();
        $file_name = $uploadData['file_name'];
      } else {
        $file_name = '';
      }
    } else {
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
    if ($data) {
      $this->queries->queries->update_collateral($data, $col_id);
      $this->update_loan_status($loan_id);
      $this->session->set_flashdata('massage', 'Colateral Updated  Successfully');
    } else {
      $this->session->set_flashdata('error', 'Data failed!!');
    }
    return redirect('oficer/collelateral_session/' . $loan_id . "/" . $col_id);

  }


  public function delete_colateral($loan_id, $col_id)
  {
    $this->load->model('queries');
    if ($this->queries->remove_collateral($col_id))
      ;
    $this->session->set_flashdata('massage', 'Colateral Deleted successfully');
    return redirect('oficer/collelateral_session/' . $loan_id . "/" . $col_id);
  }


  public function local_government($loan_id)
  {
    $this->load->model('queries');
    $loan_attach = $this->queries->get_loanAttach($loan_id);
    $region = $this->queries->get_region();
    $local_gov = $this->queries->get_localgovernmentDetail($loan_id);
    // print_r($local_gov);
    //           exit();
    $this->load->view('oficer/local_government', ['loan_attach' => $loan_attach, 'region' => $region, 'local_gov' => $local_gov]);
  }


  public function Update_local_govDetails($loan_id, $attach_id)
  {
    $this->load->model('queries');
    //Prepare array of user data
    $data = array(
      //'loan_id'=> $this->input->post('loan_id'),
      'oficer' => $this->input->post('oficer'),
      'phone_oficer' => $this->input->post('phone_oficer'),
    );
    //    echo "<pre>";
    // print_r($data);
    //      exit();
    //Pass user data to model
    $this->load->model('queries');
    $data = $this->queries->update_localDetail($data, $attach_id);
    $this->update_loan_status($loan_id);
    //Storing insertion status message.
    if ($data) {
      $this->session->set_flashdata('massage', 'Local government information Updated Successfully');
    } else {
      $this->session->set_flashdata('error', 'Data failed!!');
    }
    $group = $this->queries->get_groupLoanData($loan_id);
    $group_id = $group->group_id;
    // echo "<pre>";
    // print_r($group_id);
    //      exit();
    if ($group_id == TRUE) {
      //echo "machemba";
      return redirect('oficer/group_member/' . $loan_id);
    } else {
      return redirect('oficer/local_government/' . $loan_id . "/" . $attach_id);
    }
  }

  public function create_local_govDetails()
  {
    $folder_Path = 'assets/upload/';
    if (isset($_POST['image'])) {
      $loan_id = $_POST['id'];
      $image = $_POST['image'];
      //$oficer = $_POST['oficer'];
      //$phone_oficer = $_POST['phone_oficer'];

      //  $_POST['id'];
      // print_r($phone_oficer);
      //     die();

      $image_parts = explode(";base64,", $_POST['image']);
      $image_type_aux = explode("image/", $image_parts[0]);

      $image_type = $image_type_aux[1];
      $data = $_POST['image'];// base64_decode($image_parts[1]);


      list($type, $data) = explode(';', $data);
      list(, $data) = explode(',', $data);
      $data = base64_decode($data);

      $file = $folder_Path . uniqid() . '.png';
      file_put_contents($file, $data);
      $this->insert_customer_local($file, $loan_id);
      echo json_encode("Successfully");

    }
  }

  public function insert_customer_local($file, $loan_id)
  {
    $data = "UPDATE tbl_attachment SET `cont_attachment`='$file' WHERE loan_id = '$loan_id'";
    $query = $this->db->query($data);
    return true;
  }


  // public function create_local_govDetails($loan_id){
  // 	$this->load->model('queries');
  //         //Prepare array of user data
  //         $data = array(
  //         'loan_id'=> $this->input->post('loan_id'),
  //         'oficer'=> $this->input->post('oficer'),
  //         'phone_oficer'=> $this->input->post('phone_oficer'),
  //         );
  //            //    echo "<pre>";
  //            // print_r($data);
  //            //      exit();
  //         //Pass user data to model
  //        $this->load->model('queries'); 
  //        $data = $this->queries->insert_localgov_details($data);

  //         //Storing insertion status message.
  //         if($data){
  //         	$this->session->set_flashdata('massage','Loan Application Sent Successfully');
  //            }else{
  //             $this->session->set_flashdata('error','Data failed!!');
  //         }
  //         $group = $this->queries->get_groupLoanData($loan_id);
  //         $group_id = $group->group_id;
  // 		$customer_id = $group->customer_id;
  //         //   echo "<pre>";
  //         //   print_r($customer_id);
  //         //        exit();
  //           if ($group_id == TRUE) {
  //           	 //echo "machemba";
  //           return redirect('oficer/group_member/'.$loan_id.'/'.$customer_id);
  //                }else{     
  //         return redirect('oficer/loan_pending/');
  //         }
  // }


  public function loan_pending()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $loan_pending = $this->queries->get_loanPendingBlanch($blanch_id);
    $total_request = $this->queries->get_total_loanPendingBlanch($blanch_id);
    //     echo "<pre>";
    // print_r($loan_pending);
    //     echo "<pre>";
    //         exit();
    $this->load->view('oficer/loan_pending', ['loan_pending' => $loan_pending, 'total_request' => $total_request]);
  }


  public function view_Dataloan($customer_id, $comp_id)
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $customer = $this->queries->get_loanData($customer_id, $comp_id);
    $sponser_detail = $this->queries->get_sponser_data($customer_id, $comp_id);
    $loan_form = $this->queries->get_formloanData($customer_id, $comp_id);
    $loan_id = $loan_form->loan_id;
    $collateral = $this->queries->get_colateral_data($loan_id);
    $local_oficer = $this->queries->get_loacagovment_data($loan_id);
    $inc_history = $this->queries->get_loanIncomeHistory($customer_id);

    // echo "<pre>";
    // print_r($collateral);
    // echo "</pre>";
    // exit();
    $this->load->view('oficer/view_loan_customer', ['customer' => $customer, 'sponser_detail' => $sponser_detail, 'loan_form' => $loan_form, 'collateral' => $collateral, 'local_oficer' => $local_oficer, 'inc_history' => $inc_history]);
  }


  public function aprove_loan($loan_id)
  {
    $this->load->helper('string');
    //Prepare array of user data
    $day = date('Y-m-d H:i');
    $data = array(
      'loan_aprove' => $this->input->post('loan_aprove'),
      'penat_status' => $this->input->post('penat_status'),
      'loan_status' => 'aproved',
      'loan_day' => $day,
      'code' => random_string('numeric', 4),

    );
    //   echo "<pre>";
    // print_r($data);
    //  echo "</pre>";
    //   exit();

    //Pass user data to model
    $this->load->model('queries');
    $data = $this->queries->update_status($loan_id, $data);
    $this->disburse($loan_id);
    //  echo "<pre>";
    // print_r($loan_id);
    //  echo "</pre>";
    //   exit();
    //Storing insertion status message.
    if ($data) {

      $this->session->set_flashdata('massage', 'Loan Approved successfully');
    } else {
      $this->session->set_flashdata('error', 'Data failed!!');
    }
    return redirect('oficer/loan_pending');
  }



  public function disburse($loan_id)
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    //$admin_data = $this->queries->get_admin_role($comp_id);
    $loan_fee = $this->queries->get_loanfee($comp_id);
    $loan_data = $this->queries->get_loanDisbarsed($loan_id);
    $loan_data_interst = $this->queries->get_loanInterest($loan_id);
    $loan_fee_sum = $this->queries->get_sumLoanFee($comp_id);
    $total_loan_fee = $loan_fee_sum->total_fee;

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
    $role = $empl_data->username;
    // print_r($loan_data);
//        exit();
    $interest_loan = $loan_data_interst->interest_formular;
    $interest = $interest_loan;
    $end_date = $day * $session;
    if ($loan_data_interst->rate == 'FLAT RATE') {

      $day_data = $end_date;
      $months = floor($day_data / 30);

      $loan_interest = $interest / 100 * $balance * $months;
      $total_loan = $balance + $loan_interest;

    } elseif ($loan_data_interst->rate == 'SIMPLE') {
      $loan_interest = $interest / 100 * $balance;
      $total_loan = $balance + $loan_interest;
    } elseif ($loan_data_interst->rate == 'REDUCING') {
      $month = date("m");
      $year = date("Y");
      $d = cal_days_in_month(CAL_GREGORIAN, $month, $year);
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
    $sms_data = $total_loan_fee / 100 * $balance;
    $remain_balance = $balance - $sms_data;


    // $sms = 'Taasisi ya '.$comp_name.' Imeingiza Mkopo Kiasi cha Tsh.'.$remain_balance.' kwenye Acc Yako ' . $loan_codeID .' Namba yasiri ya kutolea mkopo ni '.$code;
    // $massage = $sms;
    // $phone = $phones;

    $loan_fee_type = $this->queries->get_loanfee_type($comp_id);
    $type = $loan_fee_type->type;
    $this->insert_loan_aprovedDisburse($comp_id, $loan_id, $customer_id, $blanch_id, $balance, $role, $group_id);
    $unchangable_balance = $balance;
    if ($type == 'PERCENTAGE VALUE') {
      for ($i = 0; $i < count($loan_fee); $i++) {
        $interest = $loan_fee[$i]->fee_interest;
        $fee_description = $loan_fee[$i]->description;
        $fee_number = $loan_fee[$i]->fee_interest;
        $withdraw_balance = $unchangable_balance * ($interest / 100);

        $new_balance = $balance - $withdraw_balance;
        $pay_id = $this->insert_loanfee($loan_fee[$i]->fee_id, $loan_fee[$i]->fee_interest, $loan_fee[$i]->description, $loan_fee[$i]->fee_interest, $loan_id, $blanch_id, $comp_id, $customer_id, $new_balance, $withdraw_balance, $group_id);
        //Update Balance in this Loop
        $balance = $new_balance;
      }
    } elseif ($type == 'MONEY VALUE') {
      for ($i = 0; $i < count($loan_fee); $i++) {
        $interest = $loan_fee[$i]->fee_interest;
        $fee_description = $loan_fee[$i]->description;
        $fee_number = $loan_fee[$i]->fee_interest;
        $withdraw_balance = $interest;

        $new_balance = $balance - $withdraw_balance;
        $pay_id = $this->insert_loanfee_money($loan_fee[$i]->fee_id, $loan_fee[$i]->fee_interest, $loan_fee[$i]->description, $loan_fee[$i]->fee_interest, $loan_id, $blanch_id, $comp_id, $customer_id, $new_balance, $withdraw_balance, $group_id);

        //Update Balance in this Loop
        $balance = $new_balance;
      }
    }

    $this->insert_loan_lecord($comp_id, $customer_id, $loan_id, $blanch_id, $total_loan, $loan_interest, $group_id);
    $this->update_loaninterest($pay_id, $total_loan);
    //$this->sendsms($phone,$massage);
    $this->aprove_disbas_status($loan_id);

    return redirect('oficer/get_loan_aproved');

  }


  public function insert_loan_aprovedDisburse($comp_id, $loan_id, $customer_id, $blanch_id, $balance, $role, $group_id)
  {
    $day = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_pay (`comp_id`,`loan_id`,`customer_id`,`blanch_id`,`balance`,`depost`,`emply`,`description`,`group_id`,`date_data`) VALUES ('$comp_id','$loan_id', '$customer_id','$blanch_id','$balance','$balance','$role','CASH DEPOST','$group_id','$day')");
  }


  public function insert_loanfee($loan_fee, $interest, $fee_description, $fee_number, $loan_id, $blanch_id, $comp_id, $customer_id, $new_balance, $withdraw_balance, $group_id)
  {
    $date = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_pay (`fee_id`,`fee_desc`,`fee_percentage`,`loan_id`,`blanch_id`,`comp_id`,`customer_id`,`balance`,`withdrow`,`p_today`,`emply`,`symbol`,`group_id`,`date_data`) VALUES ('$loan_fee','$fee_description','$fee_number','$loan_id','$blanch_id','$comp_id','$customer_id','$new_balance','$withdraw_balance','$date','SYSTEM WITHDRAWAL','%','$group_id','$date')");
    return $this->db->insert_id();
  }

  public function insert_loanfee_money($loan_fee, $interest, $fee_description, $fee_number, $loan_id, $blanch_id, $comp_id, $customer_id, $new_balance, $withdraw_balance, $group_id)
  {
    $date = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_pay (`fee_id`,`fee_desc`,`fee_percentage`,`loan_id`,`blanch_id`,`comp_id`,`customer_id`,`balance`,`withdrow`,`p_today`,`emply`,`symbol`,`group_id`,`date_data`) VALUES ('$loan_fee','$fee_description','$fee_number','$loan_id','$blanch_id','$comp_id','$customer_id','$new_balance','$withdraw_balance','$date','SYSTEM WITHDRAWAL','Tsh','$group_id','$date')");
    return $this->db->insert_id();
  }



  //update loan + interest in pay table
  public function update_loaninterest($pay_id, $total_loan)
  {
    $sqldata = "UPDATE `tbl_pay` SET `interest_loan`= '$total_loan' WHERE `pay_id`= '$pay_id'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }




  public function insert_loan_lecord($comp_id, $customer_id, $loan_id, $blanch_id, $total_loan, $loan_interest, $group_id)
  {
    $day = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_prev_lecod (`comp_id`,`customer_id`,`loan_id`,`blanch_id`,`total_loan`,`total_int`,`lecod_day`,`group_id`) VALUES ('$comp_id', '$customer_id','$loan_id','$blanch_id','$total_loan','$loan_interest','$day','$group_id')");
  }




  public function aprove_disbas_status($loan_id)
  {
    //Prepare array of user data
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

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
    $day = $loan_data->day;
    $end_date = $day * $session_loan;
    if ($loan_data->rate == 'FLAT RATE') {
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
      $loan_interest = $interest / 100 * $loan_aproved * $months;

      $total_loan = $loan_aproved + $loan_interest;

      $restoration = ($loan_interest + $loan_aproved) / ($session_loan);
      $res = $restoration;
    } elseif ($loan_data->rate == 'SIMPLE') {
      $interest = $interest_loan;
      $loan_interest = $interest / 100 * $loan_aproved;
      $total_loan = $loan_aproved + $loan_interest;
      $restoration = ($loan_interest + $loan_aproved) / ($session_loan);
      $res = $restoration;
    } elseif ($loan_data->rate == 'REDUCING') {
      $month = date("m");
      $year = date("Y");
      $d = cal_days_in_month(CAL_GREGORIAN, $month, $year);
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
      'loan_status' => 'disbarsed',
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

    //data inorder to send sms
    $sms_data = $total_loan_fee / 100 * $loan_aproved;
    $remain_balance = $loan_aproved - $sms_data;
    //   echo "<pre>";
    // print_r($data);
    //  echo "</pre>";
    //   exit();
    //send sms function
    $sms = $comp_name . ' Imeingiza Mkopo Kiasi cha Tsh.' . $remain_balance . ' kwenye Acc Yako ' . $loan_codeID . ' Namba ya Siri Ni' . $code . ' Kwa msaada zaidi piga simu Namba ' . $comp_phone;
    $massage = $sms;
    $phone = $phones;
    // print_r($massage);
    //     exit();
    //Pass user data to model
    $this->load->model('queries');
    $data = $this->queries->update_status($loan_id, $data);

    //Storing insertion status message.
    if ($data) {
      if (@$smscount->sms_number == TRUE) {
        $new_sms = 1;
        $total_sms = @$sms_number + $new_sms;
        $this->update_count_sms($comp_id, $total_sms, $sms_id);
      } elseif (@$smscount->sms_number == FALSE) {
        $sms_number = 1;
        $this->insert_count_sms($comp_id, $sms_number);
      }
      //$this->sendsms($phone,$massage);
      $this->session->set_flashdata('massage', 'Loan disbarsed successfully');
    } else {
      $this->session->set_flashdata('error', 'Data failed!!');
    }

    return redirect('oficer/loan_pending');
  }



  //insert sms counter
  public function insert_count_sms($comp_id, $sms_number)
  {
    $date = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_sms_count (`comp_id`,`sms_number`,`date`) VALUES ('$comp_id','$sms_number','$date')");
  }

  //update smscounter
  public function update_count_sms($comp_id, $total_sms, $sms_id)
  {
    $sqldata = "UPDATE `tbl_sms_count` SET `sms_number`= '$total_sms' WHERE `comp_id`= '$comp_id' AND `sms_id`='$sms_id'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }


  public function disburse_loan()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);



    $disburse = $this->queries->get_DisbarsedLoanBlanch_data($blanch_id);
    $total_loanDis = $this->queries->get_sum_loanDisbursed_blanch($blanch_id);
    $total_interest_loan = $this->queries->get_sum_loanDisburse_interest_blanch($blanch_id);

    // echo "<pre>";
    // print_r($disburse);
    // echo "</pre>";
    //     exit();
    $this->load->view('oficer/disburse_loan', ['disburse' => $disburse, 'total_loanDis' => $total_loanDis, 'total_interest_loan' => $total_interest_loan]);
  }


  public function teller_dashboard()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    // $float = $this->queries->get_today_float($comp_id);
    // $depost = $this->queries->get_sumTodayDepost($comp_id);
    // $withdraw = $this->queries->get_sumTodayWithdrawal($comp_id);

    $customer = $this->queries->get_allcutomerblanchData($blanch_id);
    // echo "<pre>";
    // print_r($customer);
    //   exit();
    $this->load->view('oficer/teller_dashboard', ['customer' => $customer, 'empl_data' => $empl_data]);
  }


  public function search_customerData()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $customery = $this->queries->get_allcutomerblanchData($blanch_id);
    $customer_id = $this->input->post('customer_id');
    $comp_id = $this->input->post('comp_id');
    $customer = $this->queries->search_CustomerLoan($customer_id);
    @$customer_id = $customer->customer_id;
    @$blanch_id = $customer->blanch_id;
    $acount = $this->queries->get_customer_account_verfied($blanch_id);

    // print_r($customer);
    //       exit();

    $this->load->view('oficer/search_loan_customer', ['customer' => $customer, 'customery' => $customery, 'acount' => $acount, 'empl_data' => $empl_data]);
  }



  public function create_withdrow_balance($customer_id)
  {
    ini_set("max_execution_time", 3600);
    $this->form_validation->set_rules('customer_id', 'Customer', 'required');
    $this->form_validation->set_rules('comp_id', 'Company', 'required');
    $this->form_validation->set_rules('blanch_id', 'blanch', 'required');
    $this->form_validation->set_rules('loan_id', 'Loan', 'required');
    $this->form_validation->set_rules('method', 'method', 'required');
    $this->form_validation->set_rules('withdrow', 'withdrow', 'required');
    $this->form_validation->set_rules('loan_status', 'loan status', 'required');
    $this->form_validation->set_rules('code', 'Code', 'required');
    $this->form_validation->set_rules('with_date', 'with date', 'required');
    $this->form_validation->set_rules('description', 'description', 'required');
    if ($this->form_validation->run()) {
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

      $empl_id = $this->session->userdata('empl_id');
      $manager_data = $this->queries->get_manager_data($empl_id);
      $comp_id = $manager_data->comp_id;
      $company_data = $this->queries->get_companyData($comp_id);
      $blanch_data = $this->queries->get_blanchData($blanch_id);
      $empl_data = $this->queries->get_employee_data($empl_id);

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
        } elseif ($fee_category_type == 'PERCENTAGE') {
          echo "makato ya percent";
          $sum_fee = $this->queries->get_sumfeepercentage($loan_id);
          $fee = $sum_fee->total_fee;
          $sum_total_loanFee = $loan_aprove * $fee / 100;
        }

      } elseif ($aina_makato == 'GENERAL') {
        if ($type == 'PERCENTAGE VALUE') {
          $sum_fee = $this->queries->get_sumfeepercentage($loan_id);
          $fee = $sum_fee->total_fee;
          $sum_total_loanFee = $loan_aprove * $fee / 100;
        } elseif ($type == 'MONEY VALUE') {
          $sum_fee = $this->queries->get_sumfeepercentage($loan_id);
          $fee = $sum_fee->total_fee;
          $sum_total_loanFee = $fee;
        }

      }
      //       print_r($sum_total_loanFee);
      // exit();


      //branch Account
      @$blanch_account = $this->queries->get_amount_remainAmountBlanch($blanch_id, $payment_method);
      $blanch_capital = @$blanch_account->blanch_capital;
      $withMoney = ($blanch_capital) - ($new_balance + $sum_total_loanFee);

      //admin role
      $role = $empl_data->username;

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

      $comp_name = $company_data->comp_name;

      //$today_float = $this->queries->get_today_cash($blanch_id);
      //$float = $today_float->blanch_capital;
      $remain_balance = $balance;
      $today = date("Y-m-d H:i");
      $sms = 'Umepokea ' . ' ' . 'Tsh.' . number_format($remain_balance) . ' ' . 'Kutoka ' . ' ' . $comp_name . ' ' . 'Tarehe ' . $today;
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

      if ($new_code != $code) {
        $this->session->set_flashdata('error', 'Loan Code is Invalid Please Try Again');
      } else {

        if ($blanch_capital < $withdrow_newbalance) {
          $this->session->set_flashdata('error', 'Branch Account balance Is Not Enough to withdraw');
        } elseif ($input_balance <= $balance) {
          //$day_loandata = $this->queries->get_loan_day($loan_id);
          $this->witdrow_balance($loan_id, $comp_id, $blanch_id, $customer_id, $new_balance, $with_balance, $description, $role, $group_id, $method);
          $this->insert_loan_lecordData($comp_id, $customer_id, $loan_id, $blanch_id, $withdrow_newbalance, $group_id, $trans_id, $restoration, $loan_aprove, $empl_id, $with_date);
          $this->withdrawal_blanch_capital($blanch_id, $payment_method, $withMoney);
          $this->insert_deducted_fee($comp_id, $blanch_id, $loan_id, $sum_total_loanFee, $group_id);
          if ($blanch_deducted == TRUE) {
            $this->update_old_deducted_balance($comp_id, $blanch_id, $new_deducted);
            //echo "update";
          } else {
            $this->insert_sum_deducted_fee($comp_id, $blanch_id, $sum_total_loanFee);
            //echo "ingiza";
          }
          // print_r($sum_total_loanFee);
          //            exit();
          $this->update_withtime($loan_id, $with_method, $statusLoan, $input_balance, $with_date);
          $this->update_returntime($loan_id, $day, $dis_day, $with_date);
          $this->insert_startLoan_date($comp_id, $loan_id, $blanch_id, $end_date, $customer_id, $with_date);
          $this->update_customer_status($customer_id);
          if ($company_data->sms_status == 'YES') {
            if (@$smscount->sms_number == TRUE) {
              $new_sms = 1;
              $total_sms = @$sms_number + $new_sms;
              $this->update_count_sms($comp_id, $total_sms, $sms_id);
            } elseif ($smscount->sms_number == FALSE) {
              $sms_number = 1;
              $this->insert_count_sms($comp_id, $sms_number);
            }
            //$this->sendsms($phone,$massage);
          } elseif ($company_data->sms_status == 'NO') {
            //echo "hakuna kitu";
          }
          $this->session->set_flashdata('massage', 'withdrow Has made Sucessfully');
        } else {
          $this->session->set_flashdata('error', 'Customer Balance is not Enough to withdraw');
        }
      }
      return redirect('oficer/data_with_depost/' . $customer_id);
    }

    $this->data_with_depost();
  }


  public function insert_loan_lecordData($comp_id, $customer_id, $loan_id, $blanch_id, $withdrow_newbalance, $group_id, $trans_id, $restoration, $loan_aprove, $empl_id, $with_date)
  {
    $day = date("Y-m-d H:i:s");
    $this->db->query("INSERT INTO tbl_prev_lecod (`comp_id`,`customer_id`,`loan_id`,`blanch_id`,`withdraw`,`lecod_day`,`group_id`,`restrations`,`loan_aprov`,`with_trans`,`empl_id`,`time_rec`) VALUES ('$comp_id','$customer_id','$loan_id','$blanch_id','$withdrow_newbalance','$with_date','$group_id','$restoration','$loan_aprove','$trans_id','$empl_id','$day')");

  }



  //update deducted fee
  public function update_old_deducted_balance($comp_id, $blanch_id, $new_deducted)
  {
    $sqldata = "UPDATE `tbl_receive_deducted` SET `deducted`= '$new_deducted' WHERE `blanch_id`= '$blanch_id'";
    $query = $this->db->query($sqldata);
    return true;
  }

  //insert sumdeducted fee
  public function insert_sum_deducted_fee($comp_id, $blanch_id, $sum_total_loanFee)
  {
    $this->db->query("INSERT INTO tbl_receive_deducted (`comp_id`,`blanch_id`,`deducted`) VALUES ('$comp_id','$blanch_id','$sum_total_loanFee')");
  }
  //insert deducted fee
  public function insert_deducted_fee($comp_id, $blanch_id, $loan_id, $sum_total_loanFee, $group_id)
  {
    $day = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_deducted_fee (`comp_id`,`blanch_id`,`loan_id`,`deducted_balance`,`deducted_date`,`group_id`) VALUES ('$comp_id','$blanch_id','$loan_id','$sum_total_loanFee','$day','$group_id')");
  }
  //withdral blanch Float
  public function withdrawal_blanch_capital($blanch_id, $payment_method, $withMoney)
  {
    $sqldata = "UPDATE `tbl_blanch_account` SET `blanch_capital`= '$withMoney' WHERE `blanch_id`= '$blanch_id' AND `receive_trans_id` = '$payment_method'";
    // print_r($sqldata);
    //  echo "<br>";
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }

  //update customer status
  public function update_customer_status($customer_id)
  {
    $sqldata = "UPDATE `tbl_customer` SET `customer_status`= 'open' WHERE `customer_id`= '$customer_id'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }

  //update customer status
  public function update_customer_statusLoan($customer_id)
  {
    $sqldata = "UPDATE `tbl_customer` SET `customer_status`= 'close' WHERE `customer_id`= '$customer_id'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }


  //update withdraw time
  public function update_withtime($loan_id, $with_method, $statusLoan, $input_balance, $with_date)
  {
    $data_day = $with_date;
    $sqldata = "UPDATE `tbl_loans` SET `dis_date`= '$data_day',`method`='$with_method',`loan_status`='$statusLoan',`disburse_day`='$data_day',`with_amount`='$input_balance',`region_id`='ok' WHERE `loan_id`= '$loan_id'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }

  //update return date
  public function update_returntime($loan_id, $day, $dis_date, $with_date)
  {
    $now = $with_date;
    $someDate = DateTime::createFromFormat("Y-m-d", $now);
    $someDate->add(new DateInterval('P' . $day . 'D'));
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
    $sqldata = "UPDATE `tbl_loans` SET `dis_date`='$now',`return_date`= '$return_data',`date_show`='$rtn' WHERE `loan_id`= '$loan_id'";
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

  public function insert_startLoan_date($comp_id, $loan_id, $blanch_id, $end_date, $customer_id, $with_date)
  {
    $this->load->model('queries');
    ini_set("max_execution_time", 3600);
    $get_day = $this->queries->get_loan_day($loan_id);
    $day = $get_day->day;
    $now = $with_date;
    $someDate = DateTime::createFromFormat("Y-m-d", $now);
    $someDate->add(new DateInterval('P' . $end_date . 'D'));
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
//          //$loan_id = 1;
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
//          //$loan_id = 1;
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
//          //$loan_id = 1;
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

  public function witdrow_balance($loan_id, $comp_id, $blanch_id, $customer_id, $new_balance, $with_balance, $description, $role, $group_id, $method)
  {
    $day = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_pay (`loan_id`,`blanch_id`,`comp_id`,`customer_id`,`withdrow`,`balance`,`description`,`pay_status`,`stat`,`date_pay`,`emply`,`group_id`,`date_data`,`p_method`) VALUES ('$loan_id','$blanch_id','$comp_id','$customer_id','$new_balance','$with_balance','$description','2','1','$day','$role','$group_id','$day','$method')");
  }


  public function data_with_depost($customer_id)
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $customer = $this->queries->search_CustomerLoan($customer_id);
    $customery = $this->queries->get_allcutomerblanchData($blanch_id);
    $customer_id = $this->input->post('customer_id');
    $comp_id = $this->input->post('comp_id');

    @$blanch_id = $customer->blanch_id;
    $acount = $this->queries->get_customer_account_verfied($blanch_id);
    $this->load->view('oficer/depost_withdrow', ['customer' => $customer, 'customery' => $customery, 'acount' => $acount, 'empl_data' => $empl_data]);
  }




  public function deposit_loan($customer_id)
  {
    $this->form_validation->set_rules('customer_id', 'Customer', 'required');
    $this->form_validation->set_rules('comp_id', 'Company', 'required');
    $this->form_validation->set_rules('blanch_id', 'blanch', 'required');
    $this->form_validation->set_rules('loan_id', 'Loan', 'required');
    $this->form_validation->set_rules('depost', 'depost', 'required');
    $this->form_validation->set_rules('p_method', 'Method', 'required');
    $this->form_validation->set_rules('description', 'description', 'required');
    $this->form_validation->set_rules('deposit_date', 'deposit date', 'required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
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

      $this->load->model('queries');
      $blanch_id = $this->session->userdata('blanch_id');
      $empl_id = $this->session->userdata('empl_id');
      $manager_data = $this->queries->get_manager_data($empl_id);
      $comp_id = $manager_data->comp_id;
      $company_data = $this->queries->get_companyData($comp_id);
      $blanch_data = $this->queries->get_blanchData($blanch_id);
      $empl_data = $this->queries->get_employee_data($empl_id);
      $company_data = $this->queries->get_companyData($comp_id);
      $loan_restoration = $this->queries->get_restoration_loan($loan_id);
      //$empl_id = $loan_restoration->empl_id;
      $date_show = $loan_restoration->date_show;
      $company = $this->queries->get_comp_data($comp_id);

      $day_id = $loan_restoration->day;



      //sms count function
      // @$smscount = $this->queries->get_smsCountDate($comp_id);
      // $sms_number = @$smscount->sms_number;
      // $sms_id = @$smscount->sms_id;

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

      @$blanch_account = $this->queries->get_amount_remainAmountBlanch($blanch_id, $payment_method);
      $blanch_capital = @$blanch_account->blanch_capital;
      $depost_money = $blanch_capital + $new_depost;

      //admin role
      $role = $empl_data->username;


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
      $day_int = $int / $ses_day;
      $day_princ = $int - $day_int;

      //insert principal balance 
      $trans_id = $payment_method;
      $princ_status = $loan_status;
      $principal_balance = $day_princ;
      $interest_balance = $day_int;

      //principal
      // $principal_blanch = $this->queries->get_blanch_capitalPrincipal($comp_id,$blanch_id,$trans_id,$princ_status);
      // $old_principal_balance = @$principal_blanch->principal_balance;
      // $principal_insert = $old_principal_balance + $principal_balance;

      //interest
      // $interest_blanch = $this->queries->get_blanch_interest_capital($comp_id,$blanch_id,$trans_id,$princ_status);
      // $interest_blanch_balance = @$interest_blanch->capital_interest;
      // $interest_insert = $interest_blanch_balance + $day_int;


      $total_depost = $this->queries->get_sum_dapost($loan_id);
      $loan_dep = $total_depost->remain_balance_loan;
      $kumaliza_depost = $loan_dep + $kumaliza;

      $loan_int = $loan_restoration->loan_int;
      $remain_loan = $loan_int - $total_depost->remain_balance_loan;

      $sun_blanch_capital = $this->queries->get_remain_blanch_capital($blanch_id, $trans_id);
      $total_blanch_amount = $sun_blanch_capital->blanch_capital;
      $deposit_new = $total_blanch_amount + $depost;

      if ($kumaliza_depost < $loan_int) {
        //print_r($kumaliza_depost);
        // echo "bado sana";
      } elseif ($kumaliza_depost > $loan_int) {
        //echo "hapana";
      } elseif ($kumaliza_depost = $loan_int) {
        $this->update_loastatus_done($loan_id);
        $this->insert_loan_kumaliza($comp_id, $blanch_id, $customer_id, $loan_id, $kumaliza, $group_id);
        $this->update_customer_statusclose($customer_id);
        //echo "tunamaliza kazi";
      }


      @$check_deposit = $this->queries->get_today_deposit_record($loan_id, $deposit_date);
      $depost_check = @$check_deposit->depost;
      $dep_id = @$check_deposit->dep_id;
      $again_deposit = $depost_check + $depost;

      @$check_prev = $this->queries->get_prev_record_report($loan_id, $deposit_date);
      $prev_deposit = @$check_prev->depost;
      $dep_id = @$check_prev->pay_id;
      $again_prev = $prev_deposit + $depost;

      //outstand deposit

      @$out_deposit = $this->queries->get_outstand_deposit($blanch_id, $trans_id);
      $out_balance = @$out_deposit->out_balance;

      $new_out_balance = $out_balance + $depost;

      $pay_id = $dep_id;

      // print_r($empl_id);
      //         exit();


      if ($out_data == TRUE) {
        if ($depost > $out_data->remain_amount) {
          $this->session->set_flashdata("error", 'Your Depost Amount is Greater');
        } else {
          $remain_amount = $out_data->remain_amount;
          $paid_amount = $out_data->paid_amount;
          $customer_id = $out_data->customer_id;
          if ($new_balance >= $remain_amount) {
            $depost_amount = $remain_amount - $new_balance;
            $paid_out = $paid_amount + $new_balance;

            // print_r($depost_amount);
            //       exit();
            //insert depost balance

            if ($check_deposit == TRUE) {
              $this->update_deposit_record($loan_id, $deposit_date, $again_deposit, $p_method, $day_id);
            } else {
              $dep_id = $this->insert_loan_lecorDeposit($comp_id, $customer_id, $loan_id, $blanch_id, $new_depost, $p_method, $role, $day_int, $day_princ, $loan_status, $group_id, $deposit_date, $empl_id, $day_id);
            }

            if (@$out_deposit->out_balance == TRUE || @$out_deposit->out_balance == '0') {
              $this->update_blanch_amount_outstand($comp_id, $blanch_id, $new_out_balance, $trans_id);
            } else {
              $this->insert_blanch_amount_outstand_deposit($comp_id, $blanch_id, $new_out_balance, $trans_id);
            }
            $this->update_loan_dep_status($loan_id);
            $new_balance = $new_depost;

            if ($dep_id > 0) {
              $this->session->set_flashdata('massage', number_format($depost) . ' Deposit has made Sucessfully');
            } else {
              $this->session->set_flashdata('massage', 'Failed');
            }
            $this->update_outstand_status($loan_id);
            if ($check_prev == TRUE) {
              $dep_id = $dep_id;
              $empl_id = $empl_id;
              $this->update_deposit_record_prev($loan_id, $deposit_date, $again_prev, $dep_id, $p_method);
            } else {
              $dep_id = $dep_id;
              $empl_id = $empl_id;
              $this->insert_loan_lecordDataDeposit($comp_id, $customer_id, $loan_id, $blanch_id, $new_depost, $dep_id, $group_id, $trans_id, $restoration, $loan_aproved, $deposit_date, $empl_id);
            }
            $this->insert_remainloan($loan_id, $depost_amount, $paid_out, $pay_id);
            $this->update_loastatus($loan_id);
            $this->depost_balance($loan_id, $comp_id, $blanch_id, $customer_id, $new_depost, $sum_balance, $description, $role, $group_id, $p_method, $deposit_date, $dep_id);
            //$this->depost_Blanch_accountBalance($comp_id,$blanch_id,$payment_method,$depost_money);
            //$this->insert_blanch_amount_deposit($blanch_id,$deposit_new,$trans_id);
            //    if(@$principal_blanch == TRUE){
            // $this->update_principal_capital_balanc($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
            // }elseif(@$principal_blanch == FALSE){
            // $this->insert_blanch_principal($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
            // }
            //interest
            //   if (@$interest_blanch == TRUE) {
            //   $this->update_interest_blanchBalance($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);    
            //   }elseif(@$interest_blanch == FALSE){
            //   $this->insert_interest_blanch_capital($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);
            // }
            $this->insert_customer_report($loan_id, $comp_id, $blanch_id, $customer_id, $group_id, $new_depost, $pay_id, $deposit_date);
            //$this->insert_prepaid_balance($loan_id,$comp_id,$blanch_id,$customer_id,$prepaid);
            $this->update_customer_statusLoan($customer_id);
            $total_depost = $this->queries->get_sum_dapost($loan_id);
            $loan_int = $loan_restoration->loan_int;
            $remain_loan = $loan_int - $total_depost->remain_balance_loan;
            //sms send
            $today = date("Y-m-d");
            $date = date("d/m/Y");
            $sms = 'Ndugu, ' . $full_name . ' ' . $date . ' Umeingiza TZS.' . number_format($new_balance) . ' ' . $comp_name . ' Mpokeaji ' . $role . ' bado unadaiwa kiasi cha TZS.' . $remain_loan;
            $massage = $sms;
            $phone = $phones;

            $loan_ID = $loan_id;
            @$out_check = $this->queries->get_outstand_total($loan_id);
            $amount_remain = @$out_check->remain_amount;
            // print_r($new_balance);
            //       exit();
            if ($amount_remain > $new_balance) {
              $this->insert_outstand_balance($comp_id, $blanch_id, $customer_id, $loan_id, $new_balance, $group_id, $dep_id);
            } elseif ($amount_remain = $new_balance) {
              $this->insert_outstand_balance($comp_id, $blanch_id, $customer_id, $loan_id, $new_balance, $group_id, $dep_id);
            }

            //$phone = '255'.substr($phones, 1,10);
            // print_r($sms);
            //   echo "<br>";
            // print_r($phone);
            //      exit();
            if ($company_data->sms_status == 'YES') {
              $this->sendsms($phone, $massage);
              //echo "kitu kipo";
            } elseif ($company_data->sms_status == 'NO') {
              //echo "Hakuna kitu hapa";
            }


          } else {
            $depost_amount = $remain_amount - $new_balance;
            $paid_out = $paid_amount + $new_balance;

            //insert depost balance
            if ($check_deposit == TRUE) {
              $this->update_deposit_record($loan_id, $deposit_date, $again_deposit, $p_method, $day_id);
            } else {
              $dep_id = $this->insert_loan_lecorDeposit($comp_id, $customer_id, $loan_id, $blanch_id, $new_depost, $p_method, $role, $day_int, $day_princ, $loan_status, $group_id, $deposit_date, $empl_id, $day_id);
            }

            if (@$out_deposit->out_balance == TRUE || @$out_deposit->out_balance == '0') {
              $this->update_blanch_amount_outstand($comp_id, $blanch_id, $new_out_balance, $trans_id);
            } else {
              $this->insert_blanch_amount_outstand_deposit($comp_id, $blanch_id, $new_out_balance, $trans_id);
            }
            $this->update_loan_dep_status($loan_id);
            $new_balance = $new_depost;
            if ($dep_id > 0) {
              $this->session->set_flashdata('massage', number_format($depost) . ' Deposit has made Sucessfully');
            } else {
              $this->session->set_flashdata('massage', 'Failed');
            }
            if ($check_prev == TRUE) {
              $dep_id = $dep_id;
              $empl_id = $empl_id;
              $this->update_deposit_record_prev($loan_id, $deposit_date, $again_prev, $dep_id, $p_method);
            } else {
              $dep_id = $dep_id;
              $empl_id = $empl_id;
              $this->insert_loan_lecordDataDeposit($comp_id, $customer_id, $loan_id, $blanch_id, $new_depost, $dep_id, $group_id, $trans_id, $restoration, $loan_aproved, $deposit_date, $empl_id);
            }
            $this->insert_remainloan($loan_id, $depost_amount, $paid_out, $pay_id);

            $this->depost_balance($loan_id, $comp_id, $blanch_id, $customer_id, $new_depost, $sum_balance, $description, $role, $group_id, $p_method, $deposit_date, $dep_id);
            //$this->insert_blanch_amount_deposit($blanch_id,$deposit_new,$trans_id);
            //    if (@$principal_blanch == TRUE) {
            // $this->update_principal_capital_balanc($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
            // }elseif(@$principal_blanch == FALSE){
            // $this->insert_blanch_principal($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
            // }
            //inrterest
            // if (@$interest_blanch == TRUE) {
            // $this->update_interest_blanchBalance($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);    
            // }elseif(@$interest_blanch == FALSE){
            // $this->insert_interest_blanch_capital($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);
            // }
            $this->insert_customer_report($loan_id, $comp_id, $blanch_id, $customer_id, $group_id, $new_depost, $pay_id, $deposit_date);
            //$this->insert_prepaid_balance($loan_id,$comp_id,$blanch_id,$customer_id,$prepaid);
            $total_depost = $this->queries->get_sum_dapost($loan_id);
            $loan_int = $loan_restoration->loan_int;
            $remain_loan = $loan_int - $total_depost->remain_balance_loan;
            //sms send
            $today = date("Y-m-d");
            $date = date("d/m/Y");
            $sms = 'Ndugu, ' . $full_name . ' ' . $date . ' Umeingiza TZS.' . number_format($new_balance) . ' ' . $comp_name . ' Mpokeaji ' . $role . ' bado unadaiwa kiasi cha TZS.' . $remain_loan;

            $massage = $sms;
            $phone = $phones;


            $loan_ID = $loan_id;
            @$out_check = $this->queries->get_outstand_total($loan_id);
            $amount_remain = @$out_check->remain_amount;

            if ($amount_remain > $new_balance) {

              $this->insert_outstand_balance($comp_id, $blanch_id, $customer_id, $loan_id, $new_balance, $group_id, $dep_id);
              // print_r($comp_id);
              //         exit();
            } elseif ($amount_remain = $new_balance) {
              $this->insert_outstand_balance($comp_id, $blanch_id, $customer_id, $loan_id, $new_balance, $group_id, $dep_id);
            }
            //$phone = '255'.substr($phones, 1,10);
            // print_r($sms);
            //   echo "<br>";
            // print_r($phone);
            //      exit();
            if ($company_data->sms_status == 'YES') {
              $this->sendsms($phone, $massage);
              //echo "kitu kipo";
            } elseif ($company_data->sms_status == 'NO') {
              //echo "Hakuna kitu hapa";
            }
          }
        }


        //ndani ya mkataba
      } elseif ($out_data == FALSE) {
        if ($kumaliza_depost > $loan_int) {
          $this->session->set_flashdata("error", 'Your Depost Amount is Greater');
        } else {
          //insert depost balance

          if ($check_deposit == TRUE) {
            $this->update_deposit_record($loan_id, $deposit_date, $again_deposit, $p_method, $day_id);
          } else {
            $dep_id = $this->insert_loan_lecorDeposit($comp_id, $customer_id, $loan_id, $blanch_id, $new_depost, $p_method, $role, $day_int, $day_princ, $loan_status, $group_id, $deposit_date, $empl_id, $day_id);
          }
          $this->insert_blanch_amount_deposit($blanch_id, $deposit_new, $trans_id);
          $this->update_loan_dep_status($loan_id);
          //exit();

          $new_balance = $new_depost;
          if ($dep_id > 0) {
            $this->session->set_flashdata('massage', number_format($depost) . ' Deposit has made Sucessfully');
          } else {
            $this->session->set_flashdata('massage', 'Deposit has made Sucessfully');
          }

          if ($check_prev == TRUE) {
            $dep_id = $dep_id;
            $empl_id = $empl_id;
            $this->update_deposit_record_prev($loan_id, $deposit_date, $again_prev, $dep_id, $p_method);
          } else {
            $dep_id = $dep_id;
            $empl_id = $empl_id;
            $this->insert_loan_lecordDataDeposit($comp_id, $customer_id, $loan_id, $blanch_id, $new_depost, $dep_id, $group_id, $trans_id, $restoration, $loan_aproved, $deposit_date, $empl_id);
          }
          $this->depost_balance($loan_id, $comp_id, $blanch_id, $customer_id, $new_depost, $sum_balance, $description, $role, $group_id, $p_method, $deposit_date, $dep_id);

          //$this->depost_Blanch_accountBalance($comp_id,$blanch_id,$payment_method,$depost_money);
          //principal
          // if (@$principal_blanch == TRUE) {
          // $this->update_principal_capital_balanc($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
          // }elseif(@$principal_blanch == FALSE){
          // $this->insert_blanch_principal($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
          // }
          //inrterest
          //   if (@$interest_blanch == TRUE) {
          //   $this->update_interest_blanchBalance($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);    
          //   }elseif(@$interest_blanch == FALSE){
          //   $this->insert_interest_blanch_capital($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);
          // }


          //updating recovery loan
          $loan_ID = $loan_id;
          @$data_pend = $this->queries->get_total_pending_loan($loan_ID);
          $total_pend = @$data_pend->total_pend;

          if (@$data_pend->total_pend == TRUE) {
            if ($depost > $total_pend) {
              $deni_lipa = $depost - $total_pend;
              //$recovery = $deni_lipa - $total_pend; 
              $this->update_loan_pending_remain($loan_id);
              $this->insert_description_report($comp_id, $blanch_id, $customer_id, $loan_id, $total_pend, $deni_lipa, $group_id, $dep_id);
            } elseif ($depost < $total_pend) {
              $deni_lipa = $total_pend - $depost;
              $this->update_loan_pending_balance($loan_id, $deni_lipa);
              $this->insert_returnDescriptionData_report($comp_id, $blanch_id, $customer_id, $loan_id, $depost, $group_id, $dep_id);
            } elseif ($depost = $total_pend) {
              $this->update_loan_pending_remain($loan_id);
              $this->insert_returnDescriptionData_report($comp_id, $blanch_id, $customer_id, $loan_id, $depost, $group_id, $dep_id);
            }
          } elseif ($data_pend->total_pend == FALSE) {
            if ($date_show >= $today) {
              if ($depost < $restoration) {
                $prepaid = 0;
              } else {
                $prepaid = $depost - $restoration;
              }
              $this->insert_prepaid_balance($loan_id, $comp_id, $blanch_id, $customer_id, $prepaid, $dep_id);
            } else {

            }

          }

          $total_depost = $this->queries->get_sum_dapost($loan_id);
          $loan_int = $loan_restoration->loan_int;
          $remain_loan = $loan_int - $total_depost->remain_balance_loan;
          //sms send
          $today = date("Y-m-d");
          $date = date("d/m/Y");
          $sms = 'Ndugu, ' . $full_name . ' ' . $date . ' Umeingiza TZS.' . number_format($new_balance) . ' ' . $comp_name . ' Mpokeaji ' . $role . ' bado unadaiwa kiasi cha TZS.' . $remain_loan;

          $massage = $sms;
          $phone = $phones;

          if ($company_data->sms_status == 'YES') {
            $this->sendsms($phone, $massage);
            //echo "kitu kipo";
          } elseif ($company_data->sms_status == 'NO') {
            //echo "Hakuna kitu hapa";
          }
        }
      }


      return redirect('oficer/data_with_depost/' . $customer_id);

    }

    $this->data_with_depost();

  }

  public function update_loan_dep_status($loan_id)
  {
    $sqldata = "UPDATE `tbl_loans` SET `dep_status`= 'close' WHERE `loan_id`= '$loan_id'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }

  public function update_blanch_amount_outstand($comp_id, $blanch_id, $new_out_balance, $trans_id)
  {
    $sqldata = "UPDATE `tbl_receve_outstand` SET `out_balance`= '$new_out_balance' WHERE `blanch_id`= '$blanch_id' AND `trans_id`='$trans_id'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }


  public function insert_blanch_amount_outstand_deposit($comp_id, $blanch_id, $new_out_balance, $trans_id)
  {
    $date = date("Y-m-d");
    $this->db->query("INSERT INTO  tbl_receve_outstand (`comp_id`,`blanch_id`,`trans_id`,`out_balance`,`date`) VALUES ('$comp_id','$blanch_id','$trans_id','$new_out_balance','$date')");
  }


  //update loan status
  public function update_loastatus($loan_id)
  {
    $sqldata = "UPDATE `tbl_loans` SET `loan_status`= 'done' WHERE `loan_id`= '$loan_id'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }

  public function insert_loan_lecordDataDeposit($comp_id, $customer_id, $loan_id, $blanch_id, $new_depost, $dep_id, $group_id, $trans_id, $restoration, $loan_aproved, $deposit_date, $empl_id)
  {
    //$day = date("Y-m-d");
    $time = date("Y-m-d H:i:s");
    $this->db->query("INSERT INTO tbl_prev_lecod (`comp_id`,`customer_id`,`loan_id`,`blanch_id`,`depost`,`lecod_day`,`pay_id`,`time_rec`,`trans_id`,`restrations`,`loan_aprov`,`empl_id`) VALUES ('$comp_id','$customer_id','$loan_id','$blanch_id','$new_depost','$deposit_date','$dep_id','$time','$trans_id','$restoration','$loan_aproved','$empl_id')");
  }


  public function insert_blanch_amount_deposit($blanch_id, $deposit_new, $trans_id)
  {
    $sqldata = "UPDATE `tbl_blanch_account` SET `blanch_capital`= '$deposit_new' WHERE `blanch_id`= '$blanch_id' AND `receive_trans_id` ='$trans_id'";
    $query = $this->db->query($sqldata);
    return true;
  }

  public function update_prepaid($loan_id, $total_prepaid)
  {
    $sqldata = "UPDATE `tbl_prepaid` SET `prepaid_amount`= '$total_prepaid' WHERE `loan_id`= '$loan_id'";
    $query = $this->db->query($sqldata);
    return true;
  }


  public function update_deposit_record_prev($loan_id, $deposit_date, $again_prev, $dep_id, $p_method)
  {
    $sqldata = "UPDATE `tbl_prev_lecod` SET `depost`= '$again_prev',`pay_id`='$dep_id',`trans_id`='$p_method' WHERE `loan_id`= '$loan_id' AND `lecod_day`='$deposit_date'";

    $query = $this->db->query($sqldata);
    return true;
  }


  public function update_deposit_record($loan_id, $deposit_date, $again_deposit, $p_method, $day_id)
  {
    $sqldata = "UPDATE `tbl_depost` SET `depost`= '$again_deposit',`depost_method`='$p_method',`day_id`='$day_id' WHERE `loan_id`= '$loan_id' AND `depost_day`='$deposit_date'";
    $query = $this->db->query($sqldata);
    return true;
  }


  public function insert_outstand_balance($comp_id, $blanch_id, $customer_id, $loan_id, $new_balance, $group_id, $dep_id)
  {

    $report_day = date("Y-m-d");
    $this->db->query("INSERT INTO  tbl_pay (`comp_id`,`blanch_id`,`customer_id`,`loan_id`,`withdrow`,`balance`,`description`,`date_data`,`auto_date`,`group_id`,`dep_id`) VALUES ('$comp_id','$blanch_id','$customer_id','$loan_id','$new_balance','0','SYSTEM / DEFAULT LOAN RETURN','$report_day','$report_day','$group_id','$dep_id')");
  }

  public function insert_returnDescriptionData_report($comp_id, $blanch_id, $customer_id, $loan_id, $depost, $group_id, $dep_id)
  {
    $report_day = date("Y-m-d");
    $this->db->query("INSERT INTO  tbl_pay (`comp_id`,`blanch_id`,`customer_id`,`loan_id`,`withdrow`,`balance`,`description`,`date_data`,`auto_date`,`group_id`,`dep_id`) VALUES ('$comp_id','$blanch_id','$customer_id','$loan_id','$depost','0','SYSTEM / PENDING LOAN RETURN','$report_day','$report_day','$group_id','$dep_id')");
  }

  public function update_loan_pending_balance($loan_id, $deni_lipa)
  {
    $sqldata = "UPDATE `tbl_pending_total` SET `total_pend`= '$deni_lipa' WHERE `loan_id`= '$loan_id'";
    $query = $this->db->query($sqldata);
    return true;
  }

  public function insert_description_report($comp_id, $blanch_id, $customer_id, $loan_id, $total_pend, $deni_lipa, $group_id, $dep_id)
  {
    $report_day = date("Y-m-d");
    $this->db->query("INSERT INTO  tbl_pay (`comp_id`,`blanch_id`,`customer_id`,`loan_id`,`withdrow`,`balance`,`description`,`date_data`,`auto_date`,`group_id`,`dep_id`) VALUES ('$comp_id','$blanch_id','$customer_id','$loan_id','$total_pend','$deni_lipa','SYSTEM / LOAN PENDING RETURN','$report_day','$report_day','$group_id','$dep_id')");
  }

  //update empty
  public function update_loan_pending_remain($loan_id)
  {
    $sqldata = "UPDATE `tbl_pending_total` SET `total_pend`= '0' WHERE `loan_id`= '$loan_id'";
    $query = $this->db->query($sqldata);
    return true;
  }


  //update loan status
  public function update_loastatus_done($loan_id)
  {
    $sqldata = "UPDATE `tbl_loans` SET `loan_status`= 'done' WHERE `loan_id`= '$loan_id'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }

  public function insert_loan_kumaliza($comp_id, $blanch_id, $customer_id, $loan_id, $kumaliza, $group_id)
  {
    $report_day = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_customer_report (`comp_id`,`blanch_id`,`customer_id`,`loan_id`,`recevable_amount`,`pending_amount`,`rep_date`,`group_id`) VALUES ('$comp_id','$blanch_id','$customer_id','$loan_id','$kumaliza','$kumaliza','$report_day','$group_id')");
  }

  //update customer status
  public function update_customer_statusclose($customer_id)
  {
    $sqldata = "UPDATE `tbl_customer` SET `customer_status`= 'close' WHERE `customer_id`= '$customer_id'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }


  public function update_interest_blanchBalance($comp_id, $blanch_id, $trans_id, $princ_status, $interest_insert)
  {
    $sqldata = "UPDATE `tbl_blanch_capital_interest` SET `capital_interest`= '$interest_insert' WHERE `blanch_id`= '$blanch_id' AND `trans_id`='$trans_id' AND `int_status`='$princ_status'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }

  public function update_principal_capital_balanc($comp_id, $blanch_id, $trans_id, $princ_status, $principal_insert)
  {
    $sqldata = "UPDATE `tbl_blanch_capital_principal` SET `principal_balance`= '$principal_insert' WHERE `blanch_id`= '$blanch_id' AND `trans_id`='$trans_id' AND `princ_status`='$princ_status'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }

  public function insert_interest_blanch_capital($comp_id, $blanch_id, $trans_id, $princ_status, $interest_insert)
  {
    $this->db->query("INSERT INTO tbl_blanch_capital_interest (`comp_id`,`blanch_id`,`trans_id`,`int_status`,`capital_interest`) VALUES ('$comp_id','$blanch_id','$trans_id','$princ_status','$interest_insert')");
  }

  public function insert_blanch_principal($comp_id, $blanch_id, $trans_id, $princ_status, $principal_insert)
  {
    $this->db->query("INSERT INTO tbl_blanch_capital_principal (`comp_id`,`blanch_id`,`trans_id`,`princ_status`,`principal_balance`) VALUES ('$comp_id','$blanch_id','$trans_id','$princ_status','$principal_insert')");
  }

  //update blanch Balance
  public function depost_Blanch_accountBalance($comp_id, $blanch_id, $payment_method, $depost_money)
  {
    $sqldata = "UPDATE `tbl_blanch_account` SET `blanch_capital`= '$depost_money' WHERE `blanch_id`= '$blanch_id' AND `receive_trans_id`='$payment_method'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }




  //update outstand status
  public function update_outstand_status($loan_id)
  {
    $sqldata = "UPDATE `tbl_outstand_loan` SET `out_status`= 'close' WHERE `loan_id`= '$loan_id'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }

  public function insert_remainloan($loan_id, $depost_amount, $paid_out, $pay_id)
  {
    $sqldata = "UPDATE `tbl_outstand_loan` SET `remain_amount`= '$depost_amount',`paid_amount`='$paid_out',`pay_id`='$pay_id' WHERE `loan_id`= '$loan_id'";
    $query = $this->db->query($sqldata);
    return true;
  }

  public function insert_blanch_amount($blanch_id, $new_depost)
  {
    $sqldata = "UPDATE `tbl_blanch_account` SET `blanch_capital`= `blanch_capital`+$new_depost WHERE `blanch_id`= '$blanch_id'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }

  public function insert_comp_balance($comp_id, $new_depost)
  {
    $sqldata = "UPDATE `tbl_ac_company` SET `comp_balance`= `comp_balance`+$new_depost WHERE `comp_id`= '$comp_id'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }

  //insert prepaid balance
  public function insert_prepaid_balance($loan_id, $comp_id, $blanch_id, $customer_id, $prepaid, $dep_id)
  {
    $date = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_prepaid (`loan_id`,`comp_id`,`blanch_id`,`customer_id`,`prepaid_amount`,`prepaid_date`,`dep_id`) VALUES ('$loan_id','$comp_id','$blanch_id','$customer_id','$prepaid','$date','$dep_id')");
  }

  public function insert_loan_lecorDeposit($comp_id, $customer_id, $loan_id, $blanch_id, $new_depost, $p_method, $role, $day_int, $day_princ, $loan_status, $group_id, $deposit_date, $empl_id, $day_id)
  {
    $time = date("Y-m-d H:i:s");
    $this->db->query("INSERT INTO  tbl_depost (`comp_id`,`customer_id`,`loan_id`,`blanch_id`,`depost`,`depost_day`,`depost_method`,`empl_username`,`sche_principal`,`sche_interest`,`dep_status`,`group_id`,`deposit_day`,`empl_id`,`day_id`) VALUES ('$comp_id','$customer_id','$loan_id','$blanch_id','$new_depost','$deposit_date','$p_method','$role','$day_princ','$day_int','$loan_status','$group_id','$time','$empl_id','$day_id')");
    return $this->db->insert_id();
  }

  public function depost_balance($loan_id, $comp_id, $blanch_id, $customer_id, $new_depost, $sum_balance, $description, $role, $group_id, $p_method, $deposit_date, $dep_id)
  {
    $day = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_pay (`loan_id`,`blanch_id`,`comp_id`,`customer_id`,`depost`,`balance`,`description`,`pay_status`,`stat`,`date_pay`,`emply`,`group_id`,`date_data`,`p_method`,`dep_id`) VALUES ('$loan_id','$blanch_id','$comp_id','$customer_id','$new_depost','$sum_balance','CASH DEPOSIT','1','1','$day','$role','$group_id','$deposit_date','$p_method','$dep_id')");


  }

  public function insert_customer_report($loan_id, $comp_id, $blanch_id, $customer_id, $group_id, $new_depost, $pay_id, $deposit_date)
  {
    //$date = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_customer_report (`loan_id`,`comp_id`,`blanch_id`,`customer_id`,`group_id`,`pending_amount`,`pay_id`,`rep_date`) VALUES ('$loan_id','$comp_id','$blanch_id','$customer_id','$group_id','$new_depost','$pay_id','$deposit_date')");
  }


  public function daily_report()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $blanch_account = $this->queries->get_sum_blanch_account($blanch_id);
    $blanch_capital = $blanch_account->total_capital_blanch;


    $total_deducted_income = $this->queries->get_deducted_income_blanch($blanch_id);
    $total_deducted = $total_deducted_income->total_deducted;

    $non_deducted = $this->queries->get_non_deducted_income_blanch($blanch_id);
    $total_non = $non_deducted->total_nonbalance;


    $total_income = $total_deducted + $total_non;

    @$today_cash = $this->queries->get_cash_inhand($blanch_id);
    @$today_deduction = $this->queries->get_total_deduction_data($blanch_id);

    $cash_transaction = $this->queries->get_account_transfor($blanch_id);
    $income = $this->queries->get_income_transaction_data($blanch_id);
    $yester_day_balance = $this->queries->get_yesterday_balance($blanch_id);
    $today_deposit = $this->queries->get_total_today_deposit($blanch_id);

    $total_today_cash = $this->queries->get_today_cash_balance($blanch_id);
    $loan_with = $this->queries->get_loan_withdrawal_today_blanch($blanch_id);

    $prepaid = $this->queries->get_today_prepaid_today($blanch_id);

    $stoo = $this->queries->get_total_stoo_trans($blanch_id);

    $acount = $this->queries->get_customer_account_verfied($blanch_id);

    $yesterday_income = $this->queries->get_yesterday_income($blanch_id);

    $more_expenses = $this->queries->get_more_expenses_today($blanch_id);

    $today_transactionInc = $this->queries->get_transaction_from_incToblanch_account($blanch_id);

    $today_expenses = $this->queries->get_total_expenses_req($blanch_id);

    $inc_lala = $this->queries->get_deduction_lala($blanch_id);

    $today_recevable = $this->queries->get_today_receivable($blanch_id);

    //          echo "<pre>";
    // print_r($today_recevable);
    //      exit();

    $today_deducted = $this->queries->get_today_income_deducted($blanch_id);
    $deducted_today = $today_deducted->total_deducted_data;
    $today_non = $this->queries->get_today_non_deducted($blanch_id);
    $non_today = $today_non->total_nondata;

    $today_total_income = $deducted_today + $non_today;
    // print_r($non_today);
    //       exit();


    if (@$today_cash->cash_amount == TRUE || @$today_cash->cash_amount == '0') {
      $this->update_cash_inhand($blanch_id, $blanch_capital, $empl_id);
      //echo "update cash";
    } else {
      $this->insert_cashinhand_data($comp_id, $blanch_id, $empl_id, $blanch_capital);
      //echo "insert cash";
    }

    if (@$today_deduction->amount == TRUE || @$today_deduction->amount == '0') {
      $this->update_duction_income($blanch_id, $empl_id, $total_income);
    } else {
      $this->insert_deduction_balance($comp_id, $blanch_id, $empl_id, $total_income);
      //echo "insert";
    }

    @$out_receive = $this->queries->get_total_blanch_outstand_account($blanch_id);
    $receve_out = @$out_receive->total_outbalance_deposit;
    @$out_stoo = $this->queries->get_outsatand_deposit($blanch_id);

    if (@$out_stoo->total_balance == TRUE || @$out_stoo->total_balance == '0') {

      //echo "update data";
      $this->update_outstand_stoo_day($comp_id, $blanch_id, $receve_out);
    } else {
      //echo "Ingiza data";
      $this->insert_outstand_stooBlance($comp_id, $blanch_id, $receve_out);
    }

    $deposit_out = $this->queries->get_total_deposit_out($blanch_id);
    $yesterDay = $this->queries->get_prev_outstand_date($blanch_id);

    $today_stoo_out = $this->queries->get_today_outstand_stoo($blanch_id);
    $remain_out = $this->queries->get_outstand_loan_data_branch($blanch_id);

    $account_out_balance = $this->queries->get_outstand_account_balance($blanch_id);

    @$day_deducted = $this->queries->get_deducted_day($blanch_id);

    if (@$day_deducted->deduct_balance == TRUE || @$day_deducted->deduct_balance == '0') {
      $this->update_deduction_today_balance($blanch_id, $total_deducted);
    } else {
      $this->insert_deduction_today_balance($comp_id, $blanch_id, $total_deducted);
    }

    @$day_nonDeducted = $this->queries->get_non_deductedDay($blanch_id);

    if (@$day_nonDeducted->non_deduct_balance == TRUE || @$day_nonDeducted->non_deduct_balance == '0') {
      $this->update_nonDeducted_dayBalance($blanch_id, $total_non);
    } else {
      $this->insert_nonDeducted_dayBalance($comp_id, $blanch_id, $total_non);
    }

    $prev_deduct = $this->queries->get_prev_deducted_income($blanch_id);
    $today_deduct_income = $this->queries->get_today_deducted_income($blanch_id);

    $prev_non = $this->queries->get_prev_nonDeducted_income($blanch_id);
    $today_non_data = $this->queries->get_today_nonDeducted_income($blanch_id);


    $out_system = $this->queries->get_total_receive_out_system($blanch_id);
    $total_out_system = $out_system->total_out_system;

    @$data_nje = $this->queries->get_out_sysstem_date($blanch_id);

    if (@$data_nje->amount == TRUE || @$data_nje->amount == '0') {
      $this->update_njesystem($blanch_id, $total_out_system);
    } else {

      $this->insert_njesystem($comp_id, $blanch_id, $total_out_system);
      //echo "insert";
    }

    $yester_dayNje = $this->queries->get_deposit_out_system_yesterday($blanch_id);
    $total_nje = $this->queries->get_today_deposit_out($blanch_id);
    $sum_out = $this->queries->get_total_deposit_outSystem($blanch_id);
    $nje_deni = $this->queries->get_total_out_deni($blanch_id);

    $nje_account = $this->queries->get_njeya_mfumo_data_account($blanch_id);

    $total_kopesha_in = $this->queries->get_total_transaction_default_insystem($blanch_id);
    $total_kopesha_out = $this->queries->get_total_transaction_default_outsystem($blanch_id);

    $today_remain_deposit = $this->queries->get_total_today_deposit_loan($blanch_id);
    $saving_deposit_remain = $this->queries->get_total_saving_deposit($blanch_id);



    //       echo "<pre>";
    // print_r($saving_deposit_remain);
    //          exit();


    $this->load->view('oficer/daily_report', ['empl_data' => $empl_data, 'cash_transaction' => $cash_transaction, 'income' => $income, 'yester_day_balance' => $yester_day_balance, 'today_deposit' => $today_deposit, 'total_today_cash' => $total_today_cash, 'loan_with' => $loan_with, 'prepaid' => $prepaid, 'stoo' => $stoo, 'acount' => $acount, 'yesterday_income' => $yesterday_income, 'today_total_income' => $today_total_income, 'more_expenses' => $more_expenses, 'today_transactionInc' => $today_transactionInc, 'today_expenses' => $today_expenses, 'inc_lala' => $inc_lala, 'today_recevable' => $today_recevable, 'deposit_out' => $deposit_out, 'yesterDay' => $yesterDay, 'today_stoo_out' => $today_stoo_out, 'remain_out' => $remain_out, 'account_out_balance' => $account_out_balance, 'prev_deduct' => $prev_deduct, 'today_deduct_income' => $today_deduct_income, 'prev_non' => $prev_non, 'today_non_data' => $today_non_data, 'yester_dayNje' => $yester_dayNje, 'total_nje' => $total_nje, 'nje_deni' => $nje_deni, 'sum_out' => $sum_out, 'nje_account' => $nje_account, 'total_out_system' => $total_out_system, 'total_kopesha_in' => $total_kopesha_in, 'total_kopesha_out' => $total_kopesha_out, 'today_remain_deposit' => $today_remain_deposit, 'saving_deposit_remain' => $saving_deposit_remain, 'non_today' => $non_today]);
  }



  public function print_default_loan($blanch_id, $from, $to)
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $empl_data = $this->queries->get_employee_data($empl_id);
    $comp_id = $empl_data->comp_id;
    $compdata = $this->queries->get_companyData($comp_id);
    if ($blanch_id == 'all') {
      $default_blanch = $this->queries->filter_loan_default_comp($comp_id);
      $total_blanch = $this->queries->get_total_outStand_company($comp_id);
    } else {
      $default_blanch = $this->queries->filter_loan_default($blanch_id, $from, $to);
      $total_blanch = $this->queries->get_total_outStand_blanch($blanch_id, $from, $to);
    }

    $blanch_data = $this->queries->get_blanch_data($blanch_id);
    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L', 'orientation' => 'L']);
    $html = $this->load->view('oficer/default_report', ['compdata' => $compdata, 'default_blanch' => $default_blanch, 'total_blanch' => $total_blanch, 'blanch_data' => $blanch_data, 'blanch_id' => $blanch_id, 'from' => $from, 'to' => $to], true);
    $mpdf->SetFooter('Generated By Brainsoft');
    $mpdf->SetWatermarkText($compdata->comp_name);
    $mpdf->showWatermarkText = true;
    $date = date("Y-m-d");
    $mpdf->WriteHTML($html);
    $output = 'Default Loan ' . $date . '.pdf';
    $mpdf->Output("$output", 'I');
  }



  public function filter_daily_report()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $blanch_id = $this->input->post('blanch_id');
    $from = $this->input->post('from');
    $to = $this->input->post('to');
    // print_r($to);
    //     exit();

    $this->load->view('oficer/filter_daily_report', ['empl_data' => $empl_data, 'blanch_id' => $blanch_id, 'from' => $from, 'to' => $to]);
  }


  public function print_daily_report_data()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $blanch_account = $this->queries->get_sum_blanch_account($blanch_id);
    $blanch_capital = $blanch_account->total_capital_blanch;


    $total_deducted_income = $this->queries->get_deducted_income_blanch($blanch_id);
    $total_deducted = $total_deducted_income->total_deducted;

    $non_deducted = $this->queries->get_non_deducted_income_blanch($blanch_id);
    $total_non = $non_deducted->total_nonbalance;


    $total_income = $total_deducted + $total_non;

    @$today_cash = $this->queries->get_cash_inhand($blanch_id);
    @$today_deduction = $this->queries->get_total_deduction_data($blanch_id);

    $cash_transaction = $this->queries->get_account_transfor($blanch_id);
    $income = $this->queries->get_income_transaction_data($blanch_id);
    $yester_day_balance = $this->queries->get_yesterday_balance($blanch_id);
    $today_deposit = $this->queries->get_total_today_deposit($blanch_id);

    $total_today_cash = $this->queries->get_today_cash_balance($blanch_id);
    $loan_with = $this->queries->get_loan_withdrawal_today_blanch($blanch_id);

    $prepaid = $this->queries->get_today_prepaid_today($blanch_id);

    $stoo = $this->queries->get_total_stoo_trans($blanch_id);

    $acount = $this->queries->get_customer_account_verfied($blanch_id);

    $yesterday_income = $this->queries->get_yesterday_income($blanch_id);

    $more_expenses = $this->queries->get_more_expenses_today($blanch_id);

    $today_transactionInc = $this->queries->get_transaction_from_incToblanch_account($blanch_id);

    $today_expenses = $this->queries->get_total_expenses_req($blanch_id);

    $inc_lala = $this->queries->get_deduction_lala($blanch_id);

    $today_recevable = $this->queries->get_today_receivable($blanch_id);

    //          echo "<pre>";
    // print_r($today_recevable);
    //      exit();

    $today_deducted = $this->queries->get_today_income_deducted($blanch_id);
    $deducted_today = $today_deducted->total_deducted_data;
    $today_non = $this->queries->get_today_non_deducted($blanch_id);
    $non_today = $today_non->total_nondata;

    $today_total_income = $deducted_today + $non_today;
    // print_r($today_total_income);
    //       exit();


    if (@$today_cash->cash_amount == TRUE || @$today_cash->cash_amount == '0') {
      $this->update_cash_inhand($blanch_id, $blanch_capital, $empl_id);
      //echo "update cash";
    } else {
      $this->insert_cashinhand_data($comp_id, $blanch_id, $empl_id, $blanch_capital);
      //echo "insert cash";
    }

    if (@$today_deduction->amount == TRUE || @$today_deduction->amount == '0') {
      $this->update_duction_income($blanch_id, $empl_id, $total_income);
    } else {
      $this->insert_deduction_balance($comp_id, $blanch_id, $empl_id, $total_income);
      //echo "insert";
    }

    @$out_receive = $this->queries->get_total_blanch_outstand_account($blanch_id);
    $receve_out = @$out_receive->total_outbalance_deposit;
    @$out_stoo = $this->queries->get_outsatand_deposit($blanch_id);

    if (@$out_stoo->total_balance == TRUE || @$out_stoo->total_balance == '0') {

      //echo "update data";
      $this->update_outstand_stoo_day($comp_id, $blanch_id, $receve_out);
    } else {
      //echo "Ingiza data";
      $this->insert_outstand_stooBlance($comp_id, $blanch_id, $receve_out);
    }

    $deposit_out = $this->queries->get_total_deposit_out($blanch_id);
    $yesterDay = $this->queries->get_prev_outstand_date($blanch_id);

    $today_stoo_out = $this->queries->get_today_outstand_stoo($blanch_id);
    $remain_out = $this->queries->get_outstand_loan_data_branch($blanch_id);

    $account_out_balance = $this->queries->get_outstand_account_balance($blanch_id);

    @$day_deducted = $this->queries->get_deducted_day($blanch_id);

    if (@$day_deducted->deduct_balance == TRUE || @$day_deducted->deduct_balance == '0') {
      $this->update_deduction_today_balance($blanch_id, $total_deducted);
    } else {
      $this->insert_deduction_today_balance($comp_id, $blanch_id, $total_deducted);
    }

    @$day_nonDeducted = $this->queries->get_non_deductedDay($blanch_id);

    if (@$day_nonDeducted->non_deduct_balance == TRUE || @$day_nonDeducted->non_deduct_balance == '0') {
      $this->update_nonDeducted_dayBalance($blanch_id, $total_non);
    } else {
      $this->insert_nonDeducted_dayBalance($comp_id, $blanch_id, $total_non);
    }

    $prev_deduct = $this->queries->get_prev_deducted_income($blanch_id);
    $today_deduct_income = $this->queries->get_today_deducted_income($blanch_id);

    $prev_non = $this->queries->get_prev_nonDeducted_income($blanch_id);
    $today_non_data = $this->queries->get_today_nonDeducted_income($blanch_id);


    $out_system = $this->queries->get_total_receive_out_system($blanch_id);
    $total_out_system = $out_system->total_out_system;

    @$data_nje = $this->queries->get_out_sysstem_date($blanch_id);

    if (@$data_nje->amount == TRUE || @$data_nje->amount == '0') {
      $this->update_njesystem($blanch_id, $total_out_system);
    } else {

      $this->insert_njesystem($comp_id, $blanch_id, $total_out_system);
      //echo "insert";
    }

    $yester_dayNje = $this->queries->get_deposit_out_system_yesterday($blanch_id);
    $total_nje = $this->queries->get_today_deposit_out($blanch_id);
    $sum_out = $this->queries->get_total_deposit_outSystem($blanch_id);
    $nje_deni = $this->queries->get_total_out_deni($blanch_id);

    $nje_account = $this->queries->get_njeya_mfumo_data_account($blanch_id);

    $total_kopesha_in = $this->queries->get_total_transaction_default_insystem($blanch_id);
    $total_kopesha_out = $this->queries->get_total_transaction_default_outsystem($blanch_id);
    $today_remain_deposit = $this->queries->get_total_today_deposit_loan($blanch_id);
    $saving_deposit_remain = $this->queries->get_total_saving_deposit($blanch_id);

    $compdata = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $date = date("Y-m-d");


    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L', 'orientation' => 'L']);
    $html = $this->load->view('oficer/daily_reportpdf', ['empl_data' => $empl_data, 'cash_transaction' => $cash_transaction, 'income' => $income, 'yester_day_balance' => $yester_day_balance, 'today_deposit' => $today_deposit, 'total_today_cash' => $total_today_cash, 'loan_with' => $loan_with, 'prepaid' => $prepaid, 'stoo' => $stoo, 'acount' => $acount, 'yesterday_income' => $yesterday_income, 'today_total_income' => $today_total_income, 'more_expenses' => $more_expenses, 'today_transactionInc' => $today_transactionInc, 'today_expenses' => $today_expenses, 'inc_lala' => $inc_lala, 'today_recevable' => $today_recevable, 'deposit_out' => $deposit_out, 'yesterDay' => $yesterDay, 'today_stoo_out' => $today_stoo_out, 'remain_out' => $remain_out, 'account_out_balance' => $account_out_balance, 'prev_deduct' => $prev_deduct, 'today_deduct_income' => $today_deduct_income, 'prev_non' => $prev_non, 'today_non_data' => $today_non_data, 'yester_dayNje' => $yester_dayNje, 'total_nje' => $total_nje, 'nje_deni' => $nje_deni, 'sum_out' => $sum_out, 'nje_account' => $nje_account, 'total_out_system' => $total_out_system, 'total_kopesha_in' => $total_kopesha_in, 'total_kopesha_out' => $total_kopesha_out, 'blanch_data' => $blanch_data, 'compdata' => $compdata, 'today_remain_deposit' => $today_remain_deposit, 'saving_deposit_remain' => $saving_deposit_remain, 'non_today' => $non_today], true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
    $mpdf->WriteHTML($html);
    $output = 'Daily report ' . $date . '.pdf';
    $mpdf->Output("$output", 'I');
  }


  public function update_njesystem($blanch_id, $total_out_system)
  {
    $day = date("Y-m-d");
    $sqldata = "UPDATE `tbl_outsystem_day` SET `amount`= '$total_out_system' WHERE `blanch_id`= '$blanch_id' AND `date`='$day'";
    $query = $this->db->query($sqldata);
    return true;
  }

  public function insert_njesystem($comp_id, $blanch_id, $total_out_system)
  {
    $day = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_outsystem_day (`comp_id`,`blanch_id`,`amount`,`date`) VALUES ('$comp_id','$blanch_id','$total_out_system','$day')");
  }


  public function insert_nonDeducted_dayBalance($comp_id, $blanch_id, $total_non)
  {
    $day = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_non_deduct_day (`comp_id`,`blanch_id`,`non_deduct_balance`,`non_date`) VALUES ('$comp_id','$blanch_id','$total_non','$day')");
  }

  public function update_nonDeducted_dayBalance($blanch_id, $total_non)
  {
    $day = date("Y-m-d");
    $sqldata = "UPDATE `tbl_non_deduct_day` SET `non_deduct_balance`= '$total_non' WHERE `blanch_id`= '$blanch_id' AND `non_date`='$day'";
    $query = $this->db->query($sqldata);
    return true;
  }


  public function insert_deduction_today_balance($comp_id, $blanch_id, $total_deducted)
  {
    $day = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_deduction_day (`comp_id`,`blanch_id`,`deduct_balance`,`date_deduct`) VALUES ('$comp_id', '$blanch_id','$total_deducted','$day')");
  }


  public function update_deduction_today_balance($blanch_id, $total_deducted)
  {
    $day = date("Y-m-d");
    $sqldata = "UPDATE `tbl_deduction_day` SET `deduct_balance`= '$total_deducted' WHERE `blanch_id`= '$blanch_id' AND `date_deduct`='$day'";
    $query = $this->db->query($sqldata);
    return true;
  }

  public function insert_outstand_stooBlance($comp_id, $blanch_id, $receve_out)
  {
    $day = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_receive_out_date (`comp_id`,`blanch_id`,`total_balance`,`date_out`) VALUES ('$comp_id', '$blanch_id','$receve_out','$day')");
  }



  public function update_outstand_stoo_day($comp_id, $blanch_id, $receve_out)
  {
    $day = date("Y-m-d");
    $sqldata = "UPDATE `tbl_receive_out_date` SET `total_balance`= '$receve_out' WHERE `blanch_id`= '$blanch_id' AND `date_out`='$day'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }



  public function insert_cashinhand_data($comp_id, $blanch_id, $empl_id, $blanch_capital)
  {
    $day = date("Y-m-d");
    $this->db->query("INSERT INTO tbl_cash_inhand (`comp_id`,`blanch_id`,`empl_id`,`cash_amount`,`cash_day`) VALUES ('$comp_id', '$blanch_id','$empl_id','$blanch_capital','$day')");
  }

  public function update_cash_inhand($blanch_id, $blanch_capital, $empl_id)
  {
    $day = date("Y-m-d");
    $sqldata = "UPDATE `tbl_cash_inhand` SET `cash_amount`= '$blanch_capital',`empl_id`='$empl_id' WHERE `blanch_id`= '$blanch_id' AND `cash_day`='$day'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }


  public function insert_deduction_balance($comp_id, $blanch_id, $empl_id, $total_income)
  {
    $day = date("Y-m-d");
    $this->db->query("INSERT INTO  tbl_deduction (`comp_id`,`blanch_id`,`empl_id`,`amount`,`date`) VALUES ('$comp_id', '$blanch_id','$empl_id','$total_income','$day')");
  }


  public function update_duction_income($blanch_id, $empl_id, $total_income)
  {
    $day = date("Y-m-d");
    $sqldata = "UPDATE `tbl_deduction` SET `amount`= '$total_income',`empl_id`='$empl_id' WHERE `blanch_id`= '$blanch_id' AND `date`='$day'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }


  public function deposit_stoo()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $acount = $this->queries->get_customer_account_verfied($blanch_id);
    $transaction_stoo = $this->queries->get_stoo_transaction($blanch_id);

    $total_stoo = $this->queries->get_total_stoo_trans($blanch_id);
    //   echo "<pre>";
    // print_r($total_stoo);
    //     exit();

    $this->load->view('oficer/stoo', ['empl_data' => $empl_data, 'acount' => $acount, 'transaction_stoo' => $transaction_stoo, 'total_stoo' => $total_stoo]);
  }


  public function transfor_amount_stoo()
  {
    $this->load->model('queries');
    $this->form_validation->set_rules('comp_id', 'company', 'required');
    $this->form_validation->set_rules('blanch_id', 'blanch', 'required');
    $this->form_validation->set_rules('stoo_amount', 'stoo', 'required');
    $this->form_validation->set_rules('from_account', 'Account', 'required');
    $this->form_validation->set_rules('empl_id', 'Employee', 'required');
    $this->form_validation->set_rules('stoo_date', 'date', 'required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
    if ($this->form_validation->run()) {
      $data = $this->input->post();

      $comp_id = $data['comp_id'];
      $blanch_id = $data['blanch_id'];
      $stoo_amount = $data['stoo_amount'];
      $account = $data['from_account'];

      $blanch_account = $this->queries->get_blanch_capital_account($blanch_id, $account);
      $blanch_balance = $blanch_account->blanch_capital;
      $chomoa = $blanch_balance - $stoo_amount;
      $new_added = $chomoa;
      // exit();
      if ($stoo_amount > $blanch_balance) {
        $this->session->set_flashdata("error", 'You don`t Have Enough Balance');
        return redirect("oficer/deposit_stoo");
      } else {
        $this->queries->insert_stoo_amount($data);
        $this->update_account_blanch_balance($blanch_id, $account, $new_added);
        $this->session->set_flashdata("massage", 'Transaction successfully');
      }
      return redirect("oficer/deposit_stoo");
    }
    $this->deposit_stoo();
  }


  public function adjust_transaction($stoo_id)
  {
    $this->load->model('queries');
    $stoo_data = $this->queries->get_stoo_transaction_delete($stoo_id);
    $stoo_amount = $stoo_data->stoo_amount;
    $account = $stoo_data->from_account;
    $blanch_id = $stoo_data->blanch_id;

    $blanch_account = $this->queries->get_blanch_capital_account($blanch_id, $account);
    $blanch_balance = $blanch_account->blanch_capital;

    $new_added = $blanch_balance + $stoo_amount;
    // print_r($blanch_balance);
    //        exit();
    $this->update_account_blanch_balance($blanch_id, $account, $new_added);
    if ($this->delete_stoo_transaction($stoo_id))
      ;
    $this->session->set_flashdata("massage", 'Successfully');
    return redirect("oficer/deposit_stoo");
  }

  public function delete_stoo_transaction($stoo_id)
  {
    return $this->db->delete('tbl_stoo', ['stoo_id' => $stoo_id]);
  }


  public function expnses_requisition_form()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $expenses = $this->queries->get_expense_data($comp_id);

    $request_exp = $this->queries->get_today_expense_request($blanch_id);

    $expenses_total = $this->queries->get_total_expenses_req($blanch_id);


    $this->load->view('oficer/expenses_requisition', ['empl_data' => $empl_data, 'expenses' => $expenses, 'request_exp' => $request_exp, 'expenses_total' => $expenses_total]);
  }


  public function filter_expenses_request()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $from = $this->input->post('from');
    $to = $this->input->post('to');
    $blanch_id = $this->input->post('blanch_id');

    $data_expenses = $this->queries->get_prev_expenses_data($from, $to, $blanch_id);
    $total_expenses = $this->queries->get_sum_expenses($from, $to, $blanch_id);
    //        echo "<pre>";
    // print_r($data_expenses);
    //      exit();

    $this->load->view('oficer/prev_expenses', ['empl_data' => $empl_data, 'data_expenses' => $data_expenses, 'from' => $from, 'to' => $to, 'total_expenses' => $total_expenses]);
  }

  public function get_remove_expenses($req_id)
  {
    $this->load->model('queries');
    $data_req = $this->queries->get_request_expenses($req_id);
    $type = $data_req->deduct_type;
    $blanch_id = $data_req->blanch_id;
    $req_amount = $data_req->req_amount;

    $deducted_income = $this->queries->get_deducted_income_blanch($blanch_id);
    $deducted = $deducted_income->total_deducted;

    $expenses_deducted = $deducted + $req_amount;

    $non_deductedIncome = $this->queries->get_non_deducted_income_blanch($blanch_id);
    $non_income = $non_deductedIncome->total_nonbalance;

    $expenses_non = $non_income + $req_amount;


    if ($type == 'deducted') {
      $this->update_expenses_income_deducted($blanch_id, $expenses_deducted);
      $this->delete_request_data($req_id);
      $this->session->set_flashdata("massage", 'Expenses Deleted Successfully');
    } elseif ($type == 'non deducted') {
      $this->update_income_nonbalance($blanch_id, $expenses_non);
      $this->delete_request_data($req_id);
      $this->session->set_flashdata("massage", 'Expenses Deleted Successfully');
    }

    return redirect("oficer/expnses_requisition_form");
  }

  public function delete_request_data($req_id)
  {
    return $this->db->delete('tbl_request_exp', ['req_id' => $req_id]);
  }


  public function create_requstion_form()
  {
    $this->load->model('queries');
    $this->form_validation->set_rules('comp_id', 'company', 'required');
    $this->form_validation->set_rules('blanch_id', 'blanch', 'required');
    $this->form_validation->set_rules('req_description', 'description', 'required');
    $this->form_validation->set_rules('req_amount', 'Amount', 'required');
    $this->form_validation->set_rules('empl_id', 'Employee', 'required');
    $this->form_validation->set_rules('req_date', 'req_date', 'required');
    $this->form_validation->set_rules('deduct_type', 'type', 'required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

    if ($this->form_validation->run()) {
      $data = $this->input->post();

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
          $this->session->set_flashdata("error", 'You don`t Have Enough Balance');
          return redirect('oficer/expnses_requisition_form');
        } else {
          $this->update_expenses_income_deducted($blanch_id, $expenses_deducted);
          $this->queries->insert_reques_expenses($data);
          $this->session->set_flashdata("massage", $this->lang->line("expenses_alert_menu"));
        }

      } elseif ($deduct_type == 'non deducted') {
        if ($non_income < $req_amount) {
          $this->session->set_flashdata("error", 'You don`t Have Enough Balance');
          return redirect('oficer/expnses_requisition_form');
        } else {
          $this->update_income_nonbalance($blanch_id, $expenses_non);
          $this->queries->insert_reques_expenses($data);
          $this->session->set_flashdata("massage", $this->lang->line("expenses_alert_menu"));
        }
      }
      return redirect("oficer/expnses_requisition_form");
    }
    $this->expnses_requisition_form();
  }

  public function update_expenses_income_deducted($blanch_id, $expenses_deducted)
  {
    $sqldata = "UPDATE `tbl_receive_deducted` SET `deducted`= '$expenses_deducted' WHERE `blanch_id`= '$blanch_id'";
    $query = $this->db->query($sqldata);
    return true;
  }

  public function update_income_nonbalance($blanch_id, $expenses_non)
  {
    $sqldata = "UPDATE `tbl_receive_non_deducted` SET `non_balance`= '$expenses_non' WHERE `blanch_id`= '$blanch_id'";
    $query = $this->db->query($sqldata);
    return true;
  }

  public function get_loan_withdrawal_data()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);
    $loan_with = $this->queries->get_loan_withdrawal_today_blanch_general($blanch_id);

    $total_loanwith = $this->queries->get_loan_withdrawal_today_blanch($blanch_id);
    // print_r($total_loanwith);
    //       exit();
    $this->load->view('oficer/loan_withdrawal', ['empl_data' => $empl_data, 'loan_with' => $loan_with, 'total_loanwith' => $total_loanwith]);
  }


  public function filter_loan_with()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $blanch_id = $this->input->post('blanch_id');
    $from = $this->input->post('from');
    $to = $this->input->post('to');
    $loan_status = $this->input->post('loan_status');

    $blanch_previous = $this->queries->get_previous_loan_with_blanch($from, $to, $blanch_id, $loan_status);
    $total_loan_with = $this->queries->total_filter_loan_with($from, $to, $blanch_id, $loan_status);
    //         echo "<pre>";
    // print_r($total_loan_with);
    //         exit();

    $this->load->view('oficer/prev_loan_with', ['empl_data' => $empl_data, 'blanch_previous' => $blanch_previous, 'from' => $from, 'to' => $to, 'total_loan_with' => $total_loan_with]);
  }


  public function oustand_loan()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);


    $default_loan = $this->queries->get_outstand_loan_blanch($blanch_id);
    $total_default = $this->queries->get_total_outStand($blanch_id);
    //  echo "<pre>";
    // print_r($total_default);
    //       exit();
    $this->load->view('oficer/outstand_loan', ['default_loan' => $default_loan, 'empl_data' => $empl_data, 'total_default' => $total_default, 'blanch_id' => $blanch_id]);
  }


  public function filter_default_loan()
  {
    $this->load->model('queries');
    $comp_id = $this->session->userdata('comp_id');
    $blanch = $this->queries->get_blanch($comp_id);



    $blanch_id = $this->input->post('blanch_id');
    $from = $this->input->post('from');
    $to = $this->input->post('to');

    if ($blanch_id == 'all') {
      $default_blanch = $this->queries->filter_loan_default_comp($comp_id, $from, $to);
      $total_blanch = $this->queries->get_total_outStand_company($comp_id, $from, $to);
    } else {
      $default_blanch = $this->queries->filter_loan_default($blanch_id, $from, $to);
      $total_blanch = $this->queries->get_total_outStand_blanch($blanch_id, $from, $to);
    }

    $blanch_data = $this->queries->get_blanch_data($blanch_id);
    // echo "<pre>";
    // print_r($total_blanch);
    //       exit();

    $this->load->view('oficer/filter_defaultloan', ['blanch' => $blanch, 'default_blanch' => $default_blanch, 'total_blanch' => $total_blanch, 'blanch_data' => $blanch_data, 'blanch_id' => $blanch_id, 'from' => $from, 'to' => $to]);
  }

  public function cash_transaction()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $cash_transaction = $this->queries->get_cash_transaction_blanch($blanch_id);
    $sum_cashTransaction = $this->queries->get_cash_transaction_sum_blanch($blanch_id);


    $account_deposit = $this->queries->get_deposit_sunnary_account_blanch($blanch_id);
    $default_list = $this->queries->get_depositing_out_blanch($blanch_id);
    $toyal_default = $this->queries->get_depositing_out_total_blanch($blanch_id);

    $withdrawal_account = $this->queries->get_withdrawal_summary_account_blanch_data($blanch_id);
    $total_code_no = $this->queries->get_total_code_number_blanch_data($blanch_id);
    $deducted_fee = $this->queries->get_total_deducted_income_blanch_data($blanch_id);

    $penart_paid = $this->queries->get_total_penart_paid_blanch_data($blanch_id);

    $miamala = $this->queries->get_miamala_hewa_blanch_data($blanch_id);
    $total_miamala = $this->queries->get_miamala_hewa_total_blanch_data($blanch_id);


    $hai_wateja = $this->queries->get_depositing_hai_blanch($blanch_id);
    $sugu_wateja = $this->queries->get_depositing_sugu_blanch($blanch_id);
    //        echo "<pre>";
    // print_r($sum_cashTransaction);
    //            exit();

    $this->load->view('oficer/cash_transaction', ['empl_data' => $empl_data, 'cash_transaction' => $cash_transaction, 'sum_cashTransaction' => $sum_cashTransaction, 'account_deposit' => $account_deposit, 'default_list' => $default_list, 'toyal_default' => $toyal_default, 'withdrawal_account' => $withdrawal_account, 'total_code_no' => $total_code_no, 'deducted_fee' => $deducted_fee, 'penart_paid' => $penart_paid, 'miamala' => $miamala, 'total_miamala' => $total_miamala, 'hai_wateja' => $hai_wateja, 'sugu_wateja' => $sugu_wateja]);
  }


  public function filter_cashTransaction()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $blanch_id = $this->input->post('blanch_id');
    $from = $this->input->post('from');
    $to = $this->input->post('to');


    $cash = $this->queries->get_blanchTransaction($from, $to, $blanch_id);
    $total_comp_data = $this->queries->get_blanchTransaction_comp_blanch($from, $to, $blanch_id);

    $account_deposit = $this->queries->get_deposit_sunnary_account_prev_blanch($blanch_id, $from, $to);
    $default_list = $this->queries->get_depositing_out_prev_blanch($blanch_id, $from, $to);
    $toyal_default = $this->queries->get_depositing_out_total_prev_blanch($blanch_id, $from, $to);

    $withdrawal_account = $this->queries->get_withdrawal_summary_account_blanch($blanch_id, $from, $to);
    $total_code_no = $this->queries->get_total_code_number_blanch($blanch_id, $from, $to);
    $deducted_fee = $this->queries->get_total_deducted_income_blanch($blanch_id, $from, $to);

    $penart_paid = $this->queries->get_total_penart_paid_blanch($blanch_id, $from, $to);

    $miamala = $this->queries->get_miamala_hewa_blanch($blanch_id, $from, $to);
    $total_miamala = $this->queries->get_miamala_hewa_total_blanch($blanch_id, $from, $to);

    $hai_wateja = $this->queries->get_depositing_hai_prev_blanch($blanch_id, $from, $to);
    $sugu_wateja = $this->queries->get_depositing_sugu_prev_blanch($blanch_id, $from, $to);

    $blanch_data = $this->queries->get_blanchData($blanch_id);
    // echo "<pre>";
    // print_r($total_cash);
    //        exit();
    $this->load->view('oficer/prev_cash', ['empl_data' => $empl_data, 'from' => $from, 'to' => $to, 'cash' => $cash, 'total_comp_data' => $total_comp_data, 'account_deposit' => $account_deposit, 'default_list' => $default_list, 'toyal_default' => $toyal_default, 'withdrawal_account' => $withdrawal_account, 'total_code_no' => $total_code_no, 'deducted_fee' => $deducted_fee, 'penart_paid' => $penart_paid, 'miamala' => $miamala, 'total_miamala' => $total_miamala, 'blanch_id' => $blanch_id, 'blanch_data' => $blanch_data, 'hai_wateja' => $hai_wateja, 'sugu_wateja' => $sugu_wateja]);
  }

  public function print_cashBlanch($from, $to, $blanch_id)
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    if ($blanch_id == 'all') {
      $cash = $this->queries->get_blanchTransaction_comp($from, $to, $comp_id);
      $total_comp_data = $this->queries->get_blanchTransaction_comp_data($from, $to, $comp_id);

      $account_deposit = $this->queries->get_deposit_sunnary_account_company($comp_id, $from, $to);
      $default_list = $this->queries->get_depositing_out_comp($comp_id, $from, $to);
      $toyal_default = $this->queries->get_depositing_out_total_comp($comp_id, $from, $to);

      $withdrawal_account = $this->queries->get_withdrawal_summary_account_company($comp_id, $from, $to);
      $total_code_no = $this->queries->get_total_code_number_comp($comp_id, $from, $to);
      $deducted_fee = $this->queries->get_total_deducted_income_company($comp_id, $from, $to);

      $penart_paid = $this->queries->get_total_penart_paid_company($comp_id, $from, $to);

      $miamala = $this->queries->get_miamala_hewa_company($comp_id, $from, $to);
      $total_miamala = $this->queries->get_miamala_hewa_total_company($comp_id, $from, $to);

    } else {
      $cash = $this->queries->get_blanchTransaction($from, $to, $blanch_id);
      $total_comp_data = $this->queries->get_blanchTransaction_comp_blanch($from, $to, $blanch_id);


      $account_deposit = $this->queries->get_deposit_sunnary_account_prev_blanch($blanch_id, $from, $to);
      $default_list = $this->queries->get_depositing_out_prev_blanch($blanch_id, $from, $to);
      $toyal_default = $this->queries->get_depositing_out_total_prev_blanch($blanch_id, $from, $to);

      $withdrawal_account = $this->queries->get_withdrawal_summary_account_blanch($blanch_id, $from, $to);
      $total_code_no = $this->queries->get_total_code_number_blanch($blanch_id, $from, $to);
      $deducted_fee = $this->queries->get_total_deducted_income_blanch($blanch_id, $from, $to);

      $penart_paid = $this->queries->get_total_penart_paid_blanch($blanch_id, $from, $to);
      $miamala = $this->queries->get_miamala_hewa_blanch($blanch_id, $from, $to);
      $total_miamala = $this->queries->get_miamala_hewa_total_blanch($blanch_id, $from, $to);

      $hai_wateja = $this->queries->get_depositing_hai_prev_blanch($blanch_id, $from, $to);
      $sugu_wateja = $this->queries->get_depositing_sugu_prev_blanch($blanch_id, $from, $to);

    }
    $blanch = $this->queries->get_blanchd($comp_id);
    $blanch_data = $this->queries->get_blanch_data($blanch_id);
    $compdata = $this->queries->get_companyData($comp_id);
    //        echo "<pre>";
    // print_r($compdata);
    //        exit();
    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L', 'orientation' => 'L']);
    $html = $this->load->view('oficer/print_cashTransaction_blanch', ['cash' => $cash, 'blanch_id' => $blanch_id, 'from' => $from, 'to' => $to, 'total_comp_data' => $total_comp_data, 'blanch_data' => $blanch_data, 'compdata' => $compdata, 'account_deposit' => $account_deposit, 'default_list' => $default_list, 'toyal_default' => $toyal_default, 'withdrawal_account' => $withdrawal_account, 'total_code_no' => $total_code_no, 'deducted_fee' => $deducted_fee, 'penart_paid' => $penart_paid, 'miamala' => $miamala, 'total_miamala' => $total_miamala, 'hai_wateja' => $hai_wateja, 'sugu_wateja' => $sugu_wateja], true);
    $mpdf->SetFooter('Generated By Brainsoft Technology');
    $mpdf->WriteHTML($html);
    $mpdf->Output();

  }


  public function loan_rejected()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);
    $loan_reject = $this->queries->get_loanlejectBlanch($blanch_id);
    // print_r($loan_reject);
    //     exit();
    $this->load->view('oficer/loan_rejected', ['empl_data' => $empl_data, 'loan_reject' => $loan_reject]);
  }


  public function saving_deposit()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);
    $acount = $this->queries->get_customer_account_verfied($blanch_id);

    $saving_deposit = $this->queries->get_saving_deposit($blanch_id);
    $total_saving = $this->queries->get_total_saving_deposit($blanch_id);
    // echo "<pre>";
    // print_r($saving_deposit);
    //       exit();

    $this->load->view('oficer/saving_deposit', ['empl_data' => $empl_data, 'acount' => $acount, 'saving_deposit' => $saving_deposit, 'total_saving' => $total_saving]);
  }


  public function remove_saving_deposit($id)
  {
    $this->load->model('queries');
    if ($this->queries->remove_saving($id))
      ;
    $this->session->set_flashdata("massage", 'Removed successfully');
    return redirect("oficer/saving_deposit");
  }





  public function create_saving_deposit()
  {
    $this->form_validation->set_rules('comp_id', 'company', 'required');
    $this->form_validation->set_rules('blanch_id', 'blanch', 'required');
    $this->form_validation->set_rules('provider', 'provider', 'required');
    $this->form_validation->set_rules('agent', 'Agent', 'required');
    $this->form_validation->set_rules('amount', 'amount', 'required');
    $this->form_validation->set_rules('ref_no', 'Reference', 'required');
    $this->form_validation->set_rules('time', 'time', 'required');
    $this->form_validation->set_rules('date', 'date', 'required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

    if ($this->form_validation->run()) {
      $data = $this->input->post();
      $this->load->model('queries');
      $blanch_id = $data['blanch_id'];
      $account = $data['provider'];
      $amount = $data['amount'];
      //   echo "<pre>";
      // print_r($amount);
      //    exit();

      $blanch_balance = $this->queries->get_blanch_account_balance($blanch_id, $account);
      $blanch_capital = $blanch_balance->blanch_capital;

      $saving = $blanch_capital + $amount;

      $this->update_blanch_capitaldata($blanch_id, $account, $saving);


      if ($this->queries->insert_saving_deposit($data)) {
        $this->session->set_flashdata("massage", 'Saving Deposit Saved successfully');
      } else {
        $this->session->set_flashdata("error", 'Failed');
      }

      return redirect("oficer/saving_deposit");
    }
    $this->saving_deposit();
  }


  public function update_blanch_capitaldata($blanch_id, $account, $saving)
  {
    $sqldata = "UPDATE `tbl_blanch_account` SET `blanch_capital`= '$saving' WHERE `blanch_id`= '$blanch_id' AND `receive_trans_id`='$account'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }


  public function remove_saving_deoposit($id)
  {
    $this->load->model('queries');
    $miamala = $this->queries->get_miamala_data($id);
    $amount = $miamala->amount;
    $account = $miamala->provider;
    $blanch_id = $miamala->blanch_id;

    $blanch_balance = $this->queries->get_blanch_account_balance($blanch_id, $account);
    $blanch_capital = $blanch_balance->blanch_capital;

    $saving = $blanch_capital - $amount;
    // print_r($saving);
    //       exit();
    $this->update_blanch_capitaldata($blanch_id, $account, $saving);


    if ($this->delete_miamala($id))
      ;
    $this->session->set_flashdata("massage", 'Deleted successfully');
    return redirect("oficer/saving_deposit");
  }

  public function delete_miamala($id)
  {
    return $this->db->delete('tbl_miamala', ['id' => $id]);
  }


  public function check_miamala($id)
  {
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

    $blanch_balance = $this->queries->get_blanch_account_balance($blanch_id, $account);
    $blanch_capital = $blanch_balance->blanch_capital;
    $saving = $blanch_capital - $amount;

    $cash_inHand = $this->queries->get_total_cashIn_Hand($blanch_id, $date);
    $cash_day = $cash_inHand->total_cashDay;

    $remove_cash = $cash_day - $amount;
    // print_r($blanch_capital);
    //     exit();
    $this->update_blanch_capitaldata($blanch_id, $account, $saving);
    if ($data->status = 'close') {
      // echo "<pre>";
      //   print_r($data);
      //     exit();
      $this->queries->update_miamala($data, $id);
      $this->session->set_flashdata('massage', 'Checked Successfully');
    }
    return redirect('oficer/checkd_miamala_data/' . $id);

  }


  public function checkd_miamala_data($id)
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $data_saving = $this->queries->get_miamala_depost($id);
    $customer = $this->queries->get_allcutomerblanchData($blanch_id);
    //     echo "<pre>";
    // print_r($data_saving);
    //       exit();

    $this->load->view('oficer/saving_deposit_loan', ['empl_data' => $empl_data, 'data_saving' => $data_saving, 'customer' => $customer]);
  }


  public function uncheck_miamala($id)
  {
    $this->load->model('queries');
    $data = $this->queries->get_miamala_depost($id);
    $miamala = $this->queries->get_miamala_data($id);
    $amount = $miamala->amount;
    $account = $miamala->provider;
    $blanch_id = $miamala->blanch_id;
    $date = $miamala->date;
    $today = date("Y-m-d");

    $blanch_balance = $this->queries->get_blanch_account_balance($blanch_id, $account);
    $blanch_capital = $blanch_balance->blanch_capital;
    $saving = $blanch_capital + $amount;
    // print_r($saving);
    //       exit();
    $cash_inHand = $this->queries->get_total_cashIn_Hand($blanch_id, $date);
    $cash_day = $cash_inHand->total_cashDay;

    $remove_cash = $cash_day + $amount;
    // print_r($remove_cash);
    // echo "<br>";
    // print_r($cash_day);
    //     exit();
    if ($date == $today) {
      $this->update_blanch_capitaldata($blanch_id, $account, $saving);
    } else {
      $this->update_cash_prev($blanch_id, $remove_cash, $date);
    }

    if ($data->status = 'open') {
      $this->queries->update_miamala($data, $id);
      $this->session->set_flashdata('massage', 'Un-Checked Successfully');
    }
    return redirect('oficer/saving_deposit');

  }

  public function update_cash_prev($blanch_id, $remove_cash, $date)
  {
    $sqldata = "UPDATE `tbl_cash_inhand` SET `cash_amount`= '$remove_cash' WHERE `blanch_id`= '$blanch_id' AND `cash_day`='$date'";
    // print_r($sqldata);
    //    exit();
    $query = $this->db->query($sqldata);
    return true;
  }



  public function out_ofsyastem()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);
    $acount = $this->queries->get_customer_account_verfied($blanch_id);
    $out_system = $this->queries->get_otstand_systemDeposit($blanch_id);
    $sum_out = $this->queries->get_total_deposit_outSystem($blanch_id);
    $today_deposit = $this->queries->get_today_deposit_out($blanch_id);
    // echo "<pre>";
    // print_r($today_deposit);
    //         exit();


    $this->load->view("oficer/out_system", ['empl_data' => $empl_data, 'acount' => $acount, 'out_system' => $out_system, 'sum_out' => $sum_out, 'today_deposit' => $today_deposit]);
  }

  public function create_default_loan_out()
  {
    $this->form_validation->set_rules('comp_id', 'company', 'required');
    $this->form_validation->set_rules('blanch_id', 'blanch', 'required');
    $this->form_validation->set_rules('out_amount', 'Amount', 'required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

    if ($this->form_validation->run()) {
      $data = $this->input->post();
      // print_r($data);
      //       exit();
      $this->load->model('queries');
      if ($this->queries->insert_out_standloan_out($data)) {
        $this->session->set_flashdata("massage", 'Saved successfully');
      } else {
        $this->session->set_flashdata("error", 'Failed');
      }
      return redirect("oficer/out_ofsyastem");
    }
    $this->out_ofsyastem();
  }

  public function modify_out_loan($id)
  {
    $this->form_validation->set_rules('out_amount', 'Amount', 'required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

    if ($this->form_validation->run()) {
      $data = $this->input->post();
      // print_r($data);
      //       exit();
      $this->load->model('queries');
      if ($this->queries->update_out_data($id, $data)) {
        $this->session->set_flashdata("massage", 'Updated successfully');
      } else {
        $this->session->set_flashdata("error", 'Failed');
      }
      return redirect("oficer/out_ofsyastem");
    }
    $this->out_ofsyastem();
  }

  public function create_deposit_out()
  {
    $this->load->model('queries');
    $this->form_validation->set_rules('comp_id', 'company', 'required');
    $this->form_validation->set_rules('blanch_id', 'blanch', 'required');
    $this->form_validation->set_rules('empl_id', 'Employee', 'required');
    $this->form_validation->set_rules('trans_id', 'Account', 'required');
    $this->form_validation->set_rules('customer_name', 'Customer', 'required');
    $this->form_validation->set_rules('amount', 'Amount', 'required');
    $this->form_validation->set_rules('date', 'date', 'required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

    if ($this->form_validation->run()) {
      $data = $this->input->post();

      $blanch_id = $data['blanch_id'];
      $empl_id = $data['empl_id'];
      $trans_id = $data['trans_id'];
      $amount = $data['amount'];
      $comp_id = $data['comp_id'];

      @$blanch_out = $this->queries->get_receive_outsystem($blanch_id, $trans_id);
      $amount_receive = @$blanch_out->amount_receive;

      $new_receve = $amount_receive + $amount;

      if (@$blanch_out->amount_receive == TRUE || @$blanch_out->amount_receive == '0') {

        $this->update_outstand_deposit_system($blanch_id, $trans_id, $new_receve);
        echo "UPDATE";
      } else {

        $this->insert_outstand_deposit_system($comp_id, $blanch_id, $trans_id, $new_receve);
        echo "insert";
      }

      // echo "<pre>";
      // print_r($new_receve);
      //     exit();

      if ($this->queries->insert_deposit_out($data)) {
        $this->session->set_flashdata("massage", 'Deposit Successfully');
      } else {
        $this->session->set_flashdata("error", 'Failed');
      }
      return redirect("oficer/out_ofsyastem");
    }
    $this->out_ofsyastem();
  }


  public function insert_outstand_deposit_system($comp_id, $blanch_id, $trans_id, $new_receve)
  {
    $this->db->query("INSERT INTO  tbl_receive_outsystem (`comp_id`,`blanch_id`,`trans_id`,`amount_receive`) VALUES ('$comp_id', '$blanch_id','$trans_id','$new_receve')");
  }

  public function update_outstand_deposit_system($blanch_id, $trans_id, $new_receve)
  {
    $sqldata = "UPDATE `tbl_receive_outsystem` SET `amount_receive`= '$new_receve' WHERE `blanch_id`= '$blanch_id' AND `trans_id`='$trans_id'";
    $query = $this->db->query($sqldata);
    return true;
  }

  public function delete_outstand_system($id)
  {
    $this->load->model('queries');
    $data_out = $this->queries->get_out_system($id);
    $amount = $data_out->amount;
    $trans_id = $data_out->trans_id;
    $blanch_id = $data_out->blanch_id;

    $out_system_data = $this->queries->get_receive_outsystem($blanch_id, $trans_id);
    $amount_receive = $out_system_data->amount_receive;

    $new_receve = $amount_receive - $amount;

    $this->update_outstand_deposit_system($blanch_id, $trans_id, $new_receve);
    // print_r($amount_receive);
    //         exit();
    if ($this->remove_out_system($id))
      ;
    $this->session->set_flashdata("massage", 'Data Deleted successfully');
    return redirect("oficer/out_ofsyastem");
  }

  public function remove_out_system($id)
  {
    return $this->db->delete('tbl_depost_out', ['id' => $id]);
  }


  public function default_balance()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $total_insystem = $this->queries->get_receive_outstand_data($blanch_id);
    $total_outsystem = $this->queries->get_receive_out_system_data($blanch_id);
    $acount = $this->queries->get_customer_account_verfied($blanch_id);

    $miamala_out = $this->queries->get_total_transaction_default_general($blanch_id);
    $out_transaction = $this->queries->get_total_transaction_default($blanch_id);
    //     echo "<pre>";
    // print_r($out_transaction);
    //     exit();

    $this->load->view('oficer/default_balance', ['empl_data' => $empl_data, 'total_insystem' => $total_insystem, 'total_outsystem' => $total_outsystem, 'acount' => $acount, 'miamala_out' => $miamala_out, 'out_transaction' => $out_transaction]);
  }

  public function create_transaction_default()
  {
    $this->load->model('queries');
    $this->form_validation->set_rules('comp_id', 'company', 'required');
    $this->form_validation->set_rules('trans_type', 'type', 'required');
    $this->form_validation->set_rules('blanch_id', 'blanch', 'required');
    $this->form_validation->set_rules('empl_id', 'Employee', 'required');
    $this->form_validation->set_rules('from_trans_id', 'Account', 'required');
    $this->form_validation->set_rules('to_trans_id', 'Account', 'required');
    $this->form_validation->set_rules('amount_trans', 'Amount', 'required');
    $this->form_validation->set_rules('trans_fee', 'Fee', 'required');
    $this->form_validation->set_rules('date', 'Date', 'required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

    if ($this->form_validation->run()) {
      $data = $this->input->post();

      $comp_id = $data['comp_id'];
      $blanch_id = $data['blanch_id'];
      $empl_id = $data['empl_id'];
      $from_account = $data['from_trans_id'];
      $to_account = $data['to_trans_id'];
      $amount = $data['amount_trans'];
      $fee = $data['trans_fee'];
      $type = $data['trans_type'];

      $account = $to_account;
      //$saving = $amount;
      $remove_def = $amount + $fee;


      //from outsystem
      $outsystem = $this->queries->get_outin_system_acount($blanch_id, $from_account);
      $receve_outsystem = $outsystem->amount_receive;
      $out_system_balance = $receve_outsystem - $remove_def;

      //from insystem
      $insystem = $this->queries->get_insystem_balance($blanch_id, $from_account);
      $receve_insystem = $insystem->out_balance;
      $insystem_balance = $receve_insystem - $remove_def;

      // print_r($insystem_balance);
      //          exit();

      //to blanch_account
      $blanch_balance = $this->queries->get_blanch_account_balance($blanch_id, $account);
      $blanch_capital = $blanch_balance->blanch_capital;
      $new_balance = $blanch_capital + $amount;
      $saving = $new_balance;



      if ($type == 'outsystem') {
        if ($receve_outsystem < $remove_def) {
          $this->session->set_flashdata("error", 'You Don`t Have Enough Balance');
          return redirect('oficer/default_balance');
        } else {
          $this->update_out_system_balance($blanch_id, $from_account, $out_system_balance);
          $this->update_blanch_capitaldata($blanch_id, $account, $saving);
          $this->queries->insert_default_transaction($data);
          $this->session->set_flashdata("massage", 'Transaction successfully');
          //echo "nje ya madeni system";
        }
      } elseif ($type == 'insystem') {
        if ($receve_insystem < $remove_def) {
          $this->session->set_flashdata("error", 'You Don`t Have Enough Balance');
          return redirect('oficer/default_balance');
        } else {
          $this->update_insystem_balance($blanch_id, $from_account, $insystem_balance);
          $this->update_blanch_capitaldata($blanch_id, $account, $saving);
          $this->queries->insert_default_transaction($data);
          $this->session->set_flashdata("massage", 'Transaction successfully');
          //echo "ndani ya madeni system";
        }
      }
      return redirect("oficer/default_balance");
    }
    $this->default_balance();
  }

  public function update_out_system_balance($blanch_id, $from_account, $out_system_balance)
  {
    $sqldata = "UPDATE `tbl_receive_outsystem` SET `amount_receive`= '$out_system_balance' WHERE `blanch_id`= '$blanch_id' AND `trans_id`='$from_account'";
    $query = $this->db->query($sqldata);
    return true;
  }

  public function update_insystem_balance($blanch_id, $from_account, $insystem_balance)
  {
    $sqldata = "UPDATE `tbl_receve_outstand` SET `out_balance`= '$insystem_balance' WHERE `blanch_id`= '$blanch_id' AND `trans_id`='$from_account'";
    $query = $this->db->query($sqldata);
    return true;
  }


  public function delete_transaction_mistak($id)
  {
    $this->load->model('queries');
    $mistak_data = $this->queries->get_out_delete_transDefault($id);

    $comp_id = $mistak_data->comp_id;
    $blanch_id = $mistak_data->blanch_id;
    $empl_id = $mistak_data->empl_id;
    $from_account = $mistak_data->from_trans_id;
    $to_account = $mistak_data->to_trans_id;
    $amount = $mistak_data->amount_trans;
    $fee = $mistak_data->trans_fee;
    $type = $mistak_data->trans_type;

    // print_r($amount);
    //          exit();
    $account = $to_account;
    //$saving = $amount;
    $remove_def = $amount + $fee;


    //from outsystem
    $outsystem = $this->queries->get_outin_system_acount($blanch_id, $from_account);
    $receve_outsystem = $outsystem->amount_receive;
    $out_system_balance = $receve_outsystem + $remove_def;

    //from insystem
    $insystem = $this->queries->get_insystem_balance($blanch_id, $from_account);
    $receve_insystem = $insystem->out_balance;
    $insystem_balance = $receve_insystem + $remove_def;



    //to blanch_account
    $blanch_balance = $this->queries->get_blanch_account_balance($blanch_id, $account);
    $blanch_capital = $blanch_balance->blanch_capital;
    $new_balance = $blanch_capital - $amount;
    $saving = $new_balance;



    if ($type == 'outsystem') {
      $this->update_out_system_balance($blanch_id, $from_account, $out_system_balance);
      $this->update_blanch_capitaldata($blanch_id, $account, $saving);
      $this->remove_transaction_mistak_default($id);
      $this->session->set_flashdata("massage", 'Transaction Deleted successfully');
      //echo "nje ya madeni system";

    } elseif ($type == 'insystem') {

      $this->update_insystem_balance($blanch_id, $from_account, $insystem_balance);
      $this->update_blanch_capitaldata($blanch_id, $account, $saving);
      $this->remove_transaction_mistak_default($id);
      $this->session->set_flashdata("massage", 'Transaction Deleted successfully');
      //echo "ndani ya madeni system";
    }
    // echo "<pre>";
    // print_r($type);
    //       exit();
    return redirect('oficer/default_balance');
  }


  public function remove_transaction_mistak_default($id)
  {
    return $this->db->delete('tbl_trans_out', ['id' => $id]);
  }


  public function loan_pending_time()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $loan_pending_new = $this->queries->get_total_loan_pending($blanch_id);
    $new_total_pending = $this->queries->get_total_pend_loan($blanch_id);

    $loan_pend = $this->queries->get_pending_reportLoanblanch($blanch_id);
    $pend = $this->queries->get_sun_loanPendingBlanch($blanch_id);
    //      echo "<pre>";
    // print_r($pend);
    //       exit();

    $this->load->view('oficer/loan_pending_time', ['empl_data' => $empl_data, 'loan_pending_new' => $loan_pending_new, 'new_total_pending' => $new_total_pending, 'loan_pend' => $loan_pend, 'pend' => $pend]);
  }


  public function get_today_receivable()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $today_recevable = $this->queries->get_today_recevable_loanBlanch($blanch_id);
    $rejesho = $this->queries->get_total_recevableBlanch($blanch_id);
    //    echo "<pre>";
    // print_r($rejesho);
    //          exit();
    $this->load->view('oficer/today_receivable', ['empl_data' => $empl_data, 'today_recevable' => $today_recevable, 'rejesho' => $rejesho]);
  }


  public function today_received()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $received = $this->queries->get_today_received_loanBlanch($blanch_id);
    $total_receved = $this->queries->get_sum_today_recevedBlanch($blanch_id);
    //    echo "<pre>";
    // print_r($received);
    //    exit();

    $this->load->view('oficer/today_received', ['empl_data' => $empl_data, 'received' => $received, 'total_receved' => $total_receved]);
  }

  public function loan_collection()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $loan_collection = $this->queries->get_loan_collectionBlanch($blanch_id);

    $loan_total = $this->queries->get_total_loanBlanch($blanch_id);
    $depost_loan = $this->queries->get_totalPaid_loanBlanch($blanch_id);
    $penart = $this->queries->get_total_penartBlanch($blanch_id);
    $penart_paid = $this->queries->get_paid_penartBlanch($blanch_id);
    //   echo "<pre>";
    // print_r($loan_collection);
    //     exit();

    $this->load->view('oficer/loan_collection', ['empl_data' => $empl_data, 'loan_collection' => $loan_collection, 'loan_total' => $loan_total, 'depost_loan' => $depost_loan, 'penart' => $penart, 'penart_paid' => $penart_paid]);
  }



  public function loan_repayment()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $repayment = $this->queries->get_loan_repayment_blanch($blanch_id);
    // echo "<pre>";
    // print_r($repayment);
    //        exit();

    $this->load->view('oficer/loan_repayment', ['empl_data' => $empl_data, 'repayment' => $repayment]);
  }


  public function customer_account_statement()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);
    $customer = $this->queries->get_allcutomerblanchData($blanch_id);
    $customery = $this->queries->get_allcutomerblanchData($blanch_id);

    $this->load->view('oficer/customer_account', ['empl_data' => $empl_data, 'customer' => $customer]);
  }

  function fetch_data_loanActive()
  {
    $this->load->model('queries');
    if ($this->input->post('customer_id')) {
      echo $this->queries->fetch_loan_list($this->input->post('customer_id'));
    }
  }

  public function customer_report()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);
    $customer_id = $this->input->post('customer_id');
    $loan_id = $this->input->post('loan_id');

    $customer = $this->queries->search_CustomerLoan($customer_id);
    // print_r($loan_id);
    // exit();
    $customery = $this->queries->get_allcutomerblanchData($blanch_id);
    $this->load->view('oficer/customer_account_report', ['empl_data' => $empl_data, 'customery' => $customery, 'customer' => $customer, 'loan_id' => $loan_id, 'customer_id' => $customer_id]);
  }


  public function print_account_statement($customer_id, $loan_id)
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);
    $compdata = $this->queries->get_companyData($comp_id);
    $customer_data = $this->queries->get_loan_schedule_customer($loan_id);

    $mpdf = new \Mpdf\Mpdf();
    $html = $this->load->view('oficer/customer_account_statement', ['compdata' => $compdata, 'customer_data' => $customer_data, 'loan_id' => $loan_id, 'customer_id' => $customer_id], true);
    $mpdf->SetFooter('Generated By Brainsoft');
    $mpdf->WriteHTML($html);
    $mpdf->Output();

  }


  public function filter_customer_statement()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $from = $this->input->post('from');
    $to = $this->input->post('to');
    $customer_id = $this->input->post('customer_id');

    $data_account = $this->queries->get_account_statement($customer_id, $from, $to);
    $customer = $this->queries->search_CustomerLoan($customer_id);
    $customery = $this->queries->get_allcutomerblanchData($blanch_id);

    // print_r($data_account);
    //     exit();

    $this->load->view('oficer/customer_statement', ['empl_data' => $empl_data, 'customer' => $customer, 'data_account' => $data_account, 'customery' => $customery]);
  }




  public function blanchwise_loan()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    $blanch_wise = $this->queries->get_sumblanch_wise_blanch($blanch_id);

    // print_r($blanc_wise);
    //       exit();

    $this->load->view('oficer/blanch_wise', ['empl_data' => $empl_data, 'blanch_wise' => $blanch_wise]);
  }

  function fetch_active_loan()
  {
    $this->load->model('queries');
    if ($this->input->post('customer_id')) {
      echo $this->queries->fetch_loan_active($this->input->post('customer_id'));
    }
  }



  public function deposit_loan_saving()
  {
    $this->form_validation->set_rules('customer_id', 'Customer', 'required');
    $this->form_validation->set_rules('comp_id', 'Company', 'required');
    $this->form_validation->set_rules('blanch_id', 'blanch', 'required');
    $this->form_validation->set_rules('loan_id', 'Loan', 'required');
    $this->form_validation->set_rules('depost', 'depost', 'required');
    $this->form_validation->set_rules('p_method', 'Method', 'required');
    $this->form_validation->set_rules('description', 'description', 'required');
    $this->form_validation->set_rules('deposit_date', 'deposit date', 'required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
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
      $depost = $depost['depost'];
      $description = 'LOAN RETURN';
      $new_depost = $depost;
      $deposit_date = $deposit_date;
      $payment_method = $p_method;
      $kumaliza = $depost;
      $trans_id = $p_method;
      $new_balance = $depost;

      $today = date("Y-m-d");

      $this->load->model('queries');
      $blanch_id = $this->session->userdata('blanch_id');
      $empl_id = $this->session->userdata('empl_id');
      $manager_data = $this->queries->get_manager_data($empl_id);
      $comp_id = $manager_data->comp_id;
      $company_data = $this->queries->get_companyData($comp_id);
      $blanch_data = $this->queries->get_blanchData($blanch_id);
      $empl_data = $this->queries->get_employee_data($empl_id);
      $company_data = $this->queries->get_companyData($comp_id);
      $loan_restoration = $this->queries->get_restoration_loan($loan_id);
      $empl_id = $loan_restoration->empl_id;
      $date_show = $loan_restoration->date_show;
      $company = $this->queries->get_comp_data($comp_id);


      //sms count function
      // @$smscount = $this->queries->get_smsCountDate($comp_id);
      // $sms_number = @$smscount->sms_number;
      // $sms_id = @$smscount->sms_id;

      $comp_name = $company->comp_name;
      $comp_phone = $company->comp_phone;

      $restoration = $loan_restoration->restration;
      $group_id = $loan_restoration->group_id;
      $loan_codeID = $loan_restoration->loan_code;



      $data_depost = $this->queries->get_customer_Loandata($customer_id);
      $customer_data = $this->queries->get_customerData($customer_id);
      $phones = $customer_data->phone_no;
      $admin_data = $this->queries->get_admin_role($comp_id);
      $remain_balance = $data_depost->balance;
      $old_balance = $remain_balance;
      $sum_balance = $old_balance + $new_depost;

      @$blanch_account = $this->queries->get_amount_remainAmountBlanch($blanch_id, $payment_method);
      $blanch_capital = @$blanch_account->blanch_capital;
      $depost_money = $blanch_capital + $new_depost;

      //admin role
      $role = $empl_data->username;


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
      $day_int = $int / $ses_day;
      $day_princ = $int - $day_int;

      //insert principal balance 
      $trans_id = $payment_method;
      $princ_status = $loan_status;
      $principal_balance = $day_princ;
      $interest_balance = $day_int;

      //principal
      // $principal_blanch = $this->queries->get_blanch_capitalPrincipal($comp_id,$blanch_id,$trans_id,$princ_status);
      // $old_principal_balance = @$principal_blanch->principal_balance;
      // $principal_insert = $old_principal_balance + $principal_balance;

      //interest
      // $interest_blanch = $this->queries->get_blanch_interest_capital($comp_id,$blanch_id,$trans_id,$princ_status);
      // $interest_blanch_balance = @$interest_blanch->capital_interest;
      // $interest_insert = $interest_blanch_balance + $day_int;


      $total_depost = $this->queries->get_sum_dapost($loan_id);
      $loan_dep = $total_depost->remain_balance_loan;
      $kumaliza_depost = $loan_dep + $kumaliza;

      $loan_int = $loan_restoration->loan_int;
      $remain_loan = $loan_int - $total_depost->remain_balance_loan;

      $sun_blanch_capital = $this->queries->get_remain_blanch_capital($blanch_id, $trans_id);
      $total_blanch_amount = $sun_blanch_capital->blanch_capital;
      $deposit_new = $total_blanch_amount + $depost;

      if ($kumaliza_depost < $loan_int) {
        //print_r($kumaliza_depost);
        // echo "bado sana";
      } elseif ($kumaliza_depost > $loan_int) {
        //echo "hapana";
      } elseif ($kumaliza_depost = $loan_int) {
        $this->update_loastatus_done($loan_id);
        $this->insert_loan_kumaliza($comp_id, $blanch_id, $customer_id, $loan_id, $kumaliza, $group_id);
        $this->update_customer_statusclose($customer_id);
        //echo "tunamaliza kazi";
      }


      @$check_deposit = $this->queries->get_today_deposit_record($loan_id, $deposit_date);
      $depost_check = @$check_deposit->depost;
      $dep_id = @$check_deposit->dep_id;
      $again_deposit = $depost_check + $depost;

      @$check_prev = $this->queries->get_prev_record_report($loan_id, $deposit_date);
      $prev_deposit = @$check_prev->depost;
      $dep_id = @$check_prev->pay_id;
      $again_prev = $prev_deposit + $depost;

      //outstand deposit

      @$out_deposit = $this->queries->get_outstand_deposit($blanch_id, $trans_id);
      $out_balance = @$out_deposit->out_balance;

      $new_out_balance = $out_balance + $depost;
      // print_r($new_out_balance);
      //          exit();
      $pay_id = $dep_id;

      if ($out_data == TRUE) {
        if ($depost > $out_data->remain_amount) {
          $this->session->set_flashdata("error", 'Your Depost Amount is Greater');
        } else {
          $remain_amount = $out_data->remain_amount;
          $paid_amount = $out_data->paid_amount;
          $customer_id = $out_data->customer_id;
          if ($new_balance >= $remain_amount) {
            $depost_amount = $remain_amount - $new_balance;
            $paid_out = $paid_amount + $new_balance;

            // print_r($depost_amount);
            //       exit();
            //insert depost balance

            if ($check_deposit == TRUE) {
              $this->update_deposit_record($loan_id, $deposit_date, $again_deposit, $p_method, $day_id);
            } else {
              $dep_id = $this->insert_loan_lecorDeposit($comp_id, $customer_id, $loan_id, $blanch_id, $new_depost, $p_method, $role, $day_int, $day_princ, $loan_status, $group_id, $deposit_date, $empl_id);
            }

            if (@$out_deposit->out_balance == TRUE || @$out_deposit->out_balance == '0') {
              $this->update_blanch_amount_outstand($comp_id, $blanch_id, $new_out_balance, $trans_id);
            } else {
              $this->insert_blanch_amount_outstand_deposit($comp_id, $blanch_id, $new_out_balance, $trans_id);
            }
            $this->update_loan_dep_status($loan_id);
            $new_balance = $new_depost;

            if ($dep_id > 0) {
              $this->session->set_flashdata('massage', 'Deposit has made Sucessfully');
            } else {
              $this->session->set_flashdata('massage', 'Failed');
            }
            $this->update_outstand_status($loan_id);
            if ($check_prev == TRUE) {
              $dep_id = $dep_id;
              $empl_id = $empl_id;
              $this->update_deposit_record_prev($loan_id, $deposit_date, $again_prev, $dep_id, $p_method);
            } else {
              $dep_id = $dep_id;
              $empl_id = $empl_id;
              $this->insert_loan_lecordDataDeposit($comp_id, $customer_id, $loan_id, $blanch_id, $new_depost, $dep_id, $group_id, $trans_id, $restoration, $loan_aproved, $deposit_date, $empl_id);
            }
            $this->insert_remainloan($loan_id, $depost_amount, $paid_out, $pay_id);
            $this->update_loastatus($loan_id);
            $this->depost_balance($loan_id, $comp_id, $blanch_id, $customer_id, $new_depost, $sum_balance, $description, $role, $group_id, $p_method, $deposit_date, $dep_id);
            //$this->depost_Blanch_accountBalance($comp_id,$blanch_id,$payment_method,$depost_money);
            //$this->insert_blanch_amount_deposit($blanch_id,$deposit_new,$trans_id);
            //    if(@$principal_blanch == TRUE){
            // $this->update_principal_capital_balanc($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
            // }elseif(@$principal_blanch == FALSE){
            // $this->insert_blanch_principal($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
            // }
            //interest
            //   if (@$interest_blanch == TRUE) {
            //   $this->update_interest_blanchBalance($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);    
            //   }elseif(@$interest_blanch == FALSE){
            //   $this->insert_interest_blanch_capital($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);
            // }
            $this->insert_customer_report($loan_id, $comp_id, $blanch_id, $customer_id, $group_id, $new_depost, $pay_id, $deposit_date);
            //$this->insert_prepaid_balance($loan_id,$comp_id,$blanch_id,$customer_id,$prepaid);
            $this->update_customer_statusLoan($customer_id);
            $total_depost = $this->queries->get_sum_dapost($loan_id);
            $loan_int = $loan_restoration->loan_int;
            $remain_loan = $loan_int - $total_depost->remain_balance_loan;
            //sms send
            $sms = 'Umeingiza Tsh.' . $new_balance . ' kwenye Acc Yako ' . $loan_codeID . $comp_name . ' Mpokeaji ' . $role . ' Kiasi kilicho baki Kulipwa ni Tsh.' . $remain_loan . ' Kwa malalamiko piga ' . $comp_phone;
            $massage = $sms;
            $phone = $phones;

            $loan_ID = $loan_id;
            @$out_check = $this->queries->get_outstand_total($loan_id);
            $amount_remain = @$out_check->remain_amount;
            // print_r($new_balance);
            //       exit();
            if ($amount_remain > $new_balance) {
              $this->insert_outstand_balance($comp_id, $blanch_id, $customer_id, $loan_id, $new_balance, $group_id, $dep_id);
            } elseif ($amount_remain = $new_balance) {
              $this->insert_outstand_balance($comp_id, $blanch_id, $customer_id, $loan_id, $new_balance, $group_id, $dep_id);
            }

            //$phone = '255'.substr($phones, 1,10);
            // print_r($sms);
            //   echo "<br>";
            // print_r($phone);
            //      exit();
            if ($company_data->sms_status == 'YES') {
              $this->sendsms($phone, $massage);
              //echo "kitu kipo";
            } elseif ($company_data->sms_status == 'NO') {
              //echo "Hakuna kitu hapa";
            }


          } else {
            $depost_amount = $remain_amount - $new_balance;
            $paid_out = $paid_amount + $new_balance;

            //insert depost balance
            if ($check_deposit == TRUE) {
              $this->update_deposit_record($loan_id, $deposit_date, $again_deposit, $p_method, $day_id);
            } else {
              $dep_id = $this->insert_loan_lecorDeposit($comp_id, $customer_id, $loan_id, $blanch_id, $new_depost, $p_method, $role, $day_int, $day_princ, $loan_status, $group_id, $deposit_date, $empl_id);
            }

            if (@$out_deposit->out_balance == TRUE || @$out_deposit->out_balance == '0') {
              $this->update_blanch_amount_outstand($comp_id, $blanch_id, $new_out_balance, $trans_id);
            } else {
              $this->insert_blanch_amount_outstand_deposit($comp_id, $blanch_id, $new_out_balance, $trans_id);
            }
            $this->update_loan_dep_status($loan_id);
            $new_balance = $new_depost;
            if ($dep_id > 0) {
              $this->session->set_flashdata('massage', 'Deposit has made Sucessfully');
            } else {
              $this->session->set_flashdata('massage', 'Failed');
            }
            if ($check_prev == TRUE) {
              $dep_id = $dep_id;
              $empl_id = $empl_id;
              $this->update_deposit_record_prev($loan_id, $deposit_date, $again_prev, $dep_id, $p_method);
            } else {
              $dep_id = $dep_id;
              $empl_id = $empl_id;
              $this->insert_loan_lecordDataDeposit($comp_id, $customer_id, $loan_id, $blanch_id, $new_depost, $dep_id, $group_id, $trans_id, $restoration, $loan_aproved, $deposit_date, $empl_id);
            }
            $this->insert_remainloan($loan_id, $depost_amount, $paid_out, $pay_id);

            $this->depost_balance($loan_id, $comp_id, $blanch_id, $customer_id, $new_depost, $sum_balance, $description, $role, $group_id, $p_method, $deposit_date, $dep_id);
            //$this->insert_blanch_amount_deposit($blanch_id,$deposit_new,$trans_id);
            //    if (@$principal_blanch == TRUE) {
            // $this->update_principal_capital_balanc($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
            // }elseif(@$principal_blanch == FALSE){
            // $this->insert_blanch_principal($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
            // }
            //inrterest
            // if (@$interest_blanch == TRUE) {
            // $this->update_interest_blanchBalance($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);    
            // }elseif(@$interest_blanch == FALSE){
            // $this->insert_interest_blanch_capital($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);
            // }
            $this->insert_customer_report($loan_id, $comp_id, $blanch_id, $customer_id, $group_id, $new_depost, $pay_id, $deposit_date);
            //$this->insert_prepaid_balance($loan_id,$comp_id,$blanch_id,$customer_id,$prepaid);
            $total_depost = $this->queries->get_sum_dapost($loan_id);
            $loan_int = $loan_restoration->loan_int;
            $remain_loan = $loan_int - $total_depost->remain_balance_loan;
            //sms send
            $sms = 'Umeingiza Tsh.' . $new_balance . ' kwenye Acc Yako ' . $loan_codeID . $comp_name . ' Mpokeaji ' . $role . ' Kiasi kilicho baki Kulipwa ni Tsh.' . $remain_loan . ' Kwa malalamiko piga ' . $comp_phone;
            $massage = $sms;
            $phone = $phones;


            $loan_ID = $loan_id;
            @$out_check = $this->queries->get_outstand_total($loan_id);
            $amount_remain = @$out_check->remain_amount;

            if ($amount_remain > $new_balance) {

              $this->insert_outstand_balance($comp_id, $blanch_id, $customer_id, $loan_id, $new_balance, $group_id, $dep_id);
              // print_r($comp_id);
              //         exit();
            } elseif ($amount_remain = $new_balance) {
              $this->insert_outstand_balance($comp_id, $blanch_id, $customer_id, $loan_id, $new_balance, $group_id, $dep_id);
            }
            //$phone = '255'.substr($phones, 1,10);
            // print_r($sms);
            //   echo "<br>";
            // print_r($phone);
            //      exit();
            if ($company_data->sms_status == 'YES') {
              $this->sendsms($phone, $massage);
              //echo "kitu kipo";
            } elseif ($company_data->sms_status == 'NO') {
              //echo "Hakuna kitu hapa";
            }
          }
        }


        //ndani ya mkataba
      } elseif ($out_data == FALSE) {
        if ($kumaliza_depost > $loan_int) {
          $this->session->set_flashdata("error", 'Your Depost Amount is Greater');
        } else {
          //insert depost balance

          if ($check_deposit == TRUE) {
            $this->update_deposit_record($loan_id, $deposit_date, $again_deposit, $p_method, $day_id);
          } else {
            $dep_id = $this->insert_loan_lecorDeposit($comp_id, $customer_id, $loan_id, $blanch_id, $new_depost, $p_method, $role, $day_int, $day_princ, $loan_status, $group_id, $deposit_date, $empl_id);
          }
          $this->insert_blanch_amount_deposit($blanch_id, $deposit_new, $trans_id);
          $this->update_loan_dep_status($loan_id);
          //exit();

          $new_balance = $new_depost;
          if ($dep_id > 0) {
            $this->session->set_flashdata('massage', 'Deposit has made Sucessfully');
          } else {
            $this->session->set_flashdata('massage', 'Deposit has made Sucessfully');
          }

          if ($check_prev == TRUE) {
            $dep_id = $dep_id;
            $empl_id = $empl_id;
            $this->update_deposit_record_prev($loan_id, $deposit_date, $again_prev, $dep_id, $p_method);
          } else {
            $dep_id = $dep_id;
            $empl_id = $empl_id;
            $this->insert_loan_lecordDataDeposit($comp_id, $customer_id, $loan_id, $blanch_id, $new_depost, $dep_id, $group_id, $trans_id, $restoration, $loan_aproved, $deposit_date, $empl_id);
          }
          $this->depost_balance($loan_id, $comp_id, $blanch_id, $customer_id, $new_depost, $sum_balance, $description, $role, $group_id, $p_method, $deposit_date, $dep_id);

          //$this->depost_Blanch_accountBalance($comp_id,$blanch_id,$payment_method,$depost_money);
          //principal
          // if (@$principal_blanch == TRUE) {
          // $this->update_principal_capital_balanc($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
          // }elseif(@$principal_blanch == FALSE){
          // $this->insert_blanch_principal($comp_id,$blanch_id,$trans_id,$princ_status,$principal_insert);
          // }
          //inrterest
          //   if (@$interest_blanch == TRUE) {
          //   $this->update_interest_blanchBalance($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);    
          //   }elseif(@$interest_blanch == FALSE){
          //   $this->insert_interest_blanch_capital($comp_id,$blanch_id,$trans_id,$princ_status,$interest_insert);
          // }


          //updating recovery loan
          $loan_ID = $loan_id;
          @$data_pend = $this->queries->get_total_pending_loan($loan_ID);
          $total_pend = @$data_pend->total_pend;

          if (@$data_pend->total_pend == TRUE) {
            if ($depost > $total_pend) {
              $deni_lipa = $depost - $total_pend;
              //$recovery = $deni_lipa - $total_pend; 
              $this->update_loan_pending_remain($loan_id);
              $this->insert_description_report($comp_id, $blanch_id, $customer_id, $loan_id, $total_pend, $deni_lipa, $group_id, $dep_id);
            } elseif ($depost < $total_pend) {
              $deni_lipa = $total_pend - $depost;
              $this->update_loan_pending_balance($loan_id, $deni_lipa);
              $this->insert_returnDescriptionData_report($comp_id, $blanch_id, $customer_id, $loan_id, $depost, $group_id, $dep_id);
            } elseif ($depost = $total_pend) {
              $this->update_loan_pending_remain($loan_id);
              $this->insert_returnDescriptionData_report($comp_id, $blanch_id, $customer_id, $loan_id, $depost, $group_id, $dep_id);
            }
          } elseif ($data_pend->total_pend == FALSE) {
            if ($date_show >= $today) {
              if ($depost < $restoration) {
                $prepaid = 0;
              } else {
                $prepaid = $depost - $restoration;
              }
              $this->insert_prepaid_balance($loan_id, $comp_id, $blanch_id, $customer_id, $prepaid, $dep_id);
            } else {

            }

          }

          $total_depost = $this->queries->get_sum_dapost($loan_id);
          $loan_int = $loan_restoration->loan_int;
          $remain_loan = $loan_int - $total_depost->remain_balance_loan;
          //sms send
          $sms = 'Umeingiza Tsh.' . $new_balance . ' kwenye Acc Yako ' . $loan_codeID . $comp_name . ' Mpokeaji ' . $role . ' Kiasi kilicho baki Kulipwa ni Tsh.' . $remain_loan . ' Kwa malalamiko piga ' . $comp_phone;
          $massage = $sms;
          $phone = $phones;

          if ($company_data->sms_status == 'YES') {
            $this->sendsms($phone, $massage);
            //echo "kitu kipo";
          } elseif ($company_data->sms_status == 'NO') {
            //echo "Hakuna kitu hapa";
          }
        }
      }


      return redirect('oficer/data_with_depost/' . $customer_id);

    }

    $this->data_with_depost();

  }



  public function float_transaction()
  {
    $this->load->model('queries');
    $blanch_id = $this->session->userdata('blanch_id');
    $empl_id = $this->session->userdata('empl_id');
    $manager_data = $this->queries->get_manager_data($empl_id);
    $comp_id = $manager_data->comp_id;
    $company_data = $this->queries->get_companyData($comp_id);
    $blanch_data = $this->queries->get_blanchData($blanch_id);
    $empl_data = $this->queries->get_employee_data($empl_id);

    //accont
    $acount = $this->queries->get_customer_account_verfied($blanch_id);
    // print_r($acount);
    //      exit();

    $this->load->view('oficer/float_transaction', ['acount' => $acount, 'empl_data' => $empl_data]);
  }


  public function transfor_money_blanch()
  {
    $this->load->model('queries');
    $this->form_validation->set_rules('comp_id', 'company', 'required');
    $this->form_validation->set_rules('from_blanch', 'blanch', 'required');
    $this->form_validation->set_rules('from_blanch_account', 'blanch_account', 'required');
    $this->form_validation->set_rules('from_amount', 'Amount', 'required');
    $this->form_validation->set_rules('to_branch', 'Amount', 'required');
    $this->form_validation->set_rules('to_branch_account', 'Amount', 'required');
    //$this->form_validation->set_rules('to_amount','Amount','required');
    $this->form_validation->set_rules('charger_fee', 'Fee', 'required');
    $this->form_validation->set_rules('date_trans', 'Date', 'required');
    $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

    if ($this->form_validation->run()) {
      $data = $this->input->post();
      // echo "<pre>";
      // print_r($data);
      //      exit();

      $comp_id = $data['comp_id'];
      $from_blanch = $data['from_blanch'];
      $from_blanch_account = $data['from_blanch_account'];
      $from_amount = $data['from_amount'];
      $to_branch = $data['to_branch'];
      $to_branch_account = $data['to_branch_account'];
      $charger_fee = $data['charger_fee'];
      $date_trans = $data['date_trans'];

      //from account
      $from_account_blance = $this->queries->get_blanch_account_balance_amount($from_blanch, $from_blanch_account);

      $from_blanch_ = $from_account_blance->blanch_id;
      $from_account_ = $from_account_blance->receive_trans_id;
      $from_balance_ = $from_account_blance->blanch_capital;
      $remove_balance = $from_balance_ - ($from_amount + $charger_fee);

      $total_makato = ($from_amount + $charger_fee);


      //to account
      $to_account_balance = $this->queries->get_blanch_account_balance_to_amount($to_branch, $to_branch_account);
      $to_blanch_ = $to_account_balance->blanch_id;
      $to_account_ = $to_account_balance->receive_trans_id;
      $to_balance = $to_account_balance->blanch_capital;
      $receive_balance = $to_balance + $from_amount;

      // print_r($from_balance_);
      //     echo "<br>";
      //     print_r($total_makato);
      //    exit();

      if ($from_balance_ < $total_makato) {
        //echo "hapana ndogo";
        $this->session->set_flashdata("error", 'Account balance Is Not Enough');
      } else {
        //  echo "hapo sawa";
        // exit();
        $this->insert_record_trans_data($comp_id, $from_blanch, $from_blanch_account, $from_amount, $to_branch, $to_branch_account, $charger_fee, $date_trans);
        $this->update_from_account($from_blanch, $from_blanch_account, $remove_balance);
        $this->update_to_account($to_branch, $to_branch_account, $receive_balance);
        $this->session->set_flashdata("massage", 'Transaction successfully');
        return redirect("oficer/float_transaction");
        // print_r($receive_balance);
        //       exit(); 
      }
    }

    $this->float_transaction();
  }


  public function insert_record_trans_data($comp_id, $from_blanch, $from_blanch_account, $from_amount, $to_branch, $to_branch_account, $charger_fee, $date_trans)
  {
    $this->db->query("INSERT INTO tbl_float_branch (`comp_id`,`from_blanch`,`from_blanch_account`,`from_amount`,`to_branch`,`to_branch_account`,`charger_fee`,`date_trans`) VALUES ('$comp_id','$from_blanch','$from_blanch_account','$from_amount','$to_branch','$to_branch_account','$charger_fee','$date_trans')");
  }


  public function update_from_account($from_blanch, $from_blanch_account, $remove_balance)
  {
    $sqldata = "UPDATE `tbl_blanch_account` SET `blanch_capital`= '$remove_balance' WHERE  `blanch_id`='$from_blanch' AND `receive_trans_id` = '$from_blanch_account'";
    // print_r($sqldata);
    //  exit();
    $query = $this->db->query($sqldata);
    return true;
  }

  public function update_to_account($to_branch, $to_branch_account, $receive_balance)
  {
    $sqldata = "UPDATE `tbl_blanch_account` SET `blanch_capital`= '$receive_balance' WHERE  `blanch_id`='$to_branch' AND `receive_trans_id` = '$to_branch_account'";
    // print_r($sqldata);
    //  exit();
    $query = $this->db->query($sqldata);
    return true;
  }


  public function get_loan_code_resend($customer_id)
  {
    $this->load->model('queries');

    $loan_code = $this->queries->get_loanCustomerCode($customer_id);
    $code = $loan_code->code;
    $phones = $loan_code->phone_no;
    $comp_id = $loan_code->comp_id;

    $sms = 'Namba ya Siri Ya Mkopo Wako ni ' . $code;
    $massage = $sms;
    $phone = '0' . substr($phones, 3, 10);
    // print_r($massage);
    //      exit();

    $this->sendsms($phone, $massage);
    $this->session->set_flashdata('massage', 'Loan code sent please Wait');
    return redirect('oficer/data_with_depost/' . $customer_id);
  }







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

  public function sendsms($phone, $massage)
  {
    //$phone = '0753871034';
    //$sms = 'mapenzi yanauwa';
    $api_key = 'hzj3MH7QjV9cMSnjTTemjvXi5k';
    //$api_key = 'qFzd89PXu1e/DuwbwxOE5uUBn6';
    //$curl = curl_init();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://galadove.loan-pocket.com/api/v1/receive/action/send/sms");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt(
      $ch,
      CURLOPT_POSTFIELDS,
      'apiKey=' . $api_key . '&phoneNumber=' . $phone . '&messageContent=' . $massage
    );

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close($ch);
  }


  //session destroy
  public function __construct()
  {
    parent::__construct();
    $lang = ($this->session->userdata('lang')) ?
      $this->session->userdata('lang') : config_item('language');
    $this->lang->load('menu', $lang);
    if (!$this->session->userdata("empl_id"))
      return redirect("welcome/employee_login");
  }
}