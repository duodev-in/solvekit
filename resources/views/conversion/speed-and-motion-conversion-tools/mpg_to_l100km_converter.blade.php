<x-tool-page-layout
    title="MPG to L/100km Converter - SolveKit"
    description="Professional fuel economy converter between miles per gallon and liters per 100 kilometers. Convert vehicle fuel efficiency for international automotive comparisons."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">MPG to L/100 km Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Enter Fuel Economy Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter fuel economy (e.g., 30)"
                                                                                        step="any"
                                                                                        min="0.1"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Value</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter vehicle fuel efficiency value</p>
                                                                            </div>

                                                                            <!-- From Unit -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    From Unit (Source)
                                                                                </label>
                                                                                <select 
                                                                                    id="fromUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <optgroup label="Imperial Fuel Economy">
                                                                                        <option value="mpg_us" selected>MPG (US) - Miles per US Gallon</option>
                                                                                        <option value="mpg_uk">MPG (UK) - Miles per Imperial Gallon</option>
                                                                                        <option value="gpm_us">GPM (US) - Gallons per 100 Miles</option>
                                                                                        <option value="gpm_uk">GPM (UK) - Gallons per 100 Miles</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Metric Fuel Economy">
                                                                                        <option value="l100km">L/100km - Liters per 100 Kilometers</option>
                                                                                        <option value="kmpl">km/L - Kilometers per Liter</option>
                                                                                        <option value="l100mi">L/100mi - Liters per 100 Miles</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Alternative Units">
                                                                                        <option value="mpg_diesel">MPG Diesel Equivalent</option>
                                                                                        <option value="mge">MPGe - Miles per Gallon Equivalent</option>
                                                                                        <option value="kwh_100mi">kWh/100mi - Electric Vehicle</option>
                                                                                        <option value="mi_kwh">mi/kWh - Electric Efficiency</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>

                                                                            <!-- To Unit -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    To Unit (Target)
                                                                                </label>
                                                                                <select 
                                                                                    id="toUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <optgroup label="Imperial Fuel Economy">
                                                                                        <option value="mpg_us">MPG (US) - Miles per US Gallon</option>
                                                                                        <option value="mpg_uk">MPG (UK) - Miles per Imperial Gallon</option>
                                                                                        <option value="gpm_us">GPM (US) - Gallons per 100 Miles</option>
                                                                                        <option value="gpm_uk">GPM (UK) - Gallons per 100 Miles</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Metric Fuel Economy">
                                                                                        <option value="l100km" selected>L/100km - Liters per 100 Kilometers</option>
                                                                                        <option value="kmpl">km/L - Kilometers per Liter</option>
                                                                                        <option value="l100mi">L/100mi - Liters per 100 Miles</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Alternative Units">
                                                                                        <option value="mpg_diesel">MPG Diesel Equivalent</option>
                                                                                        <option value="mge">MPGe - Miles per Gallon Equivalent</option>
                                                                                        <option value="kwh_100mi">kWh/100mi - Electric Vehicle</option>
                                                                                        <option value="mi_kwh">mi/kWh - Electric Efficiency</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>

                                                                            </div>

                                                                            <!-- Precision Control -->
                                                                            <div class="space-y-2 hidden">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Display Precision
                                                                                </label>
                                                                                <div class="flex items-center space-x-4">
                                                                                    <input 
                                                                                        type="range" 
                                                                                        id="precision" 
                                                                                        min="0" 
                                                                                        max="6" 
                                                                                        value="2" 
                                                                                        class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                                                                                    >
                                                                                    <span class="text-sm font-mono text-gray-700 min-w-[3rem]" id="precisionValue">2 digits</span>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Adjust decimal places for results</p>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-medium rounded-lg transition-colors duration-200"
                                                                                >
                                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                                    </svg>
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-7">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Fuel Economy Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl border-l-4 border-yellow-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Fuel Economy</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-yellow-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-yellow-600 hover:text-yellow-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Fuel Economy Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Imperial Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Imperial Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">MPG (US)</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="mpgUsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Miles per US gallon</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">MPG (UK)</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="mpgUkDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Miles per imperial gallon</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">GPM (US)</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="gpmUsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Gallons per 100 miles</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">MPGe</h5>
                                                                                            <div class="text-lg font-bold text-pink-600 font-mono" id="mgeDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Miles per gallon equivalent</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Metric Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Metric Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">L/100km</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="l100kmDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Liters per 100 kilometers</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-lg border-l-4 border-emerald-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">km/L</h5>
                                                                                            <div class="text-lg font-bold text-emerald-600 font-mono" id="kmplDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Kilometers per liter</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">L/100mi</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="l100miDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Liters per 100 miles</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-amber-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">kWh/100mi</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="kwh100miDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Electric vehicle efficiency</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>



                                                                    </div>
                                    </div>
                                </div>
                            </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Fuel Economy Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Fuel Economy Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="fuel-example px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-value="25" data-from="mpg_us" data-to="l100km">25 MPG</button>
                                                            <button type="button" class="fuel-example px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-value="8" data-from="l100km" data-to="mpg_us">8 L/100km</button>
                                                            <button type="button" class="fuel-example px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-value="50" data-from="mpg_us" data-to="l100km">50 MPG</button>
                                                            <button type="button" class="fuel-example px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-value="15" data-from="l100km" data-to="mpg_us">15 L/100km</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Fuel Economy Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Fuel Economy Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>Formula:</strong> 235.214 ÷ MPG = L/100km</div>
                                                        <div><strong>Imperial gal:</strong> 20% larger than US gal</div>
                                                        <div><strong>Excellent:</strong> &lt;6 L/100km (&gt;39 MPG)</div>
                                                        <div><strong>Good:</strong> 6-8 L/100km (29-39 MPG)</div>
                                                        <div><strong>Average:</strong> 8-12 L/100km (20-29 MPG)</div>
                                                        <div><strong>Poor:</strong> &gt;12 L/100km (&lt;20 MPG)</div>
                                                        <div><strong>Compact car:</strong> 6-8 L/100km</div>
                                                        <div><strong>Sedan:</strong> 7-10 L/100km</div>
                                                        <div><strong>SUV:</strong> 9-15 L/100km</div>
                                                        <div><strong>Pickup truck:</strong> 10-18 L/100km</div>
                                                        <div><strong>Hybrid:</strong> 4-6 L/100km</div>
                                                        <div><strong>Electric:</strong> 15-25 kWh/100mi</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputValue = document.getElementById('inputValue');
                        const fromUnit = document.getElementById('fromUnit');
                        const toUnit = document.getElementById('toUnit');
                        const precision = document.getElementById('precision');
                        const precisionValue = document.getElementById('precisionValue');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const mpgUsDisplay = document.getElementById('mpgUsDisplay');
                        const mpgUkDisplay = document.getElementById('mpgUkDisplay');
                        const gpmUsDisplay = document.getElementById('gpmUsDisplay');
                        const mgeDisplay = document.getElementById('mgeDisplay');
                        const l100kmDisplay = document.getElementById('l100kmDisplay');
                        const kmplDisplay = document.getElementById('kmplDisplay');
                        const l100miDisplay = document.getElementById('l100miDisplay');
                        const kwh100miDisplay = document.getElementById('kwh100miDisplay');
                        const copyResult = document.getElementById('copyResult');

                        const unitLabels = {
                            mpg_us: 'MPG (US)',
                            mpg_uk: 'MPG (UK)',
                            gpm_us: 'GPM (US)',
                            gpm_uk: 'GPM (UK)',
                            l100km: 'L/100 km',
                            kmpl: 'km/L',
                            l100mi: 'L/100 mi',
                            mpg_diesel: 'MPG Diesel',
                            mge: 'MPGe',
                            kwh_100mi: 'kWh/100 mi',
                            mi_kwh: 'mi/kWh'
                        };

                        const unitNames = {
                            mpg_us: 'Miles per US Gallon (MPG US)',
                            mpg_uk: 'Miles per Imperial Gallon (MPG UK)',
                            gpm_us: 'US Gallons per 100 Miles',
                            gpm_uk: 'Imperial Gallons per 100 Miles',
                            l100km: 'Liters per 100 Kilometers (L/100 km)',
                            kmpl: 'Kilometers per Liter (km/L)',
                            l100mi: 'Liters per 100 Miles (L/100 mi)',
                            mpg_diesel: 'MPG Diesel Equivalent',
                            mge: 'Miles per Gallon Equivalent (MPGe)',
                            kwh_100mi: 'Kilowatt-hours per 100 Miles (kWh/100 mi)',
                            mi_kwh: 'Miles per Kilowatt-hour (mi/kWh)'
                        };

                        function getPrecision() {
                            return parseInt(precision.value);
                        }

                        function formatNumber(num) {
                            if (!Number.isFinite(num)) {
                                return '--';
                            }
                            if (num === 0) {
                                return '0';
                            }
                            const abs = Math.abs(num);
                            if (abs >= 1e12 || abs < 1e-6) {
                                return parseFloat(num.toPrecision(5)).toExponential();
                            }
                            if (abs >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: getPrecision() });
                            }
                            return num.toLocaleString(undefined, { maximumSignificantDigits: 5 });
                        }

                        function withUnit(value, unit) {
                            return `${value} ${unitLabels[unit]}`;
                        }

                        // Core conversion functions
                        function mpgUsToL100km(mpg) {
                            return 235.214 / mpg;
                        }

                        function l100kmToMpgUs(l100km) {
                            return 235.214 / l100km;
                        }

                        function mpgUsToMpgUk(mpg) {
                            return mpg * 1.201; // Imperial gallon is ~20% larger
                        }

                        function mpgUkToMpgUs(mpg) {
                            return mpg / 1.201;
                        }

                        function convertFuelEconomy(value, fromUnit, toUnit) {
                            // Convert everything to MPG (US) first, then to target
                            let mpgUs;
                            
                            switch(fromUnit) {
                                case 'mpg_us':
                                    mpgUs = value;
                                    break;
                                case 'mpg_uk':
                                    mpgUs = mpgUkToMpgUs(value);
                                    break;
                                case 'l100km':
                                    mpgUs = l100kmToMpgUs(value);
                                    break;
                                case 'kmpl':
                                    mpgUs = value * 2.352; // km/L to MPG conversion
                                    break;
                                case 'gpm_us':
                                    mpgUs = 100 / value; // GPM is inverse of MPG
                                    break;
                                case 'gpm_uk':
                                    mpgUs = mpgUkToMpgUs(100 / value);
                                    break;
                                case 'l100mi':
                                    mpgUs = 378.541 / value; // L/100mi to MPG
                                    break;
                                case 'mge':
                                    mpgUs = value; // MPGe is equivalent to MPG for conversion
                                    break;
                                case 'kwh_100mi':
                                    mpgUs = 3370.5 / value; // 33.705 kWh per gallon equivalent (EPA)
                                    break;
                                case 'mi_kwh':
                                    mpgUs = value * 33.705;
                                    break;
                                default:
                                    mpgUs = value;
                            }
                            
                            // Convert from MPG (US) to target unit
                            switch(toUnit) {
                                case 'mpg_us':
                                    return mpgUs;
                                case 'mpg_uk':
                                    return mpgUsToMpgUk(mpgUs);
                                case 'l100km':
                                    return mpgUsToL100km(mpgUs);
                                case 'kmpl':
                                    return mpgUs / 2.352;
                                case 'gpm_us':
                                    return 100 / mpgUs;
                                case 'gpm_uk':
                                    return 100 / mpgUsToMpgUk(mpgUs);
                                case 'l100mi':
                                    return 378.541 / mpgUs;
                                case 'mge':
                                    return mpgUs;
                                case 'kwh_100mi':
                                    return 3370.5 / mpgUs;
                                case 'mi_kwh':
                                    return mpgUs / 33.705;
                                default:
                                    return mpgUs;
                            }
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const from = fromUnit.value;
                            const to = toUnit.value;

                            if (!isNaN(inputVal) && inputVal > 0) {
                                const result = convertFuelEconomy(inputVal, from, to);
                                
                                // Update primary output
                                output.textContent = withUnit(formatNumber(result), to);
                                resultTitle.textContent = unitNames[to];
                                resultDescription.textContent = `${withUnit(formatNumber(inputVal), from)} = ${withUnit(formatNumber(result), to)}`;

                                // Update all unit displays
                                mpgUsDisplay.textContent = formatNumber(convertFuelEconomy(inputVal, from, 'mpg_us'));
                                mpgUkDisplay.textContent = formatNumber(convertFuelEconomy(inputVal, from, 'mpg_uk'));
                                gpmUsDisplay.textContent = formatNumber(convertFuelEconomy(inputVal, from, 'gpm_us'));
                                mgeDisplay.textContent = formatNumber(convertFuelEconomy(inputVal, from, 'mge'));
                                l100kmDisplay.textContent = formatNumber(convertFuelEconomy(inputVal, from, 'l100km'));
                                kmplDisplay.textContent = formatNumber(convertFuelEconomy(inputVal, from, 'kmpl'));
                                l100miDisplay.textContent = formatNumber(convertFuelEconomy(inputVal, from, 'l100mi'));
                                kwh100miDisplay.textContent = formatNumber(convertFuelEconomy(inputVal, from, 'kwh_100mi'));

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Converted Fuel Economy';
                            resultDescription.textContent = 'Converted result';
                            mpgUsDisplay.textContent = '--';
                            mpgUkDisplay.textContent = '--';
                            gpmUsDisplay.textContent = '--';
                            mgeDisplay.textContent = '--';
                            l100kmDisplay.textContent = '--';
                            kmplDisplay.textContent = '--';
                            l100miDisplay.textContent = '--';
                            kwh100miDisplay.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            fromUnit.value = 'mpg_us';
                            toUnit.value = 'l100km';
                            precision.value = 2;
                            precisionValue.textContent = '2 digits';
                            clearOutputs();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        fromUnit.addEventListener('change', convert);
                        toUnit.addEventListener('change', convert);

                        precision.addEventListener('input', function() {
                            precisionValue.textContent = this.value + ' digits';
                            convert();
                        });

                        clearButton.addEventListener('click', clearAll);

                        // Copy functionality
                        copyResult.addEventListener('click', function() {
                            const text = output.textContent;
                            if (text !== '--') {
                                navigator.clipboard.writeText(text).then(() => {
                                    this.textContent = 'Copied!';
                                    setTimeout(() => {
                                        this.textContent = 'Copy Result';
                                    }, 2000);
                                });
                            }
                        });

                        // Example buttons
                        const fuelExamples = document.querySelectorAll('.fuel-example');
                        fuelExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const from = this.getAttribute('data-from');
                                const to = this.getAttribute('data-to');
                                
                                inputValue.value = value;
                                fromUnit.value = from;
                                toUnit.value = to;
                                convert();
                                
                                // Update button styles
                                fuelExamples.forEach(btn => btn.classList.remove('bg-yellow-100', 'text-yellow-700'));
                                fuelExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-yellow-100', 'text-yellow-700');
                            });
                        });

                        // Initialize
                        precisionValue.textContent = precision.value + ' digits';
                        inputValue.focus();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
