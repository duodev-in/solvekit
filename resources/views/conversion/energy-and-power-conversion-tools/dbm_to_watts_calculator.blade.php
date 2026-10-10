<x-tool-page-layout
    title="dBm to Watts Calculator - ConvertPro"
    description="Professional dBm to watts calculator for RF power conversion. Convert decibel-milliwatts to watts for radio frequency and telecommunications applications."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">dBm to Watts Calculator</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                                            <!-- Power Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="powerValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Power Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="powerValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter power (e.g., 30)"
                                                                                        step="any"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Power</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter RF power value for conversion</p>
                                                                            </div>

                                                                            <!-- Power Unit -->
                                                                            <div class="space-y-2">
                                                                                <label for="powerUnit" class="block text-sm font-semibold text-gray-700">
                                                                                    Power Unit
                                                                                </label>
                                                                                <select 
                                                                                    id="powerUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <optgroup label="Decibel Units">
                                                                                        <option value="dbm" selected>dBm - Decibel-milliwatts</option>
                                                                                        <option value="dbw">dBW - Decibel-watts</option>
                                                                                        <option value="dbu">dBu - Decibel-microvolts</option>
                                                                                        <option value="dbv">dBV - Decibel-volts</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Linear Power Units">
                                                                                        <option value="watt">Watt (W)</option>
                                                                                        <option value="milliwatt">Milliwatt (mW)</option>
                                                                                        <option value="microwatt">Microwatt (μW)</option>
                                                                                        <option value="nanowatt">Nanowatt (nW)</option>
                                                                                        <option value="picowatt">Picowatt (pW)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Specialized Units">
                                                                                        <option value="eirp">EIRP (Effective Isotropic Radiated Power)</option>
                                                                                        <option value="erp">ERP (Effective Radiated Power)</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>
                                                                            </div>

                                                                            <!-- Reference Impedance -->
                                                                            <div class="space-y-2">
                                                                                <label for="impedance" class="block text-sm font-semibold text-gray-700">
                                                                                    Reference Impedance (Ω)
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="impedance" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter impedance (default: 50)"
                                                                                        step="any"
                                                                                        min="1"
                                                                                        value="50"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Ohms</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">System impedance (50Ω standard for RF systems)</p>
                                                                            </div>

                                                                            <!-- Application Context -->
                                                                            <div class="space-y-2 hidden">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Application Context
                                                                                </label>
                                                                                <select 
                                                                                    id="applicationContext" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="">General RF calculation</option>
                                                                                    <option value="cellular">Cellular/Mobile Communications</option>
                                                                                    <option value="wifi">WiFi/Wireless LAN</option>
                                                                                    <option value="broadcast">Broadcasting</option>
                                                                                    <option value="radar">Radar Systems</option>
                                                                                    <option value="satellite">Satellite Communications</option>
                                                                                    <option value="test_equipment">Test Equipment</option>
                                                                                </select>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">RF Power Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-l-4 border-blue-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Power</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Power result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-blue-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-blue-600 hover:text-blue-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Power Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Decibel Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Decibel Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">dBm</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="dbmDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Decibel-milliwatts</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">dBW</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="dbwDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Decibel-watts</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">dBu</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="dbuDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Decibel-microvolts</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Linear Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Linear Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Watts</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="wattsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">SI power unit</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-lg border-l-4 border-emerald-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Milliwatts</h5>
                                                                                            <div class="text-lg font-bold text-emerald-600 font-mono" id="milliwattsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">1/1000 watts</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Microwatts</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="microwattsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">1/1,000,000 watts</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- RF Parameters -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">RF Parameters</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Voltage (RMS)</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="voltageDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Root mean square</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Current (RMS)</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="currentDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Root mean square</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Power Class</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="powerClassDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">RF power category</div>
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
                <!-- Quick Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick RF Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-power="30" data-unit="dbm">30 dBm</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-power="0" data-unit="dbm">0 dBm</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-power="-30" data-unit="dbm">-30 dBm</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-power="1" data-unit="watt">1 W</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Reference Information -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">RF Power Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>0 dBm</strong> = 1 mW</div>
                                                        <div><strong>30 dBm</strong> = 1 W</div>
                                                        <div><strong>-30 dBm</strong> = 1 μW</div>
                                                        <div><strong>-60 dBm</strong> = 1 nW</div>
                                                        <div><strong>WiFi router</strong> ≈ 20 dBm</div>
                                                        <div><strong>Cell phone</strong> ≈ 23 dBm</div>
                                                        <div><strong>Bluetooth</strong> ≈ 0 dBm</div>
                                                        <div><strong>FM radio</strong> ≈ 50 dBm</div>
                                                        <div><strong>GPS signal</strong> ≈ -130 dBm</div>
                                                        <div><strong>Radar</strong> ≈ 60 dBm</div>
                                                        <div><strong>Microwave oven</strong> ≈ 37 dBm</div>
                                                        <div><strong>Satellite uplink</strong> ≈ 40 dBm</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const powerValue = document.getElementById('powerValue');
                        const powerUnit = document.getElementById('powerUnit');
                        const impedance = document.getElementById('impedance');
                        const applicationContext = document.getElementById('applicationContext');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const dbmDisplay = document.getElementById('dbmDisplay');
                        const dbwDisplay = document.getElementById('dbwDisplay');
                        const dbuDisplay = document.getElementById('dbuDisplay');
                        const wattsDisplay = document.getElementById('wattsDisplay');
                        const milliwattsDisplay = document.getElementById('milliwattsDisplay');
                        const microwattsDisplay = document.getElementById('microwattsDisplay');
                        const voltageDisplay = document.getElementById('voltageDisplay');
                        const currentDisplay = document.getElementById('currentDisplay');
                        const powerClassDisplay = document.getElementById('powerClassDisplay');
                        const copyResult = document.getElementById('copyResult');

                        function formatNumber(num, decimals = 3) {
                            const absolute = Math.abs(num);
                            if (absolute >= 1e15 || (absolute < 1e-6 && num !== 0)) {
                                return num.toExponential(3).replace(/\.?0+e/, 'e');
                            } else if (absolute >= 1e6) {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                            } else if (absolute < 1 && num !== 0) {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                            } else {
                                return num.toLocaleString(undefined, { maximumFractionDigits: decimals, minimumFractionDigits: 0 });
                            }
                        }

                        const unitSymbols = {
                            dbm: 'dBm',
                            dbw: 'dBW',
                            dbu: 'dBu',
                            dbv: 'dBV',
                            watt: 'W',
                            milliwatt: 'mW',
                            microwatt: 'μW',
                            nanowatt: 'nW',
                            picowatt: 'pW',
                            eirp: 'W EIRP',
                            erp: 'W ERP'
                        };

                        function dbmToWatts(dbm) {
                            return Math.pow(10, (dbm - 30) / 10);
                        }

                        function wattsToDbm(watts) {
                            return 10 * Math.log10(watts * 1000);
                        }

                        function getPowerClass(dbm) {
                            if (dbm < -60) return 'Ultra-low power';
                            if (dbm < -30) return 'Low power';
                            if (dbm < 0) return 'Medium-low power';
                            if (dbm < 20) return 'Medium power';
                            if (dbm < 30) return 'High power';
                            if (dbm < 50) return 'Very high power';
                            return 'Extreme power';
                        }

                        function convertToWatts(value, unit) {
                            switch(unit) {
                                case 'dbm':
                                    return dbmToWatts(value);
                                case 'dbw':
                                    return Math.pow(10, value / 10);
                                case 'dbu':
                                    // dBu to watts (assuming 50 ohm impedance)
                                    const voltage = Math.pow(10, (value - 90) / 20);
                                    return Math.pow(voltage, 2) / 50;
                                case 'dbv':
                                    // dBV to watts (assuming 50 ohm impedance)
                                    const voltageDbv = Math.pow(10, value / 20);
                                    return Math.pow(voltageDbv, 2) / 50;
                                case 'watt':
                                    return value;
                                case 'milliwatt':
                                    return value / 1000;
                                case 'microwatt':
                                    return value / 1000000;
                                case 'nanowatt':
                                    return value / 1000000000;
                                case 'picowatt':
                                    return value / 1000000000000;
                                case 'eirp':
                                case 'erp':
                                    return value; // Treat as watts for conversion
                                default:
                                    return value;
                            }
                        }

                        function calculate() {
                            const power = parseFloat(powerValue.value);
                            const unit = powerUnit.value;
                            const z = parseFloat(impedance.value) || 50;

                            const watts = isNaN(power) ? NaN : convertToWatts(power, unit);

                            if (!isNaN(power) && watts > 0 && Number.isFinite(watts)) {
                                const dbm = wattsToDbm(watts);
                                
                                // Update primary output
                                let primaryResult;
                                if (unit === 'dbm' || unit === 'dbw' || unit === 'dbu' || unit === 'dbv') {
                                    primaryResult = formatNumber(watts) + ' W';
                                    resultTitle.textContent = 'Power in Watts (W)';
                                } else {
                                    primaryResult = formatNumber(dbm) + ' dBm';
                                    resultTitle.textContent = 'Power in Decibel-Milliwatts (dBm)';
                                }
                                output.textContent = primaryResult;
                                resultDescription.textContent = `${power} ${unitSymbols[unit]} = ${primaryResult}`;

                                // Display in all units
                                dbmDisplay.textContent = formatNumber(dbm) + ' dBm';
                                dbwDisplay.textContent = formatNumber(dbm - 30) + ' dBW';
                                
                                // Calculate dBu (referenced to 775mV RMS across impedance)
                                const voltage = Math.sqrt(watts * z);
                                const dbu = 20 * Math.log10(voltage / 0.775);
                                dbuDisplay.textContent = formatNumber(dbu) + ' dBu';

                                wattsDisplay.textContent = formatNumber(watts) + ' W';
                                milliwattsDisplay.textContent = formatNumber(watts * 1000) + ' mW';
                                microwattsDisplay.textContent = formatNumber(watts * 1000000) + ' μW';

                                // RF parameters
                                voltageDisplay.textContent = formatNumber(voltage) + ' V';
                                const current = voltage / z;
                                currentDisplay.textContent = formatNumber(current) + ' A';
                                powerClassDisplay.textContent = getPowerClass(dbm);


                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Converted Power';
                            resultDescription.textContent = 'Power result';
                            dbmDisplay.textContent = '--';
                            dbwDisplay.textContent = '--';
                            dbuDisplay.textContent = '--';
                            wattsDisplay.textContent = '--';
                            milliwattsDisplay.textContent = '--';
                            microwattsDisplay.textContent = '--';
                            voltageDisplay.textContent = '--';
                            currentDisplay.textContent = '--';
                            powerClassDisplay.textContent = '--';
                        }

                        function clearAll() {
                            powerValue.value = '';
                            powerUnit.value = 'dbm';
                            impedance.value = '50';
                            applicationContext.value = '';
                            clearOutputs();
                            powerValue.focus();
                        }

                        // Event listeners
                        powerValue.addEventListener('input', calculate);
                        powerUnit.addEventListener('change', calculate);
                        impedance.addEventListener('input', calculate);
                        applicationContext.addEventListener('change', calculate);

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
                        const exampleBtns = document.querySelectorAll('.example-btn');
                        exampleBtns.forEach(button => {
                            button.addEventListener('click', function() {
                                const power = this.getAttribute('data-power');
                                const unit = this.getAttribute('data-unit');
                                
                                powerValue.value = power;
                                powerUnit.value = unit;
                                calculate();
                                
                                // Update button styles
                                exampleBtns.forEach(btn => btn.classList.remove('bg-blue-100', 'text-blue-700'));
                                exampleBtns.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-blue-100', 'text-blue-700');
                            });
                        });

                        // Initialize
                        powerValue.focus();

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
