<x-tool-page-layout
    title="Newton Meter Calculator - SolveKit"
    description="Professional Newton meter torque calculator for engineering applications. Convert between Nm, kNm, lbf·ft and other torque units with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Torque (Nm)</h1>
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
                                                                                        <optgroup label="SI Units">
                                                                                            <option value="uNm">Micronewton meter (µN·m)</option>
                                                                                            <option value="mNm">Millinewton meter (mN·m)</option>
                                                                                            <option value="Nm" selected>Newton meter (N·m)</option>
                                                                                            <option value="kNm">Kilonewton meter (kN·m)</option>
                                                                                            <option value="MNm">Meganewton meter (MN·m)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Metric Force Units">
                                                                                            <option value="kgfm">Kilogram-force meter (kgf·m)</option>
                                                                                            <option value="kgfcm">Kilogram-force cm (kgf·cm)</option>
                                                                                            <option value="gfcm">Gram-force cm (gf·cm)</option>
                                                                                            <option value="tfm_metric">Metric ton-force meter (tf·m)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Imperial Units">
                                                                                            <option value="lbfft">Pound-force foot (lbf·ft)</option>
                                                                                            <option value="lbfin">Pound-force inch (lbf·in)</option>
                                                                                            <option value="ozfin">Ounce-force inch (ozf·in)</option>
                                                                                            <option value="tfm_us">Ton-force meter (US tf·m)</option>
                                                                                            <option value="tfm_uk">Ton-force meter (UK tf·m)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Other Units">
                                                                                            <option value="pdlft">Poundal foot (pdl·ft)</option>
                                                                                            <option value="dyncm">Dyne centimeter (dyn·cm)</option>
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
                                                                                        <optgroup label="SI Units">
                                                                                            <option value="uNm">Micronewton meter (µN·m)</option>
                                                                                            <option value="mNm">Millinewton meter (mN·m)</option>
                                                                                            <option value="Nm">Newton meter (N·m)</option>
                                                                                            <option value="kNm">Kilonewton meter (kN·m)</option>
                                                                                            <option value="MNm">Meganewton meter (MN·m)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Metric Force Units">
                                                                                            <option value="kgfm">Kilogram-force meter (kgf·m)</option>
                                                                                            <option value="kgfcm">Kilogram-force cm (kgf·cm)</option>
                                                                                            <option value="gfcm">Gram-force cm (gf·cm)</option>
                                                                                            <option value="tfm_metric">Metric ton-force meter (tf·m)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Imperial Units">
                                                                                            <option value="lbfft" selected>Pound-force foot (lbf·ft)</option>
                                                                                            <option value="lbfin">Pound-force inch (lbf·in)</option>
                                                                                            <option value="ozfin">Ounce-force inch (ozf·in)</option>
                                                                                            <option value="tfm_us">Ton-force meter (US tf·m)</option>
                                                                                            <option value="tfm_uk">Ton-force meter (UK tf·m)</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Other Units">
                                                                                            <option value="pdlft">Poundal foot (pdl·ft)</option>
                                                                                            <option value="dyncm">Dyne centimeter (dyn·cm)</option>
                                                                                        </optgroup>
                                                                                    </select>
                                                                                </div>
                                                                            </div>



                                                                            <!-- Scientific Notation Toggle -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Display Format
                                                                                </label>
                                                                                <div class="grid grid-cols-4 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-indigo-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="3" class="text-indigo-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">3 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-indigo-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="6" class="text-indigo-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-xs font-medium">6 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-indigo-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="9" class="text-indigo-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">9 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-indigo-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="scientific" class="text-indigo-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">Scientific</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Unit Swap Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="swapUnits"
                                                                                    class="inline-flex items-center px-4 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <div class="p-6 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl border-l-4 border-indigo-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Torque</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Target torque unit</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-indigo-600 font-mono" id="output">--</div>
                                                                                        <div class="text-sm text-gray-500 font-medium" id="outputUnitDisplay">lbf·ft</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Common SI Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Newton meter</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="nmOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Kilonewton meter</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="knmOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">kgf·m</h4>
                                                                                        <div class="text-lg font-bold text-purple-600 font-mono" id="kgfmOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Imperial Units -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">lbf·ft</h4>
                                                                                        <div class="text-lg font-bold text-orange-600 font-mono" id="lbfftOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">lbf·in</h4>
                                                                                        <div class="text-lg font-bold text-cyan-600 font-mono" id="lbfinOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">dyn·cm</h4>
                                                                                        <div class="text-lg font-bold text-yellow-600 font-mono" id="dyncmOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Engineering Scale Indicator -->
                                                                            <div class="p-4 bg-gradient-to-r from-violet-50 to-purple-50 rounded-lg border border-violet-200">
                                                                                <h4 class="text-sm font-semibold text-violet-800 mb-2 text-center">Engineering Scale</h4>
                                                                                <div class="text-center">
                                                                                    <div class="text-lg font-bold text-violet-700" id="engineeringScale">Enter torque value</div>
                                                                                    <div class="text-xs text-violet-600 mt-1" id="scaleDescription">--</div>
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
                <!-- Quick Conversion Presets -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Newton Meter Conversions
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors" data-from="Nm" data-to="lbfft">Nm → lbf·ft</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors" data-from="lbfft" data-to="Nm">lbf·ft → Nm</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors" data-from="kgfm" data-to="Nm">kgf·m → Nm</button>
                                                            <button type="button" class="unit-preset px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors" data-from="lbfin" data-to="Nm">lbf·in → Nm</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Newton Meter Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div>• 1 Nm = 0.7376 lbf·ft</div>
                                                        <div>• 1 lbf·ft = 1.3558 Nm</div>
                                                        <div>• 1 kgf·m = 9.807 Nm</div>
                                                        <div>• 1 kNm = 1000 Nm</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">About Newton Meter Calculations</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600">
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">SI Standard Unit</h4>
                                    <p>The Newton meter (N·m) is the SI derived unit for torque (moment of force). It represents the torque produced by a force of one newton applied at a distance of one meter from a pivot point, and is fundamental in mechanical engineering calculations.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Engineering Applications</h4>
                                    <p>Critical for mechanical design, motor specifications, fastener torque requirements, gear calculations, and any rotational machinery analysis. Essential for international projects requiring precise torque conversions between different unit systems.</p>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-indigo-50 rounded-lg border border-indigo-200">
                                <p class="text-sm text-indigo-800">
                                    <strong>Engineering Note:</strong> Newton meters are equivalent to Joules for energy, but represent different physical quantities - torque vs. energy. Always specify the context!
                                </p>
                            </div>
                        </div>

                        <!-- Common Torque Examples -->
                        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Common Newton Meter Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Small Motor</div>
                                    <div class="text-indigo-600 cursor-pointer hover:text-indigo-800 transition-colors" data-value="0.5" data-unit="Nm">0.5 Nm</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 0.37 lbf·ft</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Bike Pedal</div>
                                    <div class="text-indigo-600 cursor-pointer hover:text-indigo-800 transition-colors" data-value="50" data-unit="Nm">50 Nm</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 37 lbf·ft</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Car Engine</div>
                                    <div class="text-indigo-600 cursor-pointer hover:text-indigo-800 transition-colors" data-value="300" data-unit="Nm">300 Nm</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 221 lbf·ft</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Industrial Motor</div>
                                    <div class="text-indigo-600 cursor-pointer hover:text-indigo-800 transition-colors" data-value="5000" data-unit="Nm">5000 Nm</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 3688 lbf·ft</div>
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
                        const knmOutput = document.getElementById('knmOutput');
                        const kgfmOutput = document.getElementById('kgfmOutput');
                        const lbfftOutput = document.getElementById('lbfftOutput');
                        const lbfinOutput = document.getElementById('lbfinOutput');
                        const dyncmOutput = document.getElementById('dyncmOutput');
                        const engineeringScale = document.getElementById('engineeringScale');
                        const scaleDescription = document.getElementById('scaleDescription');
                        const conversionFormula = document.getElementById('conversionFormula');

                        // All conversion factors relative to Newton meter (N·m)
                        const conversionFactors = {
                            uNm: 1e-6,                    // Micronewton meter
                            mNm: 1e-3,                    // Millinewton meter
                            Nm: 1,                        // Newton meter
                            kNm: 1e3,                     // Kilonewton meter
                            MNm: 1e6,                     // Meganewton meter
                            kgfm: 9.80665,                // Kilogram-force meter
                            kgfcm: 0.0980665,             // Kilogram-force centimeter
                            gfcm: 0.0000980665,           // Gram-force centimeter
                            tfm_metric: 9806.65,          // Metric ton-force meter
                            lbfft: 1.3558179,             // Pound-force foot
                            lbfin: 0.1129848,             // Pound-force inch
                            ozfin: 0.007061552,           // Ounce-force inch
                            tfm_us: 8896.4432,            // US ton-force meter
                            tfm_uk: 9964.016,             // UK ton-force meter
                            pdlft: 0.04214011,            // Poundal foot
                            dyncm: 1e-7                   // Dyne centimeter
                        };

                        const unitNames = {
                            uNm: 'Micronewton-meters',
                            mNm: 'Millinewton-meters',
                            Nm: 'Newton-meters',
                            kNm: 'Kilonewton-meters',
                            MNm: 'Meganewton-meters',
                            kgfm: 'Kilogram-force meters',
                            kgfcm: 'Kilogram-force centimeters',
                            gfcm: 'Gram-force centimeters',
                            tfm_metric: 'Metric ton-force meters',
                            lbfft: 'Pound-force feet',
                            lbfin: 'Pound-force inches',
                            ozfin: 'Ounce-force inches',
                            tfm_us: 'US ton-force meters',
                            tfm_uk: 'UK ton-force meters',
                            pdlft: 'Poundal feet',
                            dyncm: 'Dyne-centimeters'
                        };

                        const unitSymbols = {
                            uNm: 'µN·m',
                            mNm: 'mN·m',
                            Nm: 'N·m',
                            kNm: 'kN·m',
                            MNm: 'MN·m',
                            kgfm: 'kgf·m',
                            kgfcm: 'kgf·cm',
                            gfcm: 'gf·cm',
                            tfm_metric: 'tf·m',
                            lbfft: 'lbf·ft',
                            lbfin: 'lbf·in',
                            ozfin: 'ozf·in',
                            tfm_us: 'US tf·m',
                            tfm_uk: 'UK tf·m',
                            pdlft: 'pdl·ft',
                            dyncm: 'dyn·cm'
                        };

                        function getPrecision() {
                            const selected = document.querySelector('input[name="precision"]:checked').value;
                            return selected;
                        }

                        function formatNumber(num, precision = 'auto') {
                            if (precision === 'scientific') {
                                return Number(num.toPrecision(5)).toExponential();
                            } else if (precision === 'auto') {
                                if (num >= 1000000 || (num !== 0 && Math.abs(num) < 0.0001)) {
                                    return Number(num.toPrecision(5)).toExponential();
                                } else if (num >= 1000) {
                                    return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                                } else if (Math.abs(num) < 1) {
                                    return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                                } else {
                                    return num.toLocaleString(undefined, { maximumFractionDigits: 6 });
                                }
                            } else {
                                const decimals = parseInt(precision);
                                if (num !== 0 && Math.abs(num) < 0.5 * Math.pow(10, -decimals)) {
                                    return Math.abs(num) < 0.000001 ? Number(num.toPrecision(4)).toExponential() : num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                                }
                                return num.toLocaleString(undefined, { maximumFractionDigits: decimals });
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
                            const fromFactor = conversionFactors[fromUnit.value];
                            const toFactor = conversionFactors[toUnit.value];
                            
                            if (fromUnit.value === toUnit.value) {
                                conversionFormula.textContent = `1 ${fromSymbol} = 1 ${toSymbol}`;
                            } else {
                                const conversionFactor = fromFactor / toFactor;
                                conversionFormula.textContent = `1 ${fromSymbol} = ${formatNumber(conversionFactor, '6')} ${toSymbol}`;
                            }
                        }

                        function classifyEngineeringScale(nmValue) {
                            if (nmValue >= 100000) {
                                return { scale: 'Heavy Industrial', description: 'Large turbines, ship engines, industrial machinery' };
                            } else if (nmValue >= 10000) {
                                return { scale: 'Industrial Scale', description: 'Large motors, industrial equipment' };
                            } else if (nmValue >= 1000) {
                                return { scale: 'Automotive/Heavy', description: 'Car engines, heavy machinery' };
                            } else if (nmValue >= 100) {
                                return { scale: 'Medium Mechanical', description: 'Power tools, medium motors' };
                            } else if (nmValue >= 10) {
                                return { scale: 'Light Mechanical', description: 'Small motors, hand tools' };
                            } else if (nmValue >= 1) {
                                return { scale: 'Precision Equipment', description: 'Servo motors, precision devices' };
                            } else {
                                return { scale: 'Micro Applications', description: 'MEMS, micro actuators' };
                            }
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const fromUnitVal = fromUnit.value;
                            const toUnitVal = toUnit.value;
                            const precision = getPrecision();

                            if (!isNaN(inputVal)) {
                                // Convert to Newton meter first, then to target unit
                                const inNm = inputVal * conversionFactors[fromUnitVal];
                                const result = inNm / conversionFactors[toUnitVal];
                                
                                output.textContent = formatNumber(result, precision);

                                // Update all common units
                                nmOutput.textContent = formatNumber(inNm, precision) + ' N·m';
                                knmOutput.textContent = formatNumber(inNm / conversionFactors.kNm, precision) + ' kN·m';
                                kgfmOutput.textContent = formatNumber(inNm / conversionFactors.kgfm, precision) + ' kgf·m';
                                lbfftOutput.textContent = formatNumber(inNm / conversionFactors.lbfft, precision) + ' lbf·ft';
                                lbfinOutput.textContent = formatNumber(inNm / conversionFactors.lbfin, precision) + ' lbf·in';
                                dyncmOutput.textContent = formatNumber(inNm / conversionFactors.dyncm, precision) + ' dyn·cm';

                                // Update engineering scale classification
                                const scale = classifyEngineeringScale(inNm);
                                engineeringScale.textContent = scale.scale;
                                scaleDescription.textContent = scale.description;
                            } else {
                                output.textContent = '--';
                                nmOutput.textContent = '--';
                                knmOutput.textContent = '--';
                                kgfmOutput.textContent = '--';
                                lbfftOutput.textContent = '--';
                                lbfinOutput.textContent = '--';
                                dyncmOutput.textContent = '--';
                                engineeringScale.textContent = 'Enter torque value';
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
                                unitPresets.forEach(btn => btn.classList.remove('bg-indigo-100', 'text-indigo-700'));
                                unitPresets.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-indigo-100', 'text-indigo-700');
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
