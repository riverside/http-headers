<input type="checkbox"
    name="hh_content_security_policy_value[<?php echo $item; ?>]"
    value="1"<?php echo isset($csp_value[$item]) ? ' checked' : NULL; ?>
    class="http-header-value"<?php echo $content_security_policy == 1 ? NULL : ' readonly'; ?>>