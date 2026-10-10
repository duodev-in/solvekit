<x-tool-page-layout
    title="Force Converter - ConvertPro"
    description="Professional force converter for engineering applications. Convert between Newtons, pounds-force, kilogram-force and other force units with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Force Converter</h1>
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
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnitDisplay">N</span>
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
                                                                                            <option value="N" selected>Newton (N)</option>
                                                                                            <option value="kN">Kilonewton (kN)</option>
                                                                                            <option value="MN">Meganewton (MN)</option>
                                                                                            <option value="kgf">Kilogram-force (kgf)</option>
                                                                                            <option value="dy">Dyne (dyn)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Imperial Units">
                                                                                            <option value="lbf">Pound-force (lbf)</option>
                                                                                            <option value="ozf">Ounce-force (ozf)</option>
                                                                                            <option value="kip">Kip-force (kip)</option>
                                                                                            <option value="tonfUS">Ton-force (US)</option>
                                                                                            <option value="tonfUK">Ton-force (UK)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Other Units">
                                                                                            <option value="poundal">Poundal (pdl)</option>
                                                                                            <option value="gf">Gram-force (gf)</option>
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
                                                                                            <option value="N">Newton (N)</option>
                                                                                            <option value="kN">Kilonewton (kN)</option>
                                                                                            <option value="MN">Meganewton (MN)</option>
                                                                                            <option value="kgf" selected>Kilogram-force (kgf)</option>
                                                                                            <option value="dy">Dyne (dyn)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Imperial Units">
                                                                                            <option value="lbf">Pound-force (lbf)</option>
                                                                                            <option value="ozf">Ounce-force (ozf)</option>
                                                                                            <option value="kip">Kip-force (kip)</option>
                                                                                            <option value="tonfUS">Ton-force (US)</option>
                                                                                            <option value="tonfUK">Ton-force (UK)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Other Units">
                                                                                            <option value="poundal">Poundal (pdl)</option>
                                                                                            <option value="gf">Gram-force (gf)</option>
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
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="2" class="text-yellow-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">2 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="4" class="text-yellow-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">4 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="6" class="text-yellow-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-xs font-medium">6 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="auto" class="text-yellow-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">Auto</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Unit Swap Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="swapUnits"
                                                                                    class="inline-flex items-center px-4 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <div class="p-6 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl border-l-4 border-yellow-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Force</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Target force unit</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-yellow-600 font-mono" id="output">--</div>
                                                                                        <div class="text-sm text-gray-500 font-medium" id="outputUnitDisplay">kgf</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Common Force Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Newton</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="newtonOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Pound-force</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="lbfOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Kilogram-force</h4>
                                                                                        <div class="text-lg font-bold text-purple-600 font-mono" id="kgfOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                                                                                <div class="p-4 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Kip-force</h4>
                                                                                        <div class="text-lg font-bold text-pink-600 font-mono" id="kipOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Force Classification -->
                                                                            <div class="p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border border-indigo-200">
                                                                                <h4 class="text-sm font-semibold text-indigo-800 mb-2 text-center">Force Classification</h4>
                                                                                <div class="text-center">
                                                                                    <div class="text-lg font-bold text-indigo-700" id="forceLevel">Enter force value</div>
                                                                                    <div class="text-xs text-indigo-600 mt-1" id="forceDescription">--</div>
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
                                                            Quick Force Conversions
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-from="N" data-to="lbf">N → lbf</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-from="lbf" data-to="N">lbf → N</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-from="kgf" data-to="N">kgf → N</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-from="kN" data-to="lbf">kN → lbf</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Force Conversion Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div>• 1 N = 0.225 lbf</div>
                                                        <div>• 1 lbf = 4.448 N</div>
                                                        <div>• 1 kgf = 9.807 N</div>
                                                        <div>• 1 kN = 1000 N</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">About Force Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600">
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Engineering Applications</h4>
                                    <p>Force conversion is fundamental in mechanical engineering, structural analysis, material testing, automotive engineering, and aerospace applications. Different regions and standards use different force units.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Unit Standards</h4>
                                    <p>Newton (N) is the SI unit for force. Pound-force is common in US engineering, while kilogram-force is still used in some applications. Understanding these conversions ensures accurate engineering calculations.</p>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                <p class="text-sm text-yellow-800">
                                    <strong>Engineering Note:</strong> Force = mass × acceleration. Always distinguish between mass (kg) and force (kgf) in calculations!
                                </p>
                            </div>
                        </div>

                        <!-- Common Force Examples -->
                        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Common Force Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Weight of 1 kg</div>
                                    <div class="text-yellow-600 cursor-pointer hover:text-yellow-800 transition-colors" data-value="9.807" data-unit="N">9.807 N</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 2.2 lbf</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Car Weight</div>
                                    <div class="text-yellow-600 cursor-pointer hover:text-yellow-800 transition-colors" data-value="15" data-unit="kN">15 kN</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 3370 lbf</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Engine Thrust</div>
                                    <div class="text-yellow-600 cursor-pointer hover:text-yellow-800 transition-colors" data-value="50000" data-unit="lbf">50,000 lbf</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 222 kN</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Hand Grip</div>
                                    <div class="text-yellow-600 cursor-pointer hover:text-yellow-800 transition-colors" data-value="400" data-unit="N">400 N</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 90 lbf</div>
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
                        const newtonOutput = document.getElementById('newtonOutput');
                        const lbfOutput = document.getElementById('lbfOutput');
                        const kgfOutput = document.getElementById('kgfOutput');
                        const knOutput = document.getElementById('knOutput');
                        const dyneOutput = document.getElementById('dyneOutput');
                        const kipOutput = document.getElementById('kipOutput');
                        const forceLevel = document.getElementById('forceLevel');
                        const forceDescription = document.getElementById('forceDescription');
                        const conversionFormula = document.getElementById('conversionFormula');

                        // All conversion factors relative to Newton (N)
                        const forceFactorsToN = {
                            N: 1,                         // Newton
                            kN: 1000,                     // Kilonewton
                            MN: 1000000,                  // Meganewton
                            lbf: 4.44822,                 // Pound-force
                            kgf: 9.80665,                 // Kilogram-force
                            dy: 0.00001,                  // Dyne
                            tonfUS: 8896.44323,           // Ton-force (US)
                            tonfUK: 9964.016384,          // Ton-force (UK)
                            kip: 4448.2216152605,         // Kip-force
                            ozf: 0.278014,                // Ounce-force
                            poundal: 0.138255,            // Poundal
                            gf: 0.00980665                // Gram-force
                        };

                        const unitNames = {
                            N: 'Newtons',
                            kN: 'Kilonewtons',
                            MN: 'Meganewtons',
                            lbf: 'Pounds-force',
                            kgf: 'Kilograms-force',
                            dy: 'Dynes',
                            tonfUS: 'Tons-force (US)',
                            tonfUK: 'Tons-force (UK)',
                            kip: 'Kips',
                            ozf: 'Ounces-force',
                            poundal: 'Poundals',
                            gf: 'Grams-force'
                        };

                        const unitSymbols = {
                            N: 'N',
                            kN: 'kN',
                            MN: 'MN',
                            lbf: 'lbf',
                            kgf: 'kgf',
                            dy: 'dyn',
                            tonfUS: 'tonf (US)',
                            tonfUK: 'tonf (UK)',
                            kip: 'kip',
                            ozf: 'ozf',
                            poundal: 'pdl',
                            gf: 'gf'
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
                            const fromFactor = forceFactorsToN[fromUnit.value];
                            const toFactor = forceFactorsToN[toUnit.value];
                            
                            if (fromUnit.value === toUnit.value) {
                                conversionFormula.textContent = `1 ${fromSymbol} = 1 ${toSymbol}`;
                            } else {
                                const conversionFactor = fromFactor / toFactor;
                                conversionFormula.textContent = `1 ${fromSymbol} = ${formatNumber(conversionFactor, 6)} ${toSymbol}`;
                            }
                        }

                        function classifyForce(newtonValue) {
                            if (newtonValue >= 1000000) {
                                return { level: 'Extreme Force', description: 'Industrial/aerospace applications' };
                            } else if (newtonValue >= 10000) {
                                return { level: 'Heavy Industrial Force', description: 'Large machinery and structures' };
                            } else if (newtonValue >= 1000) {
                                return { level: 'Industrial Force', description: 'Manufacturing and construction' };
                            } else if (newtonValue >= 100) {
                                return { level: 'Moderate Force', description: 'Hand tools and equipment' };
                            } else if (newtonValue >= 10) {
                                return { level: 'Light Force', description: 'Everyday applications' };
                            } else if (newtonValue >= 1) {
                                return { level: 'Small Force', description: 'Precision instruments' };
                            } else {
                                return { level: 'Micro Force', description: 'Scientific measurements' };
                            }
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const fromUnitVal = fromUnit.value;
                            const toUnitVal = toUnit.value;
                            const precision = getPrecision();

                            if (!isNaN(inputVal)) {
                                // Convert to Newton first, then to target unit
                                const inNewton = inputVal * forceFactorsToN[fromUnitVal];
                                const result = inNewton / forceFactorsToN[toUnitVal];
                                
                                output.textContent = formatNumber(result, precision);

                                // Update all common units
                                newtonOutput.textContent = formatNumber(inNewton, precision) + ' N';
                                lbfOutput.textContent = formatNumber(inNewton / forceFactorsToN.lbf, precision) + ' lbf';
                                kgfOutput.textContent = formatNumber(inNewton / forceFactorsToN.kgf, precision) + ' kgf';
                                knOutput.textContent = formatNumber(inNewton / forceFactorsToN.kN, precision) + ' kN';
                                dyneOutput.textContent = formatNumber(inNewton / forceFactorsToN.dy, precision) + ' dyn';
                                kipOutput.textContent = formatNumber(inNewton / forceFactorsToN.kip, precision) + ' kip';

                                // Update force classification
                                const force = classifyForce(inNewton);
                                forceLevel.textContent = force.level;
                                forceDescription.textContent = force.description;
                            } else {
                                output.textContent = '--';
                                newtonOutput.textContent = '--';
                                lbfOutput.textContent = '--';
                                kgfOutput.textContent = '--';
                                knOutput.textContent = '--';
                                dyneOutput.textContent = '--';
                                kipOutput.textContent = '--';
                                forceLevel.textContent = 'Enter force value';
                                forceDescription.textContent = '--';
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
                                unitPresets.forEach(btn => btn.classList.remove('bg-yellow-100', 'text-yellow-700'));
                                unitPresets.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-yellow-100', 'text-yellow-700');
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
