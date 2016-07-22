<div class="crumb">TOP ＞ 記事を見る</div>
<div style="clear: both; margin: 40px 0px -20px">  
    <a class="create_article" href="<?php echo base_url(); ?>owner/recruitment/" ><span>募集</span></a>  
</div>
<div class="list-box"><!-- list-box ここから -->
    <div class="list-title">記事を見る</div>    
    <div class="contents-box-wrapper">        
        <div class="article_container">                            
                <div class="article_types">                                       
                    <div id="occasional_wrapper">
                        <label>投稿日時: </label>
                        <span class="fbolder"><?php echo $data[0]['posted_date']; ?></span>                       
                    </div> 
                </div>                
                <textarea disabled style="height: 200px; width: 775px; margin-bottom: 20px; padding: 10px;"><?php echo $data[0]['message']; ?></textarea>                               
        </div>
    </div>
</div>
