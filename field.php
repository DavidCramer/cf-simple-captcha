<?php

$opps = array('+','-','+','-','+','-');

$first = rand(5,9);
$second = rand(0,5);
$third = rand(1, $first - 1);

?>

<?php echo $wrapper_before; ?>
	<?php echo $field_label; ?>
	<?php echo $field_before; ?>
		<input <?php echo $field_placeholder; ?> type="hidden" name="cfscf[<?php echo $field['ID'] . $second . $first . $third; ?>]" value="<?php echo $field['ID']; ?>">
		<?php echo $first . ' ' . $opps[ $second ] . ' ' . $third; ?> = <input autocomplete="off" style="max-width: 50px; display: inline;" type="text" data-field="<?php echo $field_base_id; ?>" class="<?php echo $field_class; ?>" id="<?php echo $field_id; ?>" name="<?php echo $field_name; ?>" value="<?php echo esc_attr( $field_value ); ?>" required>
		<?php echo $field_caption; ?>
	<?php echo $field_after; ?>
<?php echo $wrapper_after; ?>