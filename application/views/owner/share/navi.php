<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$snav = HelperApp::get_session('snav');
$free_owner = HelperApp::get_session('free_owner');
$urgent_recruitment = HelperApp::get_session('urgentRecruitment');
?>
<div id="navi">
    <table id="navi" name="navi" class="navi">
        <thead name="tr_navi" id="tr_navi">
        <tr>
            <th name="thm1" id="thm1">
                <a href="<?php echo base_url() . 'owner/index'; ?>">TOP</a>
            </th>
            <th name="th2" id="th2"><a id="m2" href="<?php echo base_url() . 'owner/scout/scout_after'; ?>">スカウト機能</a></th>
            <th name="th3" id="th3"><a id="m3" href="<?php echo base_url() . 'owner/history/history_scout'; ?>">スカウト履歴</a></th>
            <th name="th5" id="th5"><a id="m5" href="<?php echo base_url() . 'owner/company'; ?>">基本情報</a></th>
            <th name="th7" id="th7" class="inbox_menu"><a id="m7" href="<?php echo base_url() . 'owner/inbox'; ?>">受信ボックス<span class="newmsg_no" id="newmsg_no"></span></a></th>
            <th name="th8" id="th8"><a class="<?php echo ($snav != 0)  ? '' : 'no_hover'; ?>" id="m8" href="<?php echo ($snav != 0)  ? base_url() . 'owner/scout/auto_send' : 'javascript:void(0)'; ?>">
                自動送信</a>
            </th>
            <th name="th13" id="th13"><a id="m13" class="<?php echo ($free_owner == 0)  ? '' : 'no_hover'; ?>" href="<?php echo ($free_owner == 0) ? base_url() . 'owner/siterank/' : 'javascript:void(0)'; ?>">サイト上位表示</th>
            <th name="th11" id="th11"><a id="m11" href="<?php echo base_url() . 'owner/analysis/'; ?>">アクセス解析</th>
            <th name="th9" id="th9"><a id="th9" class="<?php echo !$urgent_recruitment ? 'no_hover' : ''; ?>" href="<?php echo $urgent_recruitment ? base_url() . 'owner/recruitment/' : 'javascript:void(0)'; ?>">急募情報</th>
            <th name="th10" id="th10"><a id="m10" href="<?php echo base_url() . 'owner/interviewer'; ?>">未経験者向け登録</a></th>
        </tr>
        </thead>
    </table>
</div>