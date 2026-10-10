<x-tool-page-layout
    title="Natural Gas Converter - ConvertPro"
    description="Professional natural gas converter for volume and energy units. Convert between cubic feet, therms, BTU, cubic meters, and other gas measurement units for energy calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Natural Gas Converter</h1>
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
                                                                                    Enter Gas Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter gas value (e.g., 1000)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Value</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter natural gas measurement value</p>
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
                                                                                    <optgroup label="Volume Units (Imperial)">
                                                                                        <option value="cubic_feet" selected>Cubic Feet (ft³)</option>
                                                                                        <option value="ccf">CCF (Hundred Cubic Feet)</option>
                                                                                        <option value="mcf">MCF (Thousand Cubic Feet)</option>
                                                                                        <option value="mmcf">MMCF (Million Cubic Feet)</option>
                                                                                        <option value="bcf">BCF (Billion Cubic Feet)</option>
                                                                                        <option value="tcf">TCF (Trillion Cubic Feet)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Volume Units (Metric)">
                                                                                        <option value="cubic_meters">Cubic Meters (m³)</option>
                                                                                        <option value="liters">Liters (L)</option>
                                                                                        <option value="cubic_centimeters">Cubic Centimeters (cm³)</option>
                                                                                        <option value="normal_cubic_meters">Normal Cubic Meters (Nm³)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Energy Units">
                                                                                        <option value="therms">Therms</option>
                                                                                        <option value="dekatherms">Dekatherms (Dth)</option>
                                                                                        <option value="btu">BTU (British Thermal Units)</option>
                                                                                        <option value="mmbtu">MMBTU (Million BTU)</option>
                                                                                        <option value="joules">Joules (J)</option>
                                                                                        <option value="kwh">Kilowatt Hours (kWh)</option>
                                                                                        <option value="mwh">Megawatt Hours (MWh)</option>
                                                                                        <option value="calories">Calories (cal)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Mass Units">
                                                                                        <option value="pounds">Pounds (lb)</option>
                                                                                        <option value="kilograms">Kilograms (kg)</option>
                                                                                        <option value="tonnes">Tonnes (t)</option>
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
                                                                                    <optgroup label="Volume Units (Imperial)">
                                                                                        <option value="cubic_feet">Cubic Feet (ft³)</option>
                                                                                        <option value="ccf" selected>CCF (Hundred Cubic Feet)</option>
                                                                                        <option value="mcf">MCF (Thousand Cubic Feet)</option>
                                                                                        <option value="mmcf">MMCF (Million Cubic Feet)</option>
                                                                                        <option value="bcf">BCF (Billion Cubic Feet)</option>
                                                                                        <option value="tcf">TCF (Trillion Cubic Feet)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Volume Units (Metric)">
                                                                                        <option value="cubic_meters">Cubic Meters (m³)</option>
                                                                                        <option value="liters">Liters (L)</option>
                                                                                        <option value="cubic_centimeters">Cubic Centimeters (cm³)</option>
                                                                                        <option value="normal_cubic_meters">Normal Cubic Meters (Nm³)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Energy Units">
                                                                                        <option value="therms">Therms</option>
                                                                                        <option value="dekatherms">Dekatherms (Dth)</option>
                                                                                        <option value="btu">BTU (British Thermal Units)</option>
                                                                                        <option value="mmbtu">MMBTU (Million BTU)</option>
                                                                                        <option value="joules">Joules (J)</option>
                                                                                        <option value="kwh">Kilowatt Hours (kWh)</option>
                                                                                        <option value="mwh">Megawatt Hours (MWh)</option>
                                                                                        <option value="calories">Calories (cal)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Mass Units">
                                                                                        <option value="pounds">Pounds (lb)</option>
                                                                                        <option value="kilograms">Kilograms (kg)</option>
                                                                                        <option value="tonnes">Tonnes (t)</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>

                                                                            </div>

                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Gas Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-xl border-l-4 border-indigo-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Gas Value</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-indigo-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-indigo-600 hover:text-indigo-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Gas Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Volume Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Volume Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Cubic Feet</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="cubicFeetDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Standard volume unit</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">CCF</h5>
                                                                                            <div class="text-lg font-bold text-cyan-600 font-mono" id="ccfDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Hundred cubic feet</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Cubic Meters</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="cubicMetersDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Metric volume unit</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">MCF</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="mcfDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Thousand cubic feet</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Energy Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Energy Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Therms</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="thermsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Common energy unit</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">BTU</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="btuDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">British thermal units</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">kWh</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="kwhDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Kilowatt hours</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">MMBTU</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="mmbtuDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Million BTU</div>
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
                <!-- Quick Gas Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Gas Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="gas-example px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors" data-value="1000" data-from="cubic_feet" data-to="therms">1000 ft³</button>
                                                            <button type="button" class="gas-example px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors" data-value="1" data-from="ccf" data-to="therms">1 CCF</button>
                                                            <button type="button" class="gas-example px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors" data-value="1" data-from="therms" data-to="btu">1 Therm</button>
                                                            <button type="button" class="gas-example px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors" data-value="1" data-from="cubic_meters" data-to="cubic_feet">1 m³</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Gas Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Natural Gas Unit Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 CCF</strong> = 100 ft³</div>
                                                        <div><strong>1 MCF</strong> = 1,000 ft³</div>
                                                        <div><strong>1 Therm</strong> = 100,000 BTU</div>
                                                        <div><strong>1 Dth</strong> = 10 Therms</div>
                                                        <div><strong>1 ft³</strong> ≈ 1,030 BTU</div>
                                                        <div><strong>1 m³</strong> = 35.314 ft³</div>
                                                        <div><strong>1 MMBTU</strong> = 1,000,000 BTU</div>
                                                        <div><strong>1 kWh</strong> = 3,412 BTU</div>
                                                        <div><strong>Standard temp:</strong> 60°F (15.6°C)</div>
                                                        <div><strong>Standard pressure:</strong> 14.7 psia</div>
                                                        <div><strong>Specific gravity:</strong> 0.55-0.65</div>
                                                        <div><strong>Heating value:</strong> 950-1,150 BTU/ft³</div>
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
                        const clearButton = document.getElementById('clearButton');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const cubicFeetDisplay = document.getElementById('cubicFeetDisplay');
                        const ccfDisplay = document.getElementById('ccfDisplay');
                        const cubicMetersDisplay = document.getElementById('cubicMetersDisplay');
                        const mcfDisplay = document.getElementById('mcfDisplay');
                        const thermsDisplay = document.getElementById('thermsDisplay');
                        const btuDisplay = document.getElementById('btuDisplay');
                        const kwhDisplay = document.getElementById('kwhDisplay');
                        const mmbtuDisplay = document.getElementById('mmbtuDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Gas conversion multipliers (to cubic feet as base)
                        const gasMultipliers = {
                            // Volume units
                            cubic_feet: 1,
                            ccf: 100,
                            mcf: 1000,
                            mmcf: 1000000,
                            bcf: 1000000000,
                            tcf: 1000000000000,
                            cubic_meters: 35.314667,
                            liters: 0.035314667,
                            cubic_centimeters: 0.000035314667,
                            normal_cubic_meters: 35.314667,
                            
                            // Energy units (assuming 1030 BTU/ft³)
                            therms: 100000 / 1030, // 100,000 BTU / 1030 BTU/ft³
                            dekatherms: 1000000 / 1030,
                            btu: 1 / 1030, // 1 BTU / 1030 BTU/ft³
                            mmbtu: 1000000 / 1030,
                            joules: 0.00000092021, // 1 J ≈ 0.000947817 BTU / 1030 BTU/ft³
                            kwh: 3412.142 / 1030, // 3412.142 BTU / 1030 BTU/ft³
                            mwh: 3412142 / 1030,
                            calories: 0.0000038527, // 1 cal ≈ 0.0039683 BTU / 1030 BTU/ft³
                            
                            // Mass units (assuming 0.6 specific gravity, ≈0.0459 lb/ft³)
                            pounds: 21.786,
                            kilograms: 48.03,
                            tonnes: 48030
                        };

                        const unitLabels = {
                            cubic_feet: 'ft³',
                            ccf: 'CCF',
                            mcf: 'MCF',
                            mmcf: 'MMCF',
                            bcf: 'BCF',
                            tcf: 'TCF',
                            cubic_meters: 'm³',
                            liters: 'L',
                            cubic_centimeters: 'cm³',
                            normal_cubic_meters: 'Nm³',
                            therms: 'therms',
                            dekatherms: 'Dth',
                            btu: 'BTU',
                            mmbtu: 'MMBTU',
                            joules: 'J',
                            kwh: 'kWh',
                            mwh: 'MWh',
                            calories: 'cal',
                            pounds: 'lb',
                            kilograms: 'kg',
                            tonnes: 't'
                        };

                        const heatingValueBtuPerCubicFoot = 1030;

                        function unitLabel(unit, amount) {
                            return unit === 'therms' && amount === 1 ? 'therm' : unitLabels[unit];
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
                                return num.toLocaleString(undefined, { maximumFractionDigits: 3 });
                            }
                            return num.toLocaleString(undefined, { maximumSignificantDigits: 5 });
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const from = fromUnit.value;
                            const to = toUnit.value;

                            if (!isNaN(inputVal) && inputVal >= 0) {
                                
                                // Convert input to cubic feet first
                                const inputInCubicFeet = inputVal * gasMultipliers[from];
                                
                                // Convert cubic feet to target unit
                                const result = inputInCubicFeet / gasMultipliers[to];
                                
                                // Update primary output
                                output.textContent = formatNumber(result) + ' ' + unitLabel(to, result);
                                resultTitle.textContent = toUnit.options[toUnit.selectedIndex].text;
                                resultDescription.textContent = `${formatNumber(inputVal)} ${unitLabel(from, inputVal)} = ${formatNumber(result)} ${unitLabel(to, result)}`;

                                // Convert to all common units and display
                                const cubicFeet = inputInCubicFeet;
                                cubicFeetDisplay.textContent = formatNumber(cubicFeet);
                                ccfDisplay.textContent = formatNumber(cubicFeet / gasMultipliers.ccf);
                                cubicMetersDisplay.textContent = formatNumber(cubicFeet / gasMultipliers.cubic_meters);
                                mcfDisplay.textContent = formatNumber(cubicFeet / gasMultipliers.mcf);
                                thermsDisplay.textContent = formatNumber(cubicFeet / gasMultipliers.therms);
                                btuDisplay.textContent = formatNumber(cubicFeet * heatingValueBtuPerCubicFoot);
                                kwhDisplay.textContent = formatNumber(cubicFeet / gasMultipliers.kwh);
                                mmbtuDisplay.textContent = formatNumber((cubicFeet * heatingValueBtuPerCubicFoot) / 1000000);

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Converted Gas Value';
                            resultDescription.textContent = 'Converted result';
                            cubicFeetDisplay.textContent = '--';
                            ccfDisplay.textContent = '--';
                            cubicMetersDisplay.textContent = '--';
                            mcfDisplay.textContent = '--';
                            thermsDisplay.textContent = '--';
                            btuDisplay.textContent = '--';
                            kwhDisplay.textContent = '--';
                            mmbtuDisplay.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            fromUnit.value = 'cubic_feet';
                            toUnit.value = 'ccf';
                            clearOutputs();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        fromUnit.addEventListener('change', convert);
                        toUnit.addEventListener('change', convert);

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
                        const gasExamples = document.querySelectorAll('.gas-example');
                        gasExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const from = this.getAttribute('data-from');
                                const to = this.getAttribute('data-to');
                                
                                inputValue.value = value;
                                fromUnit.value = from;
                                toUnit.value = to;
                                convert();
                                
                                // Update button styles
                                gasExamples.forEach(btn => btn.classList.remove('bg-indigo-100', 'text-indigo-700'));
                                gasExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-indigo-100', 'text-indigo-700');
                            });
                        });

                        // Initialize
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
