<div style="color:red;text-align:center;">
    <?php echo validation_errors();?>
    <?php echo $this->session->flashdata('success');?>    
</div>

<form method="post">
    <table width="100%" style="padding-top: 20px;" cellpadding="5">
        <tr>
            <th colspan="2">サクラ体験談</th>
        </tr>
        <tr>
            <td width="20%">都道府県</td>
            <td>
                <select name="city">
                <?php foreach ($cities as $key => $value) : ?>
                    <option value="<?php echo $value['id']; ?>" <?php echo (isset($exp_data['city_id']) && $exp_data['city_id'] == $value['id']) ? 'selected' : ''?>><?php echo $value['name']; ?></option>
                <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>年代</td>
            <td>
                <select name="age">
                <?php foreach ($agelist as $key => $value) : ?>
                    <option value="<?php echo $value['id']; ?>" <?php echo (isset($exp_data['age_id']) && $exp_data['age_id'] == $value['id']) ? 'selected' : '' ?>><?php echo $value['name1']; ?>歳～<?php echo $value['name2']; ?>歳</option>
                <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>タイトル</td>
            <td><input maxlength="50" required="" placeholder="50文字以内で入力してください" type="text" name="title" style="width: 490px;" value="<?php if (isset($_POST['title'])) { echo set_value('title'); } else{ echo (isset($exp_data['title'])) ? $exp_data['title'] : ''; }?>"></td>
        </tr>
        <tr>
            <td valign="top">本文</td>
            <td><textarea maxlength="1000" required="" placeholder="1000文字以内で入力してください" style="width: 500px; min-height: 200px;" name="content"><?php if (isset($_POST['content'])) { echo set_value('content'); }else{echo (isset($exp_data['content'])) ? $exp_data['content'] : ''; } ?></textarea></td>
        </tr>
        <?php if(isset($modify_flag)):?>
        <tr>
            <td colspan="2"><input type="hidden" name="exp_id" value="<?php echo (isset($exp_data['id']))? $exp_data['id']:''?>"></td>
        </tr>
        <?php endif;?>
        <tr>
            <td></td>
            <td align="left"><input type="submit" value="投稿する" onclick="this.disabled=true;this.form.submit();"></td>
        </tr>
    </table>
</form>