<label>Select Langauge</label>
<?php
echo ossn_plugin_view('input/dropdown', array(
				'name' => 'code',
				'placeholder' => 'Select',
				'options' => ossn_get_installed_translations(),
));
?>
<div class="margin-top-10">
	<input type="submit" value="Export" class="btn btn-sm btn-success" />
</div>	