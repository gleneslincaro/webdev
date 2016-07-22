<div id="container">



    <div class="list-box"><!-- list-box ここから -->

        <div class="list-title">■非表示</div>

        <br ><br ><br >



        <div class="message_box">
            <table class="message">
                <tr>

                    非表示にしました。<br>
                非表示を解除する場合は、履歴一覧　→　応募非表示一覧から戻すことが可能となっています。<br><br>
                </tr>
            </table>
        </div>

        <br><br>
        <?php
        if($flag==0)
        {
        ?>
        <center><a href="<?php echo base_url().'owner/index' ?>" title="前のページへ戻る">前のページへ戻る</a></center>
        <?php
        }
        else
        {
        ?>
        <center><a href="<?php echo base_url().'owner/history/history_app' ?>" title="前のページへ戻る">前のページへ戻る</a></center>
        <?php
        }
        ?>

    </div><!-- list-box ここまで -->



</div><!-- container ここまで -->