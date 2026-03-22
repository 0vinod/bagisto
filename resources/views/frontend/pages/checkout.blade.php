@extends('frontend.layouts.master')

@section('title', 'Checkout page')

@section('main-content')
    <!-- Modern Breadcrumbs -->
    <div class="modern-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="modern-breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('cart') }}">Shopping Cart</a></li>
                            <li class="breadcrumb-item active">Checkout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Checkout Section -->
    <section class="modern-checkout section">
        <div class="container">
            @php
                $selectedCountry = old('country', ($lastOrder ? $lastOrder->country : null) ?? ($user ? ($user->country ?? 'NP') : 'NP'));
            @endphp
            
            <form class="checkout-form" method="POST" action="{{ route('cart.order') }}">
                @csrf
                <div class="row g-4">
                    <!-- Billing Details Column -->
                    <div class="col-lg-8 col-12">
                        <div class="billing-details-card">
                            <div class="card-header">
                                <h3><i class="fas fa-file-invoice me-2"></i> Billing Details</h3>
                                <p>Please fill in your information to complete your order</p>
                            </div>
                            
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- First Name -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" 
                                                   class="form-control @error('first_name') is-invalid @enderror" 
                                                   id="first_name" 
                                                   name="first_name" 
                                                   placeholder="First Name"
                                                   value="{{ old('first_name', ($lastOrder ? $lastOrder->first_name : null) ?? $firstName ?? '') }}">
                                            <label for="first_name">First Name <span class="required">*</span></label>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Last Name -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" 
                                                   class="form-control @error('last_name') is-invalid @enderror" 
                                                   id="last_name" 
                                                   name="last_name" 
                                                   placeholder="Last Name"
                                                   value="{{ old('last_name', ($lastOrder ? $lastOrder->last_name : null) ?? $lastName ?? '') }}">
                                            <label for="last_name">Last Name <span class="required">*</span></label>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Email Address -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   placeholder="Email Address"
                                                   value="{{ old('email', ($lastOrder ? $lastOrder->email : null) ?? ($user ? $user->email : '')) }}">
                                            <label for="email">Email Address <span class="required">*</span></label>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Phone Number -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="tel" 
                                                   class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" 
                                                   name="phone" 
                                                   placeholder="Phone Number"
                                                   value="{{ old('phone', $lastOrder ? $lastOrder->phone : '') }}">
                                            <label for="phone">Phone Number <span class="required">*</span></label>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Country -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select @error('country') is-invalid @enderror" 
                                                    id="country" 
                                                    name="country">
                                                <option value="">Select Country</option>
                                                <option value="AF" {{ $selectedCountry == 'AF' ? 'selected' : '' }}>Afghanistan</option>
                                                <option value="AL" {{ $selectedCountry == 'AL' ? 'selected' : '' }}>Albania</option>
                                                <option value="DZ" {{ $selectedCountry == 'DZ' ? 'selected' : '' }}>Algeria</option>
                                                <option value="AS" {{ $selectedCountry == 'AS' ? 'selected' : '' }}>American Samoa</option>
                                                <option value="AD" {{ $selectedCountry == 'AD' ? 'selected' : '' }}>Andorra</option>
                                                <option value="AO" {{ $selectedCountry == 'AO' ? 'selected' : '' }}>Angola</option>
                                                <option value="AI" {{ $selectedCountry == 'AI' ? 'selected' : '' }}>Anguilla</option>
                                                <option value="AQ" {{ $selectedCountry == 'AQ' ? 'selected' : '' }}>Antarctica</option>
                                                <option value="AG" {{ $selectedCountry == 'AG' ? 'selected' : '' }}>Antigua and Barbuda</option>
                                                <option value="AR" {{ $selectedCountry == 'AR' ? 'selected' : '' }}>Argentina</option>
                                                <option value="AM" {{ $selectedCountry == 'AM' ? 'selected' : '' }}>Armenia</option>
                                                <option value="AW" {{ $selectedCountry == 'AW' ? 'selected' : '' }}>Aruba</option>
                                                <option value="AU" {{ $selectedCountry == 'AU' ? 'selected' : '' }}>Australia</option>
                                                <option value="AT" {{ $selectedCountry == 'AT' ? 'selected' : '' }}>Austria</option>
                                                <option value="AZ" {{ $selectedCountry == 'AZ' ? 'selected' : '' }}>Azerbaijan</option>
                                                <option value="BS" {{ $selectedCountry == 'BS' ? 'selected' : '' }}>Bahamas</option>
                                                <option value="BH" {{ $selectedCountry == 'BH' ? 'selected' : '' }}>Bahrain</option>
                                                <option value="BD" {{ $selectedCountry == 'BD' ? 'selected' : '' }}>Bangladesh</option>
                                                <option value="BB" {{ $selectedCountry == 'BB' ? 'selected' : '' }}>Barbados</option>
                                                <option value="BY" {{ $selectedCountry == 'BY' ? 'selected' : '' }}>Belarus</option>
                                                <option value="BE" {{ $selectedCountry == 'BE' ? 'selected' : '' }}>Belgium</option>
                                                <option value="BZ" {{ $selectedCountry == 'BZ' ? 'selected' : '' }}>Belize</option>
                                                <option value="BJ" {{ $selectedCountry == 'BJ' ? 'selected' : '' }}>Benin</option>
                                                <option value="BM" {{ $selectedCountry == 'BM' ? 'selected' : '' }}>Bermuda</option>
                                                <option value="BT" {{ $selectedCountry == 'BT' ? 'selected' : '' }}>Bhutan</option>
                                                <option value="BO" {{ $selectedCountry == 'BO' ? 'selected' : '' }}>Bolivia</option>
                                                <option value="BA" {{ $selectedCountry == 'BA' ? 'selected' : '' }}>Bosnia and Herzegovina</option>
                                                <option value="BW" {{ $selectedCountry == 'BW' ? 'selected' : '' }}>Botswana</option>
                                                <option value="BV" {{ $selectedCountry == 'BV' ? 'selected' : '' }}>Bouvet Island</option>
                                                <option value="BR" {{ $selectedCountry == 'BR' ? 'selected' : '' }}>Brazil</option>
                                                <option value="IO" {{ $selectedCountry == 'IO' ? 'selected' : '' }}>British Indian Ocean Territory</option>
                                                <option value="BN" {{ $selectedCountry == 'BN' ? 'selected' : '' }}>Brunei Darussalam</option>
                                                <option value="BG" {{ $selectedCountry == 'BG' ? 'selected' : '' }}>Bulgaria</option>
                                                <option value="BF" {{ $selectedCountry == 'BF' ? 'selected' : '' }}>Burkina Faso</option>
                                                <option value="BI" {{ $selectedCountry == 'BI' ? 'selected' : '' }}>Burundi</option>
                                                <option value="KH" {{ $selectedCountry == 'KH' ? 'selected' : '' }}>Cambodia</option>
                                                <option value="CM" {{ $selectedCountry == 'CM' ? 'selected' : '' }}>Cameroon</option>
                                                <option value="CA" {{ $selectedCountry == 'CA' ? 'selected' : '' }}>Canada</option>
                                                <option value="CV" {{ $selectedCountry == 'CV' ? 'selected' : '' }}>Cape Verde</option>
                                                <option value="KY" {{ $selectedCountry == 'KY' ? 'selected' : '' }}>Cayman Islands</option>
                                                <option value="CF" {{ $selectedCountry == 'CF' ? 'selected' : '' }}>Central African Republic</option>
                                                <option value="TD" {{ $selectedCountry == 'TD' ? 'selected' : '' }}>Chad</option>
                                                <option value="CL" {{ $selectedCountry == 'CL' ? 'selected' : '' }}>Chile</option>
                                                <option value="CN" {{ $selectedCountry == 'CN' ? 'selected' : '' }}>China</option>
                                                <option value="CX" {{ $selectedCountry == 'CX' ? 'selected' : '' }}>Christmas Island</option>
                                                <option value="CC" {{ $selectedCountry == 'CC' ? 'selected' : '' }}>Cocos (Keeling) Islands</option>
                                                <option value="CO" {{ $selectedCountry == 'CO' ? 'selected' : '' }}>Colombia</option>
                                                <option value="KM" {{ $selectedCountry == 'KM' ? 'selected' : '' }}>Comoros</option>
                                                <option value="CG" {{ $selectedCountry == 'CG' ? 'selected' : '' }}>Congo</option>
                                                <option value="CD" {{ $selectedCountry == 'CD' ? 'selected' : '' }}>Congo, Democratic Republic</option>
                                                <option value="CK" {{ $selectedCountry == 'CK' ? 'selected' : '' }}>Cook Islands</option>
                                                <option value="CR" {{ $selectedCountry == 'CR' ? 'selected' : '' }}>Costa Rica</option>
                                                <option value="CI" {{ $selectedCountry == 'CI' ? 'selected' : '' }}>Cote D'Ivoire</option>
                                                <option value="HR" {{ $selectedCountry == 'HR' ? 'selected' : '' }}>Croatia</option>
                                                <option value="CU" {{ $selectedCountry == 'CU' ? 'selected' : '' }}>Cuba</option>
                                                <option value="CY" {{ $selectedCountry == 'CY' ? 'selected' : '' }}>Cyprus</option>
                                                <option value="CZ" {{ $selectedCountry == 'CZ' ? 'selected' : '' }}>Czech Republic</option>
                                                <option value="DK" {{ $selectedCountry == 'DK' ? 'selected' : '' }}>Denmark</option>
                                                <option value="DJ" {{ $selectedCountry == 'DJ' ? 'selected' : '' }}>Djibouti</option>
                                                <option value="DM" {{ $selectedCountry == 'DM' ? 'selected' : '' }}>Dominica</option>
                                                <option value="DO" {{ $selectedCountry == 'DO' ? 'selected' : '' }}>Dominican Republic</option>
                                                <option value="EC" {{ $selectedCountry == 'EC' ? 'selected' : '' }}>Ecuador</option>
                                                <option value="EG" {{ $selectedCountry == 'EG' ? 'selected' : '' }}>Egypt</option>
                                                <option value="SV" {{ $selectedCountry == 'SV' ? 'selected' : '' }}>El Salvador</option>
                                                <option value="GQ" {{ $selectedCountry == 'GQ' ? 'selected' : '' }}>Equatorial Guinea</option>
                                                <option value="ER" {{ $selectedCountry == 'ER' ? 'selected' : '' }}>Eritrea</option>
                                                <option value="EE" {{ $selectedCountry == 'EE' ? 'selected' : '' }}>Estonia</option>
                                                <option value="ET" {{ $selectedCountry == 'ET' ? 'selected' : '' }}>Ethiopia</option>
                                                <option value="FK" {{ $selectedCountry == 'FK' ? 'selected' : '' }}>Falkland Islands (Malvinas)</option>
                                                <option value="FO" {{ $selectedCountry == 'FO' ? 'selected' : '' }}>Faroe Islands</option>
                                                <option value="FJ" {{ $selectedCountry == 'FJ' ? 'selected' : '' }}>Fiji</option>
                                                <option value="FI" {{ $selectedCountry == 'FI' ? 'selected' : '' }}>Finland</option>
                                                <option value="FR" {{ $selectedCountry == 'FR' ? 'selected' : '' }}>France</option>
                                                <option value="GF" {{ $selectedCountry == 'GF' ? 'selected' : '' }}>French Guiana</option>
                                                <option value="PF" {{ $selectedCountry == 'PF' ? 'selected' : '' }}>French Polynesia</option>
                                                <option value="TF" {{ $selectedCountry == 'TF' ? 'selected' : '' }}>French Southern Territories</option>
                                                <option value="GA" {{ $selectedCountry == 'GA' ? 'selected' : '' }}>Gabon</option>
                                                <option value="GM" {{ $selectedCountry == 'GM' ? 'selected' : '' }}>Gambia</option>
                                                <option value="GE" {{ $selectedCountry == 'GE' ? 'selected' : '' }}>Georgia</option>
                                                <option value="DE" {{ $selectedCountry == 'DE' ? 'selected' : '' }}>Germany</option>
                                                <option value="GH" {{ $selectedCountry == 'GH' ? 'selected' : '' }}>Ghana</option>
                                                <option value="GI" {{ $selectedCountry == 'GI' ? 'selected' : '' }}>Gibraltar</option>
                                                <option value="GR" {{ $selectedCountry == 'GR' ? 'selected' : '' }}>Greece</option>
                                                <option value="GL" {{ $selectedCountry == 'GL' ? 'selected' : '' }}>Greenland</option>
                                                <option value="GD" {{ $selectedCountry == 'GD' ? 'selected' : '' }}>Grenada</option>
                                                <option value="GP" {{ $selectedCountry == 'GP' ? 'selected' : '' }}>Guadeloupe</option>
                                                <option value="GU" {{ $selectedCountry == 'GU' ? 'selected' : '' }}>Guam</option>
                                                <option value="GT" {{ $selectedCountry == 'GT' ? 'selected' : '' }}>Guatemala</option>
                                                <option value="GN" {{ $selectedCountry == 'GN' ? 'selected' : '' }}>Guinea</option>
                                                <option value="GW" {{ $selectedCountry == 'GW' ? 'selected' : '' }}>Guinea-Bissau</option>
                                                <option value="GY" {{ $selectedCountry == 'GY' ? 'selected' : '' }}>Guyana</option>
                                                <option value="HT" {{ $selectedCountry == 'HT' ? 'selected' : '' }}>Haiti</option>
                                                <option value="HM" {{ $selectedCountry == 'HM' ? 'selected' : '' }}>Heard Island and Mcdonald Islands</option>
                                                <option value="VA" {{ $selectedCountry == 'VA' ? 'selected' : '' }}>Holy See (Vatican City State)</option>
                                                <option value="HN" {{ $selectedCountry == 'HN' ? 'selected' : '' }}>Honduras</option>
                                                <option value="HK" {{ $selectedCountry == 'HK' ? 'selected' : '' }}>Hong Kong</option>
                                                <option value="HU" {{ $selectedCountry == 'HU' ? 'selected' : '' }}>Hungary</option>
                                                <option value="IS" {{ $selectedCountry == 'IS' ? 'selected' : '' }}>Iceland</option>
                                                <option value="IN" {{ $selectedCountry == 'IN' ? 'selected' : '' }}>India</option>
                                                <option value="ID" {{ $selectedCountry == 'ID' ? 'selected' : '' }}>Indonesia</option>
                                                <option value="IR" {{ $selectedCountry == 'IR' ? 'selected' : '' }}>Iran, Islamic Republic of</option>
                                                <option value="IQ" {{ $selectedCountry == 'IQ' ? 'selected' : '' }}>Iraq</option>
                                                <option value="IE" {{ $selectedCountry == 'IE' ? 'selected' : '' }}>Ireland</option>
                                                <option value="IL" {{ $selectedCountry == 'IL' ? 'selected' : '' }}>Israel</option>
                                                <option value="IT" {{ $selectedCountry == 'IT' ? 'selected' : '' }}>Italy</option>
                                                <option value="JM" {{ $selectedCountry == 'JM' ? 'selected' : '' }}>Jamaica</option>
                                                <option value="JP" {{ $selectedCountry == 'JP' ? 'selected' : '' }}>Japan</option>
                                                <option value="JO" {{ $selectedCountry == 'JO' ? 'selected' : '' }}>Jordan</option>
                                                <option value="KZ" {{ $selectedCountry == 'KZ' ? 'selected' : '' }}>Kazakhstan</option>
                                                <option value="KE" {{ $selectedCountry == 'KE' ? 'selected' : '' }}>Kenya</option>
                                                <option value="KI" {{ $selectedCountry == 'KI' ? 'selected' : '' }}>Kiribati</option>
                                                <option value="KP" {{ $selectedCountry == 'KP' ? 'selected' : '' }}>Korea, Democratic People's Republic of</option>
                                                <option value="KR" {{ $selectedCountry == 'KR' ? 'selected' : '' }}>Korea, Republic of</option>
                                                <option value="KW" {{ $selectedCountry == 'KW' ? 'selected' : '' }}>Kuwait</option>
                                                <option value="KG" {{ $selectedCountry == 'KG' ? 'selected' : '' }}>Kyrgyzstan</option>
                                                <option value="LA" {{ $selectedCountry == 'LA' ? 'selected' : '' }}>Lao People's Democratic Republic</option>
                                                <option value="LV" {{ $selectedCountry == 'LV' ? 'selected' : '' }}>Latvia</option>
                                                <option value="LB" {{ $selectedCountry == 'LB' ? 'selected' : '' }}>Lebanon</option>
                                                <option value="LS" {{ $selectedCountry == 'LS' ? 'selected' : '' }}>Lesotho</option>
                                                <option value="LR" {{ $selectedCountry == 'LR' ? 'selected' : '' }}>Liberia</option>
                                                <option value="LY" {{ $selectedCountry == 'LY' ? 'selected' : '' }}>Libyan Arab Jamahiriya</option>
                                                <option value="LI" {{ $selectedCountry == 'LI' ? 'selected' : '' }}>Liechtenstein</option>
                                                <option value="LT" {{ $selectedCountry == 'LT' ? 'selected' : '' }}>Lithuania</option>
                                                <option value="LU" {{ $selectedCountry == 'LU' ? 'selected' : '' }}>Luxembourg</option>
                                                <option value="MO" {{ $selectedCountry == 'MO' ? 'selected' : '' }}>Macao</option>
                                                <option value="MK" {{ $selectedCountry == 'MK' ? 'selected' : '' }}>Macedonia, the Former Yugoslav Republic of</option>
                                                <option value="MG" {{ $selectedCountry == 'MG' ? 'selected' : '' }}>Madagascar</option>
                                                <option value="MW" {{ $selectedCountry == 'MW' ? 'selected' : '' }}>Malawi</option>
                                                <option value="MY" {{ $selectedCountry == 'MY' ? 'selected' : '' }}>Malaysia</option>
                                                <option value="MV" {{ $selectedCountry == 'MV' ? 'selected' : '' }}>Maldives</option>
                                                <option value="ML" {{ $selectedCountry == 'ML' ? 'selected' : '' }}>Mali</option>
                                                <option value="MT" {{ $selectedCountry == 'MT' ? 'selected' : '' }}>Malta</option>
                                                <option value="MH" {{ $selectedCountry == 'MH' ? 'selected' : '' }}>Marshall Islands</option>
                                                <option value="MQ" {{ $selectedCountry == 'MQ' ? 'selected' : '' }}>Martinique</option>
                                                <option value="MR" {{ $selectedCountry == 'MR' ? 'selected' : '' }}>Mauritania</option>
                                                <option value="MU" {{ $selectedCountry == 'MU' ? 'selected' : '' }}>Mauritius</option>
                                                <option value="YT" {{ $selectedCountry == 'YT' ? 'selected' : '' }}>Mayotte</option>
                                                <option value="MX" {{ $selectedCountry == 'MX' ? 'selected' : '' }}>Mexico</option>
                                                <option value="FM" {{ $selectedCountry == 'FM' ? 'selected' : '' }}>Micronesia, Federated States of</option>
                                                <option value="MD" {{ $selectedCountry == 'MD' ? 'selected' : '' }}>Moldova, Republic of</option>
                                                <option value="MC" {{ $selectedCountry == 'MC' ? 'selected' : '' }}>Monaco</option>
                                                <option value="MN" {{ $selectedCountry == 'MN' ? 'selected' : '' }}>Mongolia</option>
                                                <option value="MS" {{ $selectedCountry == 'MS' ? 'selected' : '' }}>Montserrat</option>
                                                <option value="MA" {{ $selectedCountry == 'MA' ? 'selected' : '' }}>Morocco</option>
                                                <option value="MZ" {{ $selectedCountry == 'MZ' ? 'selected' : '' }}>Mozambique</option>
                                                <option value="MM" {{ $selectedCountry == 'MM' ? 'selected' : '' }}>Myanmar</option>
                                                <option value="NA" {{ $selectedCountry == 'NA' ? 'selected' : '' }}>Namibia</option>
                                                <option value="NR" {{ $selectedCountry == 'NR' ? 'selected' : '' }}>Nauru</option>
                                                <option value="NP" {{ $selectedCountry == 'NP' ? 'selected' : '' }}>Nepal</option>
                                                <option value="NL" {{ $selectedCountry == 'NL' ? 'selected' : '' }}>Netherlands</option>
                                                <option value="AN" {{ $selectedCountry == 'AN' ? 'selected' : '' }}>Netherlands Antilles</option>
                                                <option value="NC" {{ $selectedCountry == 'NC' ? 'selected' : '' }}>New Caledonia</option>
                                                <option value="NZ" {{ $selectedCountry == 'NZ' ? 'selected' : '' }}>New Zealand</option>
                                                <option value="NI" {{ $selectedCountry == 'NI' ? 'selected' : '' }}>Nicaragua</option>
                                                <option value="NE" {{ $selectedCountry == 'NE' ? 'selected' : '' }}>Niger</option>
                                                <option value="NG" {{ $selectedCountry == 'NG' ? 'selected' : '' }}>Nigeria</option>
                                                <option value="NU" {{ $selectedCountry == 'NU' ? 'selected' : '' }}>Niue</option>
                                                <option value="NF" {{ $selectedCountry == 'NF' ? 'selected' : '' }}>Norfolk Island</option>
                                                <option value="MP" {{ $selectedCountry == 'MP' ? 'selected' : '' }}>Northern Mariana Islands</option>
                                                <option value="NO" {{ $selectedCountry == 'NO' ? 'selected' : '' }}>Norway</option>
                                                <option value="OM" {{ $selectedCountry == 'OM' ? 'selected' : '' }}>Oman</option>
                                                <option value="PK" {{ $selectedCountry == 'PK' ? 'selected' : '' }}>Pakistan</option>
                                                <option value="PW" {{ $selectedCountry == 'PW' ? 'selected' : '' }}>Palau</option>
                                                <option value="PS" {{ $selectedCountry == 'PS' ? 'selected' : '' }}>Palestinian Territory, Occupied</option>
                                                <option value="PA" {{ $selectedCountry == 'PA' ? 'selected' : '' }}>Panama</option>
                                                <option value="PG" {{ $selectedCountry == 'PG' ? 'selected' : '' }}>Papua New Guinea</option>
                                                <option value="PY" {{ $selectedCountry == 'PY' ? 'selected' : '' }}>Paraguay</option>
                                                <option value="PE" {{ $selectedCountry == 'PE' ? 'selected' : '' }}>Peru</option>
                                                <option value="PH" {{ $selectedCountry == 'PH' ? 'selected' : '' }}>Philippines</option>
                                                <option value="PN" {{ $selectedCountry == 'PN' ? 'selected' : '' }}>Pitcairn</option>
                                                <option value="PL" {{ $selectedCountry == 'PL' ? 'selected' : '' }}>Poland</option>
                                                <option value="PT" {{ $selectedCountry == 'PT' ? 'selected' : '' }}>Portugal</option>
                                                <option value="PR" {{ $selectedCountry == 'PR' ? 'selected' : '' }}>Puerto Rico</option>
                                                <option value="QA" {{ $selectedCountry == 'QA' ? 'selected' : '' }}>Qatar</option>
                                                <option value="RE" {{ $selectedCountry == 'RE' ? 'selected' : '' }}>Reunion</option>
                                                <option value="RO" {{ $selectedCountry == 'RO' ? 'selected' : '' }}>Romania</option>
                                                <option value="RU" {{ $selectedCountry == 'RU' ? 'selected' : '' }}>Russian Federation</option>
                                                <option value="RW" {{ $selectedCountry == 'RW' ? 'selected' : '' }}>Rwanda</option>
                                                <option value="SH" {{ $selectedCountry == 'SH' ? 'selected' : '' }}>Saint Helena</option>
                                                <option value="KN" {{ $selectedCountry == 'KN' ? 'selected' : '' }}>Saint Kitts and Nevis</option>
                                                <option value="LC" {{ $selectedCountry == 'LC' ? 'selected' : '' }}>Saint Lucia</option>
                                                <option value="PM" {{ $selectedCountry == 'PM' ? 'selected' : '' }}>Saint Pierre and Miquelon</option>
                                                <option value="VC" {{ $selectedCountry == 'VC' ? 'selected' : '' }}>Saint Vincent and the Grenadines</option>
                                                <option value="WS" {{ $selectedCountry == 'WS' ? 'selected' : '' }}>Samoa</option>
                                                <option value="SM" {{ $selectedCountry == 'SM' ? 'selected' : '' }}>San Marino</option>
                                                <option value="ST" {{ $selectedCountry == 'ST' ? 'selected' : '' }}>Sao Tome and Principe</option>
                                                <option value="SA" {{ $selectedCountry == 'SA' ? 'selected' : '' }}>Saudi Arabia</option>
                                                <option value="SN" {{ $selectedCountry == 'SN' ? 'selected' : '' }}>Senegal</option>
                                                <option value="CS" {{ $selectedCountry == 'CS' ? 'selected' : '' }}>Serbia and Montenegro</option>
                                                <option value="SC" {{ $selectedCountry == 'SC' ? 'selected' : '' }}>Seychelles</option>
                                                <option value="SL" {{ $selectedCountry == 'SL' ? 'selected' : '' }}>Sierra Leone</option>
                                                <option value="SG" {{ $selectedCountry == 'SG' ? 'selected' : '' }}>Singapore</option>
                                                <option value="SK" {{ $selectedCountry == 'SK' ? 'selected' : '' }}>Slovakia</option>
                                                <option value="SI" {{ $selectedCountry == 'SI' ? 'selected' : '' }}>Slovenia</option>
                                                <option value="SB" {{ $selectedCountry == 'SB' ? 'selected' : '' }}>Solomon Islands</option>
                                                <option value="SO" {{ $selectedCountry == 'SO' ? 'selected' : '' }}>Somalia</option>
                                                <option value="ZA" {{ $selectedCountry == 'ZA' ? 'selected' : '' }}>South Africa</option>
                                                <option value="GS" {{ $selectedCountry == 'GS' ? 'selected' : '' }}>South Georgia and the South Sandwich Islands</option>
                                                <option value="ES" {{ $selectedCountry == 'ES' ? 'selected' : '' }}>Spain</option>
                                                <option value="LK" {{ $selectedCountry == 'LK' ? 'selected' : '' }}>Sri Lanka</option>
                                                <option value="SD" {{ $selectedCountry == 'SD' ? 'selected' : '' }}>Sudan</option>
                                                <option value="SR" {{ $selectedCountry == 'SR' ? 'selected' : '' }}>Suriname</option>
                                                <option value="SJ" {{ $selectedCountry == 'SJ' ? 'selected' : '' }}>Svalbard and Jan Mayen</option>
                                                <option value="SZ" {{ $selectedCountry == 'SZ' ? 'selected' : '' }}>Swaziland</option>
                                                <option value="SE" {{ $selectedCountry == 'SE' ? 'selected' : '' }}>Sweden</option>
                                                <option value="CH" {{ $selectedCountry == 'CH' ? 'selected' : '' }}>Switzerland</option>
                                                <option value="SY" {{ $selectedCountry == 'SY' ? 'selected' : '' }}>Syrian Arab Republic</option>
                                                <option value="TW" {{ $selectedCountry == 'TW' ? 'selected' : '' }}>Taiwan, Province of China</option>
                                                <option value="TJ" {{ $selectedCountry == 'TJ' ? 'selected' : '' }}>Tajikistan</option>
                                                <option value="TZ" {{ $selectedCountry == 'TZ' ? 'selected' : '' }}>Tanzania, United Republic of</option>
                                                <option value="TH" {{ $selectedCountry == 'TH' ? 'selected' : '' }}>Thailand</option>
                                                <option value="TL" {{ $selectedCountry == 'TL' ? 'selected' : '' }}>Timor-Leste</option>
                                                <option value="TG" {{ $selectedCountry == 'TG' ? 'selected' : '' }}>Togo</option>
                                                <option value="TK" {{ $selectedCountry == 'TK' ? 'selected' : '' }}>Tokelau</option>
                                                <option value="TO" {{ $selectedCountry == 'TO' ? 'selected' : '' }}>Tonga</option>
                                                <option value="TT" {{ $selectedCountry == 'TT' ? 'selected' : '' }}>Trinidad and Tobago</option>
                                                <option value="TN" {{ $selectedCountry == 'TN' ? 'selected' : '' }}>Tunisia</option>
                                                <option value="TR" {{ $selectedCountry == 'TR' ? 'selected' : '' }}>Turkey</option>
                                                <option value="TM" {{ $selectedCountry == 'TM' ? 'selected' : '' }}>Turkmenistan</option>
                                                <option value="TC" {{ $selectedCountry == 'TC' ? 'selected' : '' }}>Turks and Caicos Islands</option>
                                                <option value="TV" {{ $selectedCountry == 'TV' ? 'selected' : '' }}>Tuvalu</option>
                                                <option value="UG" {{ $selectedCountry == 'UG' ? 'selected' : '' }}>Uganda</option>
                                                <option value="UA" {{ $selectedCountry == 'UA' ? 'selected' : '' }}>Ukraine</option>
                                                <option value="AE" {{ $selectedCountry == 'AE' ? 'selected' : '' }}>United Arab Emirates</option>
                                                <option value="GB" {{ $selectedCountry == 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                                <option value="US" {{ $selectedCountry == 'US' ? 'selected' : '' }}>United States</option>
                                                <option value="UM" {{ $selectedCountry == 'UM' ? 'selected' : '' }}>United States Minor Outlying Islands</option>
                                                <option value="UY" {{ $selectedCountry == 'UY' ? 'selected' : '' }}>Uruguay</option>
                                                <option value="UZ" {{ $selectedCountry == 'UZ' ? 'selected' : '' }}>Uzbekistan</option>
                                                <option value="VU" {{ $selectedCountry == 'VU' ? 'selected' : '' }}>Vanuatu</option>
                                                <option value="VE" {{ $selectedCountry == 'VE' ? 'selected' : '' }}>Venezuela</option>
                                                <option value="VN" {{ $selectedCountry == 'VN' ? 'selected' : '' }}>Viet Nam</option>
                                                <option value="VG" {{ $selectedCountry == 'VG' ? 'selected' : '' }}>Virgin Islands, British</option>
                                                <option value="VI" {{ $selectedCountry == 'VI' ? 'selected' : '' }}>Virgin Islands, U.s.</option>
                                                <option value="WF" {{ $selectedCountry == 'WF' ? 'selected' : '' }}>Wallis and Futuna</option>
                                                <option value="EH" {{ $selectedCountry == 'EH' ? 'selected' : '' }}>Western Sahara</option>
                                                <option value="YE" {{ $selectedCountry == 'YE' ? 'selected' : '' }}>Yemen</option>
                                                <option value="ZM" {{ $selectedCountry == 'ZM' ? 'selected' : '' }}>Zambia</option>
                                                <option value="ZW" {{ $selectedCountry == 'ZW' ? 'selected' : '' }}>Zimbabwe</option>
                                            </select>
                                            <label for="country">Country <span class="required">*</span></label>
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Address Line 1 -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" 
                                                   class="form-control @error('address1') is-invalid @enderror" 
                                                   id="address1" 
                                                   name="address1" 
                                                   placeholder="Address Line 1"
                                                   value="{{ old('address1', $lastOrder ? $lastOrder->address1 : '') }}">
                                            <label for="address1">Address Line 1 <span class="required">*</span></label>
                                            @error('address1')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Address Line 2 -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" 
                                                   class="form-control @error('address2') is-invalid @enderror" 
                                                   id="address2" 
                                                   name="address2" 
                                                   placeholder="Address Line 2"
                                                   value="{{ old('address2', $lastOrder ? $lastOrder->address2 : '') }}">
                                            <label for="address2">Address Line 2 (Optional)</label>
                                            @error('address2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- City/Town -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" 
                                                   class="form-control @error('city') is-invalid @enderror" 
                                                   id="city" 
                                                   name="city" 
                                                   placeholder="City/Town"
                                                   value="{{ old('city', $lastOrder ? $lastOrder->city : '') }}">
                                            <label for="city">City/Town <span class="required">*</span></label>
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Postal Code -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" 
                                                   class="form-control @error('post_code') is-invalid @enderror" 
                                                   id="post_code" 
                                                   name="post_code" 
                                                   placeholder="Postal Code"
                                                   value="{{ old('post_code', $lastOrder ? $lastOrder->post_code : '') }}">
                                            <label for="post_code">Postal Code</label>
                                            @error('post_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Additional Notes -->
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" 
                                                      id="notes" 
                                                      name="notes" 
                                                      placeholder="Order Notes (Optional)"
                                                      style="height: 100px">{{ old('notes') }}</textarea>
                                            <label for="notes">Order Notes (Optional)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Summary Column -->
                    <div class="col-lg-4 col-12">
                        <div class="order-summary-card">
                            <div class="card-header">
                                <h3><i class="fas fa-shopping-cart me-2"></i> Your Order</h3>
                            </div>
                            
                            <div class="card-body">
                                <!-- Cart Items Preview -->
                                @if(Helper::cartCount() > 0)
                                    <div class="cart-items-preview mb-3">
                                        <h5>Order Items</h5>
                                        @php $cart_items = Helper::getAllProductFromCart(); @endphp
                                        @foreach($cart_items as $item)
                                            <div class="cart-item-preview">
                                                <div class="item-info">
                                                    <span class="item-name">{{ $item->product->title }}</span>
                                                    <span class="item-quantity">x{{ $item->quantity }}</span>
                                                </div>
                                                <span class="item-price">${{ number_format($item->amount, 2) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <!-- Order Totals -->
                                <div class="order-totals">
                                    <div class="total-row">
                                        <span>Subtotal</span>
                                        <span class="order_subtotal" data-price="{{ Helper::totalCartPrice() }}">
                                            ${{ number_format(Helper::totalCartPrice(), 2) }}
                                        </span>
                                    </div>
                                    
                                    <div class="total-row shipping-row">
                                        <span>Shipping</span>
                                        <span class="shipping-cost">
                                            @if(count(Helper::shipping()) > 0 && Helper::cartCount() > 0)
                                                <select name="shipping" class="shipping-select" id="shipping_select">
                                                    <option value="">Select shipping method</option>
                                                    @foreach(Helper::shipping() as $shipping)
                                                        <option value="{{ $shipping->id }}" 
                                                                data-price="{{ $shipping->price }}"
                                                                {{ old('shipping') == $shipping->id ? 'selected' : '' }}>
                                                            {{ $shipping->type }}: ${{ number_format($shipping->price, 2) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <span class="free-shipping">Free Shipping</span>
                                            @endif
                                        </span>
                                    </div>
                                    
                                    @if(session('coupon'))
                                        <div class="total-row coupon-row">
                                            <span>Discount (Coupon)</span>
                                            <span class="coupon_price" data-price="{{ session('coupon')['value'] }}">
                                                -${{ number_format(session('coupon')['value'], 2) }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <div class="total-row grand-total">
                                        <span>Total</span>
                                        @php
                                            $total_amount = Helper::totalCartPrice();
                                            if(session('coupon')){
                                                $total_amount = $total_amount - session('coupon')['value'];
                                            }
                                        @endphp
                                        <span class="order_total_price" id="order_total_price">
                                            ${{ number_format($total_amount, 2) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Payment Methods -->
                                <div class="payment-methods mt-4">
                                    <h5>Payment Method</h5>
                                    <div class="payment-options">
                                        <div class="payment-option">
                                            <input type="radio" 
                                                   name="payment_method" 
                                                   id="payment_cod" 
                                                   value="cod"
                                                   {{ session('payment_method') == 'cod' ? 'checked' : '' }}
                                                   {{ old('payment_method') == 'cod' ? 'checked' : '' }}>
                                            <label for="payment_cod">
                                                <i class="fas fa-money-bill-wave"></i>
                                                Cash on Delivery
                                            </label>
                                        </div>
                                        
                                        <div class="payment-option">
                                            <input type="radio" 
                                                   name="payment_method" 
                                                   id="payment_paypal" 
                                                   value="paypal"
                                                   {{ session('payment_method') == 'paypal' ? 'checked' : '' }}
                                                   {{ old('payment_method') == 'paypal' ? 'checked' : '' }}>
                                            <label for="payment_paypal">
                                                <i class="fab fa-paypal"></i>
                                                PayPal
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Payment Methods Image -->
                                <div class="payment-methods-img mt-3">
                                    <img src="{{ asset('backend/img/payment-method.png') }}" alt="Payment Methods" class="img-fluid">
                                </div>
                                
                                <!-- Place Order Button -->
                                <div class="place-order-btn mt-4">
                                    <button type="submit" class="btn btn-primary btn-place-order">
                                        <i class="fas fa-check-circle me-2"></i> Place Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="modern-services section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="service-card">
                        <i class="fas fa-truck-fast"></i>
                        <h4>Free Shipping</h4>
                        <p>Orders over $100</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="service-card">
                        <i class="fas fa-undo-alt"></i>
                        <h4>Free Return</h4>
                        <p>Within 30 days returns</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="service-card">
                        <i class="fas fa-lock"></i>
                        <h4>Secure Payment</h4>
                        <p>100% secure payment</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="service-card">
                        <i class="fas fa-tag"></i>
                        <h4>Best Price</h4>
                        <p>Guaranteed price</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Newsletter Section -->
    <section class="modern-newsletter section">
        <div class="container">
            <div class="newsletter-wrapper">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="newsletter-content">
                            <h4><i class="fas fa-envelope"></i> Subscribe to our Newsletter</h4>
                            <p>Get 10% off your first purchase and stay updated with our latest offers!</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <form action="mail/mail.php" method="get" target="_blank" class="newsletter-form">
                            <div class="input-group">
                                <input type="email" 
                                       name="EMAIL" 
                                       class="form-control" 
                                       placeholder="Your email address" 
                                       required>
                                <button type="submit" class="btn btn-subscribe">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    /* Modern Checkout Styles */
    .modern-breadcrumbs {
        background: #f8f9fa;
        padding: 15px 0;
        margin-bottom: 30px;
    }
    
    .modern-breadcrumb {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        padding: 0;
        margin: 0;
        background: transparent;
    }
    
    .modern-breadcrumb .breadcrumb-item {
        color: #6c757d;
    }
    
    .modern-breadcrumb .breadcrumb-item a {
        color: #F7941D;
        text-decoration: none;
    }
    
    .modern-breadcrumb .breadcrumb-item.active {
        color: #333;
    }
    
    .modern-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        padding: 0 8px;
        color: #6c757d;
    }
    
    /* Billing Details Card */
    .billing-details-card,
    .order-summary-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .card-header {
        background: linear-gradient(135deg, #F7941D 0%, #F76E1C 100%);
        color: white;
        padding: 20px 25px;
        border-bottom: none;
    }
    
    .card-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }
    
    .card-header p {
        margin: 5px 0 0;
        font-size: 13px;
        opacity: 0.9;
    }
    
    .card-body {
        padding: 25px;
    }
    
    /* Form Styles */
    .form-floating {
        position: relative;
    }
    
    .form-floating > .form-control,
    .form-floating > .form-select {
        height: 58px;
        padding: 1rem 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .form-floating > .form-control:focus,
    .form-floating > .form-select:focus {
        border-color: #F7941D;
        box-shadow: 0 0 0 0.2rem rgba(247, 148, 29, 0.1);
    }
    
    .form-floating > label {
        padding: 1rem 0.75rem;
        color: #6c757d;
    }
    
    .required {
        color: #dc3545;
    }
    
    /* Order Totals */
    .order-totals {
        border-top: 1px solid #e5e7eb;
        padding-top: 15px;
    }
    
    .total-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .total-row:last-child {
        border-bottom: none;
    }
    
    .grand-total {
        font-size: 18px;
        font-weight: bold;
        color: #F7941D;
        padding-top: 15px;
        margin-top: 5px;
        border-top: 2px solid #F7941D;
    }
    
    .shipping-select {
        width: 100%;
        padding: 6px 10px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-size: 14px;
        background: white;
    }
    
    .free-shipping {
        color: #28a745;
        font-weight: 500;
    }
    
    /* Cart Items Preview */
    .cart-items-preview {
        max-height: 300px;
        overflow-y: auto;
        margin-bottom: 20px;
    }
    
    .cart-item-preview {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .item-info {
        display: flex;
        gap: 10px;
    }
    
    .item-name {
        font-size: 14px;
        font-weight: 500;
    }
    
    .item-quantity {
        font-size: 12px;
        color: #6c757d;
    }
    
    .item-price {
        font-weight: 500;
        color: #F7941D;
    }
    
    /* Payment Methods */
    .payment-options {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .payment-option {
        display: flex;
        align-items: center;
    }
    
    .payment-option input[type="radio"] {
        width: 18px;
        height: 18px;
        margin-right: 10px;
        cursor: pointer;
        accent-color: #F7941D;
    }
    
    .payment-option label {
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        font-weight: 500;
    }
    
    .payment-option label i {
        font-size: 18px;
        color: #F7941D;
    }
    
    .payment-methods-img {
        text-align: center;
        padding: 15px 0;
        border-top: 1px solid #e5e7eb;
    }
    
    .payment-methods-img img {
        max-height: 40px;
    }
    
    /* Place Order Button */
    .btn-place-order {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #F7941D 0%, #F76E1C 100%);
        border: none;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-place-order:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(247, 148, 29, 0.3);
    }
    
    /* Services Section */
    .modern-services {
        background: #f8f9fa;
        padding: 60px 0;
        margin-top: 50px;
    }
    
    .service-card {
        text-align: center;
        padding: 25px;
        background: white;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .service-card i {
        font-size: 40px;
        color: #F7941D;
        margin-bottom: 15px;
    }
    
    .service-card h4 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .service-card p {
        font-size: 14px;
        color: #6c757d;
        margin: 0;
    }
    
    /* Newsletter Section */
    .modern-newsletter {
        padding: 60px 0;
        background: linear-gradient(135deg, #F7941D 0%, #F76E1C 100%);
    }
    
    .newsletter-wrapper {
        background: rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 40px;
    }
    
    .newsletter-content h4 {
        color: white;
        font-size: 24px;
        margin-bottom: 10px;
    }
    
    .newsletter-content p {
        color: rgba(255,255,255,0.9);
        margin: 0;
    }
    
    .newsletter-form .input-group {
        background: white;
        border-radius: 50px;
        overflow: hidden;
    }
    
    .newsletter-form .form-control {
        border: none;
        padding: 12px 20px;
        font-size: 14px;
    }
    
    .newsletter-form .form-control:focus {
        box-shadow: none;
    }
    
    .btn-subscribe {
        background: #333;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 0;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-subscribe:hover {
        background: #F7941D;
        color: white;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .card-header,
        .card-body {
            padding: 20px;
        }
        
        .newsletter-wrapper {
            padding: 25px;
            text-align: center;
        }
        
        .newsletter-form {
            margin-top: 20px;
        }
        
        .service-card {
            padding: 20px;
        }
    }
    
    /* Loading State */
    .btn-place-order.loading {
        position: relative;
        pointer-events: none;
        opacity: 0.7;
    }
    
    .btn-place-order.loading::after {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        top: 50%;
        left: 50%;
        margin-left: -10px;
        margin-top: -10px;
        border: 2px solid #fff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 0.6s linear infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('frontend/js/nice-select/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() { 
        $("select.select2").select2(); 
    });
    $('select.nice-select').niceSelect();
    
    // Shipping cost calculation
    $(document).ready(function(){
        $('.shipping-select').change(function(){
            let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
            let subtotal = parseFloat($('.order_subtotal').data('price')); 
            let coupon = parseFloat($('.coupon_price').data('price')) || 0; 
            $('#order_total_price').text('$' + (subtotal + cost - coupon).toFixed(2));
        });
        
        // Auto-select COD if coming from product page
        @if(session('payment_method') == 'cod')
            $('#payment_cod').prop('checked', true);
        @endif
        
        // Form validation
        $('.checkout-form').on('submit', function(e) {
            let isValid = true;
            
            // Check required fields
            $(this).find('input[required], select[required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            // Check payment method selected
            if (!$('input[name="payment_method"]:checked').val()) {
                $('.payment-options').addClass('border-danger');
                isValid = false;
            } else {
                $('.payment-options').removeClass('border-danger');
            }
            
            if (!isValid) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $('.is-invalid:first').offset().top - 100
                }, 500);
                return false;
            }
            
            // Show loading state
            $('.btn-place-order').addClass('loading');
            return true;
        });
    });
    
    function showMe(box){
        var checkbox = document.getElementById('shipping').style.display;
        var vis = 'none';
        if(checkbox == "none"){
            vis = 'block';
        }
        if(checkbox == "block"){
            vis = "none";
        }
        document.getElementById(box).style.display = vis;
    }
</script>
@endpush