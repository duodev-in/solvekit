<x-tool-page-layout
    title="Nm to in-lbs Converter - SolveKit"
    description="Professional torque converter for engineering applications. Convert between Newton-meters, inch-pounds, foot-pounds and other torque units with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Nm to in-lbs</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Enter Torque Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter torque value"
                                                                                        step="any"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnitDisplay">Nm</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Unit Selection -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <div class="space-y-2">
                                                                                    <label for="fromUnit" class="block text-sm font-semibold text-gray-700">
                                                                                        Convert From
                                                                                    </label>
                                                                                    <select 
                                                                                        id="fromUnit" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <optgroup label="Metric Units">
                                                                                            <option value="nm" selected>Newton-meter (Nm)</option>
                                                                                            <option value="kgm">Kilogram-meter (kg⋅m)</option>
                                                                                            <option value="dynecm">Dyne-centimeter (dyn⋅cm)</option>
                                                                                            <option value="gcm">Gram-centimeter (g⋅cm)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Imperial Units">
                                                                                            <option value="inchlbs">Inch-pounds (in-lbs)</option>
                                                                                            <option value="ftlbs">Foot-pounds (ft-lbs)</option>
                                                                                            <option value="ozin">Ounce-inch (oz⋅in)</option>
                                                                                            <option value="lbft">Pound-foot (lb⋅ft)</option>
                                                                                        </optgroup>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="space-y-2">
                                                                                    <label for="toUnit" class="block text-sm font-semibold text-gray-700">
                                                                                        Convert To
                                                                                    </label>
                                                                                    <select 
                                                                                        id="toUnit" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <optgroup label="Metric Units">
                                                                                            <option value="nm">Newton-meter (Nm)</option>
                                                                                            <option value="kgm">Kilogram-meter (kg⋅m)</option>
                                                                                            <option value="dynecm">Dyne-centimeter (dyn⋅cm)</option>
                                                                                            <option value="gcm">Gram-centimeter (g⋅cm)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Imperial Units">
                                                                                            <option value="inchlbs" selected>Inch-pounds (in-lbs)</option>
                                                                                            <option value="ftlbs">Foot-pounds (ft-lbs)</option>
                                                                                            <option value="ozin">Ounce-inch (oz⋅in)</option>
                                                                                            <option value="lbft">Pound-foot (lb⋅ft)</option>
                                                                                        </optgroup>
                                                                                    </select>
                                                                                </div>
                                                                            </div>



                                                                            <!-- Precision Level -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Precision Level
                                                                                </label>
                                                                                <div class="grid grid-cols-4 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="2" class="text-purple-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">2 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="4" class="text-purple-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">4 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="6" class="text-purple-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-xs font-medium">6 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="auto" class="text-purple-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">Auto</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Unit Swap Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="swapUnits"
                                                                                    class="inline-flex items-center px-4 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium rounded-lg transition-colors duration-200"
                                                                                >
                                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                                                                    </svg>
                                                                                    Swap Units
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-7">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Converted Value</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border-l-4 border-purple-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Torque</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Target torque unit</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-purple-600 font-mono" id="output">--</div>
                                                                                        <div class="text-sm text-gray-500 font-medium" id="outputUnitDisplay">in-lbs</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Common Torque Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Newton-meter</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="nmOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Inch-pounds</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="inchlbsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Foot-pounds</h4>
                                                                                        <div class="text-lg font-bold text-orange-600 font-mono" id="ftlbsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Kilogram-meter</h4>
                                                                                        <div class="text-lg font-bold text-cyan-600 font-mono" id="kgmOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Ounce-inch</h4>
                                                                                        <div class="text-lg font-bold text-yellow-600 font-mono" id="ozinOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Dyne-centimeter</h4>
                                                                                        <div class="text-lg font-bold text-pink-600 font-mono" id="dynecmOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Conversion Formula -->
                                                                            <div class="p-4 bg-gray-50 rounded-lg">
                                                                                <h4 class="text-sm font-semibold text-gray-700 mb-2 text-center">Conversion Formula</h4>
                                                                                <div class="text-center text-sm text-gray-600 font-mono" id="conversionFormula">
                                                                                    Select units to see conversion formula
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Unit Swaps -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Conversion Presets
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-from="nm" data-to="inchlbs">Nm → in-lbs</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-from="nm" data-to="ftlbs">Nm → ft-lbs</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-from="ftlbs" data-to="nm">ft-lbs → Nm</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-from="inchlbs" data-to="nm">in-lbs → Nm</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Torque Conversion Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div>• 1 Nm = 8.8507 in-lbs</div>
                                                        <div>• 1 Nm = 0.7376 ft-lbs</div>
                                                        <div>• 1 ft-lbs = 12 in-lbs</div>
                                                        <div>• 1 kg⋅m = 9.8067 Nm</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">About Torque Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600">
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Engineering Applications</h4>
                                    <p>Torque conversion is critical in mechanical engineering, automotive, aerospace, and manufacturing. Different regions and industries use different torque units, making accurate conversion essential for specifications and safety.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Unit Standards</h4>
                                    <p>Newton-meter (Nm) is the SI unit for torque. Inch-pounds and foot-pounds are common in US applications. Understanding these conversions ensures proper tool selection and fastener specifications.</p>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-purple-50 rounded-lg border border-purple-200">
                                <p class="text-sm text-purple-800">
                                    <strong>Safety Note:</strong> Always verify torque specifications and units for critical applications. Incorrect torque values can lead to mechanical failures!
                                </p>
                            </div>
                        </div>

                        <!-- Common Torque Examples -->
                        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Common Torque Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Spark Plug</div>
                                    <div class="text-purple-600 cursor-pointer hover:text-purple-800 transition-colors" data-value="25" data-unit="nm">25 Nm</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 221 in-lbs</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Wheel Lug Nut</div>
                                    <div class="text-purple-600 cursor-pointer hover:text-purple-800 transition-colors" data-value="100" data-unit="nm">100 Nm</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 885 in-lbs</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Small Screw</div>
                                    <div class="text-purple-600 cursor-pointer hover:text-purple-800 transition-colors" data-value="12" data-unit="inchlbs">12 in-lbs</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 1.36 Nm</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Cylinder Head</div>
                                    <div class="text-purple-600 cursor-pointer hover:text-purple-800 transition-colors" data-value="80" data-unit="ftlbs">80 ft-lbs</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 108 Nm</div>
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
                        const inputUnitDisplay = document.getElementById('inputUnitDisplay');
                        const outputUnitDisplay = document.getElementById('outputUnitDisplay');
                        const precisionRadios = document.getElementsByName('precision');
                        const swapUnits = document.getElementById('swapUnits');
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const nmOutput = document.getElementById('nmOutput');
                        const inchlbsOutput = document.getElementById('inchlbsOutput');
                        const ftlbsOutput = document.getElementById('ftlbsOutput');
                        const kgmOutput = document.getElementById('kgmOutput');
                        const ozinOutput = document.getElementById('ozinOutput');
                        const dynecmOutput = document.getElementById('dynecmOutput');
                        const conversionFormula = document.getElementById('conversionFormula');

                        // All conversion factors relative to Newton-meter (Nm)
                        const units = {
                            nm: 1,                    // Newton-meter
                            inchlbs: 8.85074579,      // Inch-pounds
                            ftlbs: 0.737562149,       // Foot-pounds
                            kgm: 0.101971621,         // Kilogram-meter
                            ozin: 141.611933,         // Ounce-inch
                            dynecm: 10000000,         // Dyne-centimeter
                            gcm: 10197.1621,          // Gram-centimeter
                            lbft: 0.737562149         // Pound-foot (same as ft-lbs)
                        };

                        const unitNames = {
                            nm: 'Newton-meters',
                            inchlbs: 'Inch-pounds',
                            ftlbs: 'Foot-pounds',
                            kgm: 'Kilogram-meters',
                            ozin: 'Ounce-inches',
                            dynecm: 'Dyne-centimeters',
                            gcm: 'Gram-centimeters',
                            lbft: 'Pound-feet'
                        };

                        const unitSymbols = {
                            nm: 'Nm',
                            inchlbs: 'in-lbs',
                            ftlbs: 'ft-lbs',
                            kgm: 'kg⋅m',
                            ozin: 'oz⋅in',
                            dynecm: 'dyn⋅cm',
                            gcm: 'g⋅cm',
                            lbft: 'lb⋅ft'
                        };

                        function getPrecision() {
                            const selected = document.querySelector('input[name="precision"]:checked').value;
                            return selected === 'auto' ? 'auto' : parseInt(selected);
                        }

                        function formatNumber(num, precision = 'auto') {
                            if (precision === 'auto') {
                                if (num >= 1000000) {
                                    return Number(num.toPrecision(5)).toExponential();
                                } else if (num >= 1000) {
                                    return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                                } else if (num >= 1) {
                                    return num.toLocaleString(undefined, { maximumFractionDigits: 4 });
                                } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                    return Number(num.toPrecision(4)).toExponential();
                                } else {
                                    return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                                }
                            } else {
                                if (num !== 0 && Math.abs(num) < 0.5 * Math.pow(10, -precision)) {
                                    return Math.abs(num) < 0.000001 ? Number(num.toPrecision(4)).toExponential() : num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                                }
                                return num.toLocaleString(undefined, { maximumFractionDigits: precision });
                            }
                        }

                        function updateUnitDisplays() {
                            inputUnitDisplay.textContent = unitSymbols[fromUnit.value];
                            outputUnitDisplay.textContent = unitSymbols[toUnit.value];
                            resultTitle.textContent = `Torque in ${unitNames[toUnit.value]}`;
                            resultDescription.textContent = 'Converted torque value';
                        }

                        function updateConversionFormula() {
                            const fromSymbol = unitSymbols[fromUnit.value];
                            const toSymbol = unitSymbols[toUnit.value];
                            const fromFactor = units[fromUnit.value];
                            const toFactor = units[toUnit.value];
                            
                            if (fromUnit.value === toUnit.value) {
                                conversionFormula.textContent = `1 ${fromSymbol} = 1 ${toSymbol}`;
                            } else {
                                const conversionFactor = toFactor / fromFactor;
                                conversionFormula.textContent = `1 ${fromSymbol} = ${formatNumber(conversionFactor, 6)} ${toSymbol}`;
                            }
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const fromUnitVal = fromUnit.value;
                            const toUnitVal = toUnit.value;
                            const precision = getPrecision();

                            if (!isNaN(inputVal)) {
                                // Convert to Nm first, then to target unit
                                const inNm = inputVal / units[fromUnitVal];
                                const result = inNm * units[toUnitVal];
                                
                                output.textContent = formatNumber(result, precision);

                                // Update all common units
                                nmOutput.textContent = formatNumber(inNm, precision) + ' Nm';
                                inchlbsOutput.textContent = formatNumber(inNm * units.inchlbs, precision) + ' in-lbs';
                                ftlbsOutput.textContent = formatNumber(inNm * units.ftlbs, precision) + ' ft-lbs';
                                kgmOutput.textContent = formatNumber(inNm * units.kgm, precision) + ' kg⋅m';
                                ozinOutput.textContent = formatNumber(inNm * units.ozin, precision) + ' oz⋅in';
                                dynecmOutput.textContent = formatNumber(inNm * units.dynecm, precision) + ' dyn⋅cm';
                            } else {
                                output.textContent = '--';
                                nmOutput.textContent = '--';
                                inchlbsOutput.textContent = '--';
                                ftlbsOutput.textContent = '--';
                                kgmOutput.textContent = '--';
                                ozinOutput.textContent = '--';
                                dynecmOutput.textContent = '--';
                            }
                        }

                        function swapUnitsFunction() {
                            const tempValue = fromUnit.value;
                            fromUnit.value = toUnit.value;
                            toUnit.value = tempValue;
                            updateUnitDisplays();
                            updateConversionFormula();
                            convert();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        fromUnit.addEventListener('change', () => {
                            updateUnitDisplays();
                            updateConversionFormula();
                            convert();
                        });
                        toUnit.addEventListener('change', () => {
                            updateUnitDisplays();
                            updateConversionFormula();
                            convert();
                        });
                        precisionRadios.forEach(radio => {
                            radio.addEventListener('change', convert);
                        });
                        swapUnits.addEventListener('click', swapUnitsFunction);

                        // Unit preset buttons
                        const unitPresets = document.querySelectorAll('.unit-preset');
                        unitPresets.forEach(button => {
                            button.addEventListener('click', function() {
                                const fromVal = this.getAttribute('data-from');
                                const toVal = this.getAttribute('data-to');
                                
                                fromUnit.value = fromVal;
                                toUnit.value = toVal;
                                updateUnitDisplays();
                                updateConversionFormula();
                                convert();
                                
                                // Update button styles
                                unitPresets.forEach(btn => btn.classList.remove('bg-purple-100', 'text-purple-700'));
                                unitPresets.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-purple-100', 'text-purple-700');
                            });
                        });

                        // Add clickable functionality to examples
                        const examples = document.querySelectorAll('[data-value][data-unit]');
                        examples.forEach(element => {
                            element.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const unit = this.getAttribute('data-unit');
                                
                                fromUnit.value = unit;
                                inputValue.value = value;
                                updateUnitDisplays();
                                updateConversionFormula();
                                convert();
                                inputValue.focus();
                            });
                        });

                        // Initialize
                        inputValue.focus();
                        updateUnitDisplays();
                        updateConversionFormula();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                inputValue.value = '';
                                convert();
                                inputValue.focus();
                            } else if (e.ctrlKey && (e.key || '').toLowerCase() === 's') {
                                e.preventDefault();
                                swapUnitsFunction();
                            }
                        });

                        // Initialize conversion
                        convert();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
