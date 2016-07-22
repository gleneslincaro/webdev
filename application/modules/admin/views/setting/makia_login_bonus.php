<center>
    <div class="makia-login-bonus-list">
        <p>累計ログインポイント設定</p>
        <p>作成日 : <?php echo (isset($created_date))?date_format($created_date, "Y-m-d H:i:s"):''; ?></p>
        <table>
            <tbody>
                <tr>
                    <th class="condition-id">条件</th>
                    <th class="num-of-days">日数</th>
                    <th class="bonus-points">ボーナス</th>      
                </tr>
                <?php if ( count($makia_login_bonus) > 0 ): ?>
                    <?php for ( $i = 0; $i<10; $i++ ): ?>
                        <tr>
                            <td><?php echo (isset($makia_login_bonus[$i]['condition_no']))?$makia_login_bonus[$i]['condition_no']:$i+1; ?></td>
                            <td><?php echo (isset($makia_login_bonus[$i]['number_of_days']))?$makia_login_bonus[$i]['number_of_days']:0; ?></td>
                            <td><?php echo (isset($makia_login_bonus[$i]['bonus_point']))?$makia_login_bonus[$i]['bonus_point']:0; echo ' 円'; ?></td>
                        </tr>
                    <?php endfor; ?>      
                <?php else: ?>
                    <tr><td colspan=3>レコードが見つかりませんでした。</td></tr>
                <?php endif; ?>      
            </tbody>
        </table>
        <br />
        <form method="POST">
            <input id="create_new_bonus" name="create_new_bonus" type="submit" style="padding: 5px;"  value="新しいボーナスを作成" />
        </form>
    </div>
</center>
