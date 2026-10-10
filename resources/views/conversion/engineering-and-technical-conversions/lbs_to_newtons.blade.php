<x-tool-page-layout
    title="Lbs ↔ Newtons Converter - ConvertPro"
    description="Professional pound-force to Newtons converter for engineering applications. Convert between lbf and N force units with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Lbs ↔ Newtons</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Enter Force Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter force value"
                                                                                        step="any"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnitDisplay">lbf</span>
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
                                                                                        <optgroup label="Imperial Units">
                                                                                            <option value="lbf" selected>Pound-force (lbf)</option>
                                                                                            <option value="ozf">Ounce-force (ozf)</option>
                                                                                            <option value="kip">Kip-force (kip)</option>
                                                                                            <option value="tonfUS">Ton-force (US)</option>
                                                                                            <option value="poundal">Poundal (pdl)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="SI Units">
                                                                                            <option value="N">Newton (N)</option>
                                                                                            <option value="kN">Kilonewton (kN)</option>
                                                                                            <option value="MN">Meganewton (MN)</option>
                                                                                            <option value="mN">Millinewton (mN)</option>
                                                                                            <option value="µN">Micronewton (µN)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Other Units">
                                                                                            <option value="kgf">Kilogram-force (kgf)</option>
                                                                                            <option value="gf">Gram-force (gf)</option>
                                                                                            <option value="dy">Dyne (dyn)</option>
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
                                                                                        <optgroup label="Imperial Units">
                                                                                            <option value="lbf">Pound-force (lbf)</option>
                                                                                            <option value="ozf">Ounce-force (ozf)</option>
                                                                                            <option value="kip">Kip-force (kip)</option>
                                                                                            <option value="tonfUS">Ton-force (US)</option>
                                                                                            <option value="poundal">Poundal (pdl)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="SI Units">
                                                                                            <option value="N" selected>Newton (N)</option>
                                                                                            <option value="kN">Kilonewton (kN)</option>
                                                                                            <option value="MN">Meganewton (MN)</option>
                                                                                            <option value="mN">Millinewton (mN)</option>
                                                                                            <option value="µN">Micronewton (µN)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Other Units">
                                                                                            <option value="kgf">Kilogram-force (kgf)</option>
                                                                                            <option value="gf">Gram-force (gf)</option>
                                                                                            <option value="dy">Dyne (dyn)</option>
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
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-pink-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="2" class="text-pink-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">2 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-pink-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="4" class="text-pink-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-xs font-medium">4 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-pink-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="6" class="text-pink-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">6 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-pink-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="auto" class="text-pink-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">Auto</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Unit Swap Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="swapUnits"
                                                                                    class="inline-flex items-center px-4 py-2 bg-pink-100 hover:bg-pink-200 text-pink-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <div class="p-6 bg-gradient-to-r from-pink-50 to-rose-50 rounded-xl border-l-4 border-pink-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Force</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Target force unit</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-pink-600 font-mono" id="output">--</div>
                                                                                        <div class="text-sm text-gray-500 font-medium" id="outputUnitDisplay">N</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Imperial vs SI Comparison -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Pound-force</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="lbfOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Newton</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="newtonOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Force Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Kilogram-force</h4>
                                                                                        <div class="text-lg font-bold text-purple-600 font-mono" id="kgfOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Kilonewton</h4>
                                                                                        <div class="text-lg font-bold text-orange-600 font-mono" id="knOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Dyne</h4>
                                                                                        <div class="text-lg font-bold text-cyan-600 font-mono" id="dyneOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Force Magnitude Indicator -->
                                                                            <div class="p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border border-indigo-200">
                                                                                <h4 class="text-sm font-semibold text-indigo-800 mb-2 text-center">Force Magnitude Scale</h4>
                                                                                <div class="text-center">
                                                                                    <div class="text-lg font-bold text-indigo-700" id="forceMagnitude">Enter force value</div>
                                                                                    <div class="text-xs text-indigo-600 mt-1" id="magnitudeDescription">--</div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Conversion Formula -->
                                                                            <div class="p-4 bg-gray-50 rounded-lg">
                                                                                <h4 class="text-sm font-semibold text-gray-700 mb-2 text-center">Conversion Formula</h4>
                                                                                <div class="text-center text-sm text-gray-600 font-mono" id="conversionFormula">
                                                                                    1 lbf = 4.44822 N
                                                                                </div>
                                                                                <div class="text-center text-xs text-gray-500 mt-1">
                                                                                    Based on standard gravitational acceleration
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
                                                            Quick Force Conversions
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-pink-100 text-gray-700 hover:text-pink-700 rounded-lg transition-colors" data-from="lbf" data-to="N">lbf → N</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-pink-100 text-gray-700 hover:text-pink-700 rounded-lg transition-colors" data-from="N" data-to="lbf">N → lbf</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-pink-100 text-gray-700 hover:text-pink-700 rounded-lg transition-colors" data-from="kgf" data-to="lbf">kgf → lbf</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-pink-100 text-gray-700 hover:text-pink-700 rounded-lg transition-colors" data-from="kip" data-to="kN">kip → kN</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Force Conversion Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div>• 1 lbf = 4.448 N</div>
                                                        <div>• 1 N = 0.2248 lbf</div>
                                                        <div>• 1 kgf = 9.807 N</div>
                                                        <div>• 1 kgf = 2.205 lbf</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">About Pound-force to Newton Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600">
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Imperial vs SI Systems</h4>
                                    <p>This converter bridges the gap between the imperial pound-force (lbf) and the SI unit Newton (N). The conversion factor 4.44822 comes from the relationship between pound-mass, standard gravity, and the kilogram-meter-second system.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Engineering Applications</h4>
                                    <p>Essential for international engineering projects, aerospace calculations, structural analysis, and any application where force measurements need to be converted between imperial and metric systems with high precision.</p>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-pink-50 rounded-lg border border-pink-200">
                                <p class="text-sm text-pink-800">
                                    <strong>Force Definition:</strong> 1 pound-force is the force exerted by a mass of 1 pound under standard gravitational acceleration (32.174 ft/s²)!
                                </p>
                            </div>
                        </div>

                        <!-- Common Force Examples -->
                        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Common Force Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Weight of 1 lb mass</div>
                                    <div class="text-pink-600 cursor-pointer hover:text-pink-800 transition-colors" data-value="1" data-unit="lbf">1 lbf</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 4.45 N</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Strong push</div>
                                    <div class="text-pink-600 cursor-pointer hover:text-pink-800 transition-colors" data-value="50" data-unit="lbf">50 lbf</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 222 N</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Car engine force</div>
                                    <div class="text-pink-600 cursor-pointer hover:text-pink-800 transition-colors" data-value="1000" data-unit="N">1000 N</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 225 lbf</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Rocket thrust</div>
                                    <div class="text-pink-600 cursor-pointer hover:text-pink-800 transition-colors" data-value="10000" data-unit="lbf">10,000 lbf</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 44.5 kN</div>
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
                        const lbfOutput = document.getElementById('lbfOutput');
                        const newtonOutput = document.getElementById('newtonOutput');
                        const kgfOutput = document.getElementById('kgfOutput');
                        const knOutput = document.getElementById('knOutput');
                        const dyneOutput = document.getElementById('dyneOutput');
                        const forceMagnitude = document.getElementById('forceMagnitude');
                        const magnitudeDescription = document.getElementById('magnitudeDescription');
                        const conversionFormula = document.getElementById('conversionFormula');

                        // All conversion factors relative to Newton (N)
                        const forceConversions = {
                            lbf: 4.44822,                 // Pound-force
                            ozf: 0.278014,                // Ounce-force
                            kip: 4448.2216152605,         // Kip-force
                            tonfUS: 8896.44323,           // Ton-force (US)
                            poundal: 0.138255,            // Poundal
                            N: 1,                         // Newton
                            kN: 1000,                     // Kilonewton
                            MN: 1000000,                  // Meganewton
                            mN: 0.001,                    // Millinewton
                            µN: 0.000001,                 // Micronewton
                            kgf: 9.80665,                 // Kilogram-force
                            gf: 0.00980665,               // Gram-force
                            dy: 0.00001                   // Dyne
                        };

                        const unitNames = {
                            lbf: 'Pounds-force',
                            ozf: 'Ounces-force',
                            kip: 'Kips',
                            tonfUS: 'Tons-force (US)',
                            poundal: 'Poundals',
                            N: 'Newtons',
                            kN: 'Kilonewtons',
                            MN: 'Meganewtons',
                            mN: 'Millinewtons',
                            µN: 'Micronewtons',
                            kgf: 'Kilograms-force',
                            gf: 'Grams-force',
                            dy: 'Dynes'
                        };

                        const unitSymbols = {
                            lbf: 'lbf',
                            ozf: 'ozf',
                            kip: 'kip',
                            tonfUS: 'tonf (US)',
                            poundal: 'pdl',
                            N: 'N',
                            kN: 'kN',
                            MN: 'MN',
                            mN: 'mN',
                            µN: 'µN',
                            kgf: 'kgf',
                            gf: 'gf',
                            dy: 'dyn'
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
                            resultTitle.textContent = `Force in ${unitNames[toUnit.value]}`;
                            resultDescription.textContent = 'Converted force value';
                        }

                        function updateConversionFormula() {
                            const fromSymbol = unitSymbols[fromUnit.value];
                            const toSymbol = unitSymbols[toUnit.value];
                            
                            if (fromUnit.value === 'lbf' && toUnit.value === 'N') {
                                conversionFormula.textContent = '1 lbf = 4.44822 N';
                            } else if (fromUnit.value === 'N' && toUnit.value === 'lbf') {
                                conversionFormula.textContent = '1 N = 0.224809 lbf';
                            } else if (fromUnit.value === toUnit.value) {
                                conversionFormula.textContent = `1 ${fromSymbol} = 1 ${toSymbol}`;
                            } else {
                                const fromFactor = forceConversions[fromUnit.value];
                                const toFactor = forceConversions[toUnit.value];
                                const conversionFactor = fromFactor / toFactor;
                                conversionFormula.textContent = `1 ${fromSymbol} = ${formatNumber(conversionFactor, 6)} ${toSymbol}`;
                            }
                        }

                        function classifyForceMagnitude(newtonValue) {
                            if (newtonValue >= 1000000) {
                                return { magnitude: 'Extreme Force', description: 'Rocket engines, heavy machinery' };
                            } else if (newtonValue >= 100000) {
                                return { magnitude: 'Very Large Force', description: 'Industrial equipment, vehicle crashes' };
                            } else if (newtonValue >= 10000) {
                                return { magnitude: 'Large Force', description: 'Car engines, hydraulic systems' };
                            } else if (newtonValue >= 1000) {
                                return { magnitude: 'Moderate Force', description: 'Athletic activities, tools' };
                            } else if (newtonValue >= 100) {
                                return { magnitude: 'Human-scale Force', description: 'Hand push, lifting objects' };
                            } else if (newtonValue >= 10) {
                                return { magnitude: 'Light Force', description: 'Gentle push, small weights' };
                            } else {
                                return { magnitude: 'Minimal Force', description: 'Light touch, precision instruments' };
                            }
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const fromUnitVal = fromUnit.value;
                            const toUnitVal = toUnit.value;
                            const precision = getPrecision();

                            if (!isNaN(inputVal)) {
                                // Convert to Newton first, then to target unit
                                const inNewton = inputVal * forceConversions[fromUnitVal];
                                const result = inNewton / forceConversions[toUnitVal];
                                
                                output.textContent = formatNumber(result, precision);

                                // Update main force units
                                lbfOutput.textContent = formatNumber(inNewton / forceConversions.lbf, precision) + ' lbf';
                                newtonOutput.textContent = formatNumber(inNewton, precision) + ' N';
                                kgfOutput.textContent = formatNumber(inNewton / forceConversions.kgf, precision) + ' kgf';
                                knOutput.textContent = formatNumber(inNewton / forceConversions.kN, precision) + ' kN';
                                dyneOutput.textContent = formatNumber(inNewton / forceConversions.dy, precision) + ' dyn';

                                // Update force magnitude indicator
                                const magnitude = classifyForceMagnitude(inNewton);
                                forceMagnitude.textContent = magnitude.magnitude;
                                magnitudeDescription.textContent = magnitude.description;
                            } else {
                                output.textContent = '--';
                                lbfOutput.textContent = '--';
                                newtonOutput.textContent = '--';
                                kgfOutput.textContent = '--';
                                knOutput.textContent = '--';
                                dyneOutput.textContent = '--';
                                forceMagnitude.textContent = 'Enter force value';
                                magnitudeDescription.textContent = '--';
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
                                unitPresets.forEach(btn => btn.classList.remove('bg-pink-100', 'text-pink-700'));
                                unitPresets.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-pink-100', 'text-pink-700');
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
