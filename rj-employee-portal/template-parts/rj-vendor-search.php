<?php
/**
 * The template for displaying vendors search forms in employee-portal
 *
 * @package astra-child
 */
?>

<form role="search" method="get" id="vendor-searchform" action="<?php echo esc_url(home_url('/')); ?>" class="searchform vendor-searchform">
  
  <div>
      <label for="vendor-name">Vendor Name</label>
      <input type="text" name="vendor-name" id="vendor-name"  placeholder="<?php echo esc_attr__('Name', 'astra-child'); ?>" autocomplete="off" />
  </div>

  <div>
      <label for="address">Address</label>
      <input type="text" name="address" id="address"  placeholder="<?php echo esc_attr__('Address', 'astra-child'); ?>" autocomplete="off" />
  </div>
  
  <div>
      <label for="city">City</label>
      <input type="text" name="city" id="city"  placeholder="<?php echo esc_attr__('City', 'astra-child'); ?>" autocomplete="off" />
  </div>

  <div>
      <label for="zip_code">Zip Code</label>
      <input type="text" name="zip_code" id="zip_code"  placeholder="<?php echo esc_attr__('Zip Code', 'astra-child'); ?>" autocomplete="off" />
  </div>

  <div>
      <label for="aspire_vendor">Aspire Vendor</label>
      <select name="aspire_vendor" id="aspire_vendor">
          <option value="">--</option>
          <option value="Yes">Yes</option>
          <option value="No">No</option>
      </select>
  </div>
  <input type="submit" value="Search">
</form>

