
<div class="caldera-config-group">
    <div> <?php esc_html_e('Your API Key and API URL can be determined by accessing User Settings. To know more click ', 'wpcf_insightly_integration'); ?><a href="https://support.insight.ly/hc/en-us/articles/204864594-Finding-your-Insightly-API-key" target="_blank"><?php esc_html_e('here', 'wpcf_insightly_integration'); ?></a></div>
</div>

<div class="caldera-config-group">
    <div><?php esc_html_e( 'Please provide Base64 encoded Insightly API key', 'integration-insightly-calderaforms' ); ?></div>
</div>
<div class="caldera-config-group">
    <label><?php esc_html_e( 'Insightly API key', 'integration-insightly-calderaforms' ); ?> </label>
    <div class="caldera-config-field">
        <input type="text" class="block-input field-config required" id="iicf_insightly_api_key" name="{{_name}}[iicf_insightly_api_key]" value="{{iicf_insightly_api_key}}" required="required">
        <div class="description"></div>
    </div>
</div>

<div class="caldera-config-group">
    <label><?php esc_html_e( 'Insightly API URL', 'integration-insightly-calderaforms' ); ?> </label>
    <div class="caldera-config-field">
        <input type="text" class="block-input field-config required" id="iicf_insightly_api_url" name="{{_name}}[iicf_insightly_api_url]" value="{{iicf_insightly_api_url}}" required="required">
        <div class="description"></div>
    </div>
</div>

<div class="caldera-config-group">
	<label><?php esc_html_e( 'Insightly Object', 'integration-insightly-calderaforms' ); ?> </label>
	<div class="caldera-config-field">
		<select class="block-input field-config" name="{{_name}}[iicf_insightly_obj]" id="iicf_insightly_obj">
			<option value="Contact" {{#is context value="Contact"}}selected="selected"{{/is}}><?php esc_html_e( 'Contact', 'integration-insightly-calderaforms' ); ?></option>
		</select>
	</div>
</div>

<div class="caldera-config-group">
    <label><?php esc_html_e( 'First Name', 'integration-insightly-calderaforms' ); ?> </label>
    <div class="caldera-config-field">
        <input type="text" class="block-input field-config magic-tag-enabled caldera-field-bind required" id="iicf_insightly_first_name" name="{{_name}}[iicf_insightly_first_name]" value="{{iicf_insightly_first_name}}" required="required">
    </div>
</div>

<div class="caldera-config-group">
    <label><?php esc_html_e( 'Last Name', 'integration-insightly-calderaforms' ); ?> </label>
    <div class="caldera-config-field">
        <input type="text" class="block-input field-config magic-tag-enabled caldera-field-bind" id="iicf_insightly_last_name" name="{{_name}}[iicf_insightly_last_name]" value="{{iicf_insightly_last_name}}">
    </div>
</div>

<div class="caldera-config-group">
    <label><?php esc_html_e( 'Your Email', 'integration-insightly-calderaforms' ); ?> </label>
    <div class="caldera-config-field">
        <input type="email" class="block-input field-config magic-tag-enabled caldera-field-bind required" id="iicf_insightly_email" name="{{_name}}[iicf_insightly_email]" value="{{iicf_insightly_email}}" required="required">
    </div>
</div>
