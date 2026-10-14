<x-tool-page-layout
    title="Density Conversion Calculator - SolveKit"
    description="Professional density conversion calculator for mass per unit volume. Convert between kg/m³, g/cm³, lb/ft³, and other density units for materials and substances."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Density Conversion</h1>
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
                                                                                    Enter Density Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter density value (e.g., 1000)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Value</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter any positive density value</p>
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
                                                                                    <optgroup label="Metric System">
                                                                                        <option value="kg_m3" selected>kg/m³ (kilograms per cubic meter)</option>
                                                                                        <option value="g_cm3">g/cm³ (grams per cubic centimeter)</option>
                                                                                        <option value="g_ml">g/mL (grams per milliliter)</option>
                                                                                        <option value="mg_cm3">mg/cm³ (milligrams per cubic centimeter)</option>
                                                                                        <option value="kg_l">kg/L (kilograms per liter)</option>
                                                                                        <option value="g_l">g/L (grams per liter)</option>
                                                                                        <option value="mg_l">mg/L (milligrams per liter)</option>
                                                                                        <option value="t_m3">t/m³ (tonnes per cubic meter)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Imperial System">
                                                                                        <option value="lb_ft3">lb/ft³ (pounds per cubic foot)</option>
                                                                                        <option value="lb_in3">lb/in³ (pounds per cubic inch)</option>
                                                                                        <option value="oz_in3">oz/in³ (ounces per cubic inch)</option>
                                                                                        <option value="lb_gal_us">lb/gal (US) (pounds per US gallon)</option>
                                                                                        <option value="lb_gal_uk">lb/gal (UK) (pounds per UK gallon)</option>
                                                                                        <option value="slug_ft3">slug/ft³ (slugs per cubic foot)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Specialized Units">
                                                                                        <option value="specific_gravity">Specific Gravity (relative to water)</option>
                                                                                        <option value="api_gravity">API Gravity (petroleum industry)</option>
                                                                                        <option value="baume_heavy">Baumé Heavy (heavy liquids)</option>
                                                                                        <option value="baume_light">Baumé Light (light liquids)</option>
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
                                                                                    <optgroup label="Metric System">
                                                                                        <option value="kg_m3">kg/m³ (kilograms per cubic meter)</option>
                                                                                        <option value="g_cm3" selected>g/cm³ (grams per cubic centimeter)</option>
                                                                                        <option value="g_ml">g/mL (grams per milliliter)</option>
                                                                                        <option value="mg_cm3">mg/cm³ (milligrams per cubic centimeter)</option>
                                                                                        <option value="kg_l">kg/L (kilograms per liter)</option>
                                                                                        <option value="g_l">g/L (grams per liter)</option>
                                                                                        <option value="mg_l">mg/L (milligrams per liter)</option>
                                                                                        <option value="t_m3">t/m³ (tonnes per cubic meter)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Imperial System">
                                                                                        <option value="lb_ft3">lb/ft³ (pounds per cubic foot)</option>
                                                                                        <option value="lb_in3">lb/in³ (pounds per cubic inch)</option>
                                                                                        <option value="oz_in3">oz/in³ (ounces per cubic inch)</option>
                                                                                        <option value="lb_gal_us">lb/gal (US) (pounds per US gallon)</option>
                                                                                        <option value="lb_gal_uk">lb/gal (UK) (pounds per UK gallon)</option>
                                                                                        <option value="slug_ft3">slug/ft³ (slugs per cubic foot)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Specialized Units">
                                                                                        <option value="specific_gravity">Specific Gravity (relative to water)</option>
                                                                                        <option value="api_gravity">API Gravity (petroleum industry)</option>
                                                                                        <option value="baume_heavy">Baumé Heavy (heavy liquids)</option>
                                                                                        <option value="baume_light">Baumé Light (light liquids)</option>
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
                                                                                        max="10" 
                                                                                        value="4" 
                                                                                        class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                                                                                    >
                                                                                    <span class="text-sm font-mono text-gray-700 min-w-[3rem]" id="precisionValue">4 digits</span>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Adjust decimal places for calculations</p>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Density Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-l-4 border-green-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Density</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-green-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-green-600 hover:text-green-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Common Density Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Metric Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Metric Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">kg/m³</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="kgm3Display">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Standard SI unit</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">g/cm³</h5>
                                                                                            <div class="text-lg font-bold text-cyan-600 font-mono" id="gcm3Display">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Common lab unit</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">g/mL</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="gmlDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Liquid measurements</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-emerald-50 to-green-50 rounded-lg border-l-4 border-emerald-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">kg/L</h5>
                                                                                            <div class="text-lg font-bold text-emerald-600 font-mono" id="kglDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Bulk materials</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Imperial Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Imperial Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">lb/ft³</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="lbft3Display">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Construction materials</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">lb/in³</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="lbin3Display">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">High density materials</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">lb/gal (US)</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="lbgalusDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Liquid fuels</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Specific Gravity</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="sgDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Relative to water</div>
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
                <!-- Quick Density Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Density Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="density-example px-3 py-2 text-sm bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors" data-value="1000" data-from="kg_m3" data-to="g_cm3">Water</button>
                                                            <button type="button" class="density-example px-3 py-2 text-sm bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors" data-value="7850" data-from="kg_m3" data-to="g_cm3">Steel</button>
                                                            <button type="button" class="density-example px-3 py-2 text-sm bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors" data-value="2700" data-from="kg_m3" data-to="g_cm3">Aluminum</button>
                                                            <button type="button" class="density-example px-3 py-2 text-sm bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors" data-value="1.225" data-from="kg_m3" data-to="g_cm3">Air</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Density Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Common Material Densities (at 20°C)</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>Water:</strong> 1000 kg/m³</div>
                                                        <div><strong>Air:</strong> 1.225 kg/m³</div>
                                                        <div><strong>Steel:</strong> 7850 kg/m³</div>
                                                        <div><strong>Aluminum:</strong> 2700 kg/m³</div>
                                                        <div><strong>Concrete:</strong> 2400 kg/m³</div>
                                                        <div><strong>Wood (oak):</strong> 750 kg/m³</div>
                                                        <div><strong>Gasoline:</strong> 750 kg/m³</div>
                                                        <div><strong>Mercury:</strong> 13534 kg/m³</div>
                                                        <div><strong>Gold:</strong> 19300 kg/m³</div>
                                                        <div><strong>Cork:</strong> 240 kg/m³</div>
                                                        <div><strong>Ice:</strong> 917 kg/m³</div>
                                                        <div><strong>Lead:</strong> 11340 kg/m³</div>
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
                        const kgm3Display = document.getElementById('kgm3Display');
                        const gcm3Display = document.getElementById('gcm3Display');
                        const gmlDisplay = document.getElementById('gmlDisplay');
                        const kglDisplay = document.getElementById('kglDisplay');
                        const lbft3Display = document.getElementById('lbft3Display');
                        const lbin3Display = document.getElementById('lbin3Display');
                        const lbgalusDisplay = document.getElementById('lbgalusDisplay');
                        const sgDisplay = document.getElementById('sgDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Density multipliers (to kg/m³)
                        const densityMultipliers = {
                            kg_m3: 1,
                            g_cm3: 1000,
                            g_ml: 1000,
                            mg_cm3: 1,
                            kg_l: 1000,
                            g_l: 1,
                            mg_l: 0.001,
                            t_m3: 1000,
                            lb_ft3: 16.018463,
                            lb_in3: 27679.905,
                            oz_in3: 1729.994,
                            lb_gal_us: 119.826427,
                            lb_gal_uk: 99.776373,
                            slug_ft3: 515.379,
                            specific_gravity: 1000,
                            api_gravity: 1000, // Special calculation needed
                            baume_heavy: 1000, // Special calculation needed
                            baume_light: 1000  // Special calculation needed
                        };

                        const unitLabels = {
                            kg_m3: 'kg/m³',
                            g_cm3: 'g/cm³',
                            g_ml: 'g/mL',
                            mg_cm3: 'mg/cm³',
                            kg_l: 'kg/L',
                            g_l: 'g/L',
                            mg_l: 'mg/L',
                            t_m3: 't/m³',
                            lb_ft3: 'lb/ft³',
                            lb_in3: 'lb/in³',
                            oz_in3: 'oz/in³',
                            lb_gal_us: 'lb/gal (US)',
                            lb_gal_uk: 'lb/gal (UK)',
                            slug_ft3: 'slug/ft³',
                            specific_gravity: 'SG',
                            api_gravity: '°API',
                            baume_heavy: '°Bé (heavy)',
                            baume_light: '°Bé (light)'
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
                            return num.toLocaleString(undefined, { maximumSignificantDigits: Math.max(getPrecision(), 1) });
                        }

                        function unitDisplayName(select) {
                            return select.options[select.selectedIndex].text;
                        }

                        function convertSpecialUnits(value, fromUnit, toKgM3 = true) {
                            if (fromUnit === 'api_gravity' && toKgM3) {
                                // API Gravity to kg/m³: ρ = 141.5 / (API + 131.5) * 1000
                                return (141.5 / (value + 131.5)) * 1000;
                            } else if (fromUnit === 'baume_heavy' && toKgM3) {
                                // Baumé Heavy to kg/m³: ρ = 145 / (145 - Bé) * 1000
                                return (145 / (145 - value)) * 1000;
                            } else if (fromUnit === 'baume_light' && toKgM3) {
                                // Baumé Light to kg/m³: ρ = 140 / (130 + Bé) * 1000
                                return (140 / (130 + value)) * 1000;
                            }
                            return value;
                        }

                        function convertFromKgM3(kgm3Value, toUnit) {
                            if (toUnit === 'api_gravity') {
                                // kg/m³ to API Gravity: API = (141.5 / (ρ/1000)) - 131.5
                                return (141.5 / (kgm3Value / 1000)) - 131.5;
                            } else if (toUnit === 'baume_heavy') {
                                // kg/m³ to Baumé Heavy: Bé = 145 - (145 / (ρ/1000))
                                return 145 - (145 / (kgm3Value / 1000));
                            } else if (toUnit === 'baume_light') {
                                // kg/m³ to Baumé Light: Bé = (140 / (ρ/1000)) - 130
                                return (140 / (kgm3Value / 1000)) - 130;
                            }
                            return kgm3Value / densityMultipliers[toUnit];
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const from = fromUnit.value;
                            const to = toUnit.value;

                            if (!isNaN(inputVal) && inputVal >= 0) {
                                // Convert input to kg/m³ first
                                let inputInKgM3;
                                if (['api_gravity', 'baume_heavy', 'baume_light'].includes(from)) {
                                    inputInKgM3 = convertSpecialUnits(inputVal, from, true);
                                } else {
                                    inputInKgM3 = inputVal * densityMultipliers[from];
                                }
                                
                                // Convert kg/m³ to target unit
                                let result;
                                if (['api_gravity', 'baume_heavy', 'baume_light'].includes(to)) {
                                    result = convertFromKgM3(inputInKgM3, to);
                                } else {
                                    result = inputInKgM3 / densityMultipliers[to];
                                }
                                
                                // Update primary output
                                output.textContent = formatNumber(result) + ' ' + unitLabels[to];
                                resultTitle.textContent = unitDisplayName(toUnit);
                                resultDescription.textContent = `${formatNumber(inputVal)} ${unitLabels[from]} = ${formatNumber(result)} ${unitLabels[to]}`;

                                // Convert to all common units and display
                                const kgm3 = inputInKgM3;
                                kgm3Display.textContent = formatNumber(kgm3);
                                gcm3Display.textContent = formatNumber(kgm3 / densityMultipliers.g_cm3);
                                gmlDisplay.textContent = formatNumber(kgm3 / densityMultipliers.g_ml);
                                kglDisplay.textContent = formatNumber(kgm3 / densityMultipliers.kg_l);
                                lbft3Display.textContent = formatNumber(kgm3 / densityMultipliers.lb_ft3);
                                lbin3Display.textContent = formatNumber(kgm3 / densityMultipliers.lb_in3);
                                lbgalusDisplay.textContent = formatNumber(kgm3 / densityMultipliers.lb_gal_us);
                                sgDisplay.textContent = formatNumber(kgm3 / 1000); // Specific gravity relative to water

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Converted Density';
                            resultDescription.textContent = 'Converted result';
                            kgm3Display.textContent = '--';
                            gcm3Display.textContent = '--';
                            gmlDisplay.textContent = '--';
                            kglDisplay.textContent = '--';
                            lbft3Display.textContent = '--';
                            lbin3Display.textContent = '--';
                            lbgalusDisplay.textContent = '--';
                            sgDisplay.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            fromUnit.value = 'kg_m3';
                            toUnit.value = 'g_cm3';
                            precision.value = 4;
                            precisionValue.textContent = '4 digits';
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
                        const densityExamples = document.querySelectorAll('.density-example');
                        densityExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const from = this.getAttribute('data-from');
                                const to = this.getAttribute('data-to');
                                
                                inputValue.value = value;
                                fromUnit.value = from;
                                toUnit.value = to;
                                convert();
                                
                                // Update button styles
                                densityExamples.forEach(btn => btn.classList.remove('bg-green-100', 'text-green-700'));
                                densityExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-green-100', 'text-green-700');
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
