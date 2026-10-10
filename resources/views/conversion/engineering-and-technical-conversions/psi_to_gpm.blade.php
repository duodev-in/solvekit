<x-tool-page-layout
    title="PSI to GPM Calculator - SolveKit"
    description="Professional PSI to GPM flow rate calculator for engineering applications. Calculate flow rates from pressure and pipe dimensions with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">PSI to GPM</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Pressure Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="pressureValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Pressure (PSI)
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="pressureValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter pressure in PSI"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">PSI</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Water pressure at the source</p>
                                                                            </div>

                                                                            <!-- Pipe Diameter Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="diameterValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Pipe Diameter
                                                                                </label>
                                                                                <div class="grid grid-cols-3 gap-2">
                                                                                    <div class="col-span-2 relative">
                                                                                        <input 
                                                                                            type="number" 
                                                                                            id="diameterValue" 
                                                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                            placeholder="Enter diameter"
                                                                                            step="any"
                                                                                            min="0"
                                                                                        >
                                                                                    </div>
                                                                                    <select 
                                                                                        id="diameterUnit" 
                                                                                        class="px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <option value="inches">inches</option>
                                                                                        <option value="mm">mm</option>
                                                                                        <option value="cm">cm</option>
                                                                                        <option value="feet">feet</option>
                                                                                    </select>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Internal diameter of the pipe</p>
                                                                            </div>

                                                                            <!-- Discharge Coefficient -->
                                                                            <div class="space-y-2">
                                                                                <label for="coefficientValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Discharge Coefficient (C)
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="coefficientValue" 
                                                                                        value="0.6" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Discharge coefficient"
                                                                                        step="0.01"
                                                                                        min="0.1"
                                                                                        max="1.0"
                                                                                    >
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Typical values: Sharp orifice (0.6), Well-rounded (0.8), Venturi (0.98)</p>
                                                                            </div>

                                                                            <!-- Output Units -->
                                                                            <div class="space-y-2">
                                                                                <label for="outputUnits" class="block text-sm font-semibold text-gray-700">
                                                                                    Flow Rate Output Unit
                                                                                </label>
                                                                                <select 
                                                                                    id="outputUnits" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="gpm">GPM (Gallons per minute)</option>
                                                                                    <option value="lpm">LPM (Liters per minute)</option>
                                                                                    <option value="cfs">CFS (Cubic feet per second)</option>
                                                                                    <option value="cms">CMS (Cubic meters per second)</option>
                                                                                    <option value="gph">GPH (Gallons per hour)</option>
                                                                                    <option value="lps">LPS (Liters per second)</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Common Pipe Size Presets -->
                                                                            

                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-teal-100 hover:bg-teal-200 text-teal-700 font-medium rounded-lg transition-colors duration-200"
                                                                                >
                                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                                    </svg>
                                                                                    Clear All
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-7">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Converted Value</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-xl border-l-4 border-teal-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Flow Rate</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Calculated from pressure and pipe dimensions</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-teal-600 font-mono" id="output">--</div>
                                                                                        <div class="text-sm text-gray-500 font-medium" id="outputUnitDisplay">GPM</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- All Flow Rate Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">GPM</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="gpmOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">LPM</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="lpmOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">CFS</h4>
                                                                                        <div class="text-lg font-bold text-purple-600 font-mono" id="cfsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Flow Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">CMS</h4>
                                                                                        <div class="text-lg font-bold text-orange-600 font-mono" id="cmsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">GPH</h4>
                                                                                        <div class="text-lg font-bold text-cyan-600 font-mono" id="gphOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">LPS</h4>
                                                                                        <div class="text-lg font-bold text-yellow-600 font-mono" id="lpsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Calculation Details -->
                                                                            <div class="p-4 bg-gray-50 rounded-lg">
                                                                                <h4 class="text-sm font-semibold text-gray-700 mb-3 text-center">Calculation Details</h4>
                                                                                <div class="space-y-2 text-sm text-gray-600">
                                                                                    <div class="flex justify-between">
                                                                                        <span>Pressure Head:</span>
                                                                                        <span class="font-mono" id="pressureHead">--</span>
                                                                                    </div>
                                                                                    <div class="flex justify-between">
                                                                                        <span>Pipe Area:</span>
                                                                                        <span class="font-mono" id="pipeArea">--</span>
                                                                                    </div>
                                                                                    <div class="flex justify-between">
                                                                                        <span>Velocity:</span>
                                                                                        <span class="font-mono" id="velocity">--</span>
                                                                                    </div>
                                                                                    <div class="flex justify-between">
                                                                                        <span>Formula:</span>
                                                                                        <span class="font-mono text-xs">Q = C × A × √(2gh)</span>
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
                <div class="space-y-2">
                                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                                    Standard Pipe Sizes
                                                                                                </label>
                                                                                                <div class="grid grid-cols-4 gap-2">
                                                                                                    <button type="button" class="pipe-preset px-3 py-2 text-sm bg-gray-100 hover:bg-teal-100 text-gray-700 hover:text-teal-700 rounded-lg transition-colors" data-diameter="0.5">1/2"</button>
                                                                                                    <button type="button" class="pipe-preset px-3 py-2 text-sm bg-gray-100 hover:bg-teal-100 text-gray-700 hover:text-teal-700 rounded-lg transition-colors" data-diameter="0.75">3/4"</button>
                                                                                                    <button type="button" class="pipe-preset px-3 py-2 text-sm bg-gray-100 hover:bg-teal-100 text-gray-700 hover:text-teal-700 rounded-lg transition-colors" data-diameter="1">1"</button>
                                                                                                    <button type="button" class="pipe-preset px-3 py-2 text-sm bg-gray-100 hover:bg-teal-100 text-gray-700 hover:text-teal-700 rounded-lg transition-colors" data-diameter="2">2"</button>
                                                                                                </div>
                                                                                            </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Formula Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Hydraulic Flow Formulas</h4>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div>• Q = C × A × √(2gh)</div>
                                                        <div>• h = P/(ρg) = P × 2.31 ft</div>
                                                        <div>• A = π × d²/4</div>
                                                        <div>• V = Q/A</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">About PSI to GPM Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600">
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Hydraulic Principles</h4>
                                    <p>Flow rate calculation from pressure involves converting pressure to velocity head using Torricelli's principle. The discharge coefficient accounts for energy losses and flow characteristics of the specific orifice or opening.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Engineering Applications</h4>
                                    <p>Essential for water system design, irrigation planning, fire protection systems, pump sizing, pipeline analysis, and any hydraulic system where flow rates must be determined from available pressure.</p>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-teal-50 rounded-lg border border-teal-200">
                                <p class="text-sm text-teal-800">
                                    <strong>Engineering Note:</strong> Results assume steady flow conditions. Real-world factors like pipe roughness, fittings, and elevation changes will affect actual flow rates!
                                </p>
                            </div>
                        </div>

                        <!-- Common Application Examples -->
                        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Common Hydraulic Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Garden Hose</div>
                                    <div class="text-teal-600 cursor-pointer hover:text-teal-800 transition-colors" data-pressure="40" data-diameter="0.75">40 PSI, 3/4"</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 8.5 GPM</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Fire Sprinkler</div>
                                    <div class="text-teal-600 cursor-pointer hover:text-teal-800 transition-colors" data-pressure="15" data-diameter="0.5">15 PSI, 1/2"</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 2.6 GPM</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Main Supply</div>
                                    <div class="text-teal-600 cursor-pointer hover:text-teal-800 transition-colors" data-pressure="60" data-diameter="2">60 PSI, 2"</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 55 GPM</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Irrigation</div>
                                    <div class="text-teal-600 cursor-pointer hover:text-teal-800 transition-colors" data-pressure="25" data-diameter="1">25 PSI, 1"</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 7.1 GPM</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const pressureValue = document.getElementById('pressureValue');
                        const diameterValue = document.getElementById('diameterValue');
                        const diameterUnit = document.getElementById('diameterUnit');
                        const coefficientValue = document.getElementById('coefficientValue');
                        const outputUnits = document.getElementById('outputUnits');
                        const outputUnitDisplay = document.getElementById('outputUnitDisplay');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const gpmOutput = document.getElementById('gpmOutput');
                        const lpmOutput = document.getElementById('lpmOutput');
                        const cfsOutput = document.getElementById('cfsOutput');
                        const cmsOutput = document.getElementById('cmsOutput');
                        const gphOutput = document.getElementById('gphOutput');
                        const lpsOutput = document.getElementById('lpsOutput');
                        const pressureHead = document.getElementById('pressureHead');
                        const pipeArea = document.getElementById('pipeArea');
                        const velocity = document.getElementById('velocity');

                        // Unit conversion factors
                        const diameterConversions = {
                            inches: 1,
                            mm: 1/25.4,
                            cm: 1/2.54,
                            feet: 12
                        };

                        const flowConversions = {
                            gpm: 448.831,      // CFS to GPM
                            lpm: 1699.01,      // CFS to LPM
                            cfs: 1,            // CFS to CFS
                            cms: 0.0283168,    // CFS to CMS
                            gph: 26929.86,     // CFS to GPH
                            lps: 28.3168       // CFS to LPS
                        };

                        const unitNames = {
                            gpm: 'Gallons per Minute',
                            lpm: 'Liters per Minute',
                            cfs: 'Cubic Feet per Second',
                            cms: 'Cubic Meters per Second',
                            gph: 'Gallons per Hour',
                            lps: 'Liters per Second'
                        };

                        const unitSymbols = {
                            gpm: 'GPM',
                            lpm: 'LPM',
                            cfs: 'CFS',
                            cms: 'CMS',
                            gph: 'GPH',
                            lps: 'LPS'
                        };

                        function formatNumber(num) {
                            if (num >= 10000) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 1 });
                            } else if (num >= 100) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                            } else if (num >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 3 });
                            } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                return Number(num.toPrecision(4)).toExponential();
                            } else {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                            }
                        }

                        function updateUnitDisplays() {
                            outputUnitDisplay.textContent = unitSymbols[outputUnits.value];
                            resultTitle.textContent = `Flow Rate in ${unitNames[outputUnits.value]}`;
                            resultDescription.textContent = 'Calculated from pressure and pipe dimensions';
                        }

                        function convert() {
                            const pressure = parseFloat(pressureValue.value);
                            const diameter = parseFloat(diameterValue.value);
                            const coefficient = parseFloat(coefficientValue.value) || 0.6;

                            if (!isNaN(pressure) && !isNaN(diameter) && pressure > 0 && diameter > 0) {
                                // Convert diameter to inches
                                const diameterInches = diameter * diameterConversions[diameterUnit.value];
                                
                                // Convert PSI to head in feet (1 PSI = 2.31 feet of head for water)
                                const headFeet = pressure * 2.31;
                                
                                // Calculate pipe area in square feet
                                const areaFt2 = Math.PI * Math.pow(diameterInches / 12, 2) / 4;
                                
                                // Calculate theoretical velocity using Torricelli's principle
                                // v = √(2gh) where g = 32.174 ft/s²
                                const theoreticalVelocity = Math.sqrt(2 * 32.174 * headFeet);
                                
                                // Calculate actual flow rate in cubic feet per second
                                const cfs = coefficient * areaFt2 * theoreticalVelocity;
                                
                                // Convert to selected output unit
                                const result = cfs * flowConversions[outputUnits.value];
                                
                                // Update primary output
                                output.textContent = formatNumber(result);
                                
                                // Update all flow rate outputs
                                gpmOutput.textContent = formatNumber(cfs * flowConversions.gpm) + ' GPM';
                                lpmOutput.textContent = formatNumber(cfs * flowConversions.lpm) + ' LPM';
                                cfsOutput.textContent = formatNumber(cfs * flowConversions.cfs) + ' CFS';
                                cmsOutput.textContent = formatNumber(cfs * flowConversions.cms) + ' CMS';
                                gphOutput.textContent = formatNumber(cfs * flowConversions.gph) + ' GPH';
                                lpsOutput.textContent = formatNumber(cfs * flowConversions.lps) + ' LPS';
                                
                                // Update calculation details
                                pressureHead.textContent = formatNumber(headFeet) + ' ft';
                                pipeArea.textContent = formatNumber(areaFt2) + ' ft²';
                                velocity.textContent = formatNumber(cfs / areaFt2) + ' ft/s';
                                
                            } else {
                                output.textContent = '--';
                                gpmOutput.textContent = '--';
                                lpmOutput.textContent = '--';
                                cfsOutput.textContent = '--';
                                cmsOutput.textContent = '--';
                                gphOutput.textContent = '--';
                                lpsOutput.textContent = '--';
                                pressureHead.textContent = '--';
                                pipeArea.textContent = '--';
                                velocity.textContent = '--';
                            }
                        }

                        function clearAll() {
                            pressureValue.value = '';
                            diameterValue.value = '';
                            coefficientValue.value = '0.6';
                            convert();
                            pressureValue.focus();
                        }

                        // Event listeners
                        pressureValue.addEventListener('input', convert);
                        diameterValue.addEventListener('input', convert);
                        diameterUnit.addEventListener('change', convert);
                        coefficientValue.addEventListener('input', convert);
                        outputUnits.addEventListener('change', () => {
                            updateUnitDisplays();
                            convert();
                        });
                        clearButton.addEventListener('click', clearAll);

                        // Pipe size preset buttons
                        const pipePresets = document.querySelectorAll('.pipe-preset');
                        pipePresets.forEach(button => {
                            button.addEventListener('click', function() {
                                const diameter = this.getAttribute('data-diameter');
                                
                                diameterUnit.value = 'inches';
                                diameterValue.value = diameter;
                                convert();
                                
                                // Update button styles
                                pipePresets.forEach(btn => btn.classList.remove('bg-teal-100', 'text-teal-700'));
                                pipePresets.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-teal-100', 'text-teal-700');
                            });
                        });

                        // Add clickable functionality to examples
                        const examples = document.querySelectorAll('[data-pressure][data-diameter]');
                        examples.forEach(element => {
                            element.addEventListener('click', function() {
                                const pressure = this.getAttribute('data-pressure');
                                const diameter = this.getAttribute('data-diameter');
                                
                                pressureValue.value = pressure;
                                diameterValue.value = diameter;
                                diameterUnit.value = 'inches';
                                convert();
                                pressureValue.focus();
                            });
                        });

                        // Initialize
                        pressureValue.focus();
                        updateUnitDisplays();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            }
                        });

                        // Initialize conversion
                        convert();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
