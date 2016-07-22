<?php

class Mcredit extends CommonQuery {
    function __construct() {
        parent::__construct();
    }

    /**
     * @author  VJソリューションズ
     * @name 	insertStatusRegisPayment
     * @todo 	クレジットカード決済でのポイント購入レコード登録
     * @param
     * @return 	-1　     失敗
     *			-1以外　	成功
     */
    public function insertStatusRegisPayment($owner_id, $money_payment, $point_payment, $money, $point, $payment_method_id, $payment_case_id, $user_list, $credit_hash, $payment_name="") {

		if ( !$owner_id || !$credit_hash || !$money_payment || !$point_payment ||
			 !$point || !$payment_method_id || !$payment_case_id){
			return -1;
		}
        $param = array(
            'owner_id' => $owner_id,
            'amount_payment' => $money_payment,
            'point_payment' => $point_payment,
            'amount' => $money,
            'point' => $point,
            'payment_method_id' => $payment_method_id,
            'payment_case_id' => $payment_case_id,
            'payment_status' => 0,
            'created_date' => $this->getCurrentDate(),
            'user_list' => $user_list,
            'credit_hash' => $credit_hash,
            'payment_name' => $payment_name
        );
        $this->db->insert('payments', $param);
        return $this->db->insert_id();
    }
}
