
<form method="post">
            <center>
                <p>joyspe管理画面</p>

                <p>
                    <table>
                        <tr>
                            <td>ログインID</td>
                            <td><input type="text" name="loginId" style="width:150px;" maxlength="10" value="<?php echo set_value("loginId") ?>"></td>
                        </tr>
                        <tr>
                            <td>パスワード</td>
                            <td><input type="password" name="password" style="width:150px;"></td>
                        </tr>
                    </table>                    
                </p>

                <button type="submit">　ログイン　</button>
            </center>
</form>