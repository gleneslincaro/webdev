      <tr class="head">
      <?php foreach ($analysis_data_ar as $value): ?>
      <td style="background-color:#1DDCD5;"><?php echo $value['month'];?></td>
      <?php endforeach; ?>
      </tr>
      
      <tr>
      <?php foreach ($analysis_data_ar as $value): ?>
      <td><?php echo round(($value['scout_open_rate'] * 100),1);?>%<br><span><?php echo round(($value['open_rate_max'] * 100),1);?>%</span></td>
      <?php endforeach; ?>
      </tr>

      <tr>
      <?php foreach ($analysis_data_ar as $value): ?>
      <td><?php echo $value['shop_access_num'];?><br><span><?php echo $value['shop_access_max'];?></span></td>
      <?php endforeach; ?>
      </tr>

      <tr>
      <?php foreach ($analysis_data_ar as $value): ?>
      <td><?php echo $value['hp_click_num'];?><br><span><?php //echo $value['hp_click_max'];?></span></td>
      <?php endforeach; ?>
      </tr>

      <tr>
      <?php foreach ($analysis_data_ar as $value): ?>
      <td><?php echo $value['kuchikomi_click_num'];?><br><span><?php //echo $value['kuchikomi_click_max'];?></td>
      <?php endforeach; ?>
      </tr>

      <tr>
      <?php foreach ($analysis_data_ar as $value): ?>
      <td><?php echo $value['tel_click_num'];?><br><span><?php //echo $value['tel_click_max'];?></td>
      <?php endforeach; ?>
      </tr>

      <tr>
      <?php foreach ($analysis_data_ar as $value): ?>
      <td><?php echo $value['mail_click_num'];?><br><span><?php //echo $value['mail_click_max'];?></td>
      <?php endforeach; ?>
      </tr>

      <tr>
      <?php foreach ($analysis_data_ar as $value): ?>
      <td><?php echo $value['question_num'];?><br><span><?php //echo $value['question_max'];?></td>
      <?php endforeach; ?>
      </tr>

      <tr>
      <?php foreach ($analysis_data_ar as $value): ?>
      <td><?php echo $value['travel_num'];?><br><span><?php //echo $value['travel_max'];?></td>
      <?php endforeach; ?>
      </tr>

      <tr>
      <?php foreach ($analysis_data_ar as $value): ?>
      <td><?php echo $value['campaign_bonus_num'];?><br><span><?php //echo $value['campaign_bonus_max'];?></td>
      <?php endforeach; ?>
      </tr>