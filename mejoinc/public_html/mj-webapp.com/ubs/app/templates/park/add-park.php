<div id="breadcrumb">
	<span><a href="?page=park">Parks</a> &gt; Create a Park</span>
</div>

<form id="park-information" name="park-information" method="post" action="?page=park&action=park-add-sql">
<fieldset>
  <legend>General Information</legend>
  <div class="form">
    <div class="form-row">
      <label for="name">Name <span class="required">*</span></label>
      <input type="text" size="28" name="name" id="name" />
    </div>
    <div class="form-row">
      <label for="address">Address <span class="required">*</span></label>
      <input type="text" size="28" name="address" id="address"  />
    </div>
    <div class="form-row">
      <label for="city">City <span class="required">*</span></label>
      <input type="text" size="24" name="city" id="city" />
    </div>
    <div class="form-row">
      <label for="state">State <span class="required">*</span></label>
      <input type="text" size="10" name="state" id="state" />
    </div>
    <div class="form-row">
      <label for="zip">Zip <span class="required">*</span></label>
      <input type="text" size="18" name="zip" id="zip" />
    </div>
    <div class="form-row">
      <label for="readUnit">Read Unit <span class="required">*</span></label>
      <select name="readUnit" id="readUnit">
        <option value=""></option> 
        <option value="HG">Gallons (Hundreds)</option>
        <option value="F">Cubic Feet</option>
        <option value="TG">Gallons (Thousands)</option>
      </select>
    </div>
    <div class="form-row">
      <label for="billingUnit">Billing Unit <span class="required">*</span></label>
      <select name="billingUnit" id="billingUnit">
      	<option value=""></option> 
        <option value="HG">Gallons (Hundreds)</option>
        <option value="F">Cubic Feet</option>
        <option value="TG">Gallons (Thousands)</option>
      </select>
    </div>
    <div class="form-row">
      <label for="min_usage">Minimum Usage <span class="required">*</span></label>
      <input type="text" size="18" name="min_usage" id="min_usage" />
    </div>
  </div>
</fieldset>
<fieldset>
  <legend>Taxes</legend>
  <div class="form">
    <div class="form-row">
      <label for="taxrate">Tax Rate <span class="required">*</span></label>
      <select name="taxrate" id="taxrate">
      	<option value=""></option> 
        <option value="0.00">0%</option>
        <option value="1.01">1%</option>
        <option value="1.02">2%</option>
        <option value="1.03">3%</option>
        <option value="1.04">4%</option>
        <option value="1.05">5%</option>
        <option value="1.06">6%</option>
        <option value="1.07">7%</option>
        <option value="1.08">8%</option>
        <option value="1.09">9%</option>
        <option value="1.10">10%</option>
        <option value="1.11">11%</option>
        <option value="1.12">12%</option>
        <option value="1.13">13%</option>
        <option value="1.14">14%</option>
        <option value="1.15">15%</option>
      </select>
    </div>
    <div class="form-row">
      <label for="taxwater">Tax Water <span class="required">*</span></label>
      <select name="taxwater" id="taxwater">
      	<option value=""></option> 
        <option value="Y">Yes</option>
        <option value="N">No</option>
      </select>
    </div>
    <div class="form-row">
      <label for="taxsewer">Tax Sewer <span class="required">*</span></label>
      <select name="taxsewer" id="taxsewer">
      	<option value=""></option> 
        <option value="Y">Yes</option>
        <option value="N">No</option>
      </select>
    </div>
  </div>
</fieldset>
<fieldset>
  <legend>Fees</legend>
  <div class="form">
    <div class="form-row">
      <label for="admin">Admin Fee <span class="required">*</span></label>
      <input type="text" size="18" name="admin" id="admin" />
    </div>
    <div class="form-row">
      <label for="service">Service Fee <span class="required">*</span></label>
      <input type="text" size="18" name="service" id="service" />
    </div>
    <div class="form-row">
      <label for="other">Fee Name <span class="required">*</span></label>
      <input type="text" size="18" name="other" id="other" />
      <label for="fuel">Fee Value <span class="required">*</span></label>
      <input type="text" size="18" name="fuel" id="fuel" />
    </div>
  </div>
</fieldset>
<fieldset>
  <legend>Process</legend>
  <div class="form">
    <div class="form-row alignRight">
  		<input type="submit" id="submit" name="submit" />
  		<input type="reset" id="reset" name="reset" />
    </div>
  </div>
</fieldset>