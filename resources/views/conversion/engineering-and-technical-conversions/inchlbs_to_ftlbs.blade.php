<x-tool-page-layout
    title="in-lbs ↔ ft-lbs Converter - ConvertPro"
    description="Professional inch-pounds to foot-pounds converter for engineering applications. Convert between in-lbs and ft-lbs torque units with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">in-lbs ↔ ft-lbs</h1>
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
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnitDisplay">in-lbs</span>
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
                                                                                        <option value="inlb" selected>Inch-pounds (in-lbs)</option>
                                                                                        <option value="ftlb">Foot-pounds (ft-lbs)</option>
                                                                                        <option value="ozin">Ounce-inches (oz⋅in)</option>
                                                                                        <option value="lbft">Pound-feet (lb⋅ft)</option>
                                                                                        <option value="nm">Newton-meters (Nm)</option>
                                                                                        <option value="kgcm">Kilogram-centimeters (kg⋅cm)</option>
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
                                                                                        <option value="inlb">Inch-pounds (in-lbs)</option>
                                                                                        <option value="ftlb" selected>Foot-pounds (ft-lbs)</option>
                                                                                        <option value="ozin">Ounce-inches (oz⋅in)</option>
                                                                                        <option value="lbft">Pound-feet (lb⋅ft)</option>
                                                                                        <option value="nm">Newton-meters (Nm)</option>
                                                                                        <option value="kgcm">Kilogram-centimeters (kg⋅cm)</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>



                                                                            <!-- Precision Level -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Precision Level
                                                                                </label>
                                                                                <div class="grid grid-cols-4 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-orange-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="2" class="text-orange-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">2 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-orange-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="4" class="text-orange-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-xs font-medium">4 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-orange-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="6" class="text-orange-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">6 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-orange-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="auto" class="text-orange-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">Auto</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Unit Swap Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="swapUnits"
                                                                                    class="inline-flex items-center px-4 py-2 bg-orange-100 hover:bg-orange-200 text-orange-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <div class="p-6 bg-gradient-to-r from-orange-50 to-red-50 rounded-xl border-l-4 border-orange-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Torque</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Target torque unit</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-orange-600 font-mono" id="output">--</div>
                                                                                        <div class="text-sm text-gray-500 font-medium" id="outputUnitDisplay">ft-lbs</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Imperial Units Comparison -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Inch-pounds</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="inlbOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Foot-pounds</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="ftlbOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Newton-meters</h4>
                                                                                        <div class="text-lg font-bold text-purple-600 font-mono" id="nmOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Ounce-inches</h4>
                                                                                        <div class="text-lg font-bold text-cyan-600 font-mono" id="ozinOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">kg⋅cm</h4>
                                                                                        <div class="text-lg font-bold text-yellow-600 font-mono" id="kgcmOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Torque Scale Guide -->
                                                                            <div class="p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border border-indigo-200">
                                                                                <h4 class="text-sm font-semibold text-indigo-800 mb-2 text-center">Torque Scale Guide</h4>
                                                                                <div class="text-center">
                                                                                    <div class="text-lg font-bold text-indigo-700" id="torqueScale">Enter torque value</div>
                                                                                    <div class="text-xs text-indigo-600 mt-1" id="scaleDescription">--</div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Simple Conversion Explanation -->
                                                                            <div class="p-4 bg-gray-50 rounded-lg">
                                                                                <h4 class="text-sm font-semibold text-gray-700 mb-2 text-center">Imperial Conversion</h4>
                                                                                <div class="text-center text-sm text-gray-600 font-mono" id="conversionFormula">
                                                                                    1 ft-lbs = 12 in-lbs
                                                                                </div>
                                                                                <div class="text-center text-xs text-gray-500 mt-1">
                                                                                    Simple multiplication: 12 inches in 1 foot
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Conversion Presets -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Imperial Conversions
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-from="inlb" data-to="ftlb">in-lbs → ft-lbs</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-from="ftlb" data-to="inlb">ft-lbs → in-lbs</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-from="ozin" data-to="inlb">oz⋅in → in-lbs</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-from="ftlb" data-to="nm">ft-lbs → Nm</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Imperial Torque Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div>• 1 ft-lbs = 12 in-lbs</div>
                                                        <div>• 1 in-lbs = 0.0833 ft-lbs</div>
                                                        <div>• 1 ft-lbs = 1.356 Nm</div>
                                                        <div>• 1 in-lbs = 0.113 Nm</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">About Imperial Torque Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600">
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Imperial System</h4>
                                    <p>The conversion between inch-pounds and foot-pounds is straightforward: there are exactly 12 inches in 1 foot. This makes it one of the simplest torque conversions in the imperial system, requiring only basic multiplication or division by 12.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Practical Applications</h4>
                                    <p>Inch-pounds are typically used for smaller fasteners and precision work, while foot-pounds are used for larger automotive and mechanical applications. Understanding both scales is essential for proper tool selection and specification compliance.</p>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-orange-50 rounded-lg border border-orange-200">
                                <p class="text-sm text-orange-800">
                                    <strong>Imperial Tip:</strong> Remember the 12:1 ratio! 1 foot-pound equals exactly 12 inch-pounds. This is based on the fundamental length conversion of 12 inches per foot.
                                </p>
                            </div>
                        </div>

                        <!-- Common Torque Examples -->
                        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Common Imperial Torque Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Small Screw</div>
                                    <div class="text-orange-600 cursor-pointer hover:text-orange-800 transition-colors" data-value="18" data-unit="inlb">18 in-lbs</div>
                                    <div class="text-xs text-gray-500 mt-1">= 1.5 ft-lbs</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Oil Drain Plug</div>
                                    <div class="text-orange-600 cursor-pointer hover:text-orange-800 transition-colors" data-value="30" data-unit="ftlb">30 ft-lbs</div>
                                    <div class="text-xs text-gray-500 mt-1">= 360 in-lbs</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Lug Nut</div>
                                    <div class="text-orange-600 cursor-pointer hover:text-orange-800 transition-colors" data-value="100" data-unit="ftlb">100 ft-lbs</div>
                                    <div class="text-xs text-gray-500 mt-1">= 1200 in-lbs</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Electronics</div>
                                    <div class="text-orange-600 cursor-pointer hover:text-orange-800 transition-colors" data-value="6" data-unit="inlb">6 in-lbs</div>
                                    <div class="text-xs text-gray-500 mt-1">= 0.5 ft-lbs</div>
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
                        const inlbOutput = document.getElementById('inlbOutput');
                        const ftlbOutput = document.getElementById('ftlbOutput');
                        const nmOutput = document.getElementById('nmOutput');
                        const ozinOutput = document.getElementById('ozinOutput');
                        const kgcmOutput = document.getElementById('kgcmOutput');
                        const torqueScale = document.getElementById('torqueScale');
                        const scaleDescription = document.getElementById('scaleDescription');
                        const conversionFormula = document.getElementById('conversionFormula');

                        // Conversion factors to inch-pounds (in-lbs)
                        const torqueConversions = {
                            inlb: 1,              // Inch-pounds
                            ftlb: 12,             // Foot-pounds (1 ft-lb = 12 in-lbs)
                            ozin: 0.0625,         // Ounce-inches (1 oz⋅in = 1/16 in-lbs)
                            lbft: 12,             // Pound-feet (same as ft-lbs)
                            nm: 8.8507458,        // Newton-meters
                            kgcm: 0.867963        // Kilogram-centimeters
                        };

                        const unitNames = {
                            inlb: 'Inch-pounds',
                            ftlb: 'Foot-pounds',
                            ozin: 'Ounce-inches',
                            lbft: 'Pound-feet',
                            nm: 'Newton-meters',
                            kgcm: 'Kilogram-centimeters'
                        };

                        const unitSymbols = {
                            inlb: 'in-lbs',
                            ftlb: 'ft-lbs',
                            ozin: 'oz⋅in',
                            lbft: 'lb⋅ft',
                            nm: 'Nm',
                            kgcm: 'kg⋅cm'
                        };

                        function getPrecision() {
                            const selected = document.querySelector('input[name="precision"]:checked').value;
                            return selected === 'auto' ? 'auto' : parseInt(selected);
                        }

                        function formatNumber(num, precision = 'auto') {
                            if (precision === 'auto') {
                                if (num >= 10000) {
                                    return num.toLocaleString(undefined, { maximumFractionDigits: 1 });
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
                            
                            if (fromUnit.value === 'inlb' && toUnit.value === 'ftlb') {
                                conversionFormula.textContent = '1 ft-lbs = 12 in-lbs (divide by 12)';
                            } else if (fromUnit.value === 'ftlb' && toUnit.value === 'inlb') {
                                conversionFormula.textContent = '1 ft-lbs = 12 in-lbs (multiply by 12)';
                            } else if (fromUnit.value === toUnit.value) {
                                conversionFormula.textContent = `1 ${fromSymbol} = 1 ${toSymbol}`;
                            } else {
                                const fromFactor = torqueConversions[fromUnit.value];
                                const toFactor = torqueConversions[toUnit.value];
                                const conversionFactor = fromFactor / toFactor;
                                conversionFormula.textContent = `1 ${fromSymbol} = ${formatNumber(conversionFactor, 6)} ${toSymbol}`;
                            }
                        }

                        function classifyTorqueScale(inlbValue) {
                            if (inlbValue >= 1200) {
                                return { scale: 'Heavy Duty', description: 'Large automotive and machinery bolts' };
                            } else if (inlbValue >= 360) {
                                return { scale: 'Automotive Standard', description: 'Common car and truck components' };
                            } else if (inlbValue >= 120) {
                                return { scale: 'Medium Assembly', description: 'General mechanical fasteners' };
                            } else if (inlbValue >= 36) {
                                return { scale: 'Light Assembly', description: 'Small mechanical components' };
                            } else if (inlbValue >= 12) {
                                return { scale: 'Precision Work', description: 'Instrumentation and fine assembly' };
                            } else {
                                return { scale: 'Delicate Components', description: 'Electronics and sensitive parts' };
                            }
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const fromUnitVal = fromUnit.value;
                            const toUnitVal = toUnit.value;
                            const precision = getPrecision();

                            if (!isNaN(inputVal)) {
                                // Convert to inch-pounds first, then to target unit
                                const inInchLbs = inputVal * torqueConversions[fromUnitVal];
                                const result = inInchLbs / torqueConversions[toUnitVal];
                                
                                output.textContent = formatNumber(result, precision);

                                // Update all unit displays
                                inlbOutput.textContent = formatNumber(inInchLbs, precision) + ' in-lbs';
                                ftlbOutput.textContent = formatNumber(inInchLbs / torqueConversions.ftlb, precision) + ' ft-lbs';
                                nmOutput.textContent = formatNumber(inInchLbs / torqueConversions.nm, precision) + ' Nm';
                                ozinOutput.textContent = formatNumber(inInchLbs / torqueConversions.ozin, precision) + ' oz⋅in';
                                kgcmOutput.textContent = formatNumber(inInchLbs / torqueConversions.kgcm, precision) + ' kg⋅cm';

                                // Update torque scale guide
                                const scale = classifyTorqueScale(inInchLbs);
                                torqueScale.textContent = scale.scale;
                                scaleDescription.textContent = scale.description;
                            } else {
                                output.textContent = '--';
                                inlbOutput.textContent = '--';
                                ftlbOutput.textContent = '--';
                                nmOutput.textContent = '--';
                                ozinOutput.textContent = '--';
                                kgcmOutput.textContent = '--';
                                torqueScale.textContent = 'Enter torque value';
                                scaleDescription.textContent = '--';
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
                                unitPresets.forEach(btn => btn.classList.remove('bg-orange-100', 'text-orange-700'));
                                unitPresets.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-orange-100', 'text-orange-700');
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
