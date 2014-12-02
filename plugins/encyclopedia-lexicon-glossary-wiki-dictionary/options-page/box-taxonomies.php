<table class="form-table">
<tr>
  <th><label for="encyclopedia_categories"><?php Echo $this->t('Activate categories') ?></label></th>
  <td>
		<select id="encyclopedia_categories" <?php Disabled(True) ?> >
			<option><?php _e('Yes') ?></option>
			<option <?php Selected(True) ?> ><?php _e('No') ?></option>
		</select> <span class="asterisk">*</span><br>
		<small>
      <?php Echo $this->t('Categories can help you create an awesome knowledge base.') ?>
    </small>
	</td>
</tr>

<tr>
  <th><label for="encyclopedia_tags"><?php Echo $this->t('Activate tags') ?></label></th>
  <td>
		<select name="encyclopedia_tags" id="encyclopedia_tags">
			<option value="yes" <?php Selected($this->Get_Option('encyclopedia_tags'), 'yes') ?> ><?php _e('Yes') ?></option>
			<option value="no" <?php Selected($this->Get_Option('encyclopedia_tags'), 'no') ?> ><?php _e('No') ?></option>
		</select><br>
		<small>
      <?php Echo $this->t('Tags are necessary if you want to display relevant entries automatically.') ?>
    </small>
	</td>
</tr>
</table>

<p><?php Echo $this->Pro_Notice('custom_tax') ?></p>

<p>
  <span class="asterisk">*</span>
  <span class="pro-notice"><?php $this->Pro_Notice() ?></span>
</p>