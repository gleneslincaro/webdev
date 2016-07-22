<?php if ($data['visiting_benefits_title_1'] || $data['visiting_benefits_title_2'] || $data['visiting_benefits_title_3'] || $data['visiting_benefits_title_1'] || $data['visiting_benefits_title_2'] || $data['visiting_benefits_title_3']) : ?>
<div class="special_merit box_wrap">
	<h3 class="ttl">ジョイスペ入店特典</h3>
	<ul>
<!--	
		<li>
			<h4><span>特典1：</span>入店お祝い金10万円！</h4>
			<p>入店10日でお祝い金10万円プレゼント！</p>
		</li>
		<li>
			<h4><span>特典2：</span>日給3万円保証！</h4>
			<p>体験入店期間は日給3万円を保証！</p>
		</li>
		<li>
			<h4><span>特典3：</span>出稼ぎ向け寮 1,500円/日！</h4>
			<p>出稼ぎ向けの寮を1,500円/日でご提供いたします！</p>
		</li>
-->
        <?php if ($data['visiting_benefits_title_1']) : ?>
		<li>
            <h4><span>特典1：</span><?php echo $data['visiting_benefits_title_1']; ?></h4>
        <?php endif;?>
        <?php if ($data['visiting_benefits_content_1']) : ?>
            <p><?php echo $data['visiting_benefits_content_1']; ?></p>
		</li>
        <?php endif; ?>
        <?php if ($data['visiting_benefits_title_2']) : ?>
		<li>
            <h4><span>特典2：</span><?php echo $data['visiting_benefits_title_2']; ?></h4>
        <?php endif;?>
        <?php if ($data['visiting_benefits_content_2']) : ?>
            <p><?php echo $data['visiting_benefits_content_2']; ?></p>
		</li>
        <?php endif; ?>
        <?php if ($data['visiting_benefits_title_3']) : ?>
		<li>
            <h4><span>特典3：</span><?php echo $data['visiting_benefits_title_3']; ?></h4>
        <?php endif;?>
        <?php if ($data['visiting_benefits_content_3']) : ?>
            <p><?php echo $data['visiting_benefits_content_3']; ?></p>
		</li>
        <?php endif; ?>
	</ul>
</div>
<?php endif; ?>