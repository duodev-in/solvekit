<x-tool-page-layout
    title="Radiation Converter - SolveKit"
    description="Professional radiation converter for dose and exposure units. Convert between Sievert, Gray, Rem, Rad, and other radiation measurement units for safety and medical applications."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Radiation Converter</h1>
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
                                                                                    Enter Radiation Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter radiation value (e.g., 1.0)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Value</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter radiation measurement value</p>
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
                                                                                    <optgroup label="Absorbed Dose">
                                                                                        <option value="gray" selected>Gray (Gy) - SI unit</option>
                                                                                        <option value="rad">Rad (rad) - Legacy unit</option>
                                                                                        <option value="milligray">Milligray (mGy)</option>
                                                                                        <option value="microgray">Microgray (μGy)</option>
                                                                                        <option value="centigray">Centigray (cGy)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Equivalent Dose">
                                                                                        <option value="sievert">Sievert (Sv) - SI unit</option>
                                                                                        <option value="rem">Rem (rem) - Legacy unit</option>
                                                                                        <option value="millisievert">Millisievert (mSv)</option>
                                                                                        <option value="microsievert">Microsievert (μSv)</option>
                                                                                        <option value="millirem">Millirem (mrem)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Exposure">
                                                                                        <option value="roentgen">Roentgen (R)</option>
                                                                                        <option value="milliroentgen">Milliroentgen (mR)</option>
                                                                                        <option value="coulomb_per_kg">Coulomb per kg (C/kg)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Activity">
                                                                                        <option value="becquerel">Becquerel (Bq)</option>
                                                                                        <option value="curie">Curie (Ci)</option>
                                                                                        <option value="kilobecquerel">Kilobecquerel (kBq)</option>
                                                                                        <option value="megabecquerel">Megabecquerel (MBq)</option>
                                                                                        <option value="gigabecquerel">Gigabecquerel (GBq)</option>
                                                                                        <option value="millicurie">Millicurie (mCi)</option>
                                                                                        <option value="microcurie">Microcurie (μCi)</option>
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
                                                                                    <optgroup label="Absorbed Dose">
                                                                                        <option value="gray">Gray (Gy) - SI unit</option>
                                                                                        <option value="rad" selected>Rad (rad) - Legacy unit</option>
                                                                                        <option value="milligray">Milligray (mGy)</option>
                                                                                        <option value="microgray">Microgray (μGy)</option>
                                                                                        <option value="centigray">Centigray (cGy)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Equivalent Dose">
                                                                                        <option value="sievert">Sievert (Sv) - SI unit</option>
                                                                                        <option value="rem">Rem (rem) - Legacy unit</option>
                                                                                        <option value="millisievert">Millisievert (mSv)</option>
                                                                                        <option value="microsievert">Microsievert (μSv)</option>
                                                                                        <option value="millirem">Millirem (mrem)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Exposure">
                                                                                        <option value="roentgen">Roentgen (R)</option>
                                                                                        <option value="milliroentgen">Milliroentgen (mR)</option>
                                                                                        <option value="coulomb_per_kg">Coulomb per kg (C/kg)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Activity">
                                                                                        <option value="becquerel">Becquerel (Bq)</option>
                                                                                        <option value="curie">Curie (Ci)</option>
                                                                                        <option value="kilobecquerel">Kilobecquerel (kBq)</option>
                                                                                        <option value="megabecquerel">Megabecquerel (MBq)</option>
                                                                                        <option value="gigabecquerel">Gigabecquerel (GBq)</option>
                                                                                        <option value="millicurie">Millicurie (mCi)</option>
                                                                                        <option value="microcurie">Microcurie (μCi)</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>

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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Radiation Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl border-l-4 border-yellow-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Radiation</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-yellow-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-yellow-600 hover:text-yellow-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Radiation Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Dose Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Dose Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Gray (Gy)</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="grayDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">SI absorbed dose</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Rad</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="radDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Legacy absorbed dose</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Sievert (Sv)</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="sievertDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">SI equivalent dose</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Rem</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="remDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Legacy equivalent dose</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Activity & Exposure Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Activity & Exposure</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Becquerel (Bq)</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="becquerelDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">SI activity unit</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Curie (Ci)</h5>
                                                                                            <div class="text-lg font-bold text-pink-600 font-mono" id="curieDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Legacy activity unit</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Roentgen (R)</h5>
                                                                                            <div class="text-lg font-bold text-cyan-600 font-mono" id="roentgenDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Exposure unit</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">mSv</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="msievertDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Common dose unit</div>
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
                <!-- Quick Radiation Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Radiation Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="radiation-example px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-value="1" data-from="gray" data-to="rad">1 Gy</button>
                                                            <button type="button" class="radiation-example px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-value="100" data-from="rad" data-to="gray">100 rad</button>
                                                            <button type="button" class="radiation-example px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-value="1" data-from="sievert" data-to="rem">1 Sv</button>
                                                            <button type="button" class="radiation-example px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-value="1" data-from="curie" data-to="becquerel">1 Ci</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Radiation Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Radiation Unit Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 Gray</strong> = 100 rad</div>
                                                        <div><strong>1 Sievert</strong> = 100 rem</div>
                                                        <div><strong>1 Curie</strong> = 3.7×10¹⁰ Bq</div>
                                                        <div><strong>1 Roentgen</strong> ≈ 0.96 rad (air)</div>
                                                        <div><strong>Background:</strong> ~2-3 mSv/year</div>
                                                        <div><strong>Chest X-ray:</strong> ~0.1 mSv</div>
                                                        <div><strong>CT scan:</strong> ~10 mSv</div>
                                                        <div><strong>Annual limit:</strong> 20 mSv (workers)</div>
                                                        <div><strong>Acute dose:</strong> >1000 mSv (severe)</div>
                                                        <div><strong>Lethal dose:</strong> >4000 mSv (LD50)</div>
                                                        <div><strong>SI units:</strong> Gy, Sv, Bq, C/kg</div>
                                                        <div><strong>Legacy units:</strong> rad, rem, Ci, R</div>
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
                        const grayDisplay = document.getElementById('grayDisplay');
                        const radDisplay = document.getElementById('radDisplay');
                        const sievertDisplay = document.getElementById('sievertDisplay');
                        const remDisplay = document.getElementById('remDisplay');
                        const becquerelDisplay = document.getElementById('becquerelDisplay');
                        const curieDisplay = document.getElementById('curieDisplay');
                        const roentgenDisplay = document.getElementById('roentgenDisplay');
                        const msievertDisplay = document.getElementById('msievertDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Radiation unit multipliers (to base SI units)
                        const radiationMultipliers = {
                            // Absorbed dose (to Gray)
                            gray: 1,
                            rad: 0.01,
                            milligray: 0.001,
                            microgray: 0.000001,
                            centigray: 0.01,
                            
                            // Equivalent dose (to Sievert)
                            sievert: 1,
                            rem: 0.01,
                            millisievert: 0.001,
                            microsievert: 0.000001,
                            millirem: 0.00001,
                            
                            // Exposure (to C/kg)
                            roentgen: 0.000258,
                            milliroentgen: 0.000000258,
                            coulomb_per_kg: 1,
                            
                            // Activity (to Becquerel)
                            becquerel: 1,
                            curie: 37000000000,
                            kilobecquerel: 1000,
                            megabecquerel: 1000000,
                            gigabecquerel: 1000000000,
                            millicurie: 37000000,
                            microcurie: 37000
                        };

                        const unitLabels = {
                            gray: 'Gy',
                            rad: 'rad',
                            milligray: 'mGy',
                            microgray: 'μGy',
                            centigray: 'cGy',
                            sievert: 'Sv',
                            rem: 'rem',
                            millisievert: 'mSv',
                            microsievert: 'μSv',
                            millirem: 'mrem',
                            roentgen: 'R',
                            milliroentgen: 'mR',
                            coulomb_per_kg: 'C/kg',
                            becquerel: 'Bq',
                            curie: 'Ci',
                            kilobecquerel: 'kBq',
                            megabecquerel: 'MBq',
                            gigabecquerel: 'GBq',
                            millicurie: 'mCi',
                            microcurie: 'μCi'
                        };

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
                                return num.toLocaleString(undefined, { maximumFractionDigits: 4 });
                            }
                            return num.toLocaleString(undefined, { maximumSignificantDigits: 5 });
                        }

                        function syncTargetUnits() {
                            const fromGroup = fromUnit.options[fromUnit.selectedIndex].parentElement.label;
                            let firstCompatible = null;

                            Array.from(toUnit.querySelectorAll('optgroup')).forEach(group => {
                                const isCompatible = group.label === fromGroup;
                                group.hidden = !isCompatible;
                                Array.from(group.children).forEach(option => {
                                    option.disabled = !isCompatible;
                                    option.hidden = !isCompatible;
                                    if (isCompatible && option.value !== fromUnit.value && !firstCompatible) {
                                        firstCompatible = option.value;
                                    }
                                });
                            });

                            if (toUnit.options[toUnit.selectedIndex].disabled) {
                                toUnit.value = firstCompatible || fromUnit.value;
                            }
                        }

                        function canConvert(fromUnit, toUnit) {
                            const doseUnits = ['gray', 'rad', 'milligray', 'microgray', 'centigray'];
                            const equivalentUnits = ['sievert', 'rem', 'millisievert', 'microsievert', 'millirem'];
                            const exposureUnits = ['roentgen', 'milliroentgen', 'coulomb_per_kg'];
                            const activityUnits = ['becquerel', 'curie', 'kilobecquerel', 'megabecquerel', 'gigabecquerel', 'millicurie', 'microcurie'];

                            const fromType = doseUnits.includes(fromUnit) ? 'dose' :
                                           equivalentUnits.includes(fromUnit) ? 'equivalent' :
                                           exposureUnits.includes(fromUnit) ? 'exposure' :
                                           activityUnits.includes(fromUnit) ? 'activity' : 'unknown';

                            const toType = doseUnits.includes(toUnit) ? 'dose' :
                                         equivalentUnits.includes(toUnit) ? 'equivalent' :
                                         exposureUnits.includes(toUnit) ? 'exposure' :
                                         activityUnits.includes(toUnit) ? 'activity' : 'unknown';

                            return fromType === toType;
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const from = fromUnit.value;
                            const to = toUnit.value;

                            if (!isNaN(inputVal) && inputVal >= 0) {
                                if (!canConvert(from, to)) {
                                    output.textContent = 'Incompatible units';
                                    resultTitle.textContent = 'Converted Radiation';
                                    resultDescription.textContent = 'Cannot convert between different radiation quantities';
                                    return;
                                }

                                // Convert via base SI unit
                                const baseValue = inputVal * radiationMultipliers[from];
                                const result = baseValue / radiationMultipliers[to];
                                
                                // Update primary output
                                output.textContent = formatNumber(result) + ' ' + unitLabels[to];
                                resultTitle.textContent = toUnit.options[toUnit.selectedIndex].text.split(' - ')[0];
                                resultDescription.textContent = `${formatNumber(inputVal)} ${unitLabels[from]} = ${formatNumber(result)} ${unitLabels[to]}`;

                                // Convert to common units for display
                                grayDisplay.textContent = formatNumber(baseValue);
                                radDisplay.textContent = formatNumber(baseValue / radiationMultipliers.rad);
                                
                                // For equivalent dose displays, assume same as absorbed dose
                                sievertDisplay.textContent = formatNumber(baseValue);
                                remDisplay.textContent = formatNumber(baseValue / radiationMultipliers.rem);
                                msievertDisplay.textContent = formatNumber(baseValue / radiationMultipliers.millisievert);

                                // Activity units (show only if relevant)
                                if (['becquerel', 'curie', 'kilobecquerel', 'megabecquerel', 'gigabecquerel', 'millicurie', 'microcurie'].includes(from)) {
                                    becquerelDisplay.textContent = formatNumber(baseValue);
                                    curieDisplay.textContent = formatNumber(baseValue / radiationMultipliers.curie);
                                } else {
                                    becquerelDisplay.textContent = 'N/A';
                                    curieDisplay.textContent = 'N/A';
                                }

                                // Exposure units
                                if (['roentgen', 'milliroentgen', 'coulomb_per_kg'].includes(from)) {
                                    roentgenDisplay.textContent = formatNumber(baseValue / radiationMultipliers.roentgen);
                                } else {
                                    roentgenDisplay.textContent = 'N/A';
                                }

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Converted Radiation';
                            resultDescription.textContent = 'Converted result';
                            grayDisplay.textContent = '--';
                            radDisplay.textContent = '--';
                            sievertDisplay.textContent = '--';
                            remDisplay.textContent = '--';
                            becquerelDisplay.textContent = '--';
                            curieDisplay.textContent = '--';
                            roentgenDisplay.textContent = '--';
                            msievertDisplay.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            fromUnit.value = 'gray';
                            syncTargetUnits();
                            toUnit.value = 'rad';
                            clearOutputs();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        fromUnit.addEventListener('change', function() {
                            syncTargetUnits();
                            convert();
                        });
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
                        const radiationExamples = document.querySelectorAll('.radiation-example');
                        radiationExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const from = this.getAttribute('data-from');
                                const to = this.getAttribute('data-to');
                                
                                inputValue.value = value;
                                fromUnit.value = from;
                                syncTargetUnits();
                                toUnit.value = to;
                                convert();
                                
                                // Update button styles
                                radiationExamples.forEach(btn => btn.classList.remove('bg-yellow-100', 'text-yellow-700'));
                                radiationExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-yellow-100', 'text-yellow-700');
                            });
                        });

                        // Initialize
                        syncTargetUnits();
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
