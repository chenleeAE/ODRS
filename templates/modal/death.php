<div class="modal fade" id="death-modal" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close-death"><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus-square"></i> Apply Death Certificate</h4>
            </div>
            <form id="death-form" class="form-horizontal" autocomplete="off">
                <div class="modal-body">
                    <div class="panel">
                        <div class="panel-body">
                            <input type="hidden" name="id">
                            
                            <div class="form-group">
                                <label>Request For<span class="text-danger">*</span></label>&emsp;
                                <div class="i-checks checkbox-inline">
                                    <label><input type="radio" value="DEATH CERTIFICATE" name="request_for" required> DEATH CERTIFICATE</label>
                                </div>
                                <div class="i-checks checkbox-inline">
                                    <label> <input type="radio" value="AUTHENTICATION" name="request_for" required> AUTHENTICATION</label>
                                </div>
                                <div class="i-checks checkbox-inline">
                                    <label> <input type="radio" value="CD/LI" name="request_for" required> CD/LI</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Number of Copies<span class="text-danger">*</span></label> 
                                        <input type="number" name="number_of_copies" class="form-control" min="1" placeholder="Enter data here" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Birth Reference No. BReN (if known)</label> 
                                        <input type="text" name="brn" class="form-control" placeholder="Enter data here">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Sex<span class="text-danger">*</span></label>
                                        <select name="sex" class="form-control" required>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <p class="font-bold">OWNER'S PERSONAL INFORMATION (FOR MARRIED FEMALE, PLEASE USE MAIDEN NAME)</p>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>First Name<span class="text-danger">*</span></label> 
                                        <input type="text" name="fname" class="form-control" placeholder="Enter data here" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Middle Name</label> 
                                        <input type="text" name="mname" class="form-control" placeholder="Enter data here">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Last Name<span class="text-danger">*</span></label> 
                                        <input type="text" name="lname" class="form-control" placeholder="Enter data here" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Date of Birth<span class="text-danger">*</span></label> 
                                        <input type="date" name="dob" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                <div class="col-md-4">
                                        <label>Province<span class="text-danger">*</span></label> 
                                        <select id="death_province" name="pob_province" class="form-control" required>
                                            <option value="">Please select</option>

                                            <?php 
                                                require_once('../modules/database.php');
                                                    $query = "SELECT province, province_code FROM ref_provinces p
                                                                WHERE p.`status` = 'Active';";

                                                $result = mysqli_query($connection, $query);
                                            
                                                while($row = mysqli_fetch_array($result)) {
                                                    $province_code = $row['province_code'];
                                                    $province = $row['province'];
                                            ?>
                                                <option value="<?php echo $province_code?>"><?php echo $province; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>City / Municipality<span class="text-danger">*</span></label> 
                                        <select id="death_city" name="pob_city" class="form-control" required>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Country</label>
                                        <select name="pob_country" class="form-control">
                                            <option value="" disabled selected>Select Country</option>
                                            <option value="Afghanistan">Afghanistan</option>
                                            <option value="Albania">Albania</option>
                                            <option value="Algeria">Algeria</option>
                                            <option value="Andorra">Andorra</option>
                                            <option value="Angola">Angola</option>
                                            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Armenia">Armenia</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Austria">Austria</option>
                                            <option value="Azerbaijan">Azerbaijan</option>
                                            <option value="Bahamas">Bahamas</option>
                                            <option value="Bahrain">Bahrain</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                            <option value="Barbados">Barbados</option>
                                            <option value="Belarus">Belarus</option>
                                            <option value="Belgium">Belgium</option>
                                            <option value="Belize">Belize</option>
                                            <option value="Benin">Benin</option>
                                            <option value="Bhutan">Bhutan</option>
                                            <option value="Bolivia">Bolivia</option>
                                            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                            <option value="Botswana">Botswana</option>
                                            <option value="Brazil">Brazil</option>
                                            <option value="Brunei">Brunei</option>
                                            <option value="Bulgaria">Bulgaria</option>
                                            <option value="Burkina Faso">Burkina Faso</option>
                                            <option value="Burundi">Burundi</option>
                                            <option value="Cabo Verde">Cabo Verde</option>
                                            <option value="Cambodia">Cambodia</option>
                                            <option value="Cameroon">Cameroon</option>
                                            <option value="Canada">Canada</option>
                                            <option value="Chad">Chad</option>
                                            <option value="Chile">Chile</option>
                                            <option value="China">China</option>
                                            <option value="Colombia">Colombia</option>
                                            <option value="Comoros">Comoros</option>
                                            <option value="Congo (Congo-Brazzaville)">Congo (Congo-Brazzaville)</option>
                                            <option value="Congo (Congo-Kinshasa)">Congo (Congo-Kinshasa)</option>
                                            <option value="Costa Rica">Costa Rica</option>
                                            <option value="Ivory Coast">Ivory Coast</option>
                                            <option value="Croatia">Croatia</option>
                                            <option value="Cuba">Cuba</option>
                                            <option value="Cyprus">Cyprus</option>
                                            <option value="Czech Republic">Czech Republic</option>
                                            <option value="Denmark">Denmark</option>
                                            <option value="Djibouti">Djibouti</option>
                                            <option value="Dominica">Dominica</option>
                                            <option value="Dominican Republic">Dominican Republic</option>
                                            <option value="Ecuador">Ecuador</option>
                                            <option value="Egypt">Egypt</option>
                                            <option value="El Salvador">El Salvador</option>
                                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                                            <option value="Eritrea">Eritrea</option>
                                            <option value="Estonia">Estonia</option>
                                            <option value="Ethiopia">Ethiopia</option>
                                            <option value="Fiji">Fiji</option>
                                            <option value="Finland">Finland</option>
                                            <option value="France">France</option>
                                            <option value="Gabon">Gabon</option>
                                            <option value="Gambia">Gambia</option>
                                            <option value="Georgia">Georgia</option>
                                            <option value="Germany">Germany</option>
                                            <option value="Ghana">Ghana</option>
                                            <option value="Greece">Greece</option>
                                            <option value="Grenada">Grenada</option>
                                            <option value="Guatemala">Guatemala</option>
                                            <option value="Guinea">Guinea</option>
                                            <option value="Guinea-Bissau">Guinea-Bissau</option>
                                            <option value="Guyana">Guyana</option>
                                            <option value="Haiti">Haiti</option>
                                            <option value="Honduras">Honduras</option>
                                            <option value="Hungary">Hungary</option>
                                            <option value="Iceland">Iceland</option>
                                            <option value="India">India</option>
                                            <option value="Indonesia">Indonesia</option>
                                            <option value="Iran">Iran</option>
                                            <option value="Iraq">Iraq</option>
                                            <option value="Ireland">Ireland</option>
                                            <option value="Israel">Israel</option>
                                            <option value="Italy">Italy</option>
                                            <option value="Jamaica">Jamaica</option>
                                            <option value="Japan">Japan</option>
                                            <option value="Jordan">Jordan</option>
                                            <option value="Kazakhstan">Kazakhstan</option>
                                            <option value="Kenya">Kenya</option>
                                            <option value="Kiribati">Kiribati</option>
                                            <option value="South Korea">South Korea</option>
                                            <option value="Kuwait">Kuwait</option>
                                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                                            <option value="Laos">Laos</option>
                                            <option value="Latvia">Latvia</option>
                                            <option value="Lebanon">Lebanon</option>
                                            <option value="Lesotho">Lesotho</option>
                                            <option value="Liberia">Liberia</option>
                                            <option value="Libya">Libya</option>
                                            <option value="Liechtenstein">Liechtenstein</option>
                                            <option value="Lithuania">Lithuania</option>
                                            <option value="Luxembourg">Luxembourg</option>
                                            <option value="Madagascar">Madagascar</option>
                                            <option value="Malawi">Malawi</option>
                                            <option value="Malaysia">Malaysia</option>
                                            <option value="Maldives">Maldives</option>
                                            <option value="Mali">Mali</option>
                                            <option value="Malta">Malta</option>
                                            <option value="Marshall Islands">Marshall Islands</option>
                                            <option value="Mauritania">Mauritania</option>
                                            <option value="Mauritius">Mauritius</option>
                                            <option value="Mexico">Mexico</option>
                                            <option value="Micronesia">Micronesia</option>
                                            <option value="Moldova">Moldova</option>
                                            <option value="Monaco">Monaco</option>
                                            <option value="Mongolia">Mongolia</option>
                                            <option value="Montenegro">Montenegro</option>
                                            <option value="Mozambique">Mozambique</option>
                                            <option value="Myanmar">Myanmar</option>
                                            <option value="Namibia">Namibia</option>
                                            <option value="Nauru">Nauru</option>
                                            <option value="Nepal">Nepal</option>
                                            <option value="Netherlands">Netherlands</option>
                                            <option value="New Zealand">New Zealand</option>
                                            <option value="Nicaragua">Nicaragua</option>
                                            <option value="Niger">Niger</option>
                                            <option value="Nigeria">Nigeria</option>
                                            <option value="North Korea">North Korea</option>
                                            <option value="Norway">Norway</option>
                                            <option value="Oman">Oman</option>
                                            <option value="Pakistan">Pakistan</option>
                                            <option value="Palau">Palau</option>
                                            <option value="Panama">Panama</option>
                                            <option value="Papua New Guinea">Papua New Guinea</option>
                                            <option value="Paraguay">Paraguay</option>
                                            <option value="Peru">Peru</option>
                                            <option value="Philippines">Philippines</option>
                                            <option value="Poland">Poland</option>
                                            <option value="Portugal">Portugal</option>
                                            <option value="Qatar">Qatar</option>
                                            <option value="Romania">Romania</option>
                                            <option value="Russia">Russia</option>
                                            <option value="Rwanda">Rwanda</option>
                                            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                            <option value="Saint Lucia">Saint Lucia</option>
                                            <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                            <option value="Samoa">Samoa</option>
                                            <option value="San Marino">San Marino</option>
                                            <option value="São Tomé and Príncipe">São Tomé and Príncipe</option>
                                            <option value="Saudi Arabia">Saudi Arabia</option>
                                            <option value="Senegal">Senegal</option>
                                            <option value="Serbia">Serbia</option>
                                            <option value="Seychelles">Seychelles</option>
                                            <option value="Sierra Leone">Sierra Leone</option>
                                            <option value="Singapore">Singapore</option>
                                            <option value="Slovakia">Slovakia</option>
                                            <option value="Slovenia">Slovenia</option>
                                            <option value="Solomon Islands">Solomon Islands</option>
                                            <option value="Somalia">Somalia</option>
                                            <option value="South Africa">South Africa</option>
                                            <option value="South Sudan">South Sudan</option>
                                            <option value="Spain">Spain</option>
                                            <option value="Sri Lanka">Sri Lanka</option>
                                            <option value="Sudan">Sudan</option>
                                            <option value="Suriname">Suriname</option>
                                            <option value="Sweden">Sweden</option>
                                            <option value="Switzerland">Switzerland</option>
                                            <option value="Syria">Syria</option>
                                            <option value="Taiwan">Taiwan</option>
                                            <option value="Tajikistan">Tajikistan</option>
                                            <option value="Tanzania">Tanzania</option>
                                            <option value="Thailand">Thailand</option>
                                            <option value="Togo">Togo</option>
                                            <option value="Tonga">Tonga</option>
                                            <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                            <option value="Tunisia">Tunisia</option>
                                            <option value="Turkey">Turkey</option>
                                            <option value="Turkmenistan">Turkmenistan</option>
                                            <option value="Tuvalu">Tuvalu</option>
                                            <option value="Uganda">Uganda</option>
                                            <option value="Ukraine">Ukraine</option>
                                            <option value="United Arab Emirates">United Arab Emirates</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                            <option value="United States">United States</option>
                                            <option value="Uruguay">Uruguay</option>
                                            <option value="Uzbekistan">Uzbekistan</option>
                                            <option value="Vanuatu">Vanuatu</option>
                                            <option value="Venezuela">Venezuela</option>
                                            <option value="Vietnam">Vietnam</option>
                                            <option value="Yemen">Yemen</option>
                                            <option value="Zambia">Zambia</option>
                                            <option value="Zimbabwe">Zimbabwe</option>
                                        </select>
                                        <small class="text-danger">Please specify country if born abroad only</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Purpose<span class="text-danger">*</span></label>
                                <br>
                                <div class="i-checks checkbox-inline">
                                    <label><input type="radio" value="Claim Benefits / Loan" name="purpose" required> Claim Benefits / Loan</label>
                                </div>
                                <div class="i-checks checkbox-inline">
                                    <label> <input type="radio" value="Employment (Local)" name="purpose" required> Employment (Local)</label>
                                </div>
                                <div class="i-checks checkbox-inline">
                                    <label> <input type="radio" value="School Requirements" name="purpose" required> School Requirements</label>
                                </div>
                                <br>
                                <div class="i-checks checkbox-inline">
                                    <label> <input type="radio" value="Passport / Travel" name="purpose" required> Passport / Travel</label>
                                </div>
                                <div class="i-checks checkbox-inline">
                                    <label> <input type="radio" value="Employment (Abroad)" name="purpose" required> Employment (Abroad)</label>
                                </div>
                                <div class="i-checks checkbox-inline">
                                    <label> <input type="radio" value="Others" name="purpose" required> Others</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Specify (if Purpose is Passport or Employment Abroad specify Country)</label> 
                                        <input type="text" name="specify" class="form-control" placeholder="Enter data here" readonly>
                                    </div>
                                </div>
                            </div>

                            <p class="font-bold">If you are not the one to claim, please upload a valid ID of the claimant and an authorization letter.</p>
                          
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Upload Valid ID (Claimant's ID)</label> 
                                        <input type="file" name="valid_id" class="form-control" accept="image/*">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Upload Authorization Letter</label> 
                                        <input type="file" name="authorization_letter" class="form-control" accept="image/*">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>